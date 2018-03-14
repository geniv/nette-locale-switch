Locale switch
=============

Installation
------------

```sh
$ composer require geniv/nette-locale-switch
```
or
```json
"geniv/nette-locale-switch": ">=1.0.0"
```

require:
```json
"php": ">=7.0.0",
"nette/nette": ">=2.4.0",
"geniv/nette-locale": ">=1.0.0",
"geniv/nette-general-form": ">=1.0.0"
```

neon configure:
```neon
services:
    - LocaleSwitch
```

usage:
```php
protected function createComponentLocaleSwitch(LocaleSwitch $localeSwitch, AliasRouter\Model $model)
{
    //$localeSwitchSection = clone $localeSwitch;
    //$localeSwitch->setTemplatePath(__DIR__ . '/templates/localeSwitch.latte');
    $domain = $model->getDomain();
//        $domain = $this->context->getByType(StaticRouter::class)->getDomain();
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
