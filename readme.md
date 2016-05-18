# Kisphp Page errors finder

[![Build Status](https://travis-ci.org/kisphp/page-not-finder.svg?branch=master)](https://travis-ci.org/kisphp/page-not-finder)
[![codecov.io](https://codecov.io/github/kisphp/page-not-finder/coverage.svg?branch=master)](https://codecov.io/github/kisphp/page-not-finder?branch=master)

[![Latest Stable Version](https://poser.pugx.org/kisphp/page-not-finder/v/stable)](https://packagist.org/packages/kisphp/page-not-finder)
[![Total Downloads](https://poser.pugx.org/kisphp/page-not-finder/downloads)](https://packagist.org/packages/kisphp/page-not-finder)
[![License](https://poser.pugx.org/kisphp/page-not-finder/license)](https://packagist.org/packages/kisphp/page-not-finder)
[![Monthly Downloads](https://poser.pugx.org/kisphp/page-not-finder/d/monthly)](https://packagist.org/packages/kisphp/page-not-finder)


## Requirements

To run this tool you need to have at least PHP 5.3.6 and curl

## Installation

Include it in your project dev dependencies

```php
composer require kisphp/page-not-finder --dev
```

## Usage

To test your web applicaiton run:

```php
vendor/bin/find404 find http://www.example.com
```

To enable verbose mode, append `-v` to the command

```php
vendor/bin/find404 find http://www.example.com -v
```
