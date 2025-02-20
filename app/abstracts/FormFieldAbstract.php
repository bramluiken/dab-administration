<?php

namespace App\Abstracts;

abstract class FormFieldAbstract {
    public $name;
    protected $label;
    protected $attributes;
    protected $validationRules = [];
    protected $sanitizationRules = [];
    protected $error;

    public function __construct($name, $label, $attributes = []) {
        $this->name = $name;
        $this->label = $label;
        $this->attributes = $attributes;
    }

    abstract public function render();

    /**
     * Validate the $value using each validation rule.
     * If the rule fails, set the error message and return false.
     */
    public function validate($value) {
        foreach ($this->validationRules as $validation) {
            $rule = $validation['rule'];
            $error = $validation['error'];
            if (!$rule($value)) {
                $this->error = $error;
                return false;
            }
        }
        return true;
    }

    /**
     * Sanitize the $value using each sanitization rule.
     */
    public function sanitize($value) {
        foreach ($this->sanitizationRules as $rule) {
            $value = $rule($value);
        }
        return $value;
    }

    /**
     * Add a validation rule along with an error message.
     * 
     * @param callable $rule The validation rule as a callable.
     * @param string $error The error message to set if the rule fails.
     */
    public function addValidationRule(callable $rule, string $error) {
        $this->validationRules[] = [
            'rule'  => $rule,
            'error' => $error,
        ];
    }

    /**
     * Add a sanitization rule.
     * 
     * @param callable $rule The sanitization rule as a callable.
     */
    public function addSanitizationRule(callable $rule) {
        $this->sanitizationRules[] = $rule;
    }

    /**
     * Retrieve the error message after validation failure.
     *
     * @return string|null
     */
    public function getError() {
        return $this->error;
    }
}