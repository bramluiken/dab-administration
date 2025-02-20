<?php

namespace App\Abstracts;

abstract class FormFieldAbstract {
    public $name;
    protected $label;
    protected $attributes;
    protected $validationRules = [];
    protected $sanitizationRules = [];

    public function __construct($name, $label, $attributes = []) {
        $this->name = $name;
        $this->label = $label;
        $this->attributes = $attributes;
    }

    abstract public function render();

    public function validate($value) {
        foreach ($this->validationRules as $rule) {
            if (!$rule($value)) {
                return false;
            }
        }
        return true;
    }

    public function sanitize($value) {
        foreach ($this->sanitizationRules as $rule) {
            $value = $rule($value);
        }
        return $value;
    }

    public function addValidationRule(callable $rule) {
        $this->validationRules[] = $rule;
    }

    public function addSanitizationRule(callable $rule) {
        $this->sanitizationRules[] = $rule;
    }
}