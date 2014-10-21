<?php
/**
 * Doydoy
 *
 * @brief			Classe Abstraite permettant de charger les décorateurs
 *            et de gérer les groupes de groupes d'éléments
 * 		
 * @category   	Doydoy
 * @package     Doydoy/Form
 * @extends 	  Zend_Form
 * 
 * @author    Doydoy
 * @version   1.0
 * 
 */

/** Zend_Form */
require_once 'Zend/Form.php';

abstract class Doydoy_Form_FormAbstract extends Zend_Form
{
  /**
   * cache pour les formulaires
   * @var Zend_Cache|null
   */
  protected $_cache = null;
  
	/**
	 * Initialisation -> appeler après __construct()
	 */
	public function init()
	{
	  
	  $this->_cache = Doydoy_Form_Tools_CacheForm::$cache; 
	  
		// Déclaration de la classe qui crée les groupes
		$this->setDefaultDisplayGroupClass('Doydoy_Form_DisplayGroup');
		
		// Suppression du décorateur Label de Zend
    $this->removeDecorator('Label');
    // le rajout de notre propre décorateur de Label (pour gérer label_id)
    // se fera dans GereForm en cas de besoin
		
		$this->initDoydoy();
	}
	
	/**
	 * Si un cache est géré
	 * On offre la possibilité de gérer des valeurs qui ne doivent pas être mises en cache
	 */
	public function valeurNoCache(){} 
	
	/**
	 * Remplace le init dans tous les formulaire
	 */
	public function initDoydoy(){} 

	/**
	 * Création d'un groupe d'éléments
	 * @param string $name nom du conteneur
	 * @param string $type type de conteneur, fieldset, div, span
	 * @param array $elements_contenu  éléments contenus (Zend_Form_Element ou Zend_Form_DisplayGroup)
	 * @param array $options  options pour le conteneur (id, class, ...)
	 * @return Zend_Form_DisplayGroup groupe nouvellement créé
	 * 
	 * @example : Bloc DIV :
	 *            $div_nom = $this->createGroupe('div_nom', 'div', array($nom), array('id'=>'contact_ligne_nom', 'class'=>'class-contact-ligne'));
	 *            Bloc Fieldset
	 *            $fieldset_civ = $this->createGroupe('fieldset_civ', 'fieldset', array($div_nom,$div_prenom), array('id'=>'contact_civ', 'class'=>'class-civ'));
	 *            $fieldset_civ->setLegend("coordonnées");
	 *            
	 */
	protected function createGroupe($name, $type, array $elements_contenu, $options = null){
	  $conteneur = new Doydoy_Form_Decorator_Conteneur();
	  $conteneur->setType($type);
	  
	  if (isset($options))
	    $conteneur->setOptions($options);
	
	  $groupe = $this->addDisplayGroupDoydoy($elements_contenu, $name);
	
	  $groupe->setDecorators(array('FormElements', array($conteneur)));
	
	  unset($conteneur);
	
	  return $groupe;
	}
	
	/**
	 * Basé sur le addDisplayGroup de Zend_Form
   * Add a display group
   *
   * Groups named elements for display purposes.
   *
   * If a referenced element does not yet exist in the form, it is omitted.
   * 
	 * @param array $groups
	 * @param string $name
	 * @param array|Zend_Config $options
	 * @throws Zend_Form_Exception
	 * @return Zend_Form_DisplayGroup groupe nouvellement créé
	 */
  /* Original de Zend_Form 1.12:
    public function addDisplayGroup(array $elements, $name, $options = null)
    {
        $group = array();
        foreach ($elements as $element) {
            if($element instanceof Zend_Form_Element) {
                $elementName = $element->getName();
                if (!isset($this->_elements[$elementName])) {
                    $this->addElement($element);
                }
                $element = $elementName;
            }

            if (isset($this->_elements[$element])) {
                $add = $this->getElement($element);
                if (null !== $add) {
                    $group[] = $add;
                }
            }
        }
        if (empty($group)) {
            require_once 'Zend/Form/Exception.php';
            throw new Zend_Form_Exception('No valid elements specified for display group');
        }

        $name = (string) $name;

        if (is_array($options)) {
            $options['form']     = $this;
            $options['elements'] = $group;
        } elseif ($options instanceof Zend_Config) {
            $options = $options->toArray();
            $options['form']     = $this;
            $options['elements'] = $group;
        } else {
            $options = array(
                'form'     => $this,
                'elements' => $group,
            );
        }

        if (isset($options['displayGroupClass'])) {
            $class = $options['displayGroupClass'];
            unset($options['displayGroupClass']);
        } else {
            $class = $this->getDefaultDisplayGroupClass();
        }

        if (!class_exists($class)) {
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass($class);
        }
        $this->_displayGroups[$name] = new $class(
            $name,
            $this->getPluginLoader(self::DECORATOR),
            $options
        );

        if (!empty($this->_displayGroupPrefixPaths)) {
            $this->_displayGroups[$name]->addPrefixPaths($this->_displayGroupPrefixPaths);
        }

        $this->_order[$name] = $this->_displayGroups[$name]->getOrder();
        $this->_orderUpdated = true;
        return $this;
    } 
	 */
	protected function addDisplayGroupDoydoy(array $groups, $name, $options = null)
	{
	  // Groupe de groupes 
	  $group_groupe = array();
	  // Groupe d'éléments
	  $group_element = array();
	  foreach ($groups as $element_group) {
	    $element_obj = $element_group;
	    if($element_group instanceof Zend_Form_DisplayGroup) {
	      $elementName = $element_group->getName();
	      if (!isset($this->_elements[$elementName])) {
	        $this->addGroup($element_group);
	      }
	      $element_group = $elementName;
	    }
	
	    if($element_group instanceof Zend_Form_Element) {
	      $elementName = $element_group->getName();
	      if (!isset($this->_elements[$elementName])) {
	        $this->addElement($element_group);
	      }
	      $element_group = $elementName;
	    }
	
	    if (isset($this->_elements[$element_group])) {
	      $add = $this->getElement($element_group);
	      if (null !== $add) {
	        if($element_obj instanceof Zend_Form_DisplayGroup)
	          $group_groupe[] = $add;
	        elseif($element_obj instanceof Zend_Form_Element)
	        $group_element[] = $add;
	      }
	    }
	  }
	  if (empty($group_groupe) && empty($group_element)) {
	    require_once 'Zend/Form/Exception.php';
	    throw new Zend_Form_Exception('No valid elements specified for display group');
	  }
	
	  $name = (string) $name;
	
	  if (is_array($options)) {
	    $options['form']     = $this;
	    $options['elements'] = $group_element;
	    $options['groups']   = $group_groupe;
	  } elseif ($options instanceof Zend_Config) {
	    $options = $options->toArray();
	    $options['form']     = $this;
	    $options['elements'] = $group_element;
	    $options['groups']   = $group_groupe;
	  } else {
	    $options = array(
	        'form'     => $this,
	        'elements' => $group_element,
	        'groups'   => $group_groupe,
	    );
	  }
	  if (isset($options['displayGroupClass'])) {
	    $class = $options['displayGroupClass'];
	    unset($options['displayGroupClass']);
	  } else {
	    $class = $this->getDefaultDisplayGroupClass();
	  }
	
	  if (!class_exists($class)) {
	    require_once 'Zend/Loader.php';
	    Zend_Loader::loadClass($class);
	  }
	
	  $this->_displayGroups[$name] = new $class(
	      $name,
	      $this->getPluginLoader(self::DECORATOR),
	      $options
	  );
	
	  if (!empty($this->_displayGroupPrefixPaths)) {
	    $this->_displayGroups[$name]->addPrefixPaths($this->_displayGroupPrefixPaths);
	  }
	
	  $this->_order[$name] = $this->_displayGroups[$name]->getOrder();
	  $this->_orderUpdated = true;
	  return $this->_displayGroups[$name];
	}

	/**
	 * Basé sur le addElement de Zend_Form
	 * Add a new groupe
	 *
	 * $element_group may be either a string element type, or an object of type
	 * Zend_Form_DisplayGroup. If a string element type is provided, $name must be
	 * provided, and $options may be optionally provided for configuring the
	 * element.
	 *
	 * If a Zend_Form_DisplayGroup is provided, $name may be optionally provided,
	 * and any provided $options will be ignored.
	 *
	 * @param  string|Zend_Form_DisplayGroup $element_group
	 * @param  string $name
	 * @param  array|Zend_Config $options
	 * @throws Zend_Form_Exception on invalid element
	 * @return Zend_Form
	 */
  /* Original de Zend_Form 1.12:
    public function addElement($element, $name = null, $options = null)
    {
        if (is_string($element)) {
            if (null === $name) {
                require_once 'Zend/Form/Exception.php';
                throw new Zend_Form_Exception('Elements specified by string must have an accompanying name');
            }

            if (is_array($this->_elementDecorators)) {
                if (null === $options) {
                    $options = array('decorators' => $this->_elementDecorators);
                } elseif ($options instanceof Zend_Config) {
                    $options = $options->toArray();
                }
                if (is_array($options)
                    && !array_key_exists('decorators', $options)
                ) {
                    $options['decorators'] = $this->_elementDecorators;
                }
            }

            $this->_elements[$name] = $this->createElement($element, $name, $options);
        } elseif ($element instanceof Zend_Form_Element) {
            $prefixPaths              = array();
            $prefixPaths['decorator'] = $this->getPluginLoader('decorator')->getPaths();
            if (!empty($this->_elementPrefixPaths)) {
                $prefixPaths = array_merge($prefixPaths, $this->_elementPrefixPaths);
            }

            if (null === $name) {
                $name = $element->getName();
            }

            $this->_elements[$name] = $element;
            $this->_elements[$name]->addPrefixPaths($prefixPaths);
        } else {
            require_once 'Zend/Form/Exception.php';
            throw new Zend_Form_Exception('Element must be specified by string or Zend_Form_Element instance');
        }

        $this->_order[$name] = $this->_elements[$name]->getOrder();
        $this->_orderUpdated = true;
        $this->_setElementsBelongTo($name);

        return $this;
    }
   */
	public function addGroup($element_group, $name = null, $options = null)
	{
	  if (is_string($element_group)) {
	    if (null === $name) {
	      require_once 'Zend/Form/Exception.php';
	      throw new Zend_Form_Exception('Elements specified by string must have an accompanying name');
	    }
	
	    if (is_array($this->_elementDecorators)) {
	      if (null === $options) {
	        $options = array('decorators' => $this->_elementDecorators);
	      } elseif ($options instanceof Zend_Config) {
	        $options = $options->toArray();
	      }
	      if (is_array($options)
	          && !array_key_exists('decorators', $options)
	      ) {
	        $options['decorators'] = $this->_elementDecorators;
	      }
	    }
	
	    $this->_elements[$name] = $this->createElement($element_group, $name, $options);
	  } elseif ($element_group instanceof Zend_Form_DisplayGroup) {
	
	    if (null === $name) {
	      $name = $element_group->getName();
	    }
	
	    $this->_elements[$name] = $element_group;
	  } else {
	    require_once 'Zend/Form/Exception.php';
	    throw new Zend_Form_Exception('Element must be specified by string or Zend_Form_Element instance');
	  }
	
	  $this->_order[$name] = $this->_elements[$name]->getOrder();
	  $this->_orderUpdated = true;
	  $this->_setElementsBelongTo($name);
	
	  return $this;
  }

  
  /**
   * Surcharge de la fonction getElementsAndSubFormsOrdered de Zend_Form
   * pour prendre en compte les conteneurs de conteneur
   * 
   * Returns a one dimensional numerical indexed array with the
   * Elements, SubForms and Elements from DisplayGroups as Values.
   *
   * Subitems are inserted based on their order Setting if set,
   * otherwise they are appended, the resulting numerical index
   * may differ from the order value.
   *
   * @access protected
   * @return array
   */
  /* Original de Zend_Form 1.12:
    public function getElementsAndSubFormsOrdered()
    {
        $ordered = array();
        foreach ($this->_order as $name => $order) {
            $order = isset($order) ? $order : count($ordered);
            if ($this->$name instanceof Zend_Form_Element ||
                $this->$name instanceof Zend_Form) {
                array_splice($ordered, $order, 0, array($this->$name));
            } else if ($this->$name instanceof Zend_Form_DisplayGroup) {
                $subordered = array();
                foreach ($this->$name->getElements() as $element) {
                    $suborder = $element->getOrder();
                    $suborder = (null !== $suborder) ? $suborder : count($subordered);
                    array_splice($subordered, $suborder, 0, array($element));
                }
                if (!empty($subordered)) {
                    array_splice($ordered, $order, 0, $subordered);
                }
            }
        }
        return $ordered;
    }
   */
  public function getElementsAndSubFormsOrdered()
  {    
    $ordered = array();
    
    foreach ($this->_order as $name => $order) {
      $order = isset($order) ? $order : count($ordered);
      if ($this->$name instanceof Zend_Form_Element || 
          $this->$name instanceof Zend_Form) {
        array_splice($ordered, $order, 0, array($this->$name));
      } else if ($this->$name instanceof Zend_Form_DisplayGroup) {
        $subordered = $this->_getAllElementsOfDisplayGroup($this->$name, 0);
        if (!empty($subordered)) {
          array_splice($ordered, $order, 0, $subordered);
        }
      }
    }
    
    return $ordered;
  }
  
  /**
   * fonction retournant tous les éléments d'un groupe 
   * On les retourne dans l'odre  puisque c'est appelé par le FormErrors
   * Et donc autant les afficher par ordre d'apparition
   * 
   * @param Zend_Form_DisplayGroup $group
   * @param integer $order_init sert à avoir l'odre d'un élément dans un groupe de groupe
   * @return array
   */
  protected function _getAllElementsOfDisplayGroup(Zend_Form_DisplayGroup $group, $order_init){
    $liste_elements = array();
    
    // Pour avoir le bon ordre on trie par les getOrder() des éléments
    $liste_element_du_groupe = array();    
    foreach ($group->getElements() as $element) {
      $liste_element_du_groupe[$element->getOrder()] = $element; 
    }
    ksort($liste_element_du_groupe);
       
    foreach ($liste_element_du_groupe as $order => $element) {
      if ($element instanceof Zend_Form_DisplayGroup){
        $elements_groupe = $this->_getAllElementsOfDisplayGroup($element, $order_init + count($liste_elements));
        $liste_elements = array_merge_recursive($liste_elements, $elements_groupe);
        $order_init = $order_init + count($liste_elements);
      }
      else{
        if(($element instanceof Zend_Form_Element) && ! ($element instanceof Doydoy_Form_Element_HtmlBrut))
          array_splice($liste_elements, $order + $order_init, 0, array($element));
      }
    }
    
    return $liste_elements;    
  }

  /**
   * @TODO gérer le clonage
   * Surcharge de la fonction getElementsAndSubFormsOrdered de Zend_Form
   * pour prendre en compte les conteneurs de conteneur
   * 
   * Clone form object and all children
   *
   * @return void
   */
  /* Original de Zend_Form 1.12:
  public function __clone()
  {
    $elements = array();
    foreach ($this->getElements() as $name => $element) {
      $elements[] = clone $element;
    }
    $this->setElements($elements);
  
    $subForms = array();
    foreach ($this->getSubForms() as $name => $subForm) {
      $subForms[$name] = clone $subForm;
    }
    $this->setSubForms($subForms);
  
    $displayGroups = array();
    foreach ($this->_displayGroups as $group)  {
      $clone    = clone $group;
      $elements = array();
      foreach ($clone->getElements() as $name => $e) {
        $elements[] = $this->getElement($name);
      }
      $clone->setElements($elements);
      $displayGroups[] = $clone;
    }
    $this->setDisplayGroups($displayGroups);
  }
  */
  /* @TODO gérer le clonage
  public function __clone()
  {
    $elements = array();
    foreach ($this->getElements() as $name => $element) {
      $elements[] = clone $element;
    }
    $this->setElements($elements);
  
    $subForms = array();
    foreach ($this->getSubForms() as $name => $subForm) {
      $subForms[$name] = clone $subForm;
    }
    $this->setSubForms($subForms);
  
    $displayGroups = array();
    foreach ($this->_displayGroups as $group)  {
      dd($group);
      $clone = $this->cloneGroupe($group);      
      $displayGroups[] = $clone;
    }
    $this->setDisplayGroups($displayGroups);
  }

  protected function cloneGroupe($group){
      $clone    = clone $group;
      $elements = array();
      $groupes = array();
      foreach ($clone->getElements() as $name => $e) {
        if ($element instanceof Zend_Form_Element) {
          $elements[] = $this->getElement($name);
        }
        if ($element instanceof Zend_Form_DisplayGroup) {
          $groupes[] = $this->getElement($name);
        }
      }
      $clone->setElements($elements);

//       foreach($groupes as $groupe){
//         $clone->addGroup($groupe);
//         $this->cloneGroupe($groupe);
//       }
    return $clone;
  } 
  */ 
}
