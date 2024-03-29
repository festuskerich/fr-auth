<?php

namespace App\Http\Controllers\helper;

class CustomResponse
{
    public $message;
    public $success;
    public $statusCode;
    public $data;
    public function __construct($message, $success, $statusCode, $data = null)
    {
        $this->message = $message;
        $this->success = $success;
        $this->statusCode = $statusCode;
        $this->data = $data;
        if ($data == null) {
            $this->data = "";
        }
    }
}
