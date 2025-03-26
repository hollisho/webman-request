# Webman框架请求验证器扩展包

> 本扩展包为Webman框架提供了一个优雅的请求验证解决方案，内置了ThinkPHP验证器，通过依赖注入方式自动生成请求对象，并对对象的字段进行校验。

## 安装

通过Composer安装：

```sh
composer require hollisho/webman-request
```

## 基本使用

### 定义请求类

首先，创建一个继承自`WebmanRequest`的请求类：

```php
<?php

namespace app\request;

use Hollisho\WebmanRequest\WebmanRequest;

class MyRequest extends WebmanRequest
{
    // 定义请求参数属性
    public $id;
    public $status = 0; // 可以设置默认值
    
    // 定义验证规则
    public function rules()
    {
        return [
            'id' => 'require|number',
            'status' => 'require|number',
        ];
    }
    
    // 定义错误消息
    protected function messages()
    {
        return [
            'id.require' => 'id不能为空',
            'id.number' => 'id必须为数字',
            'status.require' => 'status不能为空',
            'status.number' => 'status必须为数字',
        ];
    }
}
```

### 在控制器中使用

在控制器中通过依赖注入方式使用请求类：

```php
<?php

namespace app\controller;

use app\request\MyRequest;
use support\Response;

class IndexController
{
    public function index(MyRequest $request)
    {
        // 验证通过后，可以直接使用请求对象的属性
        $id = $request->id;
        $status = $request->status;
        
        // 业务逻辑处理...
        return json(['code' => 0, 'msg' => 'success', 'data' => [
            'id' => $id,
            'status' => $status
        ]]);
    }
}
```

## 常用验证规则

本扩展包内置了ThinkPHP验证器的所有验证规则，以下是一些常用的验证规则：

| 规则 | 说明 | 示例 |
| --- | --- | --- |
| require | 必须填写 | 'name' => 'require' |
| number | 必须是数字 | 'age' => 'number' |
| integer | 必须是整数 | 'count' => 'integer' |
| float | 必须是浮点数 | 'price' => 'float' |
| boolean | 必须是布尔值 | 'status' => 'boolean' |
| email | 必须是邮箱格式 | 'email' => 'email' |
| array | 必须是数组 | 'tags' => 'array' |
| date | 必须是日期格式 | 'birthday' => 'date' |
| alpha | 必须是字母 | 'name' => 'alpha' |
| alphaNum | 必须是字母和数字 | 'account' => 'alphaNum' |
| alphaDash | 必须是字母、数字、下划线或破折号 | 'username' => 'alphaDash' |
| chs | 必须是中文 | 'name' => 'chs' |
| chsAlpha | 必须是中文或字母 | 'name' => 'chsAlpha' |
| chsAlphaNum | 必须是中文、字母或数字 | 'name' => 'chsAlphaNum' |
| chsDash | 必须是中文、字母、数字、下划线或破折号 | 'name' => 'chsDash' |
| url | 必须是URL地址 | 'website' => 'url' |
| ip | 必须是IP地址 | 'ip' => 'ip' |
| mobile | 必须是手机号码 | 'mobile' => 'mobile' |
| idCard | 必须是身份证号码 | 'idcard' => 'idCard' |
| zipCode | 必须是邮政编码 | 'zipcode' => 'zipCode' |
| in | 必须在范围内 | 'type' => 'in:1,2,3' |
| notIn | 必须不在范围内 | 'type' => 'notIn:1,2,3' |
| between | 必须在范围内 | 'age' => 'between:18,60' |
| notBetween | 必须不在范围内 | 'age' => 'notBetween:0,17' |
| length | 长度必须在范围内 | 'name' => 'length:2,20' |
| max | 最大长度 | 'name' => 'max:20' |
| min | 最小长度 | 'password' => 'min:6' |
| after | 必须在日期之后 | 'begin_time' => 'after:2020-01-01' |
| before | 必须在日期之前 | 'end_time' => 'before:2030-01-01' |
| confirm | 必须和指定字段相同 | 'repassword' => 'confirm:password' |
| different | 必须和指定字段不同 | 'nickname' => 'different:username' |
| eq | 必须等于指定值 | 'status' => 'eq:1' |
| neq | 必须不等于指定值 | 'status' => 'neq:0' |
| gt | 必须大于指定值 | 'age' => 'gt:18' |
| lt | 必须小于指定值 | 'age' => 'lt:60' |
| egt | 必须大于等于指定值 | 'age' => 'egt:18' |
| elt | 必须小于等于指定值 | 'age' => 'elt:60' |
| regex | 必须满足正则表达式 | 'zip' => 'regex:/^\d{6}$/' |


## 总结

`hollisho/webman-request`扩展包为Webman框架提供了一个强大而灵活的请求验证解决方案，通过依赖注入的方式自动验证请求参数，使代码更加简洁和易于维护。它支持多种验证规则、自定义验证规则、验证场景等高级功能，能够满足各种复杂的验证需求。

## 参考链接

- [Webman官方文档](https://www.workerman.net/doc/webman/)
- [ThinkPHP验证器文档](https://www.kancloud.cn/manual/thinkphp5_1/360141)

## 特别说明

## 特别说明

- 由于thinkphp验证器的原因，本扩展包不支持php8.0以上的版本，请在使用前确认您的PHP版本。
- 本扩展包仅提供了基本的请求验证功能，对于更复杂的验证需求，您可以根据实际情况自行扩展。（例如场景的支持目前尚未支持）