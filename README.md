# Homeful References Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/homeful/references.svg?style=flat-square)](https://packagist.org/packages/homeful/references)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/homeful/references/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/homeful/references/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/homeful/references/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/homeful/references/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/homeful/references.svg?style=flat-square)](https://packagist.org/packages/homeful/references)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require homeful/references
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="references-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="references-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="references-views"
```

## Usage

```php
$references = new Homeful\References();
echo $references->echoPhrase('Hello, Homeful!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Anais Santos](https://github.com/anais-enclavewrx)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
