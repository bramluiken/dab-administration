<?php

namespace App\FormFields;

use App\Abstracts\FormFieldAbstract;

class SelectField extends FormFieldAbstract {
    private $options;

    public function __construct($name, $label, $attributes = []) {
        parent::__construct($name, $label, $attributes);
        $this->options = $attributes['options'];
    }

    public function render() {
        $attrs = '';
        foreach ($this->attributes as $key => $value) {
            $attrs .= " $key=\"$value\"";
        }

        $options = '';
        foreach ($this->options as $value => $label) {
            $options .= "<option value=\"$value\">$label</option>";
        }

        $errmsg = !empty($this->error)
            ? "<div class=\"form-error\">{$this->error}</div>"
            : '';
        
        return "<div class=\"form-group\">
            <label for=\"{$this->name}\">{$this->label}</label>
            <select name=\"{$this->name}\" id=\"{$this->name}\"$attrs>$options</select>
            $errmsg
        </div>";
    }
}