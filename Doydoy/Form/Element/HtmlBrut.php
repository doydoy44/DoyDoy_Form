<?php
/**
 * Doydoy
 *
 * @brief	Elément servant à écrire du texte brut sans 
 *        qu'il y ai d'élément de formulaire
 *
 * @category   Doydoy
 * @package    Doydoy/Form
 * @subpackage Element
 * @extends    Zend_Form_Element
 *
 * @author    Doydoy
 * @version   1.0
 */

/** Zend_Form_Element */
require_once 'Zend/Form/Element.php';

class Doydoy_Form_Element_HtmlBrut extends Zend_Form_Element
{
    /**
     * Default form view helper to use for rendering
     * @var string
     */
    public $helper = 'formHtmlBrut';

    /**
     * Initialize object; used by extending classes
     *
     * @return void
     */
    public function init()
    {
      // Pas de décorateur par défaut;
      $this->setDisableLoadDefaultDecorators(true);
      // Comme on veut simplement afficher du texte, on ne garde que le décorateur de l'élément
      $this->setDecorators(array('ViewHelper'));
      $this->setIgnore(true);
      $this->setAllowEmpty(true);
      $this->setRequired(false);
    }
    

    /**
     * Validate element value
     *
     * If a translation adapter is registered, any error messages will be
     * translated according to the current locale, using the given error code;
     * if no matching translation is found, the original message will be
     * utilized.
     *
     * Note: The *filtered* value is validated.
     *
     * @param  mixed $value
     * @param  mixed $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
      // Il n'y a rien a tester, donc toujours valide
      return true;
    }
}
