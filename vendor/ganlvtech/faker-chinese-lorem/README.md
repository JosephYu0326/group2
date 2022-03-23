# Faker Chinese Lorem

Faker is a PHP library that generates fake data for you. See [fzaninotto/Faker](https://github.com/fzaninotto/Faker).

Faker Chinese Lorem let you generate Lorem in Chinese.

[![Build Status](https://travis-ci.org/ganlvtech/faker-chinese-lorem.svg?branch=master)](https://travis-ci.org/ganlvtech/faker-chinese-lorem)

## Installation

```sh
composer require ganlvtech/faker-chinese-lorem
```

## Basic Usage

Use `Faker\Factory::create()` to create and initialize a faker generator, and then use `.

```php
<?php
// require the Faker autoloader
require_once '/path/to/Faker/src/autoload.php';
// alternatively, use another PSR-0 compliant autoloader (like the Symfony2 ClassLoader for instance)

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create('zh_CN');

// add Faker Chinese Lorem provider
$faker->addProvider(new FakerChineseLorem\Provider\zh_CN\Lorem($faker));

// generate data by accessing properties
$faker->word;
  // '的'
  // '的一'
  // '的一是'
  // '的一是在'
```

## Formatters

### `Faker\Provider\zh_CN\Lorem`

```php
<?php

// Generate a random single Chinese character
echo $faker->char; // '的'

// Generate an array of random characters
echo $faker->chars; // array('的', '一', '是')

// Generate a random word
// A chinese word usually contains 1 - 4 single character.
// Character numbers : Frequency
//                 1 : 10%
//                 2 : 60%
//                 3 : 10%
//                 4 : 20%
echo $faker->word; // '的' // '的一' // '的一是' // '的一是在'
// Generate a word that contians exact number of characters
echo $faker->word(2); // '的一' // '是在'

// Other functions
echo $faker->sentence; // sentence always end with a Chinese period (。).
echo $faker->sentences;
echo $faker->paragraph;
echo $faker->paragraphs;
echo $faker->text
echo $faker->text(100); // text contains no more than 100 Chinese characters (not 100 bytes)
```

## License

Faker Chinese Lorem is released under the MIT Licence. See the bundled LICENSE file for details.