<?php
/**
 * Doydoy
 *
 * @brief	Décorateur pour les conteneurs
 *        Permet d'avoir un bloc de div, span ou fieldset
 *        Basé sur le décorateur de fieldset Zend_Form_Decorator_Fieldset
 *
 * @category   Doydoy
 * @package    Doydoy/Form
 * @subpackage Decorator
 * @extends    Zend_Form_Decorator_Fieldset
 *
 * @author    Doydoy
 * @version   1.0
 */

/** Zend_Form_Decorator_Fieldset */
require_once 'Zend/Form/Decorator/Fieldset.php';


class Doydoy_Form_Decorator_Conteneur extends Zend_Form_Decorator_Fieldset
{

    /**
     * Type de conteneur (fieldset, div, span, ...)
     * Par défaut, c'est fieldset
     * @var string
     */
    protected $_type = 'fieldset';
    
    /**
     * permet d'avoir un id dans la balise legend
     * @var string
     */
    protected $_legend_id = null;

    /**
     * permet d'avoir une classe dans la balise legend
     * @var string
     */
    protected $_legend_class = null;

    /**
     * Set type
     *
     * @param  string $value
     * @return Zend_Form_Decorator_Conteneur
     */
    public function setType($value)
    {
      $this->_type = (string) $value;
      return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    { 
      return $this->_type;
    }

    /**
     * Set l'id du bloc legend
     *
     * @param  string $value
     * @return Zend_Form_Decorator_Conteneur
     */
    public function setLegendId($value)
    {
      $this->_legend_id = (string) $value;
      return $this;
    }

    /**
     * Set la class du bloc legend
     *
     * @param  string $value
     * @return Zend_Form_Decorator_Conteneur
     */
    public function setLegendClass($value)
    {
      $this->_legend_class = (string) $value;
      return $this;
    }
    
    
    /**
     * Render a conteneur
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $type    = $this->getType();
        $legend  = $this->getLegend();
        $attribs = $this->getOptions();
        $name    = $element->getFullyQualifiedName();
        
        if (array_key_exists('id', $attribs) && '' !== $attribs['id']) {            
            $id = $attribs['id'];
        }
        else
          $id = '';
        

        if (isset($legend) || isset($this->_legend_id) || isset($this->_legend_class)) {
          if (isset($legend)){
            if (null !== ($translator = $element->getTranslator())) {
                $legend = $translator->translate($legend);
            }
            $attribs['legend'] = $legend;
          }
          if (isset($this->_legend_id)){
            $attribs['legend_id'] = $this->_legend_id;
          }
          if (isset($this->_legend_class)){
            $attribs['legend_class'] = $this->_legend_class;
          }
        }

        foreach (array_keys($attribs) as $attrib) {
            $testAttrib = strtolower($attrib);
            if (in_array($testAttrib, $this->stripAttribs)) {
                unset($attribs[$attrib]);
            }
        }

        // Récupération du décorateur
        return $view->conteneur($name, $type, $content, $attribs);
    }
}
