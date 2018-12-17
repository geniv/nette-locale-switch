Locale switch
=============

Installation
------------

```sh
$ composer require geniv/nette-locale-switch
```
or
```json
"geniv/nette-locale-switch": "^2.0"
```

require:
```json
"php": ">=7.0",
"nette/nette": ">=2.4",
"geniv/nette-locale": ">=2.0",
"geniv/nette-general-form": ">=1.0"
```

neon configure:
```neon
services:
    - LocaleSwitch
```

usage:
```php
protected function createComponentLocaleSwitch(ILocaleSwitch $localeSwitch, IAliasRouter $aliasRouter): ILocaleSwitch
{
    //$localeSwitch->setTemplatePath(__DIR__ . '/templates/header-lang.latte');
    $domain = $aliasRouter->getDomainAlias();
    if ($domain) {
        $localeSwitch->setDomain($domain);
    }
    return $localeSwitch;
}
```

usage:
```latte
{control localeSwitch}
or
{control localeSwitch, $idLocale}
```
