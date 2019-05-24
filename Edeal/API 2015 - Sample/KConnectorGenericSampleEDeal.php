<?php

namespace UserFiles\Connectors\KConnectorGenericSampleEDeal ;


const KIAMO_ROOT            = __DIR__ . "/../../../../../" ;
const KIAMO_CONNECTOR_TOOLS = KIAMO_ROOT . "www/Symfony/src/Kiamo/Bundle/AdminBundle/Utility/Connectors/" ;

require_once KIAMO_CONNECTOR_TOOLS . "ParameterBag.php"                                    ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorInterface.php"              ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactInterface.php"       ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactUrlInterface.php"    ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactSearchInterface.php" ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanyInterface.php"       ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanyUrlInterface.php"    ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanySearchInterface.php" ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketInterface.php"        ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketUrlInterface.php"     ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketSearchInterface.php"  ;


// Interfaces
use Kiamo\Bundle\AdminBundle\Utility\Connectors\ParameterBag                       ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorInterface ;

// Interfaces : Contact
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorContactInterface       ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorContactUrlInterface    ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorContactSearchInterface ;

// Interface : Company
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorCompanyInterface ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorCompanyUrlInterface ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorCompanySearchInterface ;

// Interface : Ticket
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorTicketInterface ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorTicketUrlInterface ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorTicketSearchInterface ;


require_once __DIR__ . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "autoload.php" ;


use KiamoConnectorSampleTools\Logger    ;
use KiamoConnectorSampleTools\Module    ;


require_once __DIR__ . "/InteractionManagerEDeal.php" ;
require_once __DIR__ . "/EntitiesManager.php" ;
require_once __DIR__ . "/CustomizationManager.php" ;


class KConnectorGenericSampleEDeal extends    Module
                                   implements KiamoConnectorInterface, 
                                              KiamoConnectorContactInterface,       // Contact
                                              KiamoConnectorContactUrlInterface,    // Contact Url
                                              KiamoConnectorContactSearchInterface, // Contact Search
                                              KiamoConnectorCompanyInterface,       // Company
                                              KiamoConnectorCompanyUrlInterface,    // Company URL
                                              KiamoConnectorCompanySearchInterface, // Company Search
                                              KiamoConnectorTicketInterface,        // Ticket
                                              KiamoConnectorTicketUrlInterface,     // Ticket URL
                                              KiamoConnectorTicketSearchInterface   // Ticket Search
{
  const ServiceName = "EDeal" ;
  const ModuleName  = __CLASS__    ;
  const ModuleDesc  = "Kiamo Generic " . self::ServiceName . " Connector Sample" ;

  public function __construct()
  {
    parent::__construct() ;

    $this->targetEnvironment = "test" ;

    $this->interactionMgr    = new InteractionManagerEDeal( $this ) ;
    $this->entitiesMgr       = new EntitiesManager(         $this ) ;
    $this->customizationMgr  = new CustomizationManager(    $this ) ;
  }


  /* **********************************
     GLOBAL Connector
  */

  static public function setLang( $lang )
  {
  }

  public function setCid( $cid )
  {
    $this->_cid = $cid ;
  }

  static public function getType()
  {
    return self::ModuleDesc ;
  }


  /* **********************************
     GLOBAL Connector Instance
  */

  public function isActivatable()
  {
    return true ;
  }

  public function setActivationInfos( $infos )
  {
  }
  
  public function getActivationInfos()
  {
    return [] ;
  }


  /* **********************************
     Entities : contact
  */

  // INTERFACE : Contact
  // ---
  public function contactIsActive()
  {
    return true ;
  }

  public function getContactLabel()
  {
    $type = 'contact' ;
    return $this->getEntityLabel( $type ) ;
  }

  public function getContactLayout()
  {
    $type = 'contact' ;
    return $this->getEntityLayout( $type ) ;
  }
  
  public function findContactById( $id )
  {
    $type = 'contact' ;
    return $this->findEntryById( $type, $id ) ;
  }

  public function findOneContact( ParameterBag $parameters )
  {
    $type = 'contact' ;
    return $this->findOneEntry( $type, $parameters ) ;
  }

  // INTERFACE : Contact Search
  // ---
  public function findContactsByQuery( $query, ParameterBag $parameters )
  {
    $type = 'contact' ;
    return $this->findEntriesByQuery( $type, $query, $parameters ) ;
  }

  // INTERFACE : Contact Url
  // ---
  public function getContactsCrmSearchUrl()
  {
    $type = 'contact' ;
    return $this->getEntitiesCrmSearchUrl( $type ) ;
  }


  /* **********************************
     Entities : company
  */

  // INTERFACE : Company
  // ---
  public function companyIsActive()
  {
    return true ;
  }

  public function getCompanyLabel()
  {
    $type = 'company' ;
    return $this->getEntityLabel( $type ) ;
  }

  public function getCompanyLayout()
  {
    $type = 'company' ;
    return $this->getEntityLayout( $type ) ;
  }
  
  public function findCompanyById( $id )
  {
    $type = 'company' ;
    return $this->findEntryById( $type, $id ) ;
  }

  public function findOneCompany( ParameterBag $parameters )
  {
    $type = 'company' ;
    return $this->findOneEntry( $type, $parameters ) ;
  }

  // INTERFACE : Company Search
  // ---
  public function findCompaniesByQuery( $query, ParameterBag $parameters )
  {
    $type = 'company' ;
    return $this->findEntriesByQuery( $type, $query, $parameters ) ;
  }

  // INTERFACE : Company Url
  // ---
  public function getCompaniesCrmSearchUrl()
  {
    $type = 'company' ;
    return $this->getEntitiesCrmSearchUrl( $type ) ;
  }


  /* **********************************
     Entities : ticket
  */

  // INTERFACE : Ticket
  // ---
  public function ticketIsActive()
  {
    return true ;
  }

  public function getTicketLabel()
  {
    $type = 'ticket' ;
    return $this->getEntityLabel( $type ) ;
  }

  public function getTicketLayout()
  {
    $type = 'ticket' ;
    return $this->getEntityLayout( $type ) ;
  }
  
  public function findTicketById( $id )
  {
    $type = 'ticket' ;
    return $this->findEntryById( $type, $id, false ) ;
  }

  public function findOneTicket( ParameterBag $parameters )
  {
    $type = 'ticket' ;
    return $this->findOneEntry( $type, $parameters ) ;
  }

  // INTERFACE : Ticket Search
  // ---
  public function findTicketsByQuery( $query, ParameterBag $parameters )
  {
    $type = 'ticket' ;
    return $this->findEntriesByQuery( $type, $query, $parameters ) ;
  }

  // INTERFACE : Ticket Url
  // ---
  public function getTicketsCrmSearchUrl()
  {
    $type = 'ticket' ;
    return $this->getEntitiesCrmSearchUrl( $type ) ;
  }


  /* **********************************
     TOOLS Entities and Entries Generic :
  */

  private  function getEntityLabel( $type )
  {
    return $this->getConf( "entities." . $type . ".labels.entity.name" ) ;
  }

  private  function getEntityLayout( $type )
  {
    return $this->entitiesMgr->getEntityLayout( $type ) ;
  }
  

  // Get the external entry by its id (already known, one way or the other)
  private  function findEntryById( $type, $id, $updateInteractionLabel = true )
  {
    $this->setActionId() ;
    
    $this->log( "Find " . $type . " by id : " . $id, Logger::LOG_INFO, __METHOD__ ) ;
    $entry     = null ;

    $extType   = $this->entitiesMgr->getEntityType( $type ) ;
    $extFields = array_keys( $this->entitiesMgr->getEntityFields( $type ) ) ;
    $raw       = $this->interactionMgr->getSingleEntry( $extType, $id, $extFields ) ;

    if( empty( $raw ) )
    {
      $this->log( "=> Not found : " . $type . " id : " . $id, Logger::LOG_INFO, __METHOD__ ) ;
      return null ;
    }

    $this->log(   "=> Found : "     . $type . " id : " . $id, Logger::LOG_INFO, __METHOD__ ) ;
    $entry = $this->entitiesMgr->getEntryInstance( $type, $raw, $updateInteractionLabel ) ;

    $this->clearActionId() ;

    return $entry ;
  }

  
  // Search matches using the ParameterBag provided by Kiamo (Media interaction)
  private  function findOneEntry( $type, &$parameters )
  {
    $this->setActionId() ;
    $this->log( "Find one " . $type, Logger::LOG_INFO, __METHOD__ ) ;
    $entry = null ;


    // Loop on the 'kiamoInputs' search parameters
    $searchPattern = $this->entitiesMgr->getEntitySearchPatternKiamoInputs( $type ) ;
    $res           = null ;
    foreach( $searchPattern as $searchItem )
    {
      $varName      = $searchItem[ 'varName' ] ;
      

      // Search entries matching the current search item (eligibility, pre-treatment, post-treatment)
      $pbParamValue = $parameters->$varName ;
      $preparedResult = $this->findEntriesBySearchPattern( $type, $pbParamValue, $searchItem ) ;
      if( empty( $preparedResult ) ) continue ;
      

      // Select one of the list
      $res = $preparedResult[0]['item'] ;  // By default, select the first returned result
      if( sizeof( $preparedResult ) > 1 )
      {
        $oneOfMethod = $this->entitiesMgr->getEntitySearchGetOneOfMethod( $type ) ;
        if( !empty( $oneOfMethod ) )
        {
          if( method_exists( $this->customizationMgr, $oneOfMethod ) )
          {
            $this->log( "Several results, Get One Of method '" . $oneOfMethod . "' applied", Logger::LOG_INFOP, __METHOD__ ) ;
            $res = $this->customizationMgr->$oneOfMethod( $preparedResult ) ;
          }
          else
          {
            $this->log( "! Get One Of method '" . $oneOfMethod . "' does not exist in '" . get_class( $this->customizationMgr ) . "' implementation", Logger::LOG_WARN, __METHOD__ ) ;
          }
        }
      }
      
      
      // One match has been found and treated : break the search loop here
      break ;
    }

    if( empty( $res ) )
    {
      $this->log( "=> No match found", Logger::LOG_INFO, __METHOD__ ) ;
      return null ;
    }

    $this->log(   "=> Match found", Logger::LOG_INFO, __METHOD__ ) ;
    $entry = $this->entitiesMgr->getEntryInstance( $type, $res ) ;

    $this->clearActionId() ;

    return $entry ;
  }


  // Search matches by query (an agent using the search button)
  private  function findEntriesByQuery( $type, $query, &$parameters )
  {
    $this->setActionId() ;
    $this->log( "Find " . $type . "s by query : '" . $query . "'", Logger::LOG_INFO, __METHOD__ ) ;
    $collection = null ;


    // Loop on the 'agentQuery' search parameters
    $searchPattern = $this->entitiesMgr->getEntitySearchPatternAgentQuery( $type ) ;
    $res           = null ;
    foreach( $searchPattern as $searchItem )
    {
      // Search entries matching the current search item (eligibility, pre-treatment, post-treatment)
      $res = $this->findEntriesBySearchPattern( $type, $query, $searchItem ) ;
      if( empty( $res ) ) continue ;
      
      // At least one match has been found and treated : break the search loop here
      break ;
    }

    if( empty( $res ) )
    {
      $this->log( "=> No match found", Logger::LOG_INFO, __METHOD__ ) ;
      return null ;
    }

    $this->log(   "=> Match(es) found : " . sizeof( $res ), Logger::LOG_INFO, __METHOD__ ) ;
    $collection = $this->entitiesMgr->getEntriesCollection( $type, $res ) ;

    $this->clearActionId() ;

    return $collection ;
  }


  // Search entries by search pattern :
  // ---
  // -> skip empty values
  // -> apply eligibility requirements, if any
  // -> apply pre-treatment on the provided value, if defined
  // -> apply post-treatment on the returned results, if defined
  public  function findEntriesBySearchPattern( $type, $paramValue, $searchPatternItem )
  {
    $entityField  = $searchPatternItem[ 'entityField' ] ;
    $operation    = $searchPatternItem[ 'operation'   ] ;
    $preTrt       = $searchPatternItem[ 'preTrt'      ] ;
    $eligibility  = $searchPatternItem[ 'eligibility' ] ;
    $postTrt      = $searchPatternItem[ 'postTrt'     ] ;
    

    // Skip empty values
    if( empty( $paramValue ) ) return null ;


    // Check parameter eligibility (if any)
    if( !empty( $eligibility ) )
    {
      if( method_exists( $this->customizationMgr, $eligibility ) )
      {
        $validParamValue = $this->customizationMgr->$eligibility( $paramValue ) ;
        if( !$validParamValue )
        {
          $this->log( "Parameter '" . $paramValue . "' does not match '" . $eligibility . "' requirements", Logger::LOG_DEBUG, __METHOD__ ) ;
          return null ;
        }
      }
      else
      {
        $this->log( "! Eligibility method '" . $eligibility . "' does not exist in '" . get_class( $this->customizationMgr ) . "' implementation", Logger::LOG_WARN, __METHOD__ ) ;
      }
    }
    

    // Apply pre-treatment on the parameter value (if any)
    $preparedParamValue = $paramValue ;
    $customers          = [] ;  // Special case : tickets
    if( !empty( $preTrt ) )
    {
      if( method_exists( $this->customizationMgr, $preTrt ) )
      {
        // !!! Special case : tickets
        // In order to get tickets, you have to get the contact or company associated customers
        if( $preTrt === 'getCustomers' )
        {
          $preTrtData = [] ;
          $preTrtData[ 'field' ] = $entityField ;
          $preTrtData[ 'value' ] = $paramValue               ;
          $customers = $this->customizationMgr->$preTrt( $preTrtData ) ;
          $this->log( "Pre-treatment '" . $preTrt . "' : " . $entityField . "=" . $paramValue . " => " . sizeof( $customers ) . " related customer(s) found", Logger::LOG_DEBUG, __METHOD__ ) ;
        }
        else
        {
          $preparedParamValue = $this->customizationMgr->$preTrt( $paramValue ) ;
          $this->log( "Pre-treatment '" . $preTrt . "' : " . $entityField . "=" . $paramValue . " => '" . $preparedParamValue . "'", Logger::LOG_DEBUG, __METHOD__ ) ;
        }
      }
      else
      {
        $this->log( "! Pre-treatment method '" . $preTrt . "' does not exist in '" . get_class( $this->customizationMgr ) . "' implementation", Logger::LOG_WARN, __METHOD__ ) ;
      }
    }
    

    // Search a match on the external Service
    $extType           = $this->entitiesMgr->getEntityType(               $type               ) ;
    $extField          = $this->entitiesMgr->getEntityField(              $type, $entityField ) ;
    $extFields         = array_keys( $this->entitiesMgr->getEntityFields( $type               ) ) ;
    $extRequestResults = [] ;

    // !!! Special case : tickets
    // Get tickets via the related customers
    if( $preTrt === 'getCustomers' )
    {
      $extField = $this->entitiesMgr->getEntityField( $type, 'customerIds' ) ;
      foreach( $customers as $customer )
      {
        $customerIdFieldPos = $this->entitiesMgr->getEntityFieldPosition( $type, 'id' ) ;
        $customerId         = $customer[ 'item' ][ $customerIdFieldPos ] ;
        if( empty( $customerId ) ) continue ;  // Just in case something goes wrong, no need to get all the platform tickets
        $tmpRes             = $this->interactionMgr->getEntriesList( $extType, $extField, $customerId, $operation, $extFields ) ;
        if( !empty( $tmpRes ) ) $extRequestResults = array_merge( $extRequestResults, $tmpRes ) ;
      }
    }
    else
    {
      $extRequestResults = $this->interactionMgr->getEntriesList( $extType, $extField, $preparedParamValue, $operation, $extFields ) ;
    }
    if( empty( $extRequestResults ) ) return null ;  // Return if no match
    

    // Apply post-treatment on the returned list (if any)
    $preparedResults = &$extRequestResults ;
    if( !empty( $postTrt ) )
    {
      if( method_exists( $this->customizationMgr, $postTrt ) )
      {
        $preparedResults = $this->customizationMgr->$postTrt( $extRequestResults ) ;
        $this->log( "Post-treatment '" . $postTrt . "' applied on " . sizeof( $extRequestResults ) . " returned result(s)", Logger::LOG_DEBUG, __METHOD__ ) ;
      }
      else
      {
        $this->log( "! Post-treatment method '" . $postTrt . "' does not exist in '" . get_class( $this->customizationMgr ) . "' implementation", Logger::LOG_WARN, __METHOD__ ) ;
      }
    }
    
    $this->log( "Found " . sizeof( $preparedResults ) . " '" . $type . "' result(s) for " . $entityField . "=" . $paramValue, Logger::LOG_DEBUG, __METHOD__ ) ;
    return $preparedResults ;
  }

  private  function getEntitiesCrmSearchUrl( $type )
  {
    return $this->entitiesMgr->getEntitiesSearchUrl( $type ) ;
  }
}
?>