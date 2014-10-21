<?php
/**
 * Doydoy
 *
 * @brief	Remplacement du Zend_View_Helper_FormSelect pour pouvoir rajouter 
 * 				des attributs dans les <option> du <select> 
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
 * @example 
 * 			// Constrcution de la liste des options		
 * 			foreach ($listeLangues as $langueCle){		//array('fr','de', ...)
 *				// Décorateur spécifique
 *				/////////////////////////////////////////////////
 *				$listeLanguesImage[] = array('attribut_spe'=>					// 'attribut_spe' indique la liste des attributs à mettre dans les balise options
 *																	array('value'=>$langueCle,	// 'fr'
 *			    															'label'=>$langueCle,	// 'fr'
 *			    															'class'=>$this->_getClassLangueCSS($langueCle), // CSS de 'fr'
 *			    															'not_escape_affiche'=>true,
 *			    															'style'=>'width:25px; font-size:0px;',
 *		    																)
 *	    															);
 *				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
 *				// exemple : 
 * 				//			attribut_spe['affiche'] = 'xxx' => <option ...>'xxx'</option>					// n'indique pas la valeur mais ce qu'on veux afficher
 * 				//			si attribut_spe['affiche'] n'existe pas =>  <option ...>attribut_spe["label"]</option>
 * 				//			si attribut_spe["not_escape_affiche"] = true alors <option ...>'xxx'</option>
 * 				//																									 sinon <option ...>$this->view->escape('xxx')</option>
 * 				//			Toutes les autres valeurs de attribut_spe seront dans les attributs du tag 'option'
 * 				//			ex.: attribut_spe["class"] = 'toto' et attribut_spe["style"] = 'width:143px;'
 * 				//						=> <option class='toto' style='width:143px;'> ... </option>
 *				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
 *			}
 *			$langues = new Zend_Form_Element_Select('langue', array('escape' => false));
 *	    $langues->setMultiOptions($listeLanguesImage)	// Rajout de la listes des options avec des attributs
 *							->setLabel('Langue')
 *    					->setSeparator('')
 *    					->setAttrib('style', 'display:none;');
 *       		  	->setAttrib('class', 'text ui-widget ui-corner-all')
 *       				->setValue('fr')		// pour cocher par défaut
 *       		  	->setRequired(true)
 *       		  	->addValidator('NotEmpty', true)
 *       				->addDecorators($decorators)
 *							////////////////////////////////////////////////////////////////
 *							// Rajout d'un décorateur pour rajputer des attributs au options
 *         			->addDecorators(array(array('ViewHelper', array('helper' => 'formSelectDoydoy')),))	//Indication qu'on prend l'aide Doydoy_Helper_FormSelectDoydoy
 *         			////////////////////////////////////////////////////////////////
 *         			->removeDecorator('Errors')
 *         
 */ 

/**
 * Abstract class for extension
 */
require_once 'Zend/View/Helper/FormElement.php';


/**
 * Helper to generate "select" list of options
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Doydoy_View_Helper_FormSelectDoydoy extends Zend_View_Helper_FormElement
{
    /**
     * Generates 'select' list of options.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are extracted in place of added parameters.
     *
     * @param mixed $value The option value to mark as 'selected'; if an
     * array, will mark all values in the array as 'selected' (used for
     * multiple-select elements).
     *
     * @param array|string $attribs Attributes added to the 'select' tag.
     *
     * @param array $options An array of key-value pairs where the array
     * key is the radio value, and the array value is the radio text.
     *
     * @param string $listsep When disabled, use this list separator string
     * between list values.
     *
     * @return string The select tag and options XHTML.
     */
    public function formSelectDoydoy($name, $value = null, $attribs = null,
        $options = null, $listsep = "<br />\n")
    {
    	
        $info = $this->_getInfo($name, $value, $attribs, $options, $listsep);
        extract($info); // name, id, value, attribs, options, listsep, disable

        // force $value to array so we can compare multiple values to multiple
        // options; also ensure it's a string for comparison purposes.
        $value = array_map('strval', (array) $value);

        // check if element may have multiple values
        $multiple = '';

        if (substr($name, -2) == '[]') {
            // multiple implied by the name
            $multiple = ' multiple="multiple"';
        }

        if (isset($attribs['multiple'])) {
            // Attribute set
            if ($attribs['multiple']) {
                // True attribute; set multiple attribute
                $multiple = ' multiple="multiple"';

                // Make sure name indicates multiple values are allowed
                if (!empty($multiple) && (substr($name, -2) != '[]')) {
                    $name .= '[]';
                }
            } else {
                // False attribute; ensure attribute not set
                $multiple = '';
            }
            unset($attribs['multiple']);
        }

        // now start building the XHTML.
        $disabled = '';
        if (true === $disable) {
            $disabled = ' disabled="disabled"';
        }

        // Build the surrounding select element first.
        $xhtml = '<select'
                . ' name="' . $this->view->escape($name) . '"'
                . ' id="' . $this->view->escape($id) . '"'
                . $multiple
                . $disabled
                . $this->_htmlAttribs($attribs)
                . ">\n    ";

        // build the list of options
        $list       = array();
        $translator = $this->getTranslator();
        foreach ((array) $options as $opt_value => $opt_label) {

            if (is_array($opt_label)
            		&& (!isset($opt_label['attribut_spe']))
            		) {
                $opt_disable = '';
                if (is_array($disable) && in_array($opt_value, $disable)) {
                    $opt_disable = ' disabled="disabled"';
                }
                if (null !== $translator) {
                    $opt_value = $translator->translate($opt_value);
                }
                $opt_id = ' id="' . $this->view->escape($id) . '-optgroup-'
                        . $this->view->escape($opt_value) . '"';
                $list[] = '<optgroup'
                        . $opt_disable
                        . $opt_id
                        . ' label="' . $this->view->escape($opt_value) .'">';
                foreach ($opt_label as $val => $lab) {
                    $list[] = $this->_build($val, $lab, $value, $disable);
                }
                $list[] = '</optgroup>';
            } else {
            	if (isset($opt_label['attribut_spe']) 
            		&& !(is_null($opt_label['attribut_spe']))
            		&& (is_array($opt_label['attribut_spe']))
            			)
                $list[] = $this->_buildattribut($opt_label['attribut_spe'], $value, $disable);
            	else
                $list[] = $this->_build($opt_value, $opt_label, $value, $disable);
            }
        }

        // add the options to the xhtml and close the select
        $xhtml .= implode("\n    ", $list) . "\n</select>";

        return $xhtml;
    }

    /**
     * Builds the actual <option> tag
     *
     * @param string $value Options Value
     * @param string $label Options Label
     * @param array  $selected The option value(s) to mark as 'selected'
     * @param array|bool $disable Whether the select is disabled, or individual options are
     * @return string Option Tag XHTML
     */
    protected function _build($value, $label, $selected, $disable)
    {
        if (is_bool($disable)) {
            $disable = array();
        }

        $opt = '<option'
             . ' value="' . $this->view->escape($value) . '"'
             . ' label="' . $this->view->escape($label) . '"';

        // selected?
        if (in_array((string) $value, $selected)) {
            $opt .= ' selected="selected"';
        }

        // disabled?
        if (in_array($value, $disable)) {
            $opt .= ' disabled="disabled"';
        }

        $opt .= '>' . $this->view->escape($label) . "</option>";

        return $opt;
    }
    /**
     * Construction de la balise <option> avec des attributs spécifiques
     *
     * @param array $attribut_spe Option's attributs
     * 							attribut_spe['affiche'] = 'xxx' => <option ...>'xxx'</option>
     * 							si attribut_spe['affiche'] n'existe pas =>  <option ...>attribut_spe["label"]</option>
     * 							si attribut_spe["not_escape_affiche"] = true alors <option ...>'xxx'</option>
     * 																													 sinon <option ...>$this->view->escape('xxx')</option>
     * 							Toutes les autres valeurs de attribut_spe seront dans les attributs du tag 'option'
     * 							ex.: attribut_spe["class"] = 'toto' et attribut_spe["style"] = 'width:143px;'
     * 										=> <option class='toto' style='width:143px;'> ... </option>
     * @param array  $selected The option value(s) to mark as 'selected'
     * @param array|bool $disable Whether the select is disabled, or individual options are
     * @return string Option Tag XHTML
     */
    protected function _buildattribut($attribut_spe, $selected, $disable)
    {
        if (is_bool($disable)) {
            $disable = array();
        }

        $opt = '<option';
        foreach ($attribut_spe as $cle => $valeur){
        	if ($cle == "affiche") continue;
        	if ($cle == "not_escape_affiche") continue;
        	$opt .= ' ' . $cle . '="' . $valeur . '"';
        }

        // selected?
        if (in_array($attribut_spe["value"], $selected)) {
            $opt .= ' selected="selected"';
        }

        // disabled?
        if (in_array($attribut_spe["value"], $disable)) {
            $opt .= ' disabled="disabled"';
        }

        $opt .= '>';
        
        if (isset($attribut_spe["affiche"]) && !empty($attribut_spe["affiche"]))
        	$affiche = $attribut_spe["affiche"];
        else 
        	$affiche = $attribut_spe["label"];
                     
        if (isset($attribut_spe["not_escape_affiche"]) 
        	&& is_bool($attribut_spe["not_escape_affiche"])
        	&& $attribut_spe["not_escape_affiche"]){
        	$opt .= $affiche;
        }
        else{
        	$opt .= $this->view->escape($affiche);
        }
        
        $opt .= "</option>";

        return $opt;
    }
}



			