## install

```sh
composer require hollisho/webman-request
```

## basic use
> 内置了think validate验证器，通过依赖注入方式，自动生成请求对象，并对对象的字段做校验

```php
//定义Request对象
class MyRequest extend WebmanRequest
{
    // id
    public $id;

    // status
    public $status = 0;

    public function rules()
    {
        return [
            'id' => 'require|integer',
            'status' => 'require|integer',
        ];
    }

    protected function messages()
    {
        return [
            'id.required' => 'id不能为空',
            'id.integer' => 'id必须为整型',
            'status.required' => 'id不能为空',
        ];
    }
}


//在控制器中注入Reqeust
class IndexController extends Controller
{

    public function parserHtml(MyRequest $request)
    {
        ......
    }
}
```
