<?php

namespace hollisho\webman\request;

use hollisho\objectbuilder\HObject;

abstract class FormModel extends HObject
{

    /**
     * @var array
     */
    private $errors;


    protected function rules(): array
    {
        return [];
    }

    protected function messages(): array
    {
        return [];
    }

    /**
     * @param $data
     * @return bool
     */
    public function load($data)
    {
        if (!empty($data) && is_array($data)) {
            $this->setAttributes($data);

            return true;
        }

        return false;
    }

    /**
     * @param bool $throwable
     * @return bool
     */
    abstract public function validate(bool $throwable = false): bool;


    /**
     * @param string|null $attribute
     * @return bool
     */
    public function hasError(string $attribute = null): bool
    {
        return $attribute === null ? !empty($this->getErrors()) : isset($this->errors[$attribute]);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors === null ? [] : $this->errors;
    }

    /**
     * @param array $errors
     */
    protected function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

}