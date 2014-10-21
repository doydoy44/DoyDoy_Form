<?php
/**
 * Doydoy
 *
 * @brief	 Décorateur permettant d'ajouter du code HTML avant ou après un élément de formulaire.
 *         Inspiré de http://wiip.fr/content/decorator-pour-ajouter-un-suffixe-ou-un-prefixe-a-un-zend_form_element
 * 		
 * @category   Doydoy
 * @package    Doydoy/Form
 * @subpackage Decorator
 * @extends    Zend_Form_Decorator_Abstract
 *
 * @author    Doydoy
 * @version   1.0
 * 
 */

/** Zend_Form_Decorator_Abstract */
require_once 'Zend/Form/Decorator/Abstract.php';

class Doydoy_Form_Decorator_AppendPrepend extends Zend_Form_Decorator_Abstract
{
  public function render($content) {
    $placement = strtoupper($this->_options['html']['placement']);
    switch ($placement) {
      case self::APPEND:
        return $content . $this->_options['html']['append'];
        break;
      case self::PREPEND:
        return $this->_options['html']['prepend'] . $content;
        break;
      case "APPEND_PREPEND":
        return $this->_options['html']['prepend'] . $content . $this->_options['html']['append'] ;
        break;
    }
  }
}
