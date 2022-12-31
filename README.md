# PHP hydrator - это библиотека для переноса данных из массива в объект и из объекта в массив

[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
![Coverage Status][badge-coverage]
[![Total Downloads][badge-downloads]][downloads]

Библиотека позволяет переносить данные из массива в объект и обратно.

Возможны следующие операции:

- конвертация данных в `Array` из `Object`;
- заполнить данными `Object` из `Array`.

## Установка

Установить этот пакет можно как зависимость, используя Composer.

``` bash
composer require fi1a/hydrator
```

## Hydrator. Перенос данных из массива в объект

Класс `Fi1a\Hydrator\Hydrator()` позволяет заполнить данными объект.
Пример:

```php
use Fi1a\Hydrator\Hydrator;

class Foo {
    /**
     * @var string
     */
    public $propertyBar;
    
    /**
     * @var int
     */
    protected $propertyBaz;

    /**
     * @var bool
     */
    private $propertyQux;
}

$hydrator = new Hydrator();

/**
 * @var Foo $model
 */
$model = $hydrator->hydrate([
    'propertyBar' => 'value',
    'propertyBaz' => 1,
    'propertyQux' => true,
], Foo::class);

$model->propertyBar; // 'value'
```

Метод `hydrate` создает объект переданного класса, для заполнения данными уже существующего объекта нужно использовать
метод `hydrateModel`:

```php
use Fi1a\Hydrator\Hydrator;
use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;

class Foo {
    /**
     * @var string
     */
    public $propertyBar;

    /**
     * @var int
     */
    protected $propertyBaz;

    /**
     * @var bool
     */
    private $propertyQux;
}

$hydrator = new Hydrator();

$model = new Foo();

$hydrator->hydrateModel([
    'propertyBar' => 'value',
    'propertyBaz' => 1,
    'propertyQux' => true,
], $model);

$model->propertyBar; // 'value'
```

### Стратегия Fi1a\Hydrator\HydrateStrategies\HydrateStrategy

Стратегия для переноса данных из массива в объект без вызова методов сеттеров объекта. Является стратегией по умолчанию.

```php
use Fi1a\Hydrator\Hydrator;

class Foo {
    /**
     * @var string
     */
    public $propertyBar;
    
    /**
     * @var int
     */
    protected $propertyBaz;

    /**
     * @var bool
     */
    private $propertyQux;
}

$hydrator = new Hydrator();

/**
 * @var Foo $model
 */
$model = $hydrator->hydrate([
    'propertyBar' => 'value',
    'propertyBaz' => 1,
    'propertyQux' => true,
], Foo::class);

$model->propertyBar; // 'value'
```

### Стратегия Fi1a\Hydrator\HydrateStrategies\HydrateCallSettersStrategy

Стратегия для переноса данных из массива в объект с вызовом сеттеров.

```php
use Fi1a\Hydrator\Hydrator;
use Fi1a\Hydrator\HydrateStrategies\HydrateCallSettersStrategy;

class Foo {
    public $propertyBar;

    protected $propertyBaz;

    private $propertyQux;

    protected function setPropertyBaz(int $propertyBaz): void
    {
        $this->propertyBaz = $propertyBaz + 1;
    }

    public function getPropertyBaz(): int
    {
        return $this->propertyBaz;
    }
}


$hydrator = new Hydrator(new HydrateCallSettersStrategy());

/**
 * @var Foo $model
 */
$model = $hydrator->hydrate([
    'propertyBar' => 'value',
    'propertyBaz' => 1,
    'propertyQux' => true,
], Foo::class);

$model->getPropertyBaz(); // 2
```

### Стратегия Fi1a\Hydrator\HydrateStrategies\HydratePublicCallSettersStrategy

Стратегия для переноса данных из массива в объект с вызовом только публичных сеттеров.

```php
use Fi1a\Hydrator\Hydrator;
use Fi1a\Hydrator\HydrateStrategies\HydratePublicCallSettersStrategy;

class Foo {
    public $propertyBar;

    protected $propertyBaz;

    private $propertyQux;

    public function setPropertyBaz(int $propertyBaz): void
    {
        $this->propertyBaz = $propertyBaz + 2;
    }

    public function getPropertyBaz(): int
    {
        return $this->propertyBaz;
    }
}


$hydrator = new Hydrator(new HydratePublicCallSettersStrategy());

/**
 * @var Foo $model
 */
$model = $hydrator->hydrate([
    'propertyBar' => 'value',
    'propertyBaz' => 1,
    'propertyQux' => true,
], Foo::class);

$model->getPropertyBaz(); // 3
```

## Extractor. Перенос данных из объекта в массив

Класс `Fi1a\Hydrator\Extractor()` осуществляет извлечение данных из объекта в массив.
Пример:

```php
use Fi1a\Hydrator\Extractor;

class Foo {
    /**
     * @var string
     */
    public $propertyBar = 'value';

    /**
     * @var int
     */
    protected $propertyBaz = 1;

    /**
     * @var bool
     */
    private $propertyQux = true;
}

$model = new Foo();

$hydrator = new Extractor();

$data = $hydrator->extract($model); // ['propertyBar' => 'value',]
```

Можно указать какие свойства нужно извлечь с помощью аргумента `$keys` метода `Fi1a\Hydrator\Extractor::extract`:

```php
use Fi1a\Hydrator\Extractor;

class Foo {
    /**
     * @var string
     */
    public $propertyBar = 'value';

    /**
     * @var int
     */
    protected $propertyBaz = 1;

    /**
     * @var bool
     */
    private $propertyQux = true;
}

$model = new Foo();

$hydrator = new Extractor();

$data = $hydrator->extract($model, ['propertyBar', 'propertyBaz']); // ['propertyBar' => 'value', 'propertyBaz' => 1,]
```

### Стратегия Fi1a\Hydrator\ExtractStrategies\ExtractPublicCallGettersStrategy

Стратегия переноса данных из объекта в массив с вызовом публичных геттеров.
Если ключи массива в метод `Fi1a\Hydrator\Extractor::extract` не переданы, будут получены все публичные свойства объекта
и свойства, имеющие публичные геттеры, иначе будут получены только переданные свойства. Является стратегией по умолчанию.

```php
use Fi1a\Hydrator\Extractor;
use Fi1a\Hydrator\ExtractStrategies\ExtractPublicCallGettersStrategy;

class Foo {
    /**
     * @var string
     */
    public $propertyBar = 'value';

    /**
     * @var int
     */
    protected $propertyBaz = 1;

    /**
     * @var bool
     */
    private $propertyQux = true;

    public function getPropertyBaz(): int
    {
        return $this->propertyBaz;
    }
}

$model = new Foo();

$hydrator = new Extractor(new ExtractPublicCallGettersStrategy());

$data = $hydrator->extract($model); // ['propertyBar' => 'value', 'propertyBaz' => 1,]
```

### Стратегия Fi1a\Hydrator\ExtractStrategies\ExtractCallGettersStrategy

Стратегия переноса данных из объекта в массив с вызовом геттеров.
Если ключи массива в метод `Fi1a\Hydrator\Extractor::extract` не переданы, будут получены все свойства объекта и вызваны их геттеры,
иначе будут получены только переданные свойства.

```php
use Fi1a\Hydrator\Extractor;
use Fi1a\Hydrator\ExtractStrategies\ExtractCallGettersStrategy;

class Foo {
    /**
     * @var string
     */
    public $propertyBar = 'value';

    /**
     * @var int
     */
    protected $propertyBaz = 1;

    /**
     * @var bool
     */
    private $propertyQux = true;

    public function getPropertyBaz(): int
    {
        return $this->propertyBaz;
    }
}

$model = new Foo();

$hydrator = new Extractor(new ExtractCallGettersStrategy());

$data = $hydrator->extract($model); // ['propertyBar' => 'value', 'propertyBaz' => 1, 'propertyQux' => true]
```

### Стратегия Fi1a\Hydrator\ExtractStrategies\ExtractPublicStrategy

Стратегия переноса публичных свойств из объекта в массив.
Если ключи массива в метод `Fi1a\Hydrator\Extractor::extract` не переданы, будут получены все публичные свойства объекта,
иначе будут получены только переданные свойства.

```php
use Fi1a\Hydrator\Extractor;
use Fi1a\Hydrator\ExtractStrategies\ExtractPublicStrategy;

class Foo {
    /**
     * @var string
     */
    public $propertyBar = 'value';

    /**
     * @var int
     */
    protected $propertyBaz = 1;

    /**
     * @var bool
     */
    private $propertyQux = true;

    public function getPropertyBaz(): int
    {
        return $this->propertyBaz;
    }
}

$model = new Foo();

$hydrator = new Extractor(new ExtractPublicStrategy());

$data = $hydrator->extract($model); // ['propertyBar' => 'value',]
```

### Стратегия Fi1a\Hydrator\ExtractStrategies\ExtractStrategy

Стратегия переноса данных из объекта в массив.
Если ключи массива в метод `Fi1a\Hydrator\Extractor::extract` не переданы, будут получены все свойства объекта,
иначе будут получены только переданные свойства.

```php
use Fi1a\Hydrator\Extractor;
use Fi1a\Hydrator\ExtractStrategies\ExtractStrategy;

class Foo {
    /**
     * @var string
     */
    public $propertyBar = 'value';

    /**
     * @var int
     */
    protected $propertyBaz = 1;

    /**
     * @var bool
     */
    private $propertyQux = true;

    public function getPropertyBaz(): int
    {
        return $this->propertyBaz;
    }
}

$model = new Foo();

$hydrator = new Extractor(new ExtractStrategy());

$data = $hydrator->extract($model); // ['propertyBar' => 'value', 'propertyBaz' => 1, 'propertyQux' => true]
```

## Наименование ключей массива

Для определения наименования ключей массива используются классы реализующие интерфейс `Fi1a\Hydrator\KeyName\KeyNameInterface`.
Объект данного класса передается в конструктор переноса данных из массива в объект и обратно.

- `Fi1a\Hydrator\KeyName\Camelize` преобразует в "stringHelper" название ключей массива;
- `Fi1a\Hydrator\KeyName\Humanize` преобразует в "string_helper" название ключей массива;

По умолчанию используется "stringHelper" название ключей массива (`Fi1a\Hydrator\KeyName\Camelize`).

Пример переноса данных из массива в объект с наименованием ключей массива "string_helper":

```php
use Fi1a\Hydrator\Hydrator;
use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;
use Fi1a\Hydrator\KeyName\Humanize;

class Foo {
    /**
     * @var string
     */
    public $propertyBar;

    /**
     * @var int
     */
    protected $propertyBaz;

    /**
     * @var bool
     */
    private $propertyQux;
}

$hydrator = new Hydrator(new HydrateStrategy(new Humanize()));

$model = new Foo();

$hydrator->hydrateModel([
    'property_bar' => 'value',
    'property_baz' => 1,
    'property_qux' => true,
], $model);

$model->propertyBar; // 'value'
```
Пример переноса данных из объекта в массив с наименованием ключей массива "string_helper":

```php
use Fi1a\Hydrator\Extractor;
use Fi1a\Hydrator\ExtractStrategies\ExtractStrategy;
use Fi1a\Hydrator\KeyName\Humanize;

class Foo {
    /**
     * @var string
     */
    public $propertyBar = 'value';

    /**
     * @var int
     */
    protected $propertyBaz = 1;

    /**
     * @var bool
     */
    private $propertyQux = true;

    public function getPropertyBaz(): int
    {
        return $this->propertyBaz;
    }
}

$model = new Foo();

$hydrator = new Extractor(new ExtractStrategy(new Humanize()));

$data = $hydrator->extract($model); // ['property_bar' => 'value', 'property_baz' => 1, 'property_qux' => true]
```

[badge-release]: https://img.shields.io/packagist/v/fi1a/hydrator?label=release
[badge-license]: https://img.shields.io/github/license/fi1a/hydrator?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/fi1a/hydrator?style=flat-square
[badge-coverage]: https://img.shields.io/badge/coverage-100%25-green
[badge-downloads]: https://img.shields.io/packagist/dt/fi1a/hydrator.svg?style=flat-square&colorB=mediumvioletred

[packagist]: https://packagist.org/packages/fi1a/hydrator
[license]: https://github.com/fi1a/hydrator/blob/master/LICENSE
[php]: https://php.net
[downloads]: https://packagist.org/packages/fi1a/hydrator