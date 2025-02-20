<?php

namespace App\Factories;

use App\Abstracts\FactoryAbstract;
use App\Abstracts\FormFieldAbstract;
use Core\Error;

class FormFieldFactory extends FactoryAbstract
{
    /**
     * Map a short type identifier to the fully-qualified class name.
     *
     * For example, "text" maps to "App\FormFields\TextField".
     *
     * @param string $type
     * @return string
     */
    protected function resolveClassName(string $type): string
    {
        return 'App\FormFields\\' . ucfirst($type) . 'Field';
    }

    /**
     * Create an instance of a form field.
     *
     * @param string $type       The product type (or alias)
     * @param array  $parameters Optional parameters to pass to the constructor.
     * @return FormFieldAbstract An instance of the resolved product.
     * @throws Error            If the class doesn’t exist.
     */
    public function create(string $type, array $parameters = []): FormFieldAbstract
    {
        $product = parent::create($type, $parameters);
        return $product;
    }
}