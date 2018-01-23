<?php

use Nette\Application\UI\Control;
use Nette\Http\Url;
use Nette\Localization\ITranslator;
use Locale\ILocale;


/**
 * Class LocaleSwitch
 *
 * @author geniv
 */
class LocaleSwitch extends Control
{
    /** @var ILocale */
    private $locale;
    /** @var ITranslator|null */
    private $translator;
    /** @var string template path */
    private $templatePath;
    /** @var array domain alias */
    private $domainAlias = [];


    /**
     * LocaleSwitch constructor.
     *
     * @param ILocale          $locale
     * @param ITranslator|null $translator
     */
    public function __construct(ILocale $locale, ITranslator $translator = null)
    {
        parent::__construct();

        $this->locale = $locale;
        $this->translator = $translator;
        $this->templatePath = __DIR__ . '/LocaleSwitch.latte';  // default path
    }


    /**
     * Set template path.
     *
     * @param string $path
     * @return $this
     */
    public function setTemplatePath($path)
    {
        $this->templatePath = $path;
        return $this;
    }


    /**
     * Set array domain alias.
     *
     * @param $alias
     * @return $this
     */
    public function setDomain($alias)
    {
        $this->domainAlias = $alias;
        return $this;
    }


    /**
     * Render component.
     */
    public function render()
    {
        $template = $this->getTemplate();

        $links = [];
        $pameteters = $this->parent->getParameters();   // presenter parameters
        $flipDomainAlias = array_flip($this->domainAlias);  // flip array domains
        $localeList = $this->locale->getListName(); // get list locales
        foreach ($localeList as $code => $name) {
            $param = array_merge($pameteters, ['locale' => $code]); // merge parameters with url and new locale
            if ($this->domainAlias && isset($flipDomainAlias[$code])) { // if active domain switch
                $url = new Url($this->parent->link('//this', $param));  // make Url link
                $url->host = $flipDomainAlias[$code];   // set Url host with flip locale
                $links[$code] = ['url' => strval($url), 'name' => $name];
            } else {
                $links[$code] = ['url' => $this->parent->link('//this', $param), 'name' => $name];
            }
        }

        $template->links = $links;
        $template->localeCode = $this->locale->getCode();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
