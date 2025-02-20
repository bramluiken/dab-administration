<?php

namespace App\FormFields;

use App\Abstracts\FormFieldAbstract;

class PasswordField extends FormFieldAbstract {
    public function render() {
        $attrs = '';
        foreach ($this->attributes as $key => $value) {
            $attrs .= " $key=\"$value\"";
        }
        return "<label for=\"{$this->name}\">{$this->label}</label><input type=\"password\" name=\"{$this->name}\" id=\"{$this->name}\"$attrs>";
    }
}