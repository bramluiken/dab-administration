<?php

namespace App\Factories;

use App\Abstracts\FactoryAbstract;
use App\Abstracts\FormAbstract;

class FormFactory extends FactoryAbstract
{
    protected function resolveClassName(string $type): string
    {
        return 'App\Forms\\' . ucfirst($type) . 'Form';
    }

    public static function create(string $type, array $parameters = []): FormAbstract{
        return parent::create($type, $parameters);
    }
}