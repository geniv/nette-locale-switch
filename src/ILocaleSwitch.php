<?php declare(strict_types=1);

use GeneralForm\ITemplatePath;
use Locale\ILocale;


/**
 * Interface ILocaleSwitch
 *
 * @author geniv
 */
interface ILocaleSwitch extends ITemplatePath
{

    /**
     * Set locale.
     *
     * @param ILocale $locale
     */
    public function setLocale(ILocale $locale);


    /**
     * Set domain.
     *
     * @param array $alias
     */
    public function setDomain(array $alias);


    /**
     * Add variable template.
     *
     * @param string $name
     * @param        $values
     */
    public function addVariableTemplate(string $name, $values);
}
