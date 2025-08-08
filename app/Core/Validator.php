<?php

namespace App\Core;

class Validator
{
    protected array $errors = [];

    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $ruleset) {
            $value = $data[$field] ?? null;
            $this->validateField($field, $value, $ruleset);
        }
        return $this;
    }

    protected function validateField(string $field, $value, string $rules): void
    {
        $rules = explode('|', $rules);
        foreach ($rules as $rule) {
            $this->applyRule($field, $value, $rule);
        }
    }

    protected function applyRule(string $field, $value, string $rule): void
    {
        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, 'Field is required');
                }
                break;
            case (str_starts_with($rule, 'min:') ? $rule : null):
                $min = (int) substr($rule, 4);
                if (strlen($value) < $min) {
                    $this->addError($field, "Field must be at least $min characters");
                }
                break;
        }
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}