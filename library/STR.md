# PHALCON: STRING MANIPULATIONS WITH 'STR' CLASS
>_Phalcon already provides powerfull helpers for string manipulations, but I was wondering what's behind these convinient helpers. The Phalcon string helpers is powered by  Library\Str class. Let's explore what methods it contains and how we can use them. For this example I will be using 'Lorem Ipsm ....' for subject testing. Here's the list of all the methods used, you can jump right to your desired method from here:_

1. [after()](#1_-_AFTER($SUBJECT,_$SEARCH)_:_STRING)
2. [contains()](#2_-_CONTAINS($HAYSTACK,_$NEEDLES)_:_BOOL)
3. [startsWith()](#3_-_STARTSWITH($HAYSTACK,_$NEEDLES)_:_BOOL)
4. [ascii()](#4_-_ASCII($VALUE,_$LANGUAGE_=_'EN')_:_STRING)
5. [before()](#5_-_BEFORE($SUBJECT,_$SEARCH)_:_STRING)
6. [finish()](#6_-_FINISH($VALUE,_$CAP)_:_STRING)
7. [is()](#7_-_IS($PATTERN,_$VALUE)_:_BOOL)
8. [length()](#8_-_LENGTH($VALUE,_$ENCODING_=_NULL)_:_INT)
9. [limit()](#9_-_LIMIT($VALUE,_$LIMIT_=_100,_$END_=_'...')_:_STRING)
10. [truncate()](#10_-_LIMIT($VALUE,_$LIMIT_=_100,_$END_=_'...')_:_STRING)
11. [lower()](#11_-_LOWER($VALUE)_:_STRING)
12. [words()](#12_-_WORDS($VALUE,_$WORDS_=_100,_$END_=_'...')_:_STRING)
13. [replaceArray()](#13_-_REPLACEARRAY($SEARCH,_ARRAY_$REPLACE,_$SUBJECT))
14. [replaceFirst()](#14_-_REPLACEFIRST($SEARCH,_$REPLACE,_$SUBJECT)_:_STRING)
15. [replaceLast()](#15_-_REPLACELAST($SEARCH,_$REPLACE,_$SUBJECT)_:_STRING)
16. [start()](#16_-_START($VALUE,_$PREFIX)_:_STRING)
17. [upper()](#17_-_UPPER($VALUE)_:_STRING)
18. [title()](#18_-_TITLE($VALUE)_:_STRING)
19. [slug()](#19_-_SLUG($TITLE,_$SEPARATOR_=_'-',_$LANGUAGE_=_'EN')_:_STRING)
20. [substr()](#20_-_SUBSTR($STRING,_$START,_$LENGTH_=_NULL)_:_STRING)
21. [ucfirst()](#21_-_UCFIRST($STRING)_:_STRING)
22. [plural()](#22_-_PLURAL($INT,[$STRING|$ARRAY],$LOCALE_=_'EN')_:_STRING)

#### 1 - AFTER($SUBJECT, $SEARCH) : STRING
This method chops off all the characters including `$search` from the start in the `$subject` and returns the rest of the string. Let's test this method:
```php
$string = 'Lorem ipsum suet';
$result = $this->str->after($string, 'ipsum');
die(var_dump($result));
```
return: `string ' suet' (length=5)`

#### 2 - CONTAINS($HAYSTACK, $NEEDLES) : BOOL
This method returns boolean true or false if a string `$haystack` contains a string / characters $needles. This is a case-sensitive method, means if it has a work 'tomorrow', it will return false for 'Tomorrow' as demonstrated below:
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->contains($string, 'amet');
die(var_dump($result));
```
return: `boolean true`
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->contains($string, 'Amet');
die(var_dump($result));
```
return: `boolean false`
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->contains($string, 'Tahir');
die(var_dump($result));
```
return: `boolean false`

#### 3 - STARTSWITH($HAYSTACK, $NEEDLES) : BOOL
This method tests if a given string `$haystack` starts with a string or one of strings in the array $needles.
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->startsWith($string, 'ipsum');
die(var_dump($result));
```
return: `boolean false`
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->startsWith($string, 'Lorem');
die(var_dump($result));
```
return: `boolean true`

#### 4 - ASCII($VALUE, $LANGUAGE = 'EN') : STRING
This method returns the ascii equivalent of the $value string in the `$language` specified.
```php
$string = 'Lorem ipsum dolor suet amet, جملة الاختبار';
$result = $this->str->ascii($string);
die(var_dump($result));
```
return: `string 'Lorem ipsum dolor suet amet, jml alakhtbar' (length=42)`

#### 5 - BEFORE($SUBJECT, $SEARCH) : STRING
This is opposite of `after()` method. This will only keep the characters before the$search characters:
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->before($string, 'dolor');
die(var_dump($result));
```
return: `string 'Lorem ipsum ' (length=12)`

#### 6 - FINISH($VALUE, $CAP) : STRING
This method add a padding to the end of the string. In other words, right-pad the string, as shown below:
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->finish($string, 'amet');
die(var_dump($result));
```
return: `string 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.amet' (length=61)`

#### 7 - IS($PATTERN, $VALUE) : BOOL
This method tests `$value` against the $pattern which can be a string or an array of strings and returns true or false if the string contains the pattern. As shown below in the example:
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->is('*ipsum*', $string);
die(var_dump($result));
```
return: `boolean true`
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->is('ipsum*', $string);
die(var_dump($result));
```
return: `boolean false`
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->is(['ipsum*', '*,', '*elit.'], $string);
die(var_dump($result));
```
return: `boolean true`

#### 8 - LENGTH($VALUE, $ENCODING = NULL) : INT
This method uses mbstring extension's `mb_strlen()` function for length, for non-ascii (Unicode) strings you have to provide `$encoding` scheme name such as UTF-8, UTF-16 etc.
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->length($string);
die(var_dump($result));
```
return: `int 57`

#### 9 - LIMIT($VALUE, $LIMIT = 100, $END = '...') : STRING
This method limits the string at a `$limit`, the default value for limit is 100 characters which is excluding the $end text.
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->limit($string, 35, '...|readmore');
die(var_dump($result));
```
return: `string 'Lorem ipsum dolor suet amet, consec...|readmore' (length=47)`

#### 10 - TRUNCATE($VALUE, $LIMIT = 100, $END = '...') : STRING
This function which prevents breaking the string in the middle of a word using the wordwrap function:
```php
$string = 'Lorem ipsum dolor suet amet, consectetur adipiscing elit.';
$result = $this->str->truncate($string, 35, '...|readmore');
die(var_dump($result));
```
return: `string 'Lorem ipsum dolor suet amet...|readmore' (length=39)`

#### 11 - LOWER($VALUE) : STRING
This method converts the string to a lower-case string.
```php
$string = 'Lorem ipsum dolor suet amet, Consectetur adipiscing elit.';
$result = $this->str->lower($string);
die(var_dump($result));
```
return: `string 'lorem ipsum dolor suet amet, consectetur adipiscing elit.' (length=57)`

#### 12 - WORDS($VALUE, $WORDS = 100, $END = '...') : STRING
This method limits the string on words just like `limit()` method.
```php
$string = 'Lorem ipsum dolor suet amet, Consectetur adipiscing elit.';
$result = $this->str->words($string, 5);
die(var_dump($result));
```
return: `string ''Lorem ipsum dolor suet amet...' (length=30)`

#### 13 - REPLACEARRAY($SEARCH, ARRAY $REPLACE, $SUBJECT)
This method replaces all the instances of `$search` in `$subject` with $replace in a starting order, you will get more clarity with the following example:
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$search = 'is';
$to_replace = ['was', 'wasnt', 'are'];
$result = $this->str->replaceArray($search, $to_replace, $string);
die(var_dump($result));
```
return: `string 'Lorem ipsum was dolor suet wasnt amet, Consectetur are adipiscing elit.' (length=71)`

#### 14 - REPLACEFIRST($SEARCH, $REPLACE, $SUBJECT) : STRING
This method will only replace the first occurance of $search with `$replace` in the $subject string as shown in the example below:
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$search = 'is';
$to_replace = 'was';
$result = $this->str->replaceFirst($search, $to_replace, $string);
die(var_dump($result));
```
return: `string 'Lorem ipsum was dolor suet is amet, Consectetur is adipiscing elit.' (length=67)`

#### 15 - REPLACELAST($SEARCH, $REPLACE, $SUBJECT) : STRING
Like `replaceFirst()` this method replaces the last occurance of $search with `$replace` in the $subject string.
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$search = ' is ';
$to_replace = ' was ';
$result = $this->str->replaceLast($search, $to_replace, $string);
die(var_dump($result));
```
return: `string 'Lorem ipsum is dolor suet is amet, Consectetur was adipiscing elit.' (length=67)`

#### 16 - START($VALUE, $PREFIX) : STRING
This method adds `$prefix` to the starting of the `$value`. In other words it left-pads the string.
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$prefix = '-|';
$result = $this->str->start($string, $prefix);
die(var_dump($result));
```
return: `string '-|Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.' (length=68)`

#### 17 - UPPER($VALUE) : STRING
This method converts `$value` to upper-case string. It uses `mb_strtoupper()`.
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$result = $this->str->upper($string);
die(var_dump($result));
```
return `string 'LOREM IPSUM IS DOLOR SUET IS AMET, CONSECTETUR IS ADIPISCING ELIT.' (length=66)`

#### 18 - TITLE($VALUE) : STRING
This method converts `$value` to title-case string.
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$result = $this->str->title($string);
die(var_dump($result));
```
return `string 'Lorem Ipsum Is Dolor Suet Is Amet, Consectetur Is Adipiscing Elit.' (length=66)`

#### 19 - SLUG($TITLE, $SEPARATOR = '-', $LANGUAGE = 'EN') : STRING
Turns given string into a slug-case string which can be useful for SEO friendly urls. It will remove any non-printable characters, special characters and convert unicode into ascii characters.

By default, the separator used is '-' but you can specify your own, like I used a '+' sign:
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit. Тестовое слово جملة الاختبار';
$result = $this->str->slug($string);
die(var_dump($result));
```
return `string 'lorem-ipsum-is-dolor-suet-is-amet-consectetur-is-adipiscing-elit-testovoe-slovo-jml-alakhtbar' (length=93)`

#### 20 - SUBSTR($STRING, $START, $LENGTH = NULL) : STRING
This method returns a sub-string of a $string from position `$start`, $length is optional but you can specify to return the number of characters to be return, it will return the rest of the string if not specified.

This method uses mbstring's `mb_substr()` function:
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$result = $this->str->substr($string, 5, 10);
die(var_dump($result));
```
return `string ' ipsum is ' (length=10)`
```php
$string = 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$result = $this->str->substr($string, 25);
die(var_dump($result));
```
return `string ' is amet, Consectetur is adipiscing elit.' (length=41)`

#### 21 - UCFIRST($STRING) : STRING
I don't know how this method compares to the PHP native `ucfirst()` function in terms of speed and memory usage but it's there. This method capitalizes the first character / letter of the string given.
```php
$string = 'lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.';
$result = $this->str->ucfirst($string);
die(var_dump($result));
```
return `string 'Lorem ipsum is dolor suet is amet, Consectetur is adipiscing elit.' (length=66)`

#### 22 - PLURAL($INT,[$STRING|$ARRAY],$LOCALE = 'EN') : STRING
Receive word in plural form
```php
$result = $this->str->plural(5, 'cap');
die(var_dump($result));
```
return `string 'caps' (length=4)`
```php
$result = $this->str->plural(1, 'cap');
die(var_dump($result));
```
return `string 'cap' (length=3)`
```php
$result = $this->str->plural(3, 'one cup;many cups');
die(var_dump($result));
```
return `string 'many cups' (length=9)`
```php
$result = $this->str->plural(8, 'чашка;чашки;чашок', 'ua');
die(var_dump($result));
```
return `string 'чашок' (length=10)`
```php
$result = $this->str->plural(3, 'чашка;чашки;чашок', 'ua');
die(var_dump($result));
```
return `string 'чашки' (length=10)`
```php
$result = $this->str->plural(1, 'чашка;чашки;чашок', 'ua');
die(var_dump($result));
```
return `string 'чашка' (length=10)`