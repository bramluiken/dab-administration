<?php

namespace App\FormFields;

use App\Abstracts\FormFieldAbstract;

class EmailField extends FormFieldAbstract {
    public function render() {
        $attrs = '';
        foreach ($this->attributes as $key => $value) {
            $attrs .= " $key=\"$value\"";
        }
        return "<label for=\"{$this->name}\">{$this->label}</label><input type=\"email\" name=\"{$this->name}\"$attrs>";
    }

    public function __construct($name, $label, $attributes = []) {
        parent::__construct($name, $label, $attributes);
        $this->addValidationRule(fn($value) => filter_var($value, FILTER_VALIDATE_EMAIL));
        $this->addSanitizationRule(fn($value) => filter_var($value, FILTER_SANITIZE_EMAIL));
    }
}