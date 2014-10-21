<?php
/**
 * Doydoy
 *
 * @brief	Remplacement du Zend_View_Helper_FormRadio pour pouvoir mettre ou non
 * 				un Label et si oui, mieux le gérer que celui du Natif
 * 				
 * 				
 * @category   Doydoy
 * @package    Doydoy/View
 * @subpackage Helper
 * 
 * @extends    Zend_View_Helper_FormElement
 *
 * @author    DoyDoy
 * @version   1.0
 * 
 * @example $langues = new Zend_Form_Element_Radio('langue', array('escape' => false));
 *					$langues->setSeparator('')
 *									->setAttrib('class', 'radio')
 *									/////////////////////////////////////////////////
 *									//->setAttrib('label_placement', 'prepend')												// On le label après le radioset
 *									//->setAttrib('label_placement', 'append')												// On le label avant le radioset
 *									//->setAttrib('label_tag', false)																	// On ne veut pas de label
 *									/////////////////////////////////////////////////
 *									->setDecorators(array('ViewHelper',
 *																				 array(array('td' => 'HtmlTag'),
 *																						   array('tag'=> 'div', 'id' => 'radiolanguebutton')
 *																							),
 *																				)
 *																)
 *									->addDecorators($decorators)
 *									/////////////////////////////////////////////////
 *									// Rajout d'un décorateur pour corriger le bug Zend sur les bouton radio
 *									->addDecorators(array(
 *																				array('ViewHelper',
 *																							array('helper' => 'formRadioDoydoy')		//Indication qu'on prend l'aide Doydoy_Helper_FormRadioDoydoy
 *																							),
 *																				)
 *																)
 *									/////////////////////////////////////////////////
 *								->removeDecorator('Errors');
 * 
 */ 

/** Zend_View_Helper_FormElement */
require_once 'Zend/View/Helper/FormElement.php';

/**
 * Helper for rendering HTML forms
 *
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Doydoy_View_Helper_FormDoydoy extends Zend_View_Helper_FormElement
{
    /**
     * Render HTML form
     *
     * @param  string $name Form name
     * @param  null|array $attribs HTML form attributes
     * @param  false|string $content Form content
     * @return string
     */
    public function formDoydoy($name, $attribs = null, $content = false)
    {
        $info = $this->_getInfo($name, $content, $attribs);
        extract($info);

        
        if (!empty($id)) {
            $id = ' id="' . $this->view->escape($id) . '"';
        } else {
            $id = '';
        }
				
        if (array_key_exists('id', $attribs) && empty($attribs['id'])) {
            unset($attribs['id']);
        }
        
        if (!empty($name)) {
            $name = ' name="' . $this->view->escape($name) . '"';
        } else {
            $name = '';
        }
        
        if ( array_key_exists('name', $attribs) && empty($attribs['id'])) {
            unset($attribs['id']);
        }

        $xhtml = '<form'
               . $id
               . $name
               . $this->_htmlAttribs($attribs)
               . '>';

        if (false !== $content) {
            $xhtml .= $content;
        }

        $xhtml .= '</form>';

        return $xhtml;
    }
}
