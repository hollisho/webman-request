<?php

namespace hollisho\webman\request;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use support\exception\BusinessException;
use support\Request;
use think\Validate;
use Webman\App;

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
     * @throws BusinessException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $this->request = \request();
        if ($this->autoLoad) {
            $data = $this->request->all();
            $this->load($data);
            $this->autoValidate && $this->validate($this->throwable);
        }
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    abstract public function makeValidate();

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws BusinessException
     */
    public function validate(bool $throwable = false): bool
    {
        /** @var Validate $validate */
        $validate = App::container()->get($this->makeValidate());
        if (!$validate->check($this->getAttributes())) {
            if ($throwable) {
                throw new BusinessException($validate->getError());
            }

            $this->setErrors(is_array($validate->getError()) ? $validate->getError() : [$validate->getError()]);
        }

        return !$this->hasError();
    }
}