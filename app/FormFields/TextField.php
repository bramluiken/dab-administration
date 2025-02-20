<?php

namespace App\FormFields;

use App\Abstracts\FormFieldAbstract;

class TextField extends FormFieldAbstract {
    public function render() {
        $attrs = '';
        foreach ($this->attributes as $key => $value) {
            $attrs .= " $key=\"$value\"";
        }
        return "<label for=\"{$this->name}\">{$this->label}</label><input type=\"text\" name=\"{$this->name}\"$attrs>";
    }
}