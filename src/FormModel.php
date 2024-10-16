<?php

namespace hollisho\webman\request;

use hollisho\objectbuilder\HObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use support\exception\BusinessException;
use think\Validate;
use Webman\App;

class FormModel extends HObject
{

    /**
     * @var array
     */
    private $errors;


    protected $rule = [];

    protected $message = [];

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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws BusinessException
     */
    public function validate(bool $throwable = false): bool
    {
        /** @var Validate $validate */
        $validate = App::container()->get(Validate::class);
        $validate->message($this->message);
        if (!$validate->check($this->getAttributes(), $this->rule)) {
            if ($throwable) {
                throw new BusinessException($validate->getError());
            }

            $this->setErrors(is_array($validate->getError()) ? $validate->getError() : [$validate->getError()]);
        }

        return !$this->hasError();
    }


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