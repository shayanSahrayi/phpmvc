<?php

use App\Core\View;

function view($template, $data=null)
{
    $view = View::getInstance();

    if (empty(trim($template)))    throw new InvalidArgumentException("Template name cannot be empty.");

    try {
        return  $view->render($template, $data);
    } catch (Exception $e) {
         throw new Exception("View rendering failed: " . $e->getMessage());
    }
}
