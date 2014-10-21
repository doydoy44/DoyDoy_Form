<?php
/**
 * Doydoy
 *
 * @brief	CacheForme permet d'appeler un formulaire qu'il soit en cache ou non
 *        Classe Static (ne peut être instanciée)
 * 		
 * @category   Doydoy
 * @package    Doydoy/Form
 * @subpackage Tools
 *
 * @author    Doydoy
 * @version   1.0
 */


class Doydoy_Form_Tools_CacheForm{
  
  /**
   * Liste des formulaires déjà chargés
   * @var array
   */
  protected static $_formulaires_charges = array();
  
  /**
   * Cache de l'application
   * @var Zend_Cache
   */
  public static $cache = null;
  
  /**
   * Pas d'instanciation possible
   */
  private function __construct(){
  }
  
  /**
   * Pas de dupplication de la classe possible
   */
  private function __clone(){
  }
  
  /**
   * Demande de chargement d'un formulaire
   *
   * @param string $class_formulaire_voulu
   * @return Zend_Form:
   */
  public static function getFormulaire($class_formulaire_voulu)
  {
    if (!class_exists($class_formulaire_voulu))
      throw new Doydoy_Form_Tools_Exception("Il n'existe pas de formulaire à ce nom :" . $class_formulaire_voulu);

//     ------------------------------------------------------------------------------------------
//     Plus long de tout mettre en cache que de mettre chaque formulaire dans un cache spécifique
//     ------------------------------------------------------------------------------------------
//     if (!isset(self::$cache)){
//       //self::$cache = (Zend_Registry::isRegistered('caches') ? Zend_Registry::get('caches') : null);
//       self::$cache = Application_ToolsDoydoy_ChargeTools::getInstance()->getCachesManager()->getCache('CacheFormulaire');    
//     }
//     if (empty(self::$_formulaires_charges)){
//       if (isset(self::$cache)){
//         if ((self::$_formulaires_charges = self::$cache->load('Liste_formulaires_dispo')) === false ) {
//           self::$_formulaires_charges = array();
//         }
//       }
//     }
    // Si le formulaire n'a pas encore été chargé, on le crée
    if(!array_key_exists($class_formulaire_voulu, self::$_formulaires_charges))
      self::$_formulaires_charges[$class_formulaire_voulu] = self::_recupFormulaire($class_formulaire_voulu);

    // Récupération des valeurs qui ne doivent pas être mise en cache
    if (self::$_formulaires_charges[$class_formulaire_voulu] instanceof Doydoy_Form_Tools_GereForm)
      self::$_formulaires_charges[$class_formulaire_voulu]->valeurNoCache();

//     ------------------------------------------------------------------------------------------
//     Plus long de tout mettre en cache que de mettre chaque formulaire dans un cache spécifique
//     ------------------------------------------------------------------------------------------
//     self::$cache->save(self::$_formulaires_charges,
//                        'Liste_formulaires_dispo',
//                        array('formulaire'));
      
    return self::$_formulaires_charges[$class_formulaire_voulu];
  }
  
  /**
   * Création du formulaire
   * Si est en cache, on va le chercher sinon, on le crée
   *
   * @param string $class_formulaire
   * @return Zend_Form
   */
  private static function _recupFormulaire($class_formulaire){

    if (!isset(self::$cache)){
      self::$cache = Doydoy_Tools_ChargeTools::getInstance()->getCachesManager()->getCache('CacheFormulaire');
    }
    if (isset(self::$cache)){      
      $id_cahe = $class_formulaire;
      if ( ($form = self::$cache->load($id_cahe)) === false ) {
        $form = new $class_formulaire();
        self::$cache->save($form, $id_cahe, array('formulaire')); // Le tableau permettra de supprimer soit tous les formulaire soit seulement celui du id
      }
    }
    else{
      $form = new $class_formulaire();
    }
		
    return $form;
  }

}