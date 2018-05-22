<?php

/*
 * 错误调试
 */

namespace LisaoWx\open;

class OpenException extends \Exception {

    private $msg; //错误信息
    private $error_code; //错误代码

    public function __construct(string $error_code = '', string $message = "") {
        parent::__construct($message);
        $this->msg = $message;
        $this->error_code = $error_code;
    }

    /**
     * 获取错误信息
     * @return type
     */
    public function get_error_msg() {
        return $this->msg;
    }

    /**
     * 获取错误代码
     * @return type
     */
    public function get_error_code() {
        return $this->error_code;
    }

}
