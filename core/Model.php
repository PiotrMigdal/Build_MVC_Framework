<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public array $errors;

    public function loadData($data)
    {
        // Assign posted data to model properties (RegisterModel->firstname...)
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function Rules(): array;
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            // value can be $this->firstname
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                //if rule is array assign its first iteration
                if(!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                // Rule no 1 - check if required and no value
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    // if not met rule, add an error
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                // Rule no 2 - check if rule exists and if email is valid, add an error if not valid email
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                // Rule no 3 - return error if rule exist and posted value length is less than min
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                // Rule no 4 - return error if rule exist and posted value length is more than min
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                // Rule no 5 - return error if rule exist and value mach the value specified in match array $this->password
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        // Go through rule params and replace tild with a value min => 8 to show the min value in the message
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        // save error in errors array
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be email',
            self::RULE_MIN => 'Min length mast be {min}',
            self::RULE_MAX => 'Max length must be {max}',
            self::RULE_MATCH => 'This field must match {match}'
        ];
    }
}