<?php

namespace App\Abstracts;

use App\Factories\FormFieldFactory;

abstract class FormAbstract {
    protected FormFieldFactory $formFieldFactory;
    protected $fields = [];
    protected $action;
    protected $method;
    protected $tableName;
    protected $db;

    public function __construct($action = '', $method = 'post', $tableName = '', $db = null) {
        $this->action = $action;
        $this->method = $method;
        $this->tableName = $tableName;
        $this->db = $db;

        $this->formFieldFactory = new FormFieldFactory();

        $this->defineFields();
    }

    abstract protected function defineFields();

    protected function addField($type, $name, $label, $attributes = []) {
        $this->fields[] = $this->formFieldFactory->create($type, [$name, $label, $attributes]);
    }

    public function render() {
        $form = "<form action=\"{$this->action}\" method=\"{$this->method}\">";
        foreach ($this->fields as $field) {
            $form .= $field->render();
        }
        $form .= "<button type=\"submit\">Submit</button></form>";
        return $form;
    }

    // Default CRUD handling
    public function handle($data) {
        if ($this->validate($data)) {
            $sanitizedData = $this->sanitize($data);
            return $this->performCrud($sanitizedData);
        }
        return false;
    }

    protected function validate($data) {
        foreach ($this->fields as $field) {
            if (isset($data[$field->name])) {
                if (!$field->validate($data[$field->name])) {
                    return false;
                }
            }
        }
        return true;
    }

    protected function sanitize($data) {
        $sanitized = [];
        foreach ($this->fields as $field) {
            if (isset($data[$field->name])) {
                $sanitized[$field->name] = $field->sanitize($data[$field->name]);
            }
        }
        return $sanitized;
    }

    protected function performCrud($data) {
        if (!$this->db || !$this->tableName) {
            throw new \Core\Error(
                'system',
                'Operation requirements not met.',
                "Database connection or table name not set.");
        }

        // Example: Insert operation
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(fn($v) => $this->db->quote($v), array_values($data)));
        $query = "INSERT INTO {$this->tableName} ($columns) VALUES ($values)";
        return $this->db->exec($query);
    }
}