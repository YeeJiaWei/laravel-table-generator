# Laravel Table Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yeejiawei/laravel-table-generator.svg)](https://packagist.org/packages/yeejiawei/laravel-table-generator)
[![Latest Version on Packagist](https://img.shields.io/badge/license-MIT-green)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/yeejiawei/laravel-table-generator.svg)](https://packagist.org/packages/yeejiawei/laravel-table-generator)
![Github.com Stars](https://img.shields.io/github/stars/yeejiawei/laravel-table-generator.svg)

## Installation

You can install the package via composer:

```bash
composer require yeejiawei/laravel-table-generator
```

## Usage

```php
$category = Category::all();
$category = Category::paginate();

return TableGenerator::create($category)
            ->setTableName('Categories')
            ->setCreatable('category.create')
            ->addColumn('id')
            ->addColumn('title')
            ->addCreatedAtColumns()
            ->addUpdatedAtColumns()
            ->setEnable('category.updateEnable')
            ->setViewable('category.show')
            ->setEditable('category.edit')
            ->setDeletable('category.destroy')
            ->render();
```

## Credits

- [YeeJiaWei](https://github.com/YeeJiaWei)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.