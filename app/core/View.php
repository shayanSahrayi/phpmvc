<?php

namespace App\Core;

use Error;

class View
{
    private static $instance;
    protected static $basePath = "/resources/view/";
    private function __construct() {}
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function render(String $template, array $data=null)
    {
       $fullPath = self::path($template);
        (function ($path) use ($data) {
            if($data){

                extract($data);
            }
            include $path;
        })($fullPath);
    }
    private static function path($path)
    {
        return dirname(dirname(__DIR__)).self::$basePath.str_replace('.', '/', $path).'.php';
    }
}
