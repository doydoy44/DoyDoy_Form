<?php
/**
 * Doydoy
 *
 * @brief	GereForm permet de créer des formulaires avec des tableaux d'éléments.
 * 		
 * @category   Doydoy
 * @package    Doydoy/Form
 * @subpackage Tools
 * @extends    Doydoy_Form_FormAbstract
 *
 * @author    Doydoy
 * @version   1.0
 * 
 * Liste des attributs possibles:
 * 
 * ---------------------
 *   Label
 * ---------------------
 * (string)  'label'               			=> Label désiré de l'élément
 * (boolean) 'no_label'            			=> pas de Label (avant => nolabel)
 * (boolean) 'only_label'          			=> on ne veut que le Label (avant => noinput)
 * (string)  'label_deco_tag'           => défini le tag du décorateur Label
 * (string)  'label_deco_css'           => défini la class du décorateur Label
 * (boolean) 'label_deco_no_css'        => Pas de css pour ce label
 * (boolean) 'label_deco_no_css_commun' => Pas de css commun pour ce label (si un css commun à tous les label a été spécifié)
 * (boolean) 'label_disable_for'   			=> enlève l'attribut 'for' de la balise <label>
 * (string)  'label_deco_id'       			=> spécifie l'id du décorateur Label
 * (array)   'label_attribut'      			=> attribut de la balise <label> (class, for, ...)
 *                                    		(string) 'for' => génère l'attribut for avec ce qu'il est indiqué
 *                                    		(string) 'id'  => spécifie l'id du tag 'label'
 *                                    		...
 * 
 * (boolean) 'default_deco' => Garde le décorateur par défaut de Zend
 * ---------------------
 *   Element
 * ---------------------
 * (string)  'type_champ' => indique le type d'élément traité, si non renseigné, ce sera Zend_Form_Element_Text  (avant => TypeChamp)
 *                           sinon 'Text'          : 'Zend_Form_Element_Text'
 *                                 'Select'        : 'Zend_Form_Element_Select';
 *                                 'Radio'         : 'Zend_Form_Element_Radio';
 *                                 'Submit'        : 'Zend_Form_Element_Submit';
 *                                 'Button'        : 'Zend_Form_Element_Button
 *                                 'Reset'         : 'Zend_Form_Element_Reset
 *                                 'File'          : 'Zend_Form_Element_File
 *                                 'Hash'          : 'Zend_Form_Element_Hash
 *                                 'Image'         : 'Zend_Form_Element_Image
 *                                 'Multi'         : 'Zend_Form_Element_Multi 
 *                                 'MultiCheckbox' : 'Zend_Form_Element_MultiCheckbox
 *                                 'Multiselect'   : 'Zend_Form_Element_Multiselect
 *                                 'Password'      : 'Zend_Form_Element_Password
 *                                 'Xhtml'         : 'Zend_Form_Element_Xhtml
 *                                 'Element'       : 'Zend_Form_Element
 *                                 'Textarea'      : 'Zend_Form_Element_Textarea';
 *                                 'Checkbox'      : 'Zend_Form_Element_Checkbox';
 *                                 'Hidden'        : 'Zend_Form_Element_Hidden';
 *                                 'HtmlBrut'      : 'Doydoy_Form_Element_HtmlBrut';
 *                                 'Conteneur'     : Conteneur de type fieldset, div, span, ...
 *                                  
 * (boolean) 'only_element'    => on ne veut pas de décorateur mise à par le sien (ViewHelper)
 * (boolean) 'no_decorateur'   => suppression de tous les décorateurs (N'a pas de sens à priori) (avant => nochamp)
 * (boolean) 'no_html_tag'     => pas de conteneur pour l'élément (pas de décorateur HtmlTag)
 * (string)  'html_tag_tag'    => remplacement du tag par défaut de la balse HtmlTag (dd)
 * (string)  'html_tag_id'     => définition de l'id de la balse HtmlTag (dd)
 * (boolean) 'no_id_html_tag'  => suppression de l'id de la balse HtmlTag (dd)
 * (string)  'html_tag_css'    => classe css de la balse HtmlTag (dd) (avant => champ_css)
 * (boolean) 'html_tag_no_css' => Pas de css pour la balse HtmlTag
 * 
 * -----------------------------------
 * Pour les conteneurs :
 * (string) 'type' => Indique le type de conteneur ('fieldset', 'div', 'span', ...)
 * (string) 'parent' => indique l'élément qui contiendra l'élément en cours
 * 
 * -----------------------------------
 * Les Légendes pour les fieldsets:
 * (array) 'legend' => (string) legend_string => Texte contenu entre les balises legend
 *                     (string) legend_id     => Permet de mettre un id dans la blaise legend
 *                     (string) legend_class  => Permet de mettre des classes dans la balise legend
 * 
 * -----------------------------------
 *                'valeur_par_defaut' => valeur par défaut de l'élément
 * (int)          'order'             => permet de changer l'odre d'un élément dans un bloc d'un formulaire
 * (array)        'choix'             => rempli les choix d'un élément multiple (setMultiOptions)
 * (array)        'attribut'          => tableau de tous les attributs de l'élément  (title, maxlength, onclick, onchange, disabled, ...)
 * (string|array) 'validateur'        => ajout un|des validateur(s) à l'élément (avant, il faut remplir le formulaire avec les validateurs disponibles avec setValidatorsDoydoy($liste_validators))
 * (boolean)      'required'          => valeur obligatoire (avant => valid_oblig)
 * (string|array) 'filtre'            => filtre ou liste de filtres pour l'élément  
 * (boolean)      'no_filtre'         => pas de filtre
 * 
 * -----------------------------------
 * Pour la gestion des caches
 * (string) 'choix_no_cache' => Les choix (alimentés par 'choix') ne sont pas mis en cache, ils sont gérés à chaque appel du formulaire
 *                              Les valeur en cache sont prioritaire donc si 'choix' et 'choix_no_cache' sont rempli on ne gardera que 'choix_no_cache'
 * (string) 'valeur_par_defaut_no_cache' => Les valeurs par défaut (alimentés par 'valeur_par_defaut') ne sont pas mis en cache, ils sont gérés à chaque appel du formulaire
 *                                          Les valeur en cache sont prioritaire donc si 'valeur_par_defaut' et 'valeur_par_defaut_no_cache' sont rempli on ne gardera que 'valeur_par_defaut_no_cache'
 * (string) 'label_no_cache' => Le label (alimentés par 'label') n'est pas mis en cache, il est géré à chaque appel du formulaire
 *                              Les valeur en cache sont prioritaire donc si 'label' et 'label_no_cache' sont rempli on ne gardera que 'label_no_cache'                                         
 *                                          
 * Les valeurs dans '..._no_cache' peuvent être des expressions entre cotes 
 *                                 ex: '$this->maFonction()' où maFonction est une fonction publique 
 * 
 * -----------------------------------
 * (array) 'AppendPrepend' => indique si on doit rajouter quelque chose avant et/ou après l'élément 
 *                            exemple: rajouter un <br> après l'élément  array('placement' => 'append','append'    => '<br>')
 * 
 * ---------------------
 *  Spécificités pour Zend_Form_Element_Checkbox
 * (array) 'checkbox_value' => valeur par défaut des état checked et unchecked
 *                          => array('checked'   => 'checked',
 *                                   'unchecked' => ''),
 * (boolean) 'checked' => coche ou décoche par défaut  
 * 
 *
 * ------------------------------------------------------------------------------
 * Fonctions Disponibles:
 * ------------------------------------------------------------------------------
 * setFormulaire(Doydoy_Form_FormAbstract &$formulaire)
 *   -> Indique à l'outil sur quel formulaire travailler
 *   
 * setElementsFormulaire(array &$elements)
 *  -> Tableau des éléments à mettre dans le formulaire
 *    $elements = array(
 *                       array('nom_element1' => array('nom_propriété1' => $valeur_propriété1,
 *                                                     'nom_propriété2' => $valeur_propriété2)
 *                             ),
 *                       array('nom_element2' => ...),
 *                       ... 
 *                      ) 
 *                      
 * getDefaultClassCSS()
 *  -> retourne les classes par défaut du décorateur HtmlTag pour tous les éléments qui n'ont pas leurs propres classes
 *  
 * setDefaultClassCSS($default_class_css)
 *  -> définit les classes par défaut du décorateur HtmlTag pour tous les éléments qui n'ont pas leurs propres classes
 *    ex: $default_class_css = 'classe_1 classe_2'
 *     
 * addClassToDefaultClassCSS($new_class_css)
 *  -> rajoute une(des) classe(s) aux classes par défaut du décorateur HtmlTag pour tous les éléments qui n'ont pas leurs propres classes
 *    ex : $new_class_css = 'classe_3'
 *  
 * getDefaultCommuneClassCSS()
 *  -> retourne les classes communes du décorateur HtmlTag pour tous les éléments qui ont leurs propres classes ('html_tag_css')
 * 
 * setDefaultCommuneClassCSS($default_commune_class_css)
 *  -> définit les classes communes du décorateur HtmlTag pour tous les éléments qui ont leurs propres classes ('html_tag_css')
 *    ex: $default_commune_class_css = 'classe_1 classe_2'
 *    
 * addClassToDefaultCommuneClassCSS($new_class_css)
 *  -> rajoute une(des) classe(s) aux classes communes du décorateur HtmlTag pour tous les éléments qui ont leurs propres classes ('html_tag_css')
 *    ex : $new_class_css = 'classe_3'
 *    
 * getDefaultCommuneLabelClassCSS()
 *  -> retourne les classes communes du décorateur Label pour tous les éléments qui ont leurs propres classes ('label_deco_css')
 * 
 * setDefaultCommuneLabelClassCSS($default_commune_class_css)
 *  -> définit les classes communes du décorateur Label pour tous les éléments qui ont leurs propres classes ('label_deco_css')
 *    ex: $default_commune_class_css = 'classe_1 classe_2'
 *    
 * addClassToDefaultCommuneLabelClassCSS($new_class_css)
 *  -> rajoute une(des) classe(s) aux classes communes du décorateur Label pour tous les éléments qui ont leurs propres classes ('label_deco_css')
 *    ex : $new_class_css = 'classe_3'
 *    
 * getDefaultLabelClassCSS()
 *  -> retourne les classes par défaut du décorateur Label pour tous les éléments qui n'ont pas leurs propres classes
 *  
 * setDefaultLabelClassCSS($default_class_css)
 *  -> définit les classes par défaut du décorateur Label pour tous les éléments qui n'ont pas leurs propres classes
 *    ex: $default_class_css = 'classe_1 classe_2'
 *    
 * addClassToDefaultLabelClassCSS($new_class_css)
 *  -> rajoute une(des) classe(s) aux classes par Label du décorateur HtmlTag pour tous les éléments qui n'ont pas leurs propres classes
 *    ex : $new_class_css = 'classe_3'
 *    
 * isRemoveAllDecoLabel()
 *   -> renvoie true s'il faut supprimer le décorateur Label
 *   
 * isRemoveAllDecoErrors()
 *   -> renvoie true s'il faut supprimer le décorateur Errors
 *   
 * isRemoveAllDecoHtmlTag()
 *   -> renvoie true s'il faut supprimer le décorateur HtmlTag
 *   
 * isRemoveAllDecoDescription()
 *   -> renvoie true s'il faut supprimer le décorateur Description
 *   
 * isRemoveAllDecoViewHelper()
 *   -> renvoie true s'il faut supprimer le décorateur ViewHelper
 *   
 * isRemoveAllDecoDtDdWrapper()
 *   -> renvoie true s'il faut supprimer le décorateur DtDdWrapper
 *   
 * isRemoveAllDecoTooltip()
 *   -> renvoie true s'il faut supprimer le décorateur Tooltip
 *   
 * isRemoveAllDecoFile()
 *   -> renvoie true s'il faut supprimer le décorateur File
 *   
 * isRemoveAllDecoImage()
 *   -> renvoie true s'il faut supprimer le décorateur Image
 *   
 * setRemoveAllDecoLabel($remove_all_deco_label)
 *   -> Indique s'il faut supprimer le décorateur Label
 *   
 * setRemoveAllDecoErrors($remove_all_deco_errors)
 *   -> Indique s'il faut supprimer le décorateur Errors
 *   
 * setRemoveAllDecoHtmlTag($remove_all_deco_html_tag)
 *   -> Indique s'il faut supprimer le décorateur HtmlTag
 *   
 * setRemoveAllDecoDescription($remove_all_deco_description)
 *   -> Indique s'il faut supprimer le décorateur Description
 *   
 * setRemoveAllDecoViewHelper($remove_all_deco_view_helper)
 *   -> Indique s'il faut supprimer le décorateur ViewHelper
 *   
 * setRemoveAllDecoDtDdWrapper($remove_all_deco_dt_dd_wrapper)
 *   -> Indique s'il faut supprimer le décorateur DtDdWrapper
 *   
 * setRemoveAllDecoTooltip($remove_all_deco_tooltip)
 *   -> Indique s'il faut supprimer le décorateur Tooltip
 *   
 * setRemoveAllDecoFile($remove_all_deco_file)
 *   -> Indique s'il faut supprimer le décorateur File
 *   
 * setRemoveAllDecoImage($remove_all_deco_image)
 *   -> Indique s'il faut supprimer le décorateur Image
 *   
 * getDefaultTagHtmlTag()
 *   -> Récupérer le Tag par défaut du décorateur HtmlTag
 *      Si on n'utilise pas setDefaultTagHtmlTag, se sera 'div' (au lieu de dd par Zend)
 *   
 * setDefaultTagHtmlTag($tag)
 *   -> Impose un tag par défaut pour tous les décorateur HtmlTag 
 *   (Zend utilise par défaut dd, nous avons choisi div, mais vous pouvez mettre autre chose)
 * 
 * getDefaultTagLabel()
 *   -> Récupérer le Tag par défaut du décorateur Label
 *      Si on n'utilise pas setDefaultTagLabel, se sera 'div' (au lieu de dt par Zend)
 *      
 * setDefaultTagLabel($tag)
 *   -> Impose un tag par défaut pour tous les décorateur Label 
 *   (Zend utilise par défaut dt, nous avons choisi div, mais vous pouvez mettre autre chose)
 * 
 * setValidatorsDoydoy(array $validators)
 *   -> Indique à l'outil la liste des validateurs disponibles
 *     array('nom_validateur' => $validateur, ...) 
 *     où $validateur est soit un nom (comme 'alnum') 
 *                        soit un Zend_Validate_Interface
 *   
 * getValidatorsDoydoy()
 *   -> retourne la liste des validateurs de l'outil
 *   
 * clearValidatorsDoydoy()
 *   -> Supprime tous les validateurs de l'outil
 *   
 * addValidatorDoydoy($name,  $validator)
 *   -> ajoute un validateur à l'outil
 * 
 * getValidator($name)
 *   -> Récupère un validateur par son nom 
 * 
 * setFiltersDoydoy(array $filters)
 *   -> Indique à l'outil la liste des filtres disponibles
 *     array('nom_filtre' => $filtre, ...) 
 *     où $filtre est soit un nom (comme 'StripTags') 
 *                        soit un Zend_Filter_Interface
 *                        
 * getFiltersDoydoy()
 *   -> retourne la liste des filtres de l'outil
 *   
 * clearFiltersDoydoy()
 *   -> Supprime tous les filtres de l'outil
 *   
 * addFilterDoydoy($name, $filter)
 *   -> ajoute un filtre à l'outil
 *   
 * getFilter($name)
 *   -> Récupère un filtre par son nom 
 *   
 * setFiltersForAllElements(array $filters)
 *   -> Indique à l'outil la liste des filtres par défaut pour tous les éléments
 *   (n'est pas pris en compte pour un éléments si les options 'filtre' ou 'no_filtre' sont renseignés)
 *   
 * clearFiltersAllElements()
 *   -> Supprime les filtres par défaut pour tous les éléments
 *   
 * addFilterAllElements($name, $filter)
 *   -> rajoue un filtre par défaut pour tous les éléments
 *   
 * errorGlobal($errorGlobal = false)
 *   ->???
 * 
 * alimenteFormulaire()
 *   -> lance le traitement de génération du formulaire
 * 
 * isParent($id_element)
 *   -> Indique si un élément est un conteneur ou pas
 *   
 *   
 * valeurNoCache()
 *   -> Alimentation des valeurs qui n'ont pas été mise en cache
 *   
 * ------------------------------------------------------------------------------
 *
 

$element_du_tableau['choix']: setMultiOptions($element_du_tableau['choix'])
//$element_du_tableau['valeur_par_defaut']
//* Exemple : bouton "Non" coché par défaut 
   'type_champ' 			=> 'Radio',
   'choix'		 		=> array('1' => 'Oui', '0' => 'Non'),
   'valeur_par_defaut'  => '0',
*

$element_du_tableau['validateur'] : nom de l'objet validator 
 //* Exemple : champ de longueur 6 caratcère et de type entier ayant 0 comme valeur par défaut
    $nbsal_validate = new Zend_Validate(); //Effectif
    $nbsal_validate ->addValidator($length_validator_6)
                    ->addValidator($entier_validator);
    
    'attribut'          => array('title'     => 'Nombre de salarié',
                                 'maxlength' => '6',
                                ),
    'validateur'        => 'nbsal_validate', //ajout d'une chaîne de validateurs Zend
    'valeur_par_defaut' => '0',                     
 *
 
 */

/** Doydoy_Form_FormAbstract */
require_once 'Doydoy/Form/FormAbstract.php';

abstract class Doydoy_Form_Tools_GereForm extends Doydoy_Form_FormAbstract {
  /**
   * Formulaire sur le quel on travaille
   * @var Doydoy_Form_FormAbstract
   */
  private $_formulaire = null;
  
  /**
   * Liste des éléments du formulaire
   * @var array
   */
  private $_elements_formulaire = null;
  
  /**
   * Element du formulaire en cours
   * @var unknown_type
   */
  private $_element_en_cours = null;

  /**
   * Element du formulaire en cours
   * @var unknown_type
   */
  private $_liste_elements_traites = null;
  
  /**
   * Liste des pères (conteneurs) avec leurs fils
   * @var array
   * @example $_liste_parents_childs = array(père1 => array(0 => fils1,
   *                                                    1 => fils2,
   *                                                    2 => père2),
   *                                     père2 => array(0 => fils3,
   *                                                    1 => fils4,
   *                                                    ...
   */
  private $_liste_parents_childs = null;

  /**
   * indique l'odre de l'élément dans le formulaire
   * @var array
   */
  private $_liste_ordre_element = array();
  
  /**
   * Liste des ordres désirés pour les éléments (setOrder())
   * @var array
   */
  private $_ordre_element_desire = array();
  
  /**
   * compteur d'ordre pour générer les éléments dans le bon odre
   * @var integer
   */
  private $_cpt_ordre = array();
    
  /**
   * Liste Original des pères (conteneurs) avec leurs fils
   * On supprime les éléments de $_liste_parents_childs au fur et à mesure qu'ils sont traités
   * Mais on veut quand même garder la liste
   */
  private $_liste_parents_childs_originale = null;
  
  /**
   * $liste des élements dont les options ne sont pas mise en cache
   * @var array
   */
  private $_liste_valeur_option_sans_cache = null;

  /**
   * $liste des élements dont les options ne sont pas mise en cache
   * @var array
   */
  private $_liste_label_sans_cache = null;
  
  /**
  * $liste des élements dont les valeurs ne sont pas mise en cache
   * @var array
   */
  private $_liste_valeur_defaut_sans_cache = null;
  
  /**
   * Liste de validateurs du formulaires 
   * @var array
   */
  protected $_liste_validators = null;
  
  /**
   * Liste de filtres du formulaires 
   * @var array
   */
  protected $_liste_filters = null;
  
  /**
   * Liste de filtres d'office pour tous les éléments du formulaires 
   * @var array
   */
  protected $_liste_filters_all_elements = null;
  
  /**
   * Classe css par défaut pour chaque élément du formulaire 
   * @var string
   */
  private $_default_class_css = '';
  
  /**
   * Classe css par défaut commune pour chaque élément du formulaire s'ils ont leurs propres classes 
   * @var string
   */
  private $_default_commune_class_css = '';
    
  /**
   * Classe css par défaut pour chaque élément Label du formulaire 
   * @var string
   */
  private $_default_label_class_css = '';
  
  /**
   * Classe css par défaut commune pour chaque élément Label du formulaire s'ils ont leurs propres classes 
   * @var string
   */
  private $_default_commune_label_class_css = '';
    
  /**
   * Faut-il supprimer le décorateur Label Par défaut
   * @var boolean
   */
  private $_remove_all_deco_label = false;
  
  /**
   * Faut-il supprimer le décorateur Errors Par défaut
   * @var boolean
   */
  private $_remove_all_deco_errors = false;
  
  /**
   * Faut-il supprimer le décorateur HtmlTag Par défaut
   * @var boolean
   */
  private $_remove_all_deco_html_tag = false;
  
  /**
   * Faut-il supprimer le décorateur Description Par défaut
   * @var boolean
   */
  private $_remove_all_deco_description = false;
  
  /**
   * Faut-il supprimer le décorateur ViewHelper Par défaut
   * @var boolean
   */
  private $_remove_all_deco_view_helper = false;
  
  /**
   * Faut-il supprimer le décorateur DtDdWrapper Par défaut
   * @var boolean
   */
  private $_remove_all_deco_dt_dd_wrapper = false;
  
  /**
   * Faut-il supprimer le décorateur ToolTip Par défaut
   * @var boolean
   */
  private $_remove_all_deco_tooltip = false;
  
  /**
   * Faut-il supprimer le décorateur File Par défaut
   * @var boolean
   */
  private $_remove_all_deco_file = false;
  
  /**
   * Faut-il supprimer le décorateur Image Par défaut
   * @var boolean
   */
  private $_remove_all_deco_image = false;
  
  /**
   * Tag par défaut du décorateur HtmlTag (si vide, on prend celui de Zend qui est 'dd')
   * J'ai choisi arbitrairement de l'initialiser à 'div'
   * Pour le changer, il faut utiliser setDefaultTagHtmlTag
   * @var string
   */
  private $_default_html_tag_tag = 'div';
  
  /**
   * Tag par défaut du décorateur Label (si vide, on prend celui de Zend qui est 'dt')
   * J'ai choisi arbitrairement de l'initialiser à 'div'
   * Pour le changer, il faut utiliser setDefaultTagLabel
   * @var string
   */
  private $_default_tag_label = 'div';
  
  /**
   * Il y a une gestion spécifique pour le décorateur DtDdWrapper
   * Cette variable permet de savoir si il y a un traitement sur ce décorateur  
   * @var boolean
   */
  private $_deco_dt_dd_wrapper_traite = false;

  /**
   * Définit si les erreurs sont retournées par les éléments ou par le formulaire
   * @var boolean
   */
  protected $_error_globale = false;
  
  /**
   * Crée le formulaire de travail
   * @param Zend_Form $formulaire
   */
  public function setFormulaire(Doydoy_Form_FormAbstract &$formulaire){
    $this->_formulaire = $formulaire;
    return $this;
  }

  /**
   * 
   * Alimente $_elements_formulaire (éléments du formulaires)
   * @param array $elements
   */
  public function setElementsFormulaire(array &$elements){
    $this->_elements_formulaire = $elements;
    return $this;
  }
    
  /**
   * Retourne la classe css par défaut pour chaque élément du formulaire 
   */
  public function getDefaultClassCSS(){
    return $this->_default_class_css;
  }
  
  /**
   * Définit la classe css par défaut pour chaque élément du formulaire 
   */  
  public function setDefaultClassCSS($default_class_css){
    $this->_default_class_css = $default_class_css;
    return $this;
  }
  
  /**
   * Ajout une classe à la classe css par défaut pour chaque élément du formulaire 
   */
  public function addClassToDefaultClassCSS($new_class_css){
    $this->_default_class_css .= ' ' . $new_class_css;
    return $this;
  }
  
  /**
   * Retourne la classe css par défaut commune pour chaque élément du formulaire s'ils ont leurs propres classes
   */
  public function getDefaultCommuneClassCSS(){
    return $this->_default_commune_class_css;
  }
  
  /**
   * Définit la classe css par défaut commune pour chaque élément du formulaire s'ils ont leurs propres classes
   */
  public function setDefaultCommuneClassCSS($default_commune_class_css){
    $this->_default_commune_class_css = ' ' . $default_commune_class_css;
    return $this;
  }
  
  /**
   * Ajoute une classe à la classe css par défaut commune pour chaque élément du formulaire s'ils ont leurs propres classes
   */
  public function addClassToDefaultCommuneClassCSS($new_class_css){
    $this->_default_commune_class_css .= ' ' . $new_class_css;
    return $this;
  }
  
  /**
   * Retourne la classe css par défaut commune pour chaque élément Label du formulaire s'ils ont leurs propres classes
   */
  public function getDefaultCommuneLabelClassCSS(){
    return $this->_default_commune_label_class_css;
  }
  
  /**
   * Définit la classe css par défaut commune pour chaque élément Label du formulaire s'ils ont leurs propres classes
   */
  public function setDefaultCommuneLabelClassCSS($default_commune_class_css){
    $this->_default_commune_label_class_css = ' ' . $default_commune_class_css;
    return $this;
  }
  
  /**
   * Ajoute une classe à la classe css par défaut commune pour chaque élément Label du formulaire s'ils ont leurs propres classes
   */
  public function addClassToDefaultCommuneLabelClassCSS($new_class_css){
    $this->_default_commune_label_class_css .= ' ' . $new_class_css;
    return $this;
  }
  
  /**
   * Retourne la classe css par défaut pour chaque élément Label du formulaire
   */
  public function getDefaultLabelClassCSS(){
    return $this->_default_label_class_css;
  }
  
  /**
   * Définit la classe css par défaut pour chaque élément Label du formulaire
   */
  public function setDefaultLabelClassCSS($default_class_css){
    $this->_default_label_class_css = $default_class_css;
    return $this;
  }
  
  /**
   * Ajoute une classe à la classe css par défaut pour chaque élément Label du formulaire
   */
  public function addClassToDefaultLabelClassCSS($new_class_css){
    $this->_default_label_class_css .= ' ' . $new_class_css;
    return $this;
  }

  /**
   * Faut-il supprimer le décorateur Label
   *
   * @return boolean
   */
  public function isRemoveAllDecoLabel(){    
    return $this->_remove_all_deco_label;
  }
  
  /**
   * Faut-il supprimer le décorateur Errors
   *
   * @return boolean
   */
  public function isRemoveAllDecoErrors(){    
    return $this->_remove_all_deco_errors;
  }
  
  /**
   * Faut-il supprimer le décorateur HtmlTag
   *
   * @return boolean
   */
  public function isRemoveAllDecoHtmlTag(){    
    return $this->_remove_all_deco_html_tag;
  }
  
  /**
   * Faut-il supprimer le décorateur Description
   *
   * @return boolean
   */
  public function isRemoveAllDecoDescription(){    
    return $this->_remove_all_deco_description;
  }
  
  /**
   * Faut-il supprimer le décorateur ViewHelper
   *
   * @return boolean
   */
  public function isRemoveAllDecoViewHelper(){    
    return $this->_remove_all_deco_view_helper;
  }
  
  /**
   * Faut-il supprimer le décorateur DtDdWrapper
   *
   * @return boolean
   */
  public function isRemoveAllDecoDtDdWrapper(){    
    return $this->_remove_all_deco_dt_dd_wrapper;
  }
  
  /**
   * Faut-il supprimer le décorateur Tooltip
   *
   * @return boolean
   */
  public function isRemoveAllDecoTooltip(){    
    return $this->_remove_all_deco_tooltip;
  }
  
  /**
   * Faut-il supprimer le décorateur File
   *
   * @return boolean
   */
  public function isRemoveAllDecoFile(){    
    return $this->_remove_all_deco_file;
  }
  
  /**
   * Faut-il supprimer le décorateur Image
   *
   * @return boolean
   */
  public function isRemoveAllDecoImage(){    
    return $this->_remove_all_deco_image;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur Label
   * 
   * @param boolean $remove_all_deco_label (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoLabel($remove_all_deco_label){
    $this->_remove_all_deco_label = (bool) $remove_all_deco_label;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur Errors
   * 
   * @param boolean $remove_all_deco_errors (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoErrors($remove_all_deco_errors){
    $this->_remove_all_deco_errors = (bool) $remove_all_deco_errors;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur HtmlTag
   * 
   * @param boolean $remove_all_deco_html_tag (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoHtmlTag($remove_all_deco_html_tag){
    $this->_remove_all_deco_html_tag = (bool) $remove_all_deco_html_tag;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur Description
   * 
   * @param boolean $remove_all_deco_description (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoDescription($remove_all_deco_description){
    $this->_remove_all_deco_description = (bool) $remove_all_deco_description;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur ViewHelper
   * 
   * @param boolean $remove_all_deco_view_helper (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoViewHelper($remove_all_deco_view_helper){
    $this->_remove_all_deco_view_helper = (bool) $remove_all_deco_view_helper;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur DtDdWrapper
   * 
   * @param boolean $remove_all_deco_dt_dd_wrapper (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoDtDdWrapper($remove_all_deco_dt_dd_wrapper){
    $this->_remove_all_deco_dt_dd_wrapper = (bool) $remove_all_deco_dt_dd_wrapper;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur Tooltip
   * 
   * @param boolean $remove_all_deco_tooltip (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoTooltip($remove_all_deco_tooltip){
    $this->_remove_all_deco_tooltip = (bool) $remove_all_deco_tooltip;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur File
   * 
   * @param boolean $remove_all_deco_file (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoFile($remove_all_deco_file){
    $this->_remove_all_deco_file = (bool) $remove_all_deco_file;
    return $this;
  }
  
  /**
   * Indiquer s'il faut supprimer le décorateur Image
   * 
   * @param boolean $remove_all_deco_image (true => on supprimme, false, => on garde)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setRemoveAllDecoImage($remove_all_deco_image){
    $this->_remove_all_deco_image = (bool) $remove_all_deco_image;
    return $this;
  }  

  /**
   * Récupérer le Tag par défaut du décorateur HtmlTag
   *
   * @return string
   */
  public function getDefaultTagHtmlTag(){
    return $this->_default_html_tag_tag;
  }

  /**
   * Changer le Tag par défaut du décorateur HtmlTag
   *
   * @param string $tag
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setDefaultTagHtmlTag($tag){
    $this->_default_html_tag_tag = (string) $tag;
    return $this;
  }

  /**
   * Récupérer le Tag par défaut du décorateur Label
   *
   * @return string
   */
  public function getDefaultTagLabel(){
    return $this->_default_tag_label;
  }

  /**
   * Changer le Tag par défaut du décorateur Label
   *
   * @param string $tag
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setDefaultTagLabel($tag){
    $this->_default_tag_label = (string) $tag;
    return $this;
  }
  
  /**
   * Initialise les Validateurs du formulaires
   *
   * @param array $validator
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setValidatorsDoydoy(array $validators){
    $this->clearValidatorsDoydoy();
    foreach($validators as $nom_validator => $validator){
      $this->addValidatorDoydoy($nom_validator, $validator);
    }
    return $this;
  }

  /**
   * Récupère la liste des validateurs
   *
   * @return null|array
   */
  public function getValidatorsDoydoy(){
    return $this->_liste_validators;
  }

  /**
   * enlève tous les validateurs
   *
   * @return Doydoy_Form_Tools_GereForm
   */
  public function clearValidatorsDoydoy(){
    $this->_liste_validators = array();
    return $this;
  }

  /**
   * Rajout d'un validateur
   *
   * @param string $name
   * @param Zend_Validate_Interface $validator
   * @return Doydoy_Form_Tools_GereForm
   */
  public function addValidatorDoydoy($name, $validator){
    if (!isset($this->_liste_validators))
      $this->_liste_validators = array();
    $this->_liste_validators[$name] = $validator;
    return $this;
  }
  /**
   * Récupère un validateur
   *
   * @param string $name
   * @return NULL|Zend_Validate_Interface
   */
  public function getValidator($name){
    if (isset($this->_liste_validators[$name]))
      return $this->_liste_validators[$name];
    return null;
  }
  
  /**
   * Initialise tous les filtres possibles du formulaires
   *
   * @param array $filter
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setFiltersDoydoy(array $filters){
    $this->clearFiltersDoydoy();
    foreach($filters as $nom_filter => $filter){
      $this->addFilterDoydoy($nom_filter, $filter);
    }
    return $this;
  }
  
  /**
   * Récupère la liste des filtres
   *
   * @return null|array
   */
  public function getFiltersDoydoy(){
    return $this->_liste_filters;
  }  
  
  /**
   * enlève tous les filtres
   *
   * @return Doydoy_Form_Tools_GereForm
   */
  public function clearFiltersDoydoy(){
    $this->_liste_filters = array();
    return $this;
  }
  
  /**
   * Rajout d'un filtre
   *
   * @param string $name
   * @param Zend_Filter_Interface|string $filter
   * @return Doydoy_Form_Tools_GereForm
   */
  public function addFilterDoydoy($name, $filter){
    if (!isset($this->_liste_filters))
      $this->_liste_filters = array();
    $this->_liste_filters[$name] = $filter;
    return $this;
  }
  
  /**
   * Récupère un filtre
   *
   * @param string $name
   * @return NULL|Zend_Validate_Interface
   */
  public function getFilter($name){
    if (isset($this->_liste_filters[$name]))
      return $this->_liste_filters[$name];
    return null;
  }
  
  /**
   * Initialise tous les filtres pour tous les éléments du formulaires
   *
   * @param array $filter tableau du type 'nom_filtre' => $filtre 
   *                      ($filtre étant une chaine de caractères comme 'StripTags' ou un filtre Zend_Filter_Interface)
   * @return Doydoy_Form_Tools_GereForm
   */
  public function setFiltersForAllElements(array $filters){
    $this->clearFiltersAllElements();
    foreach($filters as $nom_filter => $filter){
      $this->addFilterAllElements($nom_filter, $filter);
    }
    return $this;
  }
  
  /**
   * enlève tous les filtres pour tous les éléments
   *
   * @return Doydoy_Form_Tools_GereForm
   */
  public function clearFiltersAllElements(){
    $this->_liste_filters_all_elements = array();
    return $this;
  }
  
  /**
   * Rajout d'un filtre pour tous les éléments
   *
   * @param string $name
   * @param Zend_Filter_Interface|string $filter
   * @return Doydoy_Form_Tools_GereForm
   */
  public function addFilterAllElements($name, $filter){
    if (!isset($this->_liste_filters_all_elements))
      $this->_liste_filters_all_elements = array();
    $this->_liste_filters_all_elements[$name] = $filter;
    return $this;
  }

  /**
   * Définit si les erreurs sont retournées par les éléments ou par le formulaire
   *
   * @param boolean $errorGlobal
   */
  public function errorGlobal($errorGlobal = false){
    $this->_error_globale = (boolean) $errorGlobal;
    return $this;
  }
  
  /**
   * A partir d'une liste d'élement, on rempli un formulaire
   *
   * @return Doydoy_Form_Tools_GereForm
   */
  public function alimenteFormulaire(){
    
    if (is_null($this->_formulaire))
      throw new Doydoy_Form_Tools_Exception("Il n'y a pas de formulaire d'affecter (Utilser la méthode setFormulaire())");
    
    $this->_chercheListeParentsChilds($this->_elements_formulaire); 
    $this->_traiteElements($this->_elements_formulaire);
    // Une fois que tous les éléments sont créés, on peut les ordonner
    $this->_gereOrdreElements($this->_elements_formulaire);

    return $this;
  }  
   
  /**
   * Alimentation de la variable $_liste_parents_childs
   * Génération de la liste des pères avec leurs fils
   * @param array $elements_formulaire
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _chercheListeParentsChilds(array &$elements_formulaire){
    
    foreach($elements_formulaire as $id_element => $infos_element){
      if (isset($infos_element['parent'])){
        if(!isset(${$infos_element['parent']})){
          ${$infos_element['parent']} = array();
        }
        ${$infos_element['parent']}[] = $id_element;
        if (!isset($this->_liste_parents_childs))
          $this->_liste_parents_childs = array();
        $this->_liste_parents_childs[$infos_element['parent']] = ${$infos_element['parent']};
      }
    }
    $this->_liste_parents_childs_originale = $this->_liste_parents_childs; 
  
    return $this;
  }

  /**
   * Parcourt la liste des éléments et les traites en fonction de leurs conteneurs
   * 
   * L'algo est similaire à celui de _traiteElements sauf qu'on traite dans l'ordre de création 
   * alors que dans le _traiteElements on crée les élement et loqrsqu'ils sont créés, on peut créer les conteneurs
   * 
   * @param array $elements_formulaire
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _gereOrdreElements(array $elements_formulaire){
    
    $this->_initCptOrdre();
  
    foreach($elements_formulaire as $id_element => $infos_element){
      // Si l'élément n'existe plus, on ne le traite pas...
      if (!isset($elements_formulaire[$id_element]))
        continue;
  
      // Si cet élément n'est pas un père, on le traite tout de suite
      if (!($this->isParent($id_element))){
        // Si l'élément n'existe plus, on ne le traite pas...
        if (isset($elements_formulaire[$id_element])){
          $this->_traiteOrdreElement($id_element, $elements_formulaire);
        }
      }
      else{
        // C'est un père et on doit créer ses propres éléments
        $this->_traiteOrdreParent($elements_formulaire, $id_element);
      }
    }

    foreach($this->_liste_ordre_element as $liste_parent){
      foreach($liste_parent as $ordre => $id_element){
        $element = $this->_liste_elements_traites[$id_element];
        $element->setOrder($ordre);
      }
    }
    
    return $this;
  }

  /**
   * Réinitialise le compteur d'ordres
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _initCptOrdre(){
    $this->_cpt_ordre = array();
    return $this;
  }
  
  /**
   * retourne le nombre d'éléments d'un conteneur
   * @return integer
   */
  protected function _getCptOrdre($id_element , $id_parent = null){
    if (!isset($id_parent)){
      $id_parent = '';
    }
    $this->_cpt_ordre[$id_parent][] = $id_element;
    return (count($this->_cpt_ordre[$id_parent]) - 1);
  }
  
  /**
   * On crée l'ordre de chaque élement suivant son conteneur
   * Pour chaque conteneur, l'ordre repart à 0
   * 
   * @return integer
   */
  protected function _alimentOrdreElement($id_element, array &$elements_formulaire){
  
    $id_parent = '';
    if (isset($elements_formulaire[$id_element]['parent'])){
      $id_parent = $elements_formulaire[$id_element]['parent'];
    }
    $ordre = $this->_getCptOrdre($id_element, $id_parent);
    if(!isset($this->_liste_ordre_element[$id_parent]))
      $this->_liste_ordre_element[$id_parent] = array();
  
    if (isset($this->_ordre_element_desire[$id_element])){
      $ordre = $this->_ordre_element_desire[$id_element];
    }
    array_splice($this->_liste_ordre_element[$id_parent], $ordre, 0, $id_element);
  
    return $this;
  }
  
  /**
   * on traite l'élement pour l'ordonner
   * 
   * @param string $id_element
   * @param array $elements_formulaire
   * @param boolean $is_conteneur
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _traiteOrdreElement($id_element, array &$elements_formulaire){
    
    $this->_alimentOrdreElement($id_element, $elements_formulaire);
    
    // On l'enlève de la liste pour ne plus avoir à le traiter
    unset($elements_formulaire[$id_element]);
    return $this;
  }
  /**
   * Trouve de façon récursive, tous les éléments qui compose le père pour les ordonner
   * 
   * @param array $elements_formulaire
   * @param string $id_element_parent
   * @param array $element
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _traiteOrdreParent(array &$elements_formulaire, $id_element_parent){

    $this->_traiteOrdreElement($id_element_parent, $elements_formulaire);
    // On parcours les fils de ce père
    foreach($this->_liste_parents_childs[$id_element_parent] as $id_element_child){
      // Si le fils est aussi un père, on le traite comme tel
      if (($this->isParent($id_element_child))){
        $this->_traiteOrdreParent($elements_formulaire, $id_element_child);
      }
      else{
        // On génère l'élément s'il existe toujours
        if (isset($elements_formulaire[$id_element_child])){
          $this->_traiteOrdreElement($id_element_child, $elements_formulaire);          
        }
      }
    }
  
    return $this;
  }
   
  /**
   * Parcourt la liste des éléments et les traites en fonction de leurs conteneurs
   * @param array $elements_formulaire
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _traiteElements(array $elements_formulaire){
    
    foreach($elements_formulaire as $id_element => $infos_element){
      // Si l'élément n'existe plus, on ne le traite pas...
      if (!isset($elements_formulaire[$id_element]))
        continue;
      
      // Si cet élément n'est pas un père, on le traite tout de suite
      if (!($this->isParent($id_element))){
        // Si l'élément n'existe plus, on ne le traite pas...
        if (isset($elements_formulaire[$id_element])){
          $this->_traiteElement($id_element, $elements_formulaire);
        }
      }
      else{
        // C'est un père et on doit créer ses propres éléments
        $this->_traiteParent($elements_formulaire, $id_element);
      }
    }  
    return $this;
  }  
  
  /**
   * on génère l'élément suivant si c'est un conteneur ou non
   * 
   * @param string $id_element
   * @param array $elements_formulaire
   * @param boolean $is_conteneur
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _traiteElement($id_element, array &$elements_formulaire, $is_conteneur = false){

    if ($is_conteneur){
      $element = $this->_genereConteneur($id_element, $elements_formulaire);      
    } 
    else
      $element = $this->_genereElement($id_element, $elements_formulaire);
    

    if (isset($elements_formulaire[$id_element]['AppendPrepend'])){
      $element->addPrefixPath('Doydoy_Form_Decorator', 'Doydoy/Form/Decorator/', 'decorator')
              ->addDecorators(array(array('AppendPrepend',
                                          array('html' => $elements_formulaire[$id_element]['AppendPrepend'])
                                          )
                                    )
                              );
    }
        
    // On gère l'odre de l'élément s'i on veut qu'il soit différent de celui qui est généré
    // (Entre autre car on traite d'abord les fils et ensuite les père)
    if(isset($elements_formulaire[$id_element]['order'])){
      //$element->setOrder($elements_formulaire[$id_element]['order']);
      $this->_ordre_element_desire[$id_element] = $elements_formulaire[$id_element]['order']; 
    }

    // Indication que l'élément est traité
    if (!isset($this->_liste_elements_traites))
      $this->_liste_elements_traites = array();
    $this->_liste_elements_traites[$id_element] = $element;
    
    // On l'enlève de la liste pour ne plus avoir à le traiter
    unset($elements_formulaire[$id_element]);
    return $this;
  }
  
  /**
   * Trouve de façon récursive, tous les éléments qui compose le père pour les générer
   * 
   * @param array $elements_formulaire
   * @param string $id_element_parent
   * @param array $element
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _traiteParent(array &$elements_formulaire, $id_element_parent){

    // On parcours les fils de ce père
    foreach($this->_liste_parents_childs[$id_element_parent] as $id_element_child){
      // Si le fils est aussi un père, on le traite comme tel
      if (($this->isParent($id_element_child))){
        $this->_traiteParent($elements_formulaire, $id_element_child);
      }
      else{
        // On génère l'élément s'il existe toujours
        if (isset($elements_formulaire[$id_element_child])){
          $this->_traiteElement($id_element_child, $elements_formulaire);
        }
      }
    }
    // On génère le père en tant que conteneur avec le true
    $this->_traiteElement($id_element_parent, $elements_formulaire, true);      
  
    return $this;
  }
  
  /**
   * Indique si l'élément recherché est un père ou non
   *
   * @param unknown_type $id_element
   * @return boolean
   */
  public function isParent($id_element){
    if (!isset($this->_liste_parents_childs))
      return false;
    return array_key_exists($id_element, $this->_liste_parents_childs);
  }

  /**
   * Génération de l'élément à ajouter au formulaire
   *
   * @param unknown_type $id_element
   * @param array $elements_formulaire
   * @return Zend_Form_Element
   */
  protected function _genereElement($id_element, array &$elements_formulaire){
  
    $element_encours = null;
  
    $infos_element = $elements_formulaire[$id_element];
  
    //$element_encours = $element->initNewElement($id_element, $infos_element);
    $element_encours = $this->_initNewElement($id_element, $infos_element);
  
    if (is_null($element_encours))
      return $this;

    // label
    $this->_setLabelElement($id_element, $element_encours, $infos_element);
    
    // pour listes déroulantes et radio-set
    $this->_setValeursOptionsElement($id_element, $element_encours, $infos_element);
   
    // pour les Checkbox
    $this->_setCheckbox($element_encours, $infos_element);
    
    // title, maxlength, onclick, onchange, disabled...
    $this->_setAttributsElement($element_encours, $infos_element);
  
    // ajout des filtre Zend
    $this->_setFiltersElement($element_encours, $infos_element);
    
    // ajout des validateurs Zend
    $this->_setValidatorsElement($element_encours, $infos_element);

    // pour définir les valeurs par défaut (autres types de champ que listes déroulantes et radioset)
    $this->_setDefaultValueElement($id_element, $element_encours, $infos_element);
    
    if (!(isset($infos_element['default_deco']) && (true === $infos_element['default_deco']))){
      // Décore l'élément (met de texte devant ou derrière, met une div, un fieldset, ...
      $this->_setDecoratorsElement($element_encours, $infos_element);
    }

    // Ajout de l'élément au formulaire
    $this->_formulaire->addElement($element_encours);
    
    return $element_encours;
  }

  /**
   * Instancie le nouvel élément du formulaire
   * @param String $nom_element
   * @param array $element_du_tableau
   * @return Zend_Form_Element
   */
  protected function _initNewElement($nom_element, array &$element_du_tableau){
  
    if (isset($element_du_tableau['type_champ'])){
      switch($element_du_tableau['type_champ']){
        case 'Text':
          $type_champ = 'Zend_Form_Element_Text';
          break;
        case 'Select':
          $type_champ = 'Zend_Form_Element_Select';
          break;
        case 'Radio':
          $type_champ = 'Zend_Form_Element_Radio';
          break;
        case 'Submit':
          $type_champ = 'Zend_Form_Element_Submit';
          break;
        case 'Button':
          $type_champ = 'Zend_Form_Element_Button';
          break;
        case 'Reset':
          $type_champ = 'Zend_Form_Element_Reset';
          break;
        case 'Textarea':
          $type_champ = 'Zend_Form_Element_Textarea';
          break;
        case 'Checkbox':
          $type_champ = 'Zend_Form_Element_Checkbox';
          break;
        case 'Hidden':
          $type_champ = 'Zend_Form_Element_Hidden';
          // les champs hidden n'ont pas de conteneur ni de label
          $element_du_tableau['no_label'] = true;
          break;
        // Les conteneur ne doivent pas être géré comme des éléments  
        case 'Conteneur':
          return null;
          break;
        case 'HtmlBrut':
          $type_champ = 'Doydoy_Form_Element_HtmlBrut';
          // les champs HtmlBrut n'ont pas besoin de conteneur ni de label
          // Sinon, on leur met dedans
          $element_du_tableau['no_html_tag'] = true;
          $element_du_tableau['no_label'] = true;
          // Pas de filtre non plus
          $element_du_tableau['no_filtre'] = true;          
          break;
        case 'File':
          $type_champ = 'Zend_Form_Element_File';
          break;
        case 'Hash':
          $type_champ = 'Zend_Form_Element_Hash';
          break;
        case 'Image':
          $type_champ = 'Zend_Form_Element_Image';
          break;
        case 'Multi':
          $type_champ = 'Zend_Form_Element_Multi';
          break;
        case 'MultiCheckbox':
          $type_champ = 'Zend_Form_Element_MultiCheckbox';
          break;
        case 'Multiselect':
          $type_champ = 'Zend_Form_Element_Multiselect';
          break;
        case 'Password':
          $type_champ = 'Zend_Form_Element_Password';
          break;
        case 'Xhtml':
          $type_champ = 'Zend_Form_Element_Xhtml';
          break;
        case 'Element':
          $type_champ = 'Zend_Form_Element';
          break;                         
      }
    }
    else{
      $type_champ = 'Zend_Form_Element_Text';
    }
    
    // Nom de l'objet
    ${$nom_element} = new $type_champ($nom_element);
        
    return ${$nom_element};
  }
  
  /**
   * 
   * Enter description here ...
   *
   * @param string $id_element
   * @param array $elements_formulaire
   * @return Ambigous <Zend_Form_DisplayGroup, multitype:>
   */
  protected function _genereConteneur($id_element, array &$elements_formulaire){

    // Création d'une variable $div_id_truc = ...
    // ou $field_id_chose = ...
    $conteneur =& ${$elements_formulaire[$id_element]['type'] . '_' . $id_element};

    $liste_contenus = array();
    if (isset($this->_liste_elements_traites)){
      foreach($this->_liste_parents_childs_originale[$id_element] as $id_element_contenu){
        // On teste l'existance d'un contenu pour des balise div sans rien dedans par exemple
        if (isset($this->_liste_elements_traites[$id_element_contenu]))
          $liste_contenus[] = $this->_liste_elements_traites[$id_element_contenu]; 
      }
    }
    
    $conteneur = $this->_formulaire->createGroupe($elements_formulaire[$id_element]['type'] . '_' . $id_element,
                                                  $elements_formulaire[$id_element]['type'],
                                                  $liste_contenus,
                                                  (isset($elements_formulaire[$id_element]['attribut']) ? $elements_formulaire[$id_element]['attribut'] : null));
    
    // Si c'est un Fieldset, on génère la légend (si besoin)
    if (isset($elements_formulaire[$id_element]['legend']) && is_array($elements_formulaire[$id_element]['legend'])){
      
      if (isset($elements_formulaire[$id_element]['legend']['legend_string']))
        $conteneur->setLegend($elements_formulaire[$id_element]['legend']['legend_string']);
      
      if ( isset($elements_formulaire[$id_element]['legend']['legend_id'])
        || isset($elements_formulaire[$id_element]['legend']['legend_class'])){
        // Rajout de l'id de la légende au décorateur
        $conteneur_deco = $conteneur->getDecorator('Conteneur');
        if (false === $conteneur_deco)
          $conteneur_deco = new Doydoy_Form_Decorator_Conteneur();

        if (isset($elements_formulaire[$id_element]['legend']['legend_id']))
          $conteneur_deco->setLegendId($elements_formulaire[$id_element]['legend']['legend_id']);
        if (isset($elements_formulaire[$id_element]['legend']['legend_class'])){
          $conteneur_deco->setLegendClass($elements_formulaire[$id_element]['legend']['legend_class']);
        }
        $conteneur->addDecorators(array('FormElements', array($conteneur_deco)));
        
        unset($conteneur_deco);
      }
    }
    
    return $conteneur;
  }
  
  /**
   * Récupère une valeur à partir d'une expression.
   *
   * @param Zend_Form_Element $element_encours
   * @param string $value
   * @throws Doydoy_Form_Tools_Exception
   * @return unknown
   */
  protected function _getCacheValue(&$element_encours, $value){
    $eval = @eval('$cache_value = ' . $value . ';');
    if (false === $eval){
      if ($element_encours instanceof Zend_Form_Element)
        $name = $element_encours->getName() . ' : ';
      else 
        $name = ''; 
      throw new Doydoy_Form_Tools_Exception($name . 'Les valeurs gérées en cache doivent être une expression en chaîne de caractère');
    }
    return $cache_value;
  }

  /**
   * Met un Label à un élément du formulaire
   *
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setLabelElement($id_element, &$element_encours, array &$element_du_tableau){
    // label 
    // On ne met en cache que ce qu'on veut (par exemple, si les données viennent de la bd, alors on ne les met pas en cache
    // Les valeur en cache sont prioritaires
    if (isset($element_du_tableau['label_no_cache'])){
      if (isset($this->_cache)){  // défini dans Doydoy_Form_FormAbstract
        // pour listes déroulantes et radio-set : Rempli les options
        $this->_liste_label_sans_cache[$id_element] = $element_encours;
      }
      else
        $this->_setLabelElementCache($element_encours, $infos_element);
    }
    else{
      if(isset($element_du_tableau['label'])){
        $element_encours->setLabel($element_du_tableau['label']);
      }
    }
    
    return $this;
  }
  
  /**
   * Met un Label à un élément du formulaire pour les valeurs à ne pas mettre en cache
   *
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */
  /* @todo: vérifier que ça marche pour les label */
  protected function _setLabelElementCache(&$element_encours, array &$element_du_tableau){
    // pour les Label dont les valeurs ne sont pas mise en caches
    if (isset($element_du_tableau['label_no_cache'])) {
      $value = $this->_getCacheValue($element_encours, $element_du_tableau['label_no_cache']);
      $element_encours->setLabel($value);      
    }
    
    return $this;
  }
  
  /**
   * Gère l'alimentation des radio-set et des combo-box
   * 
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @example : bouton radio "Non" coché par défaut 
                'type_champ' 				=> 'Radio',
                'choix'		 					=> array('1' => 'Oui', '0' => 'Non'),
                'valeur_par_defaut' => '0',
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setValeursOptionsElement($id_element, &$element_encours, array &$element_du_tableau){    
    // On ne met en cache que ce qu'on veut (par exemple, si les données viennent de la bd, alors on ne les met pas en cache
    // Les valeur en cache sont prioritaire
    if (isset($element_du_tableau['choix_no_cache'])){
      if (isset($this->_cache)){  // défini dans Doydoy_Form_FormAbstract
        // pour listes déroulantes et radio-set : Rempli les options
        $this->_liste_valeur_option_sans_cache[$id_element] = $element_encours;
      }
      else
        $this->_setValeursOptionsElementCache($element_encours, $infos_element);
    }
    else{
      if (isset($element_du_tableau['choix'])) {
        $element_encours->setMultiOptions($element_du_tableau['choix']); 
      }
    }
    
    return $this;
  }
  
  /**
   * Gère l'alimentation des radio-set et des combo-box pour les valeurs à ne pas mettre en cache
   * 
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @example : bouton radio "Non" coché par défaut 
                'type_champ' 				=> 'Radio',
                'choix'		 					=> array('1' => 'Oui', '0' => 'Non'),
                'valeur_par_defaut' => '0',
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setValeursOptionsElementCache(&$element_encours, array &$element_du_tableau){
    // pour listes déroulantes et radio-set
    if (isset($element_du_tableau['choix_no_cache'])) {
      $value = $this->_getCacheValue($element_encours, $element_du_tableau['choix_no_cache']);
      $element_encours->setMultiOptions($value);      
    }
    return $this;
  }
  
  /**
   * Définit la valeur par défaut
   * 
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setDefaultValueElement($id_element, &$element_encours, array &$element_du_tableau){
    // On ne met en cache que ce qu'on veut (par exemple, si les données viennent de la bd, alors on ne les met pas en cache
    if (isset($element_du_tableau['valeur_par_defaut_no_cache'])){
      if (isset($this->_cache)){  // défini dans Doydoy_Form_FormAbstract
        // pour définir les valeurs par défaut (autres types de champ que listes déroulantes et radioset)
        $this->_liste_valeur_defaut_sans_cache[$id_element] = $element_encours;
      }
      else
        $this->_setDefaultValueElementCache($element_encours, $infos_element);
    }
    else{
      // pour définir les valeurs par défaut (autres types de champ que listes déroulantes et radioset)
      if (isset($element_du_tableau['valeur_par_defaut'])){
        $element_encours->setValue($element_du_tableau['valeur_par_defaut']);
      }
    }
    
    return $this;
  }
  
  /**
   * Définit la valeur par défaut pour les valeurs à ne pas mettre en cache
   * 
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setDefaultValueElementCache(&$element_encours, array &$element_du_tableau){
    // pour définir les valeurs par défaut (autres types de champ que listes déroulantes et radioset)
    if (isset($element_du_tableau['valeur_par_defaut_no_cache'])){
      $value = $this->_getCacheValue($element_encours, $element_du_tableau['valeur_par_defaut_no_cache']);
      $element_encours->setValue($value);
    }
    return $this;
  }

  /**
   * Gestion spécifique des Checkbox
   *
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setCheckbox(&$element_encours, array &$element_du_tableau){
    // pour définir les valeurs par défaut (autres types de champ que listes déroulantes et radioset)
    if (isset($element_du_tableau['checkbox_value'])){
      if (isset($element_du_tableau['checkbox_value']['checked']))
        $element_encours->setCheckedValue($element_du_tableau['checkbox_value']['checked']);
      if (isset($element_du_tableau['checkbox_value']['unchecked']))
        $element_encours->setUncheckedValue($element_du_tableau['checkbox_value']['unchecked']);
    }
    if (isset($element_du_tableau['checked']))
        $element_encours->setChecked($element_du_tableau['checked']);

    return $this;
  }
      
  /**
   * Alimente les attributs du champ ex.: title, maxlength, onclick, onchange, disabled...
   * 
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   */
  protected function _setAttributsElement(&$element_encours, array &$element_du_tableau){
    if(isset($element_du_tableau['attribut'])) {
      foreach($element_du_tableau['attribut'] as $cle => $valeur){
        $element_encours->setAttrib($cle, $valeur);
      }
    }
    return $this;
  }
  
  /**
   * Alimente les Validateurs
   * Gère aussi l'option Obligatoire
   * 
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setValidatorsElement(&$element_encours, array &$element_du_tableau){
    // ajout des validateurs Zend
    if(isset($element_du_tableau['validateur']) && !empty($element_du_tableau['validateur'])) {
      // Soit on passe une liste de validateurs
      if (is_array($element_du_tableau['validateur'])){
        foreach($element_du_tableau['validateur'] as $nom_validateur){
          $validator = $this->getValidator($nom_validateur);
          if (isset($validator)){
            $element_encours->addValidator($validator);
          }
          else{
            // pour des validateur reconnu tel que 'alnum'
            $element_encours->addValidator($nom_validateur);
          }
        }
      }
      // Soit on passe un seul validateur
      else{
        $validator = $this->getValidator($element_du_tableau['validateur']);
        if (isset($validator)){
          $element_encours->addValidator($validator);
        }
        else
          // pour des validateur reconnu tel que 'alnum'
          $element_encours->addValidator($element_du_tableau['validateur']);
      }
    }
    if(isset($element_du_tableau['required'])){
      $element_encours->setRequired((boolean) $element_du_tableau['required']);
    }
    return $this;
  }
  
  /**
   * Alimente les Filtres
   * Gère aussi l'option Obligatoire
   * 
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _setFiltersElement(&$element_encours, array &$element_du_tableau){
    if (isset($element_du_tableau['no_filtre']) && (true === $element_du_tableau['no_filtre'])){
      $element_encours->clearFilters();
      return $this;
    }
    // ajout des filtres Zend
    if(isset($element_du_tableau['filtre']) && !empty($element_du_tableau['filtre'])) {
      // Soit on passe une liste de validateurs
      if (is_array($element_du_tableau['filtre'])){
        foreach($element_du_tableau['filtre'] as $nom_filtre){
          $filter = $this->getFilter($nom_filtre);
          if (isset($filter))
            $element_encours->addFilter($filter);
          else
            // pour des validateur reconnu tel que 'StripTags'
            $element_encours->addFilter($nom_filtre);
        }
      }
      // Soit on passe un seul validateur
      else{
        $filter = $this->getFilter($element_du_tableau['filtre']);
        if (isset($filter))
          $element_encours->addFilter($filter);
        else
          // pour des validateur reconnu tel que 'StripTags'
          $element_encours->addFilter($element_du_tableau['filtre']);
      }
    }
    else{
      if (isset($this->_liste_filters_all_elements) && !empty($this->_liste_filters_all_elements)){
        foreach($this->_liste_filters_all_elements as $nom_filtre => $filtre){
          $filter = $this->getFilter($nom_filtre);
          if (isset($filter))
            $element_encours->addFilter($filter);
          else
            // pour des validateur reconnu tel que 'StripTags'
            $element_encours->addFilter($nom_filtre);
        }
      }
    }
    return $this;
  }

  /**
   * Génère les décorateurs de l'élément en cours
   *
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @return Doydoy_Form_Tools_GereForm
   */    
  protected function _setDecoratorsElement(&$element_encours, array &$element_du_tableau){
    /**********************************DECORATEURS**********************************/    
    if ($this->isRemoveAllDecoLabel())
      $element_encours->removeDecorator('Label');
    if ($this->isRemoveAllDecoErrors())
      $element_encours->removeDecorator('Errors');
    if ($this->isRemoveAllDecoHtmlTag())
      $element_encours->removeDecorator('HtmlTag');
    if ($this->isRemoveAllDecoDescription())
      $element_encours->removeDecorator('Description');
    if ($this->isRemoveAllDecoViewHelper())
      $element_encours->removeDecorator('ViewHelper');
    if ($this->isRemoveAllDecoDtDdWrapper())
      $element_encours->removeDecorator('DtDdWrapper');
    if ($this->isRemoveAllDecoTooltip())
      $element_encours->removeDecorator('Tooltip');
    if ($this->isRemoveAllDecoFile())
      $element_encours->removeDecorator('File');
    if ($this->isRemoveAllDecoImage())
      $element_encours->removeDecorator('Image');
    
    /*****************************/
    if (isset($element_du_tableau['no_decorateur']) && (true === $element_du_tableau['no_decorateur'])) {
      $element_encours->clearDecorators();
      return $this;
    }
    
    if (isset($element_du_tableau['only_element']) && (true === $element_du_tableau['only_element'])) {
      $element_encours->removeDecorator('Errors');
      $element_encours->removeDecorator('HtmlTag');
      $element_encours->removeDecorator('DtDdWrapper');
      $element_encours->removeDecorator('Description');
      $element_encours->removeDecorator('Label');
      return $this;
    }

    // Gestion du déco DtDdWrapper qui doit être remplacé par
    // le décorateur HtmlTag pour des besoins spécifiques
    $this->_deco_dt_dd_wrapper_traite = false;
    $deco_dt_dd_wrapper = $element_encours->getDecorator('DtDdWrapper');
    
    
    $this->_gereDecoLabel($element_encours, $element_du_tableau, $deco_dt_dd_wrapper);

    if(isset($element_du_tableau['only_label']) && ($element_du_tableau['only_label'])) {      
      // label seul
      $element_encours->removeDecorator('Errors');
      $element_encours->removeDecorator('HtmlTag');
      $element_encours->removeDecorator('Description');
      $element_encours->removeDecorator('ViewHelper');
      return $this;
    }
     
    $this->_gereDecoHtmlTag($element_encours, $element_du_tableau, $deco_dt_dd_wrapper);
          
    return $this;
  }

  /**
   * Gestion des décorateurs concernant les Label
   *
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @param false|Zend_Form_Decorator_Abstract| $deco_dt_dd_wrapper
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _gereDecoLabel(&$element_encours, array &$element_du_tableau, &$deco_dt_dd_wrapper){
    // Si pas de label
    if(isset($element_du_tableau['no_label']) && (true === $element_du_tableau['no_label'])){
      $element_encours->removeDecorator('Label');
      if (false !== $deco_dt_dd_wrapper && $deco_dt_dd_wrapper instanceof Zend_Form_Decorator_DtDdWrapper){
        $element_encours->removeDecorator('DtDdWrapper');
        $element_encours->addDecorator('HtmlTag');
      }
    }
    else{
      // Rajout de notre propre décorateur de Label (pour gérer label_deco_id)
      $element_encours->addPrefixPath('Doydoy_Form_Decorator', 'Doydoy/Form/Decorator/', 'decorator')
                      ->addDecorator('Label');
      
      // Y a-t-il des traitement à faire sur les Label?
      $class_defaut_label = $this->getDefaultLabelClassCSS();
      if(isset($element_du_tableau['label'])
      || isset($element_du_tableau['label_deco_tag'])
      || isset($element_du_tableau['label_deco_css'])
      || isset($element_du_tableau['label_deco_id'])
      || isset($element_du_tableau['only_label']) // juste le label donc si on a une décorateur DtDdWrapper, il faut le modifier
      || isset($element_du_tableau['label_disable_for'])
      || isset($element_du_tableau['label_attribut'])
      || !empty($class_defaut_label)
      ){
        // S'il y a un traitement particulier sur les Labels
        // et qu'on a par défaut un déco DtDdWrapper
        // alors on le remplace par un déco Label et un Déco HtmlTag
        if (false !== $deco_dt_dd_wrapper && $deco_dt_dd_wrapper instanceof Zend_Form_Decorator_DtDdWrapper){
          
          $deco_label = $this->_gereLabelDtDdWrapper($element_encours, $element_du_tableau, $deco_dt_dd_wrapper);
          
          if (!isset($element_du_tableau['only_label']) || (true !== $element_du_tableau['only_label'])){
            // S'il y avait un décorateur DtDdWrapper c'est qu'il y avait une balise dt et une dd
            // Donc rajout du décorateur HtmlTag pour gérer la balise dd
            if (!($element_encours->getDecorator('HtmlTag')))
              $element_encours->addDecorator('HtmlTag');
          }
          // Suppression du décorateur DtDdWrapper
          $element_encours->removeDecorator('DtDdWrapper');
          
          // Indique pour la suite du programme s'il y a déjà eu une traitement dessu
          $this->_deco_dt_dd_wrapper_traite = true;
          
        }
        else{
          $deco_label = $element_encours->getDecorator('Label');
          if(!$deco_label){
            // Si le décorateur n'existe pas, on je rajoute car on en a besoin
            $element_encours->addDecorator('Label');
            $deco_label = $element_encours->getDecorator('Label');
          }          
        }
        
        // Remplacement de l'id
        if(isset($element_du_tableau['label_deco_id'])){
          $deco_label->setLabelId($element_du_tableau['label_deco_id']);
        }
        elseif (false !== $deco_dt_dd_wrapper && $deco_dt_dd_wrapper instanceof Zend_Form_Decorator_DtDdWrapper){
          $deco_label->setId($element_encours->getName() . '-element');
        }
        
        // Remplacement du tag par défaut (dt)
        if(isset($element_du_tableau['label_deco_tag'])){
          $deco_label->setOption('tag', $element_du_tableau['label_deco_tag']);    
        }
        else {         
          $tag = $this->getDefaultTagLabel();          
          $deco_label->setOption('tag', $tag);
        }

        // Rajout de css pour le décorateur Label
        if(!(isset($element_du_tableau['label_deco_no_css']) && (true === $element_du_tableau['label_deco_no_css']))) {
          // ajout de la classe css pour chaque div de label
          if(isset($element_du_tableau['label_deco_css'])) {
            $css_commun = '';
            if(!(isset($element_du_tableau['label_deco_no_css_commun']) && (true === $element_du_tableau['label_deco_no_css_commun']))) {
              $css_commun = $this->getDefaultCommuneLabelClassCSS();
            }
            $deco_label->setTagClass($element_du_tableau['label_deco_css'] . $css_commun);
          }
          // classe css par défaut
          else {          
            if (!empty($class_defaut_label))
              $deco_label->setTagClass($class_defaut_label);
          }
        }
        else{
          $deco_label->removeOption('class');
          if (!is_null($deco_label->getOption('tagClass')))
            $deco_label->removeOption('tagClass');
        }
        
        // Désactivation de l'attribut 'for' du Label
        if(isset($element_du_tableau['label_disable_for'])){
          $deco_label->setOption('disableFor', true);
        }
        if(isset($element_du_tableau['label_attribut'])){
          foreach($element_du_tableau['label_attribut'] as $attribut_nom => $attribut_val){
            if ('for' == $attribut_nom){
              $deco_label->setOption('disableFor', false);
            }
            if ('id' == $attribut_nom)
              $deco_label->setOption('id_tag_label', $attribut_val);
            else
              $deco_label->setOption($attribut_nom, $attribut_val);
          }
        }
      }
    }
    return $this;
  } 

  /**
   * Gestion des décorateurs concernant les HtmlTag
   *
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @param false|Zend_Form_Decorator_Abstract| $deco_dt_dd_wrapper
   * @return Doydoy_Form_Tools_GereForm
   */
  protected function _gereDecoHtmlTag(&$element_encours, array &$element_du_tableau, &$deco_dt_dd_wrapper){

    // On ne veut pas de décorateur entourant l'élément (comme le HtmlTag)
    if(isset($element_du_tableau['no_html_tag']) && (true === $element_du_tableau['no_html_tag'])) {

      // Si on a un décorateur DtDdWrapper, on ne veut pas la balise dd, mais on va quand même garder la balise dt
      if (false !== $deco_dt_dd_wrapper && $deco_dt_dd_wrapper instanceof Zend_Form_Decorator_DtDdWrapper){
        // Si on pas pas encore traité le décorateur DtDdWrapper
        // c'est qu'on est pas passé dans la gestion des décorateur des Label
        // On un DtDdWrapper possède une balise dd qu'il faut prendre en compte
        if (!$this->_deco_dt_dd_wrapper_traite){
          $this->_gereLabelDtDdWrapper($element_encours, $element_du_tableau, $deco_dt_dd_wrapper);
        }
        $element_encours->removeDecorator('DtDdWrapper');
        $this->_deco_dt_dd_wrapper_traite = true;
      } //if ($deco_dt_dd_wrapper){ ...
      
      $element_encours->removeDecorator('HtmlTag');
    }
    else
    {
      // Y a-t-il des traitement à faire sur les conteneur (HtmlTag)
      $tag_defaut_conteneur = $this->getDefaultTagHtmlTag();
      $class_defaut_conteneur = $this->getDefaultClassCSS();
      $class_defaut_commune_conteneur = $this->getDefaultCommuneClassCSS();
      if(isset($element_du_tableau['html_tag_tag'])
          || isset($element_du_tableau['html_tag_id'])
          || isset($element_du_tableau['no_id_html_tag'])
          || isset($element_du_tableau['html_tag_css'])
          || !empty($class_defaut_conteneur)
          || !empty($tag_defaut_conteneur)
          || !empty($class_defaut_commune_conteneur)
      ){
    
        // S'il y a un traitement particulier sur les HtmlTag
        // et qu'on a par défaut un déco DtDdWrapper
        // alors on le remplace par un déco Label et un Déco HtmlTag
        if (false !== $deco_dt_dd_wrapper && $deco_dt_dd_wrapper instanceof Zend_Form_Decorator_DtDdWrapper){
          // Si on pas pas encore traité le décorateur DtDdWrapper
          // c'est qu'on est pas passé dans la gestion des décorateur des Label
          // On un DtDdWrapper possède une balise dd qu'il faut prendre en compte
          if (!$this->_deco_dt_dd_wrapper_traite){
            $this->_gereLabelDtDdWrapper($element_encours, $element_du_tableau, $deco_dt_dd_wrapper);
          }
          $element_encours->removeDecorator('DtDdWrapper');
          $this->_deco_dt_dd_wrapper_traite = true;
        } //if ($deco_dt_dd_wrapper){ ...
         
        $deco_html_tag = $element_encours->getDecorator('HtmlTag');
        if (!$deco_html_tag){
          // Si le décorateur n'existe pas, on je rajoute car on en a besoin
          $element_encours->addDecorator('HtmlTag');
          $deco_html_tag = $element_encours->getDecorator('HtmlTag');
        }
    
        // Si on veut changer les tag du conteneur de l'input par défaut
        if(isset($element_du_tableau['html_tag_tag'])){
          $deco_html_tag->setOption('tag', $element_du_tableau['html_tag_tag']);
        }
        else {
          $deco_html_tag->setOptions(array('tag' => $tag_defaut_conteneur,
                                           'id'  => $tag_defaut_conteneur . '_' . $element_encours->getId())
                                     );
        }
    
        // On veut un id spécifique pour le conteneur de l'élément
        if(isset($element_du_tableau['html_tag_id'])){
          $deco_html_tag->setOption('id', $element_du_tableau['html_tag_id']);
        }
        
        // On ne veut pas d'id pour le conteneur de l'élément
        if(isset($element_du_tableau['no_id_html_tag'])){
          $deco_html_tag->removeOption('id');
        }

        // Rajout de css pour le décorateur Label
        if(!(isset($element_du_tableau['html_tag_no_css']) && (true === $element_du_tableau['html_tag_no_css']))) {
          // ajout de la classe css pour chaque div de champ (input, select...)
          if(isset($element_du_tableau['html_tag_css'])) {
            $css_commun = '';
            if(!(isset($element_du_tableau['html_tag_no_css']) && (true === $element_du_tableau['html_tag_no_css']))) {
              $css_commun = $class_defaut_commune_conteneur;
            }
            $deco_html_tag->setOption('class', $element_du_tableau['html_tag_css'] . $css_commun);
          }
          // classe css par défaut
          else{
            if (!empty($class_defaut_conteneur))
              $deco_html_tag->setOption('class', $class_defaut_conteneur);
            else
              $deco_html_tag->removeOption('class');
          }
        }
        else
          $deco_html_tag->removeOption('class');
      }
    }
    return $this;
  }
  
  /**
   * Traite le label d'un décorateur DtDdWrapper pour le transformer en décorateur Label
   *
   * @param Zend_Form_Element $element_encours
   * @param array $element_du_tableau
   * @param false|Zend_Form_Decorator_Abstract| $deco_dt_dd_wrapper
   * @return false|Zend_Form_Decorator_Label
   */
  protected function _gereLabelDtDdWrapper(&$element_encours, array &$element_du_tableau, &$deco_dt_dd_wrapper){

    $deco_label = false;
    if(isset($element_du_tableau['no_label']) && (true === $element_du_tableau['no_label'])){
      return $deco_label;
    }
    if (false !== $deco_dt_dd_wrapper && $deco_dt_dd_wrapper instanceof Zend_Form_Decorator_DtDdWrapper){
      /* Decorateur DtDdWrapper (cf. Zend_Form_Decorator_DtDdWrapper) :
       * 
       *  $elementName = $this->getElement()->getName();
       *
       *  $dtLabel = $this->getOption('dtLabel');
       *  if( null === $dtLabel ) {
       *    $dtLabel = '&#160;';
       *  }
       *
       * return '<dt id="' . $elementName . '-label">' . $dtLabel . '</dt>' .
       *        '<dd id="' . $elementName . '-element">' . $content . '</dd>';
       */
      // Recherche du Label
      if(isset($element_du_tableau['label'])){
        $dtLabel = $element_du_tableau['label'];
      }
      else{
        $dtLabel = $deco_dt_dd_wrapper->getOption('dtLabel');
        if( null === $dtLabel ) {
          $dtLabel = '&#160;';
        }
      }
      
      // Rajout du décorateur Label
      $deco_label = $element_encours->getDecorator('Label');
      if(!$deco_label){
        $element_encours->addDecorator('Label');
        $deco_label = $element_encours->getDecorator('Label');
      }
      // Affectation du Label
      $element_encours->setLabel($dtLabel);
    }
    return $deco_label;
  }
  
  /**
   * Alimentation des valeurs qui ne doivent pas être mise en cache
   * @return Doydoy_Form_Tools_GereForm
   */
  public function valeurNoCache(){
    if (isset($this->_liste_valeur_option_sans_cache)){
      foreach($this->_liste_valeur_option_sans_cache as $id_element => $element){
        $this->_setValeursOptionsElementCache($element, $this->_elements_formulaire[$id_element]);
      }
    }
    if (isset($this->_liste_valeur_defaut_sans_cache)){
      foreach($this->_liste_valeur_defaut_sans_cache as $id_element => $element){
        $this->_setDefaultValueElementCache($element, $this->_elements_formulaire[$id_element]);
      }
    }    
    if (isset($this->_liste_label_sans_cache)){
      foreach($this->_liste_label_sans_cache as $id_element => $element){
        $this->_setLabelElementCache($element, $this->_elements_formulaire[$id_element]);
      }
    }    
        
    return $this;
  }  
}
