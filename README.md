# laravel-luhn-validator

ID card valudator, luhn algorithm validator.

Laravel 身份验证, luhn 算法验证

### 安装

```bash
composer require themismin/laravel-luhn-validator
```

### 使用
```php
$rules = [
    'card_number' => [
        'required',
        'luhn'
    ]
];
```
