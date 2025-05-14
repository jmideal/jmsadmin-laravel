<?php

namespace App\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class UsePermission
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
