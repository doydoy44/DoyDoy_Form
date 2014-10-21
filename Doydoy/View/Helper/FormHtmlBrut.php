<?php
/**
 * Doydoy
 *
 * @brief	Vue d'aide pour les éléments n'ayant que du texte
 *        Appelé par Doydoy_Form_Element_HtmlBrut
 *
 * @category   Doydoy
 * @package    Doydoy/View
 * @subpackage Helper
 * 
 * @extends    Zend_View_Helper_FormElement
 *
 * @author    Doydoy
 * @version   1.0
 */

/** Zend_View_Helper_FormElement */
require_once 'Zend/View/Helper/FormElement.php';

class Doydoy_View_Helper_FormHtmlBrut extends Zend_View_Helper_FormElement
{
    /**
     * Generates a 'text' element.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are used in place of added parameters.
     *
     * @param mixed $value The element value.
     *
     * @param array $attribs Attributes for the element tag.
     *
     * @return string The element XHTML.
     */
    public function formHtmlBrut($name, $value = null, $attribs = null)
    {
        $xhtml = '';
        
        if (isset($value)) 
          $xhtml = $value;
        
        return $xhtml;
    }
}
