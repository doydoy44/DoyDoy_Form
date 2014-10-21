<?php
/**
 * DoyDoy
 *
 * @brief	Singleton permettant de ne charger qu'une seule fois les boites à outils 
 * 				
 * @category   DoyDoy
 * @package    DoyDoy/Tools
 *
 * @author    DoyDoy
 * @version   1.0
 * 
 */

class Doydoy_Tools_ChargeTools
{ 
	/** 
	 *************************************************************
	 * Singleton
	 *************************************************************
	 */
	protected static $_instance = null;

	private function __construct(){		
	}
	private function __clone(){		
	}
    
  public static function getInstance()
  {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 *************************************************************
	 * Récupère l'objet Boite à outils pour les caches
	 *************************************************************
	 */
	protected $_caches_manager = null;
	
	function getCachesManager(){
	  if (is_null($this->_caches_manager)) $this->_caches_manager = Doydoy_Tools_CachesManager::getInstance();
	  return $this->_caches_manager;
	}
}
