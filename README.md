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
"geniv/nette-locale": ">=1.0.0"
```

neon configure:
```neon
services:
    - LocaleSwitch
```

usage:
```php
use LocaleSwitch;
use AliasRouter\Model;

protected function createComponentLocaleSwitch(LocaleSwitch $localeSwitch)
{
//    $localeSwitch->setTemplatePath(__DIR__ . '/templates/localeSwitch.latte');
    $domain = $this->context->getByType(Model::class)->getDomain();
    if (isset($domain['switch']) && isset($domain['alias']) && $domain['switch']) {
        $localeSwitch->setDomain($domain['alias']);
    }
    return $localeSwitch;
}
```

usage:
```latte
{control localeSwitch}
```
