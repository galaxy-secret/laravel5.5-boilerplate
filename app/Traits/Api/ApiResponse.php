<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/19 16:16
 */

namespace App\Traits\Api;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;


trait ApiResponse
{

    /**
     * @var int
     */
    protected $http_status_code = FoundationResponse::HTTP_OK;
    protected $http_headers = [];

    /**
     * @return array
     */
    public function getHttpHeaders(): array
    {
        return $this->http_headers;
    }

    /**
     * @param array $http_headers
     * @return ApiResponse
     */
    public function setHttpHeaders(array $http_headers): ApiResponse
    {
        $this->http_headers = $http_headers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHTTPStatusCode()
    {
        return $this->http_status_code;
    }

    /**
     * @param $http_status_code
     * @return $this
     */
    public function setHTTPStatusCode($http_status_code)
    {
        $this->http_status_code = $http_status_code;
        return $this;
    }

    /**
     * @param $data
     * @param $http_status_code
     * @param array $header
     * @return mixed
     */
    public function respond($data, $http_status_code = null, $header = [])
    {
        $header = empty($header) ? $this->getHttpHeaders(): array_merge_recursive($this->getHttpHeaders(), $header);
        $http_status_code = $http_status_code ?? $this->getHTTPStatusCode();
        return Response::json($data,$http_status_code,$header);
    }

    /**
     * @param $message
     * @param array $data
     * @param $code
     * @param null $http_status_code
     * @return mixed
     */
    public function packResponse($message, array $data, $code = 200, $http_status_code = null){
        if ($http_status_code){
            $this->setHTTPStatusCode($http_status_code);
        }
        $send = [
            'code' => $code,
            'data' => null,
            'message' => $message,
        ];
        $send = array_merge($send, $data);
        return $this->respond($send, $http_status_code);
    }

    /**
     * @param string $message
     * @param array $data
     * @param null $code
     * @param null $http_status_code
     * @return mixed
     * @author pandaria
     * @date 2018/4/20 13:35
     */
    public function message($message = "success", $data = [], $code = null, $http_status_code = null){
        return $this->packResponse($message, $data, $code, $http_status_code);
    }

    /**
     * @param $message
     * @param int $code
     * @param $http_status_code
     * @return mixed
     */
    public function failed($message, $code, $http_status_code = FoundationResponse::HTTP_BAD_REQUEST){
        return $this->message($message,[], $code, $http_status_code);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!"){
        return $this->failed($message,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @param array $data
     * @return mixed
     */
    public function created($data = [], $message = "created")
    {
        return $this->message($message, $data, FoundationResponse::HTTP_CREATED, FoundationResponse::HTTP_CREATED);
    }

    /**
     * @param $data
     * @param string $message
     * @return mixed
     */
    public function success($data, $message = "success"){
        return $this->message($message,$data, FoundationResponse::HTTP_OK);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message, Foundationresponse::HTTP_NOT_FOUND, Foundationresponse::HTTP_NOT_FOUND);
    }



}