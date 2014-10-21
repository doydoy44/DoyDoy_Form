<?php
/**
 * DoyDoy
 *
 * @brief	Boite à outils concernant la gestion des caches
 * 
 * 				Cette classe peut être instanciée par DoyDoy_Tools_ChargeTools (Singleton)
 * 				
 * @category   DoyDoy
 * @package    DoyDoy/Tools
 *
 * @author    DoyDoy
 * @version   1.0
 * 
 */

class Doydoy_Tools_CachesManager
{ 
	/**************************************************************
	 * Singleton
	 **************************************************************/
  /**
   * Objet contenant l'instance de la Classe
   * 
   * @var DoyDoy_Xdbc_Xdbc 
   */
	protected static $_instance = null;
	
  /**
   * Interdit le clonage de la classe
   */
	private function __clone(){		
	}
    
  /**
   * Récupère l'instance de la classe ou la crée
   */
  public static function getInstance()
  {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/************************************************/
	protected $_cache_manager = null;

	public function setCache($cache_name, Zend_Cache_Core $cache){
	  if (!isset($this->_cache_manager))
	    $this->_cache_manager = new Zend_Cache_Manager;
	
	  $this->_cache_manager->setCache($cache_name, $cache);
	}
	
	public function getCache($cache_name){
	  if (!isset($this->_cache_manager))
	    return null;
	  if (!$this->_cache_manager->hasCache($cache_name))
	    return null;
	  else 
	    return $this->_cache_manager->getCache($cache_name);
	}
	
}
