<?php
namespace App\Core;

abstract class Middleware{
    public abstract function handle($request,$next);
}