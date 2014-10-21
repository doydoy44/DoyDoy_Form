<?php
/**
 * Form label helper
 *
 * @category   Zend
 * @package    Doydoy/View
 * @subpackage Helper
 * 
 * @extends    Zend_View_Helper_FormElement
 * 
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/** Zend_View_Helper_FormElement **/
require_once 'Zend/View/Helper/FormElement.php';

class Doydoy_View_Helper_FormLabel extends Zend_View_Helper_FormElement
{
    /**
     * Generates a 'label' element.
     *
     * @param  string $name The form element name for which the label is being generated
     * @param  string $value The label text
     * @param  array $attribs Form element attributes (used to determine if disabled)
     * @return string The element XHTML.
     */
    public function formLabel($name, $value = null, array $attribs = null)
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable, escape

        // build the element
        if ($disable) {
            // disabled; display nothing
            return  '';
        }
        
        $for_value = !(empty($attribs['for'])) ? $attribs['for'] : $this->view->escape($id);

        if (array_key_exists('for', $attribs)) {
          unset($attribs['for']);
        }

        if (!(empty($attribs['id_tag_label']))){
          $id = ' id="' . $attribs['id_tag_label'] . '"';
          unset($attribs['id_tag_label']);
        }
        else 
          $id = '';

        
        $value = ($escape) ? $this->view->escape($value) : $value;
        
        $for   = (empty($attribs['disableFor']) || !$attribs['disableFor'])
               ? ' for="' . $for_value . '"'
               : '';
                
        if (array_key_exists('disableFor', $attribs)) {
            unset($attribs['disableFor']);
        }

        // enabled; display label
        $xhtml = '<label'
                . $id
                . $for
                . $this->_htmlAttribs($attribs)
                . '>' . $value . '</label>';

        return $xhtml;
    }
}
