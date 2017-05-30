<?php

use Nette\Application\UI\Control;
use Nette\Http\Url;
use Nette\Localization\ITranslator;
use Locale\Locale;


/**
 * Class LocaleSwitch
 *
 * @author geniv
 */
class LocaleSwitch extends Control
{
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
     * @param Locale           $locale
     * @param ITranslator|null $translator
     */
    public function __construct(Locale $locale, ITranslator $translator = null)
    {
        parent::__construct();

        $this->locale = $locale;
        $this->translator = $translator;
        $this->templatePath = __DIR__ . '/LocaleSwitch.latte';  // implicitni cesta
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
        $pameteters = $this->parent->getParameters();   // naceni parametru
        $flipDomainAlias = array_flip($this->domainAlias);  // obraceni pole domen
        $localeList = $this->locale->getListName(); // vyber listu jazyku
        foreach ($localeList as $code => $name) {
            $param = array_merge($pameteters, ['locale' => $code]); // slouceni paremetru s url a noveho jazyka
            if ($this->domainAlias && isset($flipDomainAlias[$code])) { // pokud je aktivni domain switch
                $url = new Url($this->parent->link('//this', $param));  // vytvoreni linku a prevod na url
                $url->host = $flipDomainAlias[$code];   // zamena hostu za flipnuty jazyk
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
