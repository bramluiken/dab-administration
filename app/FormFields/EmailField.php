<?php

namespace App\FormFields;

use App\Abstracts\FormFieldAbstract;

class EmailField extends FormFieldAbstract {
    public function render() {
        $attrs = '';
        foreach ($this->attributes as $key => $value) {
            $attrs .= " $key=\"$value\"";
        }

        $errmsg = !empty($this->error)
            ? "<div class=\"form-error\">{$this->error}</div>"
            : '';
        
        return "<div class=\"form-group\">
            <label for=\"{$this->name}\">{$this->label}</label>
            <input type=\"email\" name=\"{$this->name}\" id=\"{$this->name}\"$attrs>
            $errmsg
        </div>";
    }

    public function __construct($name, $label, $attributes = []) {
        parent::__construct($name, $label, $attributes);
        $this->addValidationRule(fn($value) => filter_var($value, FILTER_VALIDATE_EMAIL), 'email invalid');
        $this->addSanitizationRule(fn($value) => filter_var($value, FILTER_SANITIZE_EMAIL));
    }
}