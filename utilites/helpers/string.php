<?php

function dd(...$paramets)
{
    echo "<pre>";
    var_dump(...$paramets);
    echo "</pre>";
}
function ddd(...$paramets)
{
    echo "<pre>";
    var_dump(...$paramets);
    echo "</pre>";
    exit;
}
