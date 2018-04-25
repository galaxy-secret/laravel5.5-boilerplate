<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/19 16:15
 */


namespace App\Helpers\Api;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Traits\Api\ApiResponse;

class ExceptionReport {

    use ApiResponse;

    const VALIDATION_EXCEPTION_CODE = 60000;

    /**
     * @var Exception
     */
    public $exception;
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    protected $report;

    /**
     * ExceptionReport constructor.
     * @param Request $request
     * @param Exception $exception
     */
    function __construct(Request $request, Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }

    /**
     * @var array
     */
    public $doReport = [
        AuthenticationException::class => ['未授权',401],
        ModelNotFoundException::class => ['改模型未找到',404],
        ValidationException::class => ['invalid params', self::VALIDATION_EXCEPTION_CODE]
    ];

    /**
     * @return bool
     */
    public function shouldReturn(){

        if (! ($this->request->wantsJson() || $this->request->ajax())){
            return false;
        }

        foreach (array_keys($this->doReport) as $report){

            if ($this->exception instanceof $report){

                $this->report = $report;
                return true;
            }
        }

        return false;

    }

    /**
     * @param Exception $e
     * @return static
     */
    public static function make(Exception $e){
        return new static(\request(),$e);
    }

    /**
     * @return mixed
     */
    public function report(){

        if ($this->exception instanceof ValidationException){
            return $this->failed(json_encode($this->exception->errors()), self::VALIDATION_EXCEPTION_CODE);
        }

        $message = $this->doReport[$this->report];

        return $this->failed($message[0],$message[1]);

    }
}