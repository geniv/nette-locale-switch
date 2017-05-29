<?php

use Nette\Application\UI\Control;
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

        if ($this->domainAlias) {
            $template->flipDomainAlias = array_flip($this->domainAlias);
        }
        $template->locales = $this->locale->getListName();
        $template->localeCode = $this->locale->getCode();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
