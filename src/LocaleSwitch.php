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
     * Render component.
     */
    public function render()
    {
        $template = $this->getTemplate();

//FIXME opravit!
        $template->host = null;
        if ($this->presenter->context->parameters['router']['languageDomainSwitch']) {
            $template->flipLanguageDomainAlias = array_flip($this->presenter->context->parameters['router']['languageDomainAlias']);
        }

        $template->languageName = $this->language->getNameLanguages();
        $template->languages = $this->language->getNameLanguages();
        $template->languageCode = $this->language->getCodeLanguage();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
