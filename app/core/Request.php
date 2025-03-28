<?php

namespace App\Core;

class Request
{

 
    public $data;
    public $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
         parse_str(file_get_contents("php://input"), $this->data);
          $this->data = array_merge($_GET, $_POST,$_FILES, $this->data);
    // asdasdasd
    }
    public function input($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }
    public function __get($key){

        return $this->data[$key];
    }
}
