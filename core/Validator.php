<?php

namespace Core;

class Validator
{
    private array $errors = [];

    /**
     * Returns true if the form is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->errors;
    }

    public function getError(string $fieldName): string
    {
        return $this->errors[$fieldName] ?? '';
    }

    public function validate(array $rules, array $payload): array
    {
        foreach ($rules as $key => $value){
            if(! $this->isInPayload($key, $payload)){
                continue;
            }
            $this->check($value, $key, $payload);
        }

        return $this->errors;
    }

    private function check(string $rule, string $fieldName, array $payload): void
    {
        $position = strpos($rule, '|');

        if($position === false){
            $this->doValidation($rule, $fieldName, $payload);
            return;
        }

        $this->doValidation(substr($rule, 0, $position), $fieldName, $payload);

        $this->check(substr($rule, $position + 1, strlen($rule)), $fieldName, $payload);
    }

    private function doValidation(string $rule, string $fieldName, array $payload): void
    {
        switch ($rule){
            case 'required':
                $this->isInPayload($fieldName, $payload);
                break;
            case 'string':
                $this->validateString($fieldName, $payload);
                break;
            case 'int':
                $this->validateInt($fieldName, $payload);
                break;
            default:
        }
    }

    private function validateString(string $fieldName, array $payload): void
    {
        if(
            is_string($payload[$fieldName]) &&
            !empty(trim($payload[$fieldName])) &&
            !is_numeric($payload[$fieldName])
        ){
            return;
        }

        $this->errors[$fieldName] = "The $fieldName is not a valid string!";
    }

    private function validateInt(string $fieldName, array $payload): void
    {
        if(
            is_numeric($payload[$fieldName]) &&
            is_int((int)$payload[$fieldName])
        ){
            return;
        }

        $this->errors[$fieldName] = "The $fieldName is not a valid integer!";
    }

    private function isInPayload(string $fieldName, array $payload): bool
    {
        if(! isset($payload[$fieldName]) || empty(trim($payload[$fieldName]))){
            $this->errors[$fieldName] = "The $fieldName is required!";
            return false;
        }
        
        return true;
    }
}