<?php

namespace App\Factories;

use App\Abstracts\FactoryAbstract;
use App\Abstracts\FormFieldAbstract;

class FormFieldFactory extends FactoryAbstract
{
    protected function resolveClassName(string $type): string
    {
        // Conventions: 'text' => 'App\FormFields\TextField', 'password' => 'App\FormFields\PasswordField', etc.
        return 'App\FormFields\\' . ucfirst($type) . 'Field';
    }

    public static function create(string $type, array $parameters = []): FormFieldAbstract{
        return parent::create($type, $parameters);
    }
}