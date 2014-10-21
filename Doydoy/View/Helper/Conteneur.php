<?php
/**
 * Doydoy
 *
 * @brief	Vue d'aide pour les conteneurs
 *        Permet d'avoir un bloc de div, span ou fieldset
 *        Appelé par Doydoy_Form_Decorator_Conteneur
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

class Doydoy_View_Helper_Conteneur extends Zend_View_Helper_FormElement
{
    /**
     * Render HTML form
     *
     * @param  string $name Form name
     * @param  string $content Form content
     * @param  array $attribs HTML form attributes
     * @return string
     */
    public function conteneur($name, $type, $content, $attribs = null)
    {
        // L'id se fait par le passage des attributs
        $id_init = (isset($attribs['id'])? ' id="' . $this->view->escape($attribs['id']) . '"' : '');

        $info = $this->_getInfo($name, $content, $attribs);
        extract($info);

        // get legend
        $legend = '';
        
        if (isset($attribs['legend']) || isset($attribs['legend_id']) || isset($attribs['legend_class'])) {
          $legendString = '';
          $legend_id    = '';
          $legend_class = '';
          $traite_legend = false;
          
          if (isset($attribs['legend'])){
            $legendString = trim($attribs['legend']);
            $legendString = (($escape) ? $this->view->escape($legendString) : $legendString);
            unset($attribs['legend']);
            if (!empty($legendString)) $traite_legend = true;
          }
          if (isset($attribs['legend_id'])){
            $legend_id = ' id="'. trim($attribs['legend_id']) . '"';
            unset($attribs['legend_id']);
            $traite_legend = true;
          }
          if (isset($attribs['legend_class'])){
            $legend_class = ' class="'. trim($attribs['legend_class']) . '"';
            unset($attribs['legend_class']);
            $traite_legend = true;
          }
          if ($traite_legend) {
              $legend = '<legend'  
                      . $legend_id 
                      . $legend_class
                      . '>'
                      . $legendString
                      . '</legend>' . PHP_EOL;
          }
        }

        // La méthode _getInfo() réinitialise l'id donc on récupère celui qu'on voulait
        $id = $id_init;

        switch (strtolower($type)) {
          case 'fieldset':
            $tag = 'fieldset';
            break;
          case 'div':
            $tag = 'div';
            break;
          case 'span':
            $tag = 'span';
            break;
          case 'p':
            $tag = 'p';
            break;
          default: $tag = strtolower($type); 
        }

        // render fieldset
        $xhtml = '<' . $tag
               . $id
               . $this->_htmlAttribs($attribs)
               . '>'
               . $legend
               . $content
               . '</' . $tag . '>';

        return $xhtml;
    }
}
