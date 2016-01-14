# LosI18n

## Introduction
This module provides routes for i18n features and a list of Languages, Countries and Regions translated to all languages.

## Requirements
- PHP 5.4 or greater
- Zend Framework 2 [framework.zend.com](http://framework.zend.com/).

## Instalation
Instalation can be done with composer ou manually

### Installation with composer
For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

  1. Enter your project directory
  2. Create or edit your `composer.json` file with following contents:

     ```json
     {
         "minimum-stability": "dev",
         "require": {
             "los/losi18n": "1.*"
         }
     }
     ```
  3. Run `php composer.phar install`
  4. Open `my/project/directory/config/application.config.php` and add `LosI18n` to your `modules`
     
### Installation without composer

  1. Clone this module [LosI18n](http://github.com/LansoWeb/LosI18n) to your vendor directory
  2. Enable it in your config/application.config.php like the step 4 in the previous section.
  
## I18n Data

This module needs data from [losi18n-data](http://github.com/LansoWeb/losi18n-data). So you need either to add the module to you project or download
individual language files:

### Adding the losi18n-data
 
  1. Enter your project directory
  2. Create or edit your `composer.json` file with following contents:

     ```json
     {
         "minimum-stability": "dev",
         "require": {
             "los/losi18n-data": "1.*"
         }
     }
     ```
  3. Run `php composer.phar update`

### Download invidual languages

After the LosI18n is installed in your project, use the download console action:

php public/index.php losi18n download <destination folder> <languages>

Examples:
```shell
mkdir -p vendor/los/losi18n-data/data
php public/index.php losi18n download vendor/los/losi18n-data/data en,en_US,pt,pt_BR 
```

### File format
There are 3 formats: php, json and csv. If you need to import the json file, it's located:
vendor/los/losi18n-data/data/<language>/languages.json
vendor/los/losi18n-data/data/<language>/countries.json
vendor/los/losi18n-data/data/<language>/regions.json

## Usage
 
### Language list
```php
$languagesService = $sm->get('losi18n-countries');
// All languages translated to pt_BR
$languages = $countriesService->getAllLanguages('pt_BR');
// All languages in their native names
$languages = $countriesService->getNativeLanguages();
// Brazilian Portuguese in English
$language = $countriesService->getLanguage('pt_BR', 'en);
```

### Country list
```php
$countriesService = $sm->get('losi18n-countries');
// All countries translated to English
$countries = $countriesService->getAllCountries('en');
// United States translated to Brazilian Portuguese
$country = $countriesService->getCountry('US','pt_BR');
```

### Region list
```php
$regionsService = $sm->get('losi18n-regions');
$regions = $countriesService->getAllRegions('pt_BR');
```

### Routes

This module provides 2 routes (but you can use it anywhere). 

This los-i18n is a Segment route that accepts a language in both formats (2 or 5 caracters: en or en_US).

For example, the bellow route will produce a route:
/en/album
/pt_BR/album

```php
'router' => array(
    'routes' => array(
        'los-i18n' => [
            'child_routes' => [
                'album' => array(
                    'type' => 'literal',
                    'options' => array(
                        'route' => '/album',
                        'defaults' => array(
                            '__NAMESPACE__' => 'Application\Controller',
                            'controller' => 'Album',
                            'action' => 'list'
                        )
                    ),
                    ...
```

A route integrated with ZfcAdmin si also provided:
/admin/en/album
/admin/pt_BR/album

```php
'router' => array(
    'routes' => array(
        'zfcadmin' => array(
            'child_routes' => array(
                'los-i18n' => [
                    'child_routes' => [
                        'album' => array(
                            'type' => 'literal',
                            'options' => array(
                                'route' => '/album',
                                'defaults' => array(
                                    '__NAMESPACE__' => 'Application\Controller',
                                    'controller' => 'Album',
                                    'action' => 'list'
                                )
                            ),
                            ...
```

The default language is pt_BR, to change it, just configure the default:
 ```php
'router' => array(
    'routes' => array(
        'los-i18n' => [
            'options' => array(
                'defaults' => array(
                    'lang' => 'en_UK',
                )
            ),
            ...
```
 
