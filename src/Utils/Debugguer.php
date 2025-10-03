<?php
declare(strict_types = 1);

namespace Debugguer
{
    function debug($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}