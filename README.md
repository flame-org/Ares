Ares
====

Download information about customer via his IN.

For dependency look at to composer.json
- kdyby/curl

Example
-------
```php
$ares = new \Flame\Ares\AresApi();
$ares->loadData('87744473'); // return object \Flame\Ares\Types\Data
```