Locale switch
=============

Installation
------------

```sh
$ composer require geniv/nette-locale-switch
```
or
```json
"geniv/nette-locale-switch": ">=1.0"
```

internal dependency:
```json
"nette/nette": ">=2.4.0",
"geniv/nette-locale": ">=1.0"
```

neon configure:
```neon
services:
    - LocaleSwitch
```

usage:
```php
use LocaleSwitch;

protected function createComponentLocaleSwitch(LocaleSwitch $localeSwitch)
{
    $localeSwitch->setTemplatePath(__DIR__ . '/templates/localeSwitch.latte');
    return $localeSwitch;
}
```

usage:
```latte
{control localeSwitch}
```
