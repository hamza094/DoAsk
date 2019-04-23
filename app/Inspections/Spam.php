<?php

namespace App\Inspections;

class Spam
{
    protected $inspection = [
        InvalidsKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {
        foreach ($this->inspection as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
