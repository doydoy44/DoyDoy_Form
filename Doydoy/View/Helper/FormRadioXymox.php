<?php
/**
 * Doydoy
 *
 * @brief	Remplacement du Zend_View_Helper_FormRadio pour pouvoir mettre ou non
 * 				un Label et si oui, mieux le gérer que celui d'origine
 * 				
 * 				
 * @category   Doydoy
 * @package    Doydoy/View
 * @subpackage Helper
 * 
 * @extends    Zend_View_Helper_FormElement
 *
 * @author    Doydoy
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


/**
 * Abstract class for extension
 */
require_once 'Zend/View/Helper/FormElement.php';


class Doydoy_View_Helper_FormRadioDoydoy extends Zend_View_Helper_FormElement
{
    /**
     * Input type to use
     * @var string
     */
    protected $_inputType = 'radio';

    /**
     * Whether or not this element represents an array collection by default
     * @var bool
     */
    protected $_isArray = false;

    /**
     * Generates a set of radio button elements.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are extracted in place of added parameters.
     *
     * @param mixed $value The radio value to mark as 'checked'.
     *
     * @param array $options An array of key-value pairs where the array
     * key is the radio value, and the array value is the radio text.
     *
     * @param array|string $attribs Attributes added to each radio.
     *
     * @return string The radio buttons XHTML.
     */
    public function formRadioDoydoy($name, $value = null, $attribs = null,
        $options = null, $listsep = "<br />\n")
    {

        $info = $this->_getInfo($name, $value, $attribs, $options, $listsep);
        extract($info); // name, value, attribs, options, listsep, disable

        // retrieve attributes for labels (prefixed with 'label_' or 'label')
        $label_attribs = array();
        foreach ($attribs as $key => $val) {
            $tmp    = false;
            $keyLen = strlen($key);
            if ((6 < $keyLen) && (substr($key, 0, 6) == 'label_')) {
                $tmp = substr($key, 6);
            } elseif ((5 < $keyLen) && (substr($key, 0, 5) == 'label')) {
                $tmp = substr($key, 5);
            }

            if ($tmp) {
                // make sure first char is lowercase
                $tmp[0] = strtolower($tmp[0]);
                $label_attribs[$tmp] = $val;
                unset($attribs[$key]);
            }
        }

        $labelPlacement = 'append';
        $labelTag				= true;
        
        foreach ($label_attribs as $key => $val) {
            switch (strtolower($key)) {
                case 'placement':
                    unset($label_attribs[$key]);
                    $val = strtolower($val);
                    if (in_array($val, array('prepend', 'append'))) {
                        $labelPlacement = $val;
                    }
                    break;
                case 'tag':
                    unset($label_attribs[$key]);
                    if (is_bool($val)) {
                        $labelTag = $val;
                    }
                    break;
            }
        }

        // the radio button values and labels
        $options = (array) $options;

        // build the element
        $xhtml = '';
        $list  = array();

        // should the name affect an array collection?
        $name = $this->view->escape($name);
        if ($this->_isArray && ('[]' != substr($name, -2))) {
            $name .= '[]';
        }

        // ensure value is an array to allow matching multiple times
        $value = (array) $value;

        // XHTML or HTML end tag?
        $endTag = ' />';
        if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
            $endTag= '>';
        }

        // add radio buttons to the list.
        require_once 'Zend/Filter/Alnum.php';
        $filter = new Zend_Filter_Alnum();
        foreach ($options as $opt_value => $opt_label) {

            // Should the label be escaped?
            if ($escape) {
                $opt_label = $this->view->escape($opt_label);
            }

            // is it disabled?
            $disabled = '';
            if (true === $disable) {
                $disabled = ' disabled="disabled"';
            } elseif (is_array($disable) && in_array($opt_value, $disable)) {
                $disabled = ' disabled="disabled"';
            }

            // is it checked?
            $checked = '';
            if (in_array($opt_value, $value)) {
                $checked = ' checked="checked"';
            }

            // generate ID
            $optId = $id . '-' . $filter->filter($opt_value);

            // Wrap the radios in labels
            $label = '';
            if ($labelTag)
            	$label = '<label'
                		 . $this->_htmlAttribs($label_attribs) . ' for="' . $optId . '">';
              $label .= $opt_label;
            if ($labelTag)
            	$label .= '</label>';

            // Create the radio button
            $radio = '<input type="' . $this->_inputType . '"'
                    . ' name="' . $name . '"'
                    . ' id="' . $optId . '"'
                    . ' value="' . $this->view->escape($opt_value) . '"'
                    . $checked
                    . $disabled
                    . $this->_htmlAttribs($attribs)
                    . $endTag;
    
            // Combine the label and the radio button
            if ('prepend' == $labelPlacement) {
                $radio = $label . $radio;
            } else {
                $radio = $radio . $label;
            }
            // add to the array of radio buttons
            $list[] = $radio;
        }

        // done!
        $xhtml .= implode($listsep, $list);

        return $xhtml;
    }
}
