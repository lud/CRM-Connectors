<?php

namespace UserFiles\Connectors\KConnectorGenericSampleEDeal ;


/**/
// Kiamo v6.x : CRM Connectors Utilities
// -----

// Utilities
use Kiamo\Bundle\AdminBundle\Utility\Connectors\ParameterBag                                    ;

// Entities
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityInstance                         ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityInstanceCollection               ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityField                            ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityLayout                           ;
/**/


/*
// Kiamo v7.x : CRM Connectors Utilities
// -----

// Utilities
use Kiamo\Admin\Utility\Connectors\ParameterBag                                    ;

// Entities
use Kiamo\Admin\Utility\Connectors\Entities\EntityInstance                         ;
use Kiamo\Admin\Utility\Connectors\Entities\EntityInstanceCollection               ;
use Kiamo\Admin\Utility\Connectors\Entities\EntityField                            ;
use Kiamo\Admin\Utility\Connectors\Entities\EntityLayout                           ;
*/


require_once __DIR__ . DIRECTORY_SEPARATOR . "../tools" . DIRECTORY_SEPARATOR . "autoload.php" ;


use KiamoConnectorSampleToolsEDeal\ConfManager ;
use KiamoConnectorSampleToolsEDeal\Logger      ;
use KiamoConnectorSampleToolsEDeal\SubModule   ;


/*
   Definitions :
   - Entity : type of entry, as a contact or a ticket for instance
   - Entry  : instance of an entity. The contact entity data of Mr John Foo, for instance.
*/
class EntitiesManager extends SubModule
{
  public   function __construct( $_parent )  // The _parent must be a module
  {
    parent::__construct( $_parent, get_class( $_parent ), ConfManager::UserConfType ) ;
    $this->tgtEnvName  = $_parent->targetEnvironment ;
  }


  /* *************************************************************************
     Main
  */
  public   function getEntryInstance( $type, $externalInstanceData, $updateInteractionLabel = true )
  {
    $res = null ;

    $packagedEntry = $this->getPackagedEntry( $type, $externalInstanceData ) ;
    $this->log( "Entry : " . $this->getPackagedEntryStr( $packagedEntry ), Logger::LOG_DEBUG, __METHOD__ ) ;

    $interactionLabel = $packagedEntry[ 'label'  ] ;
    if( $updateInteractionLabel === false ) $interactionLabel = '' ;

    $res = new EntityInstance(
      $packagedEntry[ 'layout' ],
      $packagedEntry[ 'id'     ],
      $packagedEntry[ 'values' ],
      $packagedEntry[ 'exturl' ],
      $interactionLabel
    ) ;

    switch( $type )
    {
    case 'contact' :
      $res->setContactId( $packagedEntry[ 'id' ] ) ;
      break ;
    case 'company' :
      $res->setCompanyId( $packagedEntry[ 'id' ] ) ;
      break ;
    case 'file'    :
      $res->setFileId(    $packagedEntry[ 'id' ] ) ;
      break ;
    case 'ticket'  :
      $res->setTicketId(  $packagedEntry[ 'id' ] ) ;
      break ;
    default :
      break ;
    }
    
    return $res ;
  }


  // Map Entities
  public   function getEntriesCollection( $type, $entriesArr )
  {
    $res = new EntityInstanceCollection( $this->getEntityLayout( $type ) ) ;
    if( empty( $entriesArr ) ) return $res ;

    $this->log( "Building entries collection...", Logger::LOG_INFOP, __METHOD__ ) ;
    foreach( $entriesArr as $externalInstanceData )
    {
      $packagedEntry = $this->getPackagedEntry( $type, $externalInstanceData[ 'item' ] ) ;
      $this->log( "=> adding entry : " . $this->getPackagedEntryStr( $packagedEntry ), Logger::LOG_DEBUG, __METHOD__ ) ;
      $res->add( $packagedEntry[ 'id'     ],
                 $packagedEntry[ 'values' ],
                 $packagedEntry[ 'exturl' ],
                 $packagedEntry[ 'label'  ] ) ;
    }
    $this->log( "Building entries collection : DONE", Logger::LOG_DEBUG, __METHOD__ ) ;
      
    return $res ;
  }


  /* *************************************************************************
     Main Entities Tools
  */
  
  // Entity Type Mapping
  // ---
  // inout =  true ==> arg type is external, expected res is internal
  // inout = false ==> arg type is internal, expected res is external
  public   function getEntityType( $type, $inout = true )
  {
    $map = $this->getConf( "entities.map" ) ;
    
    $res = 'NO_MATCH' ;
    switch( $type )
    {
    case 'contact'  :
    case 'company'  :
    case 'dossier'  :
    case 'ticket'   :
    case 'customer' :
      foreach( $map as $key => $val )
      {
        if( $val === $type )
        {
          $res = $key ;
          break ;
        }
      }
      break ;
    default  :
      foreach( $map as $key => $val )
      {
        if( $key === $type )
        {
          $res = $val ;
          break ;
        }
      }
      break ;
    }
    return $res ;
  }
  
  // Entity Layout
  // ---
  public   function getEntityLayout( $type )
  {
    $entityLabel        = $this->getEntityLabel(        $type ) ;
    $entityFieldDisplay = $this->getEntityFieldDisplay( $type ) ;
    $layout             = new EntityLayout( $entityLabel, $entityFieldDisplay ) ;

    $_entityFields = $this->getEntityFields( $type ) ;
    foreach( $_entityFields as $name => $desc )
    {
      $displayFlag          = $desc[ 'display' ] ;
      $kiamoDataType        = $this->mapDataType( $desc[ 'type' ] ) ;
      $label                = $desc[ 'label'   ] ;
      $kiamoVariableMapping = $desc[ 'map'     ] ;
      $layout->addField( $name, $label, $kiamoDataType, $kiamoVariableMapping, $displayFlag ) ;
    }
    return $layout ;
  }
  

  public   function getEntitiesSearchUrl( $type, $additionalData = '' )
  {
    $res         = null ;
    $urlPatterns = $this->getConf( ConfManager::getConfPath( "environments", $this->tgtEnvName, "urls", "search" ) ) ;
    $urlPattern  = $urlPatterns[ $type ] ;
    $res         = $urlPatterns[ 'baseUrl' ] . $urlPattern[ 'prefix' ] . $additionalData . $urlPattern[ 'postfix' ] ;
    return $res ;
  }

  
  /* *************************************************************************
     Main Entries Tools
  */

  // Entry Label
  // ---
  
  public   function getEntryLabel( $type, $values )
  {
    // Get the entry label as (if) defined in conf
    $res = $this->_getConfiguredEntryLabel( $type, $values ) ;
    if( empty( $res ) )  // Default value
    {
      switch( $type )
      {
      case 'contact' :
        $labelField = $this->getEntityFieldPosition( $type, 'lastname' ) ;
        $res        = $values[ $labelField ] ;
        break ;
      case 'company' :
        $labelField = $this->getEntityFieldPosition( $type, 'name' ) ;
        $res        = $values[ $labelField ] ;
        break ;
      case 'file'    :
      case 'ticket'  :
      default :
        break ;
      }
    }
    return $res ;
  }

  private  function _getConfiguredEntryLabel( $type, $values )
  {
    $res = '' ;
    $elPattern = $this->getEntryLabelPattern( $type ) ;
    if( empty( $elPattern ) ) return $res ;
    foreach( $elPattern[ 'stringItems' ] as $strItem )
    {
      $value = '' ;
      if(      $strItem[ 'type' ] === 'string' )
      {
        $value      = $strItem[ 'value' ] ;
      }
      else if( $strItem[ 'type' ] === 'field'  )
      {
        $labelField = $this->getEntityFieldPosition( $type, $strItem[ 'value' ] ) ;
        $value      = $values[ $labelField ] ;
      }
      if(  empty( $value ) ) continue ;
      if( !empty( $res   ) ) $res .= $elPattern[ 'separator' ] ;
      $res .= $value ;
    }
    return $res ;
  }

  public   function getPackagedEntry( $type, $values )
  {
    $res = [] ;

    // Map values with fields
    $_entityFields = $this->getEntityFields( $type ) ;
    $_values          = [] ;
    $res[ 'values' ]  = [] ;
    $i                = 0 ;
    foreach( $_entityFields as $name => $desc )
    {
      $cur = utf8_encode( $values[$i] ) ;
      array_push( $_values, $cur ) ;
      $res[ 'values' ][ $name ] = $cur ;
      $i++ ;
    }

    $res[ 'layout' ]  = $this->getEntityLayout(        $type          ) ;
    $_idField         = $this->getEntityFieldPosition( $type, 'id'    ) ;
    $res[ 'id'     ]  = $values[                       $_idField      ] ;
    $res[ 'exturl' ]  = $this->getEntryExternalUrl(    $type, $_values ) ;
    $res[ 'label'  ]  = $this->getEntryLabel(          $type, $_values ) ;

    return $res ;
  }
  public   function getPackagedEntryStr( $packagedEntry )
  {
    $res  = "" ;
    $res .=       "id=" .                    $packagedEntry[ 'id'     ]         ;
    $res .= ", label='" .                    $packagedEntry[ 'label'  ] .   "'" ;
    $res .= ", values=" . '[' . json_encode( $packagedEntry[ 'values' ] ) . ']' ;
    $res .= ", exturl=" .                    $packagedEntry[ 'exturl' ]         ;
    return $res ;
  }
  
  public   function getEntryExternalUrl( $type, $values )
  {
    $res         = null ;
    $_idField    = $this->getEntityFieldPosition( $type, 'id' ) ;
    $id          = $values[ $_idField ] ;
    $urlPatterns = $this->getConf( ConfManager::getConfPath( "environments", $this->tgtEnvName, "urls", "view" ) ) ;
    $urlPattern  = $urlPatterns[ $type ] ;
    $res         = $urlPatterns[ 'baseUrl' ] . $urlPattern[ 'prefix' ] . $id . $urlPattern[ 'postfix' ] ;
    return $res ;
  }

  
  /* *************************************************************************
     Internal Tools
  */
  
  // Get Configuration
  // ---
  public   function getEntityConf( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type ) ) ;
  }

  public   function getEntityLabelConf( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "labels", "entity" ) ) ;
  }

  public   function getEntityLabel( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "labels", "entity", "name" ) ) ;
  }

  public   function getEntityFieldDisplay( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "labels", "entity", "fieldDisplay" ) ) ;
  }

  public   function getEntryLabelPattern( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "labels", "entry" ) ) ;
  }

  public   function getEntityFields( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "map" ) ) ;
  }

  public   function getEntityField( $type, $internalKey )
  {
    $res = '' ;
    $map = $this->getEntityFields( $type ) ;
    foreach( $map as $key => $val )
    {
      if( $val[ 'key' ] === $internalKey )
      {
        $res = $key ;
        break ;
      }
    }
    return $res ;
  }

  public   function getEntityFieldPosition( $type, $internalKey )
  {
    $res = '' ;
    $map = $this->getEntityFields( $type ) ;
    $i = 0 ;
    foreach( $map as $key => $val )
    {
      if( $val[ 'key' ] === $internalKey )
      {
        break ;
      }
      $i++ ;
    }
    return $i ;
  }

  public   function getEntitySearchPatternKiamoInputs( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "search", "kiamoInputs" ) ) ;
  }

  public   function getEntitySearchPatternAgentQuery( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "search", "agentQuery" ) ) ;
  }

  public   function getEntitySearchGetOneOfMethod( $type )
  {
    return $this->getConf( ConfManager::getConfPath( "entities", $type, "search", "getOneOfList" ) ) ;
  }
  
  // Map Kiamo Data Type
  private  function mapDataType( $dataType )
  {
    $res = null ;
    switch( $dataType )
    {
    case 'text' :
      $res = EntityField::TYPE_TEXT ;
      break ;
    case 'date' :
      $res = EntityField::TYPE_DATE ;
      break ;
    case 'datetime' :
      $res = EntityField::TYPE_DATETIME ;
      break ;
    case 'tzdatetime' :
      $res = EntityField::TYPE_TZDATETIME ;
      break ;
    case 'time' :
      $res = EntityField::TYPE_TIME ;
      break ;
    case 'tztime' :
      $res = EntityField::TYPE_TZTIME ;
      break ;
    case 'birthday' :
      $res = EntityField::TYPE_BIRTHDAY ;
      break ;
    case 'phone' :
      $res = EntityField::TYPE_PHONE ;
      break ;
    case 'email' :
      $res = EntityField::TYPE_EMAIL ;
      break ;
    case 'id' :
    case 'url' :
    case 'multi' :
    case 'array' :
    case 'json' :
    case 'int' :
    case 'float' :
    case 'boolean' :
    case 'string' :
    default :
      $res = EntityField::TYPE_STRING ;
      break ;
    }
    return $res ;
  }

}
?>
