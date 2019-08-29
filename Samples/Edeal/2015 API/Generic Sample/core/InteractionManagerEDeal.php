<?php

namespace UserFiles\Connectors\KConnectorGenericSampleEDeal ;


require_once __DIR__ . DIRECTORY_SEPARATOR . "../tools" . DIRECTORY_SEPARATOR . "autoload.php" ;


use KiamoConnectorSampleToolsEDeal\ConfManager ;
use KiamoConnectorSampleToolsEDeal\Logger      ;
use KiamoConnectorSampleToolsEDeal\Resources   ;
use KiamoConnectorSampleToolsEDeal\SoapClient  ;
use KiamoConnectorSampleToolsEDeal\SubModule   ;
use KiamoConnectorSampleToolsEDeal\Webs        ;


class InteractionManagerEDeal extends SubModule
{
  public   function __construct( $_parent )  // The _parent must be a module
  {
    parent::__construct( $_parent, get_class( $_parent ), ConfManager::UserConfType ) ;
    $this->tgtEnvName   = $_parent->targetEnvironment ;
    $this->wsClient     = null ;
  }


  /* *************************************************************************
     Main
  */

  public   function getSingleEntry( $entityType, $entityId, $outfields )
  {
    $authenticated = $this->authenticate() ;
    if( $authenticated === false )
    {
      $this->log( "Authentication failure.", Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }

    $this->log( "Type = " . $entityType . ", Id = " . $entityId, Logger::LOG_INFO, __METHOD__ ) ;
    
    $params = [
      0 => $entityType,
      1 => $entityId,
      2 => $outfields  ] ;
    $res = $this->wsClient->call( 'getSingleObject', $params ) ;
    
    if( empty( $res ) || ( array_key_exists( 'item', $res ) && empty( $res[ 'item' ] ) ) ) return null ;

    return $res[ 'item' ] ;
  }

  public   function getEntriesList( $entityType, $field, $value, $operation, $fields )
  {
    $authenticated = $this->authenticate() ;
    if( $authenticated === false )
    {
      $this->log( "Authentication failure.", Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }

    $this->log( "Querying type='" . $entityType . "', field=" . $field . "', value='" . $value . "', operation='" . $operation . "'...", Logger::LOG_INFOP, __METHOD__ ) ;
    $_query  = $this->getQuery( $entityType, $field, $value, $operation, $fields ) ;
    $params  = [
      0 => $entityType,
      1 => $fields, 
      2 => $_query
    ] ;
    $res = $this->wsClient->call( 'getObjectList', $params ) ;

    if( empty( $res ) || ( array_key_exists( 'item', $res ) && empty( $res[ 'item' ] ) ) )
    {
      $this->log( "=> No match", Logger::LOG_INFOP, __METHOD__ ) ;
      return null ;
    }
    $this->log( "=> " . sizeof( $res[ 'item' ] ) . " match(es) found", Logger::LOG_INFOP, __METHOD__ ) ;
    if( sizeof( $res[ 'item' ] ) === 1 ) return [ $res[ 'item' ] ] ;

    return $res[ 'item' ] ;
  }


  /* *************************************************************************
     Main Tools
  */
  public   function authenticate()
  {
    if(  empty( $this->tgtEnvName ) ) return null ;
    if( !empty( $this->wsClient   ) ) return true ;

    $this->log( "Target environment              : '" . $this->tgtEnvName . "'", Logger::LOG_INFO, __METHOD__ ) ;

    $accessData       = $this->getEnvAccessData( $this->tgtEnvName ) ;
    $authentData      = $accessData[  'authent'  ] ;

    $_namespace       = $accessData[  'platform' ][ 'namespace' ] ;
    $url              = $authentData[ 'url'      ] ;
    $username         = $authentData[ 'account'  ][ 'adminUser' ][ 'username'      ] ;
    $password         = $authentData[ 'account'  ][ 'adminUser' ][ 'password'      ] ;

    $this->log( "Authentication attempt, url     : " . $url, Logger::LOG_INFO, __METHOD__ ) ;

    $this->wsClient = new SoapClient( $this, $url, $_namespace ) ;
    $this->wsClient->soap_defencoding = 'UTF-8' ;
    $this->wsClient->decode_utf8 = false ;

    // Authenticate
    $params    = [ 0 => $username,
                   1 => $password ] ;
    $response = $this->wsClient->call( 'authenticate', $params ) ;

    // Authentication Failed
    if( empty( $response ) )
    {
      $this->log( "Authentication FAILED.", Logger::LOG_WARN, __METHOD__ ) ;
      return false ;
    }

    // Authentication OK
    $this->log( "Authentication OK.", Logger::LOG_INFO, __METHOD__ ) ;
    return true ;
  }


  public  function  getQuery( $entityType, $field, $value, $operation, &$fields )
  {
    $_queryStr = null ;
    switch( $operation )
    {
    case 'contains' :
      $_queryStr  = $field . " contains ('" . $value . "')" ;
      break ;
    default :
      $_queryStr = $field .      " like '%" . $value . "%'" ;
      break ;
    }
    $res = [ $_queryStr ] ;
    return $res ;
  }
  

  /* *************************************************************************
     Internal Tools
  */
  private  function getEnvAccessData()
  {
    return $this->getConf( ConfManager::getConfPath( "environments", $this->tgtEnvName, "accessdata" ) ) ;
  }
}
?>
