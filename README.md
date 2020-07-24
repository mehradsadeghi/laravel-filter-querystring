# Laravel Token Generator
#### Generate tokens based on your desire driver and algorithms

### Installation
`$ composer require mehradsadeghi/laravel-token-generator`

### Publishing config file
It'll work with the default configurations, But you can publish the config file in order to change defaults or add your custom driver.

`$ php artisan vendor:publish`

### Drivers
There are 3 drivers available: 
- Basic
- Crypto
- Unique

*You can set the default driver in `config/token-generator.php` or in your `.env` file by `TOKEN_GENERATOR_DEFAULT` key.*

#### Basic
It simply generates a random token.

Example:
```php
\Mehradsadeghi\TokenGenerator\TokenGeneratorFacade::generate();
```
You can also change the default length of token in config file:
```php
'basic' => [
    'driver' => \Mehradsadeghi\TokenGenerator\Drivers\Basic::class,
    'options' => [
        'length' => 10
    ]
]
```
         
#### Crypto
It generates cryptographically secure pseudo-random token.
 
#### Unique
It generates a hashed (unique) token, based on given algorithm. You can specify the algorithm in `options` index of `unique` driver array.
```php
'unique' => [
    'driver' => \Mehradsadeghi\TokenGenerator\Drivers\Unique::class,
    'options' => [
        'alg' => 'sha256'
    ]
]
```
Example:
```php
\Mehradsadeghi\TokenGenerator\TokenGeneratorFacade::generate('your input');
```

### Helper Function
`token()` helper function and `TokenGeneratorFacade` can be used interchangeably. For example:

```php
token()->generate();
```

### Switching Drivers Dynamically
You can switch generator driver dynamically at run-time:

```php
token()->generate(); // default driver
token()->driver('crypto')->generate(); // crypto driver
```
also
```php
TokenGeneratorFacade::driver('crypto')->generate();
```
### Extending Token Generator
You can set up your own custom driver in a few steps. 

1) Add your desired configuration into `token-generator` config file:

```php
return [

    'default' => env('TOKEN_GENERATOR_DEFAULT', 'basic'),

    'drivers' => [

        ...

        'new_driver' => [
            'driver' => Path\To\Your\CustomGenerator::class,
            'options' => [
                'length' => 20
            ]
        ]
    ]
];
```
*Note that `options` is optional.*

2) Create the `CustomGenerator.php` :

```php

use Mehradsadeghi\TokenGenerator\TokenGeneratorContract;

class CustomGenerator implements TokenGeneratorContract
{
    private $length;

    public function __construct($length)
    {
        $this->length = $length;
    }

    public function generate(): string
    {
        // your logic to generate token
    }
}

```

3) And finally:
```php
token()->driver('new_driver')->generate();
```