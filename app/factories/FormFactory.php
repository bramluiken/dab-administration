<?php

namespace App\Factories;

use App\Abstracts\FactoryAbstract;
use App\Abstracts\FormAbstract;
use Core\Error;

class FormFactory extends FactoryAbstract
{
    protected function resolveClassName(string $type): string
    {
        return 'App\Forms\\' . ucfirst($type) . 'Form';
    }

    /**
     * Create an instance of a Form based on the provided type.
     *
     * @param string $type       The form type (or alias)
     * @param array $parameters  Optional parameters to pass to the constructor.
     * @return FormAbstract      An instance of the form.
     * @throws Error            If the form class does not exist.
     * @throws \Exception       If the created form is not an instance of FormAbstract.
     */
    public function create(string $type, array $parameters = []): FormAbstract
    {
        $form = parent::create($type, $parameters);
        return $form;
    }
}