<?php

namespace App\Http\Controllers;

use InvalidArgumentException;

abstract class Controller
{

    protected function switchStatus(bool|string $status): string|bool
    {
        if (is_bool($status)) {
            return $status ? "Active" : "Inactive";
        }

        if (is_string($status)) {
            return $status === "Active";
        }

        throw new InvalidArgumentException("Invalid status type. Expected bool or string.");
    }

    function removeSpacesFromWorld(array $strings): array
    {
        return array_map(function ($string) {
            return str_replace(' ', '', $string);
        }, $strings);
    }


}
