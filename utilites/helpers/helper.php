<?php

function redirect($url)
{
    $url = "http://localhost/" . BASE_DOMAIN . $url;
    header("Location:$url");
    die();
}

function redirectBack()
{
    $url = $_SERVER['HTTP_REFERER'] ?? '';
    header("Location:$url");
    die();
}

function assets($url)
{

    return  "/public/assets/$url";
    // return "public/assets/$url";
    // return "7_box/public/assets/"

}

function url($url)
{
    $url = "http://localhost/" . BASE_DOMAIN . $url;
    return $url;
}

function saveImage($from, $imageName, $path)
{

    $mim = mime_content_type($from);
    $allowedMimes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',
        'image/tiff',
        'image/heic',
    ];
    if (!in_array($mim, $allowedMimes)) {
        return false;
    }


    $ext = pathinfo($imageName, PATHINFO_EXTENSION);
    $allowTypes = ['jpg', 'png', 'jpeg', 'tiff', 'gif', 'webp', 'svg', 'HEIC', 'H.264'];
    if (!in_array($ext, $allowTypes)) {
        return false;
    }


    $path_main = BASE_PATH . "/public/assets/" . $path . "/";
    if (!is_dir($path_main)) {
        mkdir($path_main, 0755, true);
    }

    if (!is_uploaded_file($from)) {

        return false;
    }
    $uniq = bin2hex(random_bytes(16)) . "." . $ext;
    $fullPath = $path_main . $uniq;
    if (move_uploaded_file($from, $fullPath)) {
        return $path . "/" . $uniq;
    }
    return false;
}
