<?php
/**
 * Doydoy
 *
 * @brief	Classe Permettant de géré des groupes de groupes 
 *        et non plus seulement des groupes d'éléments
 *        Permet d'avoir des fieldset imbriqués 
 * 		
 * @category   	Doydoy
 * @package     Doydoy/Form
 * @extends 	  Zend_Form_DisplayGroup
 *
 * @author    Doydoy
 * @version   1.0
 * 
 */

/** Zend_Form_DisplayGroup */
require_once 'Zend/Form/DisplayGroup.php';

class Doydoy_Form_DisplayGroup extends Zend_Form_DisplayGroup
{
    
    /**
     * Constructor
     *
     * @param  string $name
     * @param  Zend_Loader_PluginLoader $loader
     * @param  array|Zend_Config $options
     * @return void
     */
    public function __construct($name, Zend_Loader_PluginLoader $loader, $options = null)
    {
      $this->clearElements();
      parent::__construct($name, $loader, $options);
    }

//    /**
//      * Array to which element belongs
//      * @var string
//      */
//     protected $_belongsTo;
    
//     /**
//      * Return array name to which element belongs
//      *
//      * @return string
//      */
//     public function getBelongsTo()
//     {
//       return $this->_belongsTo;
//     }

//     /**
//      * Set array to which element belongs
//      *
//      * @param  string $array
//      * @return Zend_Form_Element
//      */
//     public function setBelongsTo($array)
//     {
//       $array = $this->filterName($array, true);
//       if (!empty($array)) {
//         $this->_belongsTo = $array;
//       }
    
//       return $this;
//     }

//     /**
//      * Get fully qualified name
//      *
//      * Places name as subitem of array and/or appends brackets.
//      *
//      * @return string
//      */
//     public function getFullyQualifiedName()
//     {
//       $name = $this->getName();
    
//       if (null !== ($belongsTo = $this->getBelongsTo())) {
//         $name = $belongsTo . '[' . $name . ']';
//       }
    
//       /* @todo les tableaux ne sont pas gérés (comme le sont les éléments)
//       if ($this->isArray()) {
//         $name .= '[]';
//       }
//       */
    
//       return $name;
//     }
    
    // Groups
    
    /**
     * copie de la fonction 'public function addElement(Zend_Form_Element $element)' mais pour les élément de type Zend_Form_DisplayGroup
     * Add element to stack
     *
     * @param  Zend_Form_Element $element
     * @return Zend_Form_DisplayGroup
     */
    public function addGroup(Zend_Form_DisplayGroup $group)
    {
      $this->_elements[$group->getName()] = $group;
      $this->_groupUpdated = true;
    
      // Display group will now handle display of element
      if (null !== ($form = $this->getForm())) {
        $form->removeFromIteration($group->getName());
      }
    
      return $this;
    }
    
    /**
     * copie de la fonction 'public function addElements' mais pour les élément de type Zend_Form_DisplayGroup
     * Add multiple elements at once
     *
     * @param  array $elements
     * @return Zend_Form_DisplayGroup
     * @throws Zend_Form_Exception if any element is not a Zend_Form_Element
     */
    public function addGroups(array $groups)
    {
      foreach ($groups as $group) {
        if (!$group instanceof Zend_Form_DisplayGroup) {
          require_once 'Zend/Form/Exception.php';
          throw new Zend_Form_Exception('elements passed via array to addGroups() must be Zend_Form_DisplayGroup only');
        }
        $this->addGroup($group);
      }
      return $this;
    }
    
    /**
     * Set multiple elements at once (overwrites)
     *
     * @param  array $elements
     * @return Zend_Form_DisplayGroup
     */
    public function setGroups(array $groups)
    { 
      if (!empty($groups)){
        return $this->addGroups($groups);
      }
    }
    
    /**
     * Set multiple elements at once (overwrites)
     * On redéfini setElements pour qu'il ne fasse pas de clearElements();
     *
     * @param  array $elements
     * @return Zend_Form_DisplayGroup
     */
    public function setElements(array $elements)
    {
      if (!empty($elements)){
        return $this->addElements($elements);
      }
    }

    /**
     * Doydoy_Form_DisplayGroup est géré comme étant un élément de formulaire
     * Donc pour toutes les fonctions correspondantes à un élément indépendant du groupe
     * on utilise un élément de substitution qui est Doydoy_Form_Element_HtmlBrut
     * 
     * @var Doydoy_Form_Element_HtmlBrut
     */
    private $_element_substitution = null;
    
    /**
     * Doydoy_Form_DisplayGroup est géré comme étant un élément de formulaire
     * Donc pour toutes les fonctions correspondantes à un élément indépendant du groupe
     * on utilise un élément de substitution qui est Doydoy_Form_Element_HtmlBrut
     * 
     * (non-PHPdoc)
     * @see Zend_Form_DisplayGroup::__call()
     */
    public function __call($name, $arguments){
      $id = uniqid('Group');
      if (!isset($this->_element_substitution)){
        $this->_element_substitution = new Doydoy_Form_Element_HtmlBrut($id);
      }
      
      //$result = $this->_element_substitution->$name($arguments);
      return $this->_element_substitution->$name($arguments);
    }
 }
