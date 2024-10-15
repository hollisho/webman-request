<?php

namespace hollisho\webman\request;

use support\exception\BusinessException;
use support\Request;
use Webman\Exception\NotFoundException;

abstract class WebmanRequest extends FormModel
{
    private $request;

    /**
     * 自动加载数据
     * @var bool
     */
    protected $autoLoad = true;

    /**
     * 自动验证数据
     * @var bool
     */
    protected $autoValidate = true;

    /**
     * 验证不通过抛异常
     * @var bool
     */
    protected $throwable = true;

    /**
     * BaseRequestBo constructor.
     * @param Request $request
     * @throws NotFoundException
     * @throws BusinessException
     */
    public function __construct()
    {
        $request = \request();
        if ($this->autoLoad) {
            $data = $request->all();
            $this->load($data);
            $this->autoValidate && $this->validate($this->throwable);
            $this->request = $request;
        }
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    abstract public function makeValidate();

    public function validate(bool $throwable = false): bool
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
}