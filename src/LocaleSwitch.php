<?php declare(strict_types=1);

use GeneralForm\ITemplatePath;
use Nette\Application\UI\Control;
use Nette\Http\Url;
use Nette\Localization\ITranslator;
use Locale\ILocale;


/**
 * Class LocaleSwitch
 *
 * @author geniv
 */
class LocaleSwitch extends Control implements ILocaleSwitch, ITemplatePath
{
    /** @var ILocale */
    private $locale;
    /** @var ITranslator|null */
    private $translator;
    /** @var string */
    private $templatePath;
    /** @var array */
    private $domainAlias = [], $variableTemplate = [];


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
     * Set locale.
     *
     * @param ILocale $locale
     */
    public function setLocale(ILocale $locale)
    {
        $this->locale = $locale;
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }


    /**
     * Set domain.
     *
     * @param array $alias
     */
    public function setDomain(array $alias)
    {
        $this->domainAlias = $alias;
    }


    /**
     * Add variable template.
     *
     * @param string $name
     * @param        $values
     */
    public function addVariableTemplate(string $name, $values)
    {
        $this->variableTemplate[$name] = $values;
    }


    /**
     * Render.
     *
     * @param int|null $idLocale
     */
    public function render(int $idLocale = null)
    {
        $template = $this->getTemplate();

        $links = [];
        $parameters = $this->parent->getParameters();   // presenter parameters
        $flipDomainAlias = array_flip($this->domainAlias);  // flip array domains
        $localeList = $this->locale->getListName(); // get list locale names
        $localeListId = $this->locale->getListId(); // get list locale ids
        foreach ($localeList as $code => $name) {
            $param = array_merge($parameters, ['locale' => $code]); // merge parameters with url and new locale
            if ($this->domainAlias && isset($flipDomainAlias[$code])) { // if active domain switch
                $url = new Url($this->parent->link('//this', $param));  // make Url link
                $url->host = $flipDomainAlias[$code];   // set Url host with flip locale
                $links[$code] = ['url' => strval($url), 'name' => $name, 'id' => $localeListId[$code]];
            } else {
                $links[$code] = ['url' => $this->parent->link('//this', $param), 'name' => $name, 'id' => $localeListId[$code]];
            }
        }

        // add user defined variable
        foreach ($this->variableTemplate as $name => $value) {
            $template->$name = $value;
        }

        $template->idLocale = $idLocale;
        $template->links = $links;
        $template->localeCode = $this->locale->getCode();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }
}
