<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/23 16:20
 */

namespace App\Helpers\SoftDeleteByUnix;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SoftDeleteScope  implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Restore', 'WithTrashed', 'WithoutTrashed', 'OnlyTrashed'];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @author pandaria
     * @date 2018/4/23 16:24
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where(function(Builder $builder) use($model) {
            $column = $model->getQualifiedDeletedAtColumn();
            $builder->where($column,0)->orWhere($column,'>',(int)$model->freshTimestampString());
        });
    }


    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function (Builder $builder) {
            $column = $this->getDeletedAtColumn($builder);

            return $builder->update([
                $column => $builder->getModel()->freshTimestampString(),
            ]);
        });
    }


    protected function getDeletedAtColumn(Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedDeletedAtColumn();
        }

        return $builder->getModel()->getDeletedAtColumn();
    }


    protected function addWithTrashed(Builder $builder)
    {
        $builder->macro('withTrashed', function (Builder $builder, $withTrashed = true) {
            if (! $withTrashed) {
                return $builder->withoutTrashed();
            }
            return $builder->withoutGlobalScope($this);
        });
    }

    protected function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();

            return $builder->update([$builder->getModel()->getDeletedAtColumn() => 0]);
        });
    }


    protected function addWithoutTrashed(Builder $builder)
    {
        $builder->macro('withoutTrashed', function (Builder $builder) {
            $model = $builder->getModel();
            $column = $model->getQualifiedDeletedAtColumn();
            $builder->withoutGlobalScope($this)->where(
                $column, 0
            )->orWhere($column,'>',(int)$model->freshTimestampString());

            return $builder;
        });
    }

    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(function(Builder $builder) use($model) {
                $column = $model->getQualifiedDeletedAtColumn();
                $builder->where($column,'>=',1)->where($column,'<=',(int)$model->freshTimestampString());
            });
            return $builder;
        });
    }

}