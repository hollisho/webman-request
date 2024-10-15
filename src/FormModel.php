<?php

namespace hollisho\webman\request;

use hollisho\objectbuilder\HObject;
use support\exception\BusinessException;
use Webman\Exception\NotFoundException;

abstract class FormModel extends HObject
{

    /**
     * @var array
     */
    private $errors;


    protected function rules()
    {
        return [];
    }

    protected function messages()
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
     * @return mixed
     */
    abstract public function makeValidate();


    /**
     * @param bool $throwable
     * @return bool
     * @throws BusinessException
     * @throws NotFoundException
     */
    public function validate($throwable = false)
    {
        $validate = $this->makeValidate();

        if (!$validate->check($this->getAttributes())) {
            if ($throwable) {
                throw new BusinessException($validate->getError());
            }

            $this->setErrors(is_array($validate->getError()) ? $validate->getError() : [$validate->getError()]);
        }

        return !$this->hasError();
    }


    /**
     * @param null|string $attribute
     * @return bool
     */
    public function hasError($attribute = null)
    {
        return $attribute === null ? !empty($this->getErrors()) : isset($this->errors[$attribute]);
    }

    /**
     * @return mixed
     */
    public function getErrors()
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