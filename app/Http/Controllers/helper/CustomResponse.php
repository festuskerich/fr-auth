<?php
namespace App\Http\Controllers\helper;

class CustomResponse {
    public $message;
    public $success;
    public $statusCode;
    public $data;
    public function __construct($message, $success, $statusCode, $data)
    {
        $this->message=$message;
        $this->success=$success;
        $this->statusCode=$statusCode;
        $this->data=$data;
    }
}
