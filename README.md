# Scelet of Phalcon (Current version of v0.5-beta)
=========
[![Phalconist](https://phalconist.phalconphp.com/artdevue/phalcon-scelet/default.svg)](https://phalconist.phalconphp.com/artdevue/phalcon-scelet)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

_This is a Scelet of Phalcon application written on Phalcon framework for the performance boost. This project created to develop applications in an easy way._ 
###### Includes
* ENV
* Multimodality
* Multilanguage
* Translation
* Debug Widget (PDW) ([this code was taken as the basis](https://github.com/jymboche/phalcon-debug-widget))
   
Have fun :) 

How to install
--------------

#### Using Composer (*recommended*)

Best way to install Scelet of Phalcon would be Composer, if you didn't install it

Run code in the terminal: 

```bash
composer create-project artdevue/phalcon-scelet -s dev
composer update
bower update
```

#### Using Git

First you need to clone the project, update vendors:

```bash
git clone https://github.com/artdevue/phalcon-scelet.git ./project
cd project
composer update
bower update
```

#### Requirements

* >= PHP 5.6.x/7.0.x development resources (PHP 5.3 and 5.4 are no longer supported)
* >= Phalcon **3.0.2**

Features
--------
After setup you’ll have multimodule apps.
* API RESTful module - responds all JSON-like requests.
* BACKEND and FRONTEND - A multi-module application uses the same document root for more than one module.

### ENV
It is often helpful to have different configuration values based on the environment where the application is running. For example, you may wish to use a different cache driver locally than you do on your production server.
The main file for the project is in the project root `.env`.
If you need to add a configuration for a different IP, you just need to add the configuration file [config_local.php](config/config_local.php) IP and the name of the file that will be used for this IP. For example:
```php
return [
        '192.168.100.2' => '.env_local'
    ];
```
The system automatically creates a copy of file [.env.example](.env.example)
>Any variable in your `.env` file can be overridden by external environment variables such as server-level or system-level environment variables.

##### Environment Variable Types
All variables in your `.env` files are parsed as strings, so some reserved values have been created to allow you to return a wider range of types from the `env()` function:

`.env` Value  | `env()` Value
------------- | -------------
true          | (bool) true
(true)        | (bool) true
false         | (bool) false
(false)       | (bool) false
empty         | (string) ''
(empty)       | (string) ''
null          | (null) null
(null)        | (null) null

If you need to define an environment variable with a value that contains spaces, you may do so by enclosing the value in double quotes.
```php
APP_NAME="My Application"
```
##### Retrieving Environment Configuration
All of the variables listed in this file will be loaded into the `$_ENV` PHP super-global when your application receives a request. However, you may use the env helper to retrieve values from these variables in your configuration files. In fact, if you review the Phalcon configuration files, you will notice several of the options already using this helper:
```php
'debug' => env('APP_DEBUG', false),
```
The second value passed to the env function is the "default value". This value will be used if no environment variable exists for the given key.

### Installing the module
If you want to install a new module, you need using the terminal run the following command
```bash
$ php apps/cli.php modules create modulename
```
**modulename** - replace it with the name of the module

For example, after executing the commands below in a terminal
```bash
$ php apps/cli.php modules create catalog
```
In the terminal, we see the report module installation
```bash
$ php apps/cli.php modules create catalog
Do you really want to install the module catalog?  Type 'yes' to continue: yes

Thank you, continuing...
Reading configuration file...
Creating a backup of the configuration file...
Record changes in the configuration file...
Create directories and files for this new module...
Installing the module is complete!
Use with pleasure!
```
After installing new module will be immediately available at http://site.com/catalog

The syntax of this command:
```bash
$ php apps/cli.php modules create $nameModule $prefixRouter $hostName
```
- **$nameModule** - (*String - Required value!*) Your module name
- **$prefixRouter** - (*String*) If the router prefix different from the module name, then enter here. If If you select - **null** - then there will be no prefix.
- **$hostName**     - (*String*) Host Name, if you want to have your module on another host. For example: http://catalog.site.com

### Using Multilanguage
* You must activate the "**multilang => true**" option in the configuration file.
* Parameter "**default_lang => 'en'**" is assigned the default language (_now is en_)
* Add an array of used languages in the project to the "languages" parameter of the configuration file
1. The default language is displayed in URL address without prefixes. For example: 
```html
site.com, site.com/page
```
2. If another language is used, then the prefix should be added at the beginning of the URL address. For example:
```html
site.com/ua, site.com/ua/page
```
3. Active language is called via config: In Controller **$this->config->lang_active** and in Volt **config.lang_active**

### Using Translation (Source is taken from the [official documentation](https://docs.phalconphp.com/en/3.0.0/reference/translate.html))
All files for translation are located in the directory specified in the configuration file with the parameter: 
**name_lang_folder** (default is the folder **_lang_**) 
and in the subfolder of the default language in the configuration file with the parameter: 
**default_lang** (default lang **_en_**)

The variable name consists of the file names and array keys in the file section.

The example of use in the controller:
```php
$accepted = $this->trans->_("validation.accepted", ['attribute' => 'test']);
```
or
```
__("validation.accepted", ['attribute' => 'test'])
```
The example of use in the template volt:
```html
{{ trans._("validation.accepted", ['attribute': 'test']) }}
```

### Using Debug Widget
You just need to activate `debug` in the config file or `APP_DEBUG` in the [.env](.env) file.
If you want the debug bar to be shown only to individual users, simply add the user’s IP [configuration file](config/config.php) to the `debugbar_api` array.

License
-------

The MIT License (MIT). Please see [License File](LICENSE) for more information.

Authors
-------
<table>
  <tr>
      <td><img src="http://www.gravatar.com/avatar/39ef1c740deff70b054c1d9ae8f86d02?s=60"></td><td valign="middle">Valentyn Rasulov<br>artdevue<br><a href="mailto:artdevue@yahoo.com">artdevue@yahoo.com</a></td>
    </tr>
</table>