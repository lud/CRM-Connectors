<?php

namespace UserFiles\Connectors\KConnectorGenericSampleSalesforce ;


require_once __DIR__ . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "autoload.php" ;


use KiamoConnectorSampleTools\ConfManager ;
use KiamoConnectorSampleTools\Logger      ;
use KiamoConnectorSampleTools\Resources   ;
use KiamoConnectorSampleTools\SubModule   ;
use KiamoConnectorSampleTools\Webs        ;


class InteractionManagerSalesforce extends SubModule
{
  public   function __construct( $_parent )  // The _parent must be a module
  {
    parent::__construct( $_parent, get_class( $_parent ), ConfManager::UserConfType ) ;
    $this->tgtEnvName  = $_parent->targetEnvironment ;
    $this->sessionToken = $this->getSavedSession() ;
  }


  /* *************************************************************************
     Main
  */

  public   function getSingleEntry( $entityType, $entityId )
  {
    $this->log( "Type = " . $entityType . ", Id = " . $entityId, Logger::LOG_INFO, __METHOD__ ) ;
    $reqStr = 'sobjects/' . $entityType . '/' . $entityId ;
    $this->log( "Request => " . $reqStr, Logger::LOG_DEBUG, __METHOD__ ) ;
    $res = $this->wsGet( $reqStr ) ;
    return $res ;
  }

  public   function getEntriesList( $entityType, $field, $value, $operation, $fields )
  {
    $_query  = $this->getQuery( $entityType, $field, $value, $operation, $fields ) ;
    $res     = $this->getEntriesListByQuery( $_query ) ;
    return $res ;
  }


  /* *************************************************************************
     Main Tools
  */
  public   function authenticate( $force = false )
  {
    if( ( $force === false ) && !empty( $this->sessionToken ) ) return $this->sessionToken ;
    if( empty( $this->tgtEnvName ) ) return null ;

    $this->log( "Target environment              : '" . $this->tgtEnvName . "'", Logger::LOG_INFO, __METHOD__ ) ;

    $accessData       = $this->getEnvAccessData( $this->tgtEnvName ) ;
    $authentData      = $accessData[ "authent" ] ;

    $grantType        = 'password' ;
    $url              = $authentData[ 'url' ] ;
    $header           = [
      'Content-type: application/x-www-form-urlencoded'
    ] ;
    $_password        = $authentData[ 'account' ][ 'adminUser' ][ 'password'         ] ;
    $_securityToken   = $authentData[ 'account' ][ 'adminUser' ][ 'security_token'   ] ;
    $password         = $_password . $_securityToken ;
    $data             = [
      'grant_type'      => $grantType,
      'client_id'       => $authentData[ 'account' ][ 'data'      ][ 'client_id'     ],
      'client_secret'   => $authentData[ 'account' ][ 'data'      ][ 'client_secret' ],
      'username'        => $authentData[ 'account' ][ 'adminUser' ][ 'username'      ],
      'password'        => $password,
    ] ;

    $this->log( "Authentication attempt, url     : " . $url, Logger::LOG_INFO, __METHOD__ ) ;
    $res              = Webs::restRequest( $url, $data, $header ) ;
    if( empty( $res ) || $res[ Webs::REST_REQUEST_STATUS ] !== true )
    {
      $this->log( "ERROR : Unable to authenticate  : " . json_encode( $res ), Logger::LOG_ERROR, __METHOD__ ) ;
    }
    else
    {
      $this->sessionToken = $res[ Webs::REST_REQUEST_RESULT ][ 'access_token' ] ;
      $this->log( "Authentication OK, access token : " . $this->sessionToken, Logger::LOG_INFO, __METHOD__ ) ;
      $this->callUrl     = $accessData[ 'platform' ][ 'url' ] . '/services/data/v' . $accessData[ 'platform' ][ 'apiVersion' ] . '/' ;
      $this->saveSession() ;
    }
    return $this->sessionToken ;
  }


  public   function wsGet( $getParams )
  {
    $originToken = $this->sessionToken ;
    if( empty( $this->sessionToken ) ) $this->authenticate( true ) ;
    if( empty( $this->sessionToken ) )
    {
      $this->log( 'No access token : Unable to get a Session Token', Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }
    $url    = $this->callUrl . $getParams ;
    $header = $this->getAccessHeader() ;

    $this->log( 'GET url=' . $url, Logger::LOG_DEBUG, __METHOD__ ) ;
    $res    = Webs::restRequest( $url, null, $header ) ;
    if( empty( $res ) || $res[ Webs::REST_REQUEST_STATUS ] !== true )
    {
      if( $res[ Webs::REST_REQUEST_HTTPCODE ] === 404 )
      {
        $this->log( "Resource not found : " . json_encode( $res ), Logger::LOG_INFO, __METHOD__ ) ;
        return null ;
      }

      $this->log( "Issue in initial request : " . json_encode( $res ), Logger::LOG_WARN, __METHOD__ ) ;

      // Refresh session token (can have expired), then retry
      $this->authenticate( true ) ;
      if( empty( $this->sessionToken ) )
      {
        $this->log( "ERROR : get '" . $getParams . "' : Unable to get a Session Token", Logger::LOG_ERROR, __METHOD__ ) ;
        return null ;
      }

      $header = $this->getAccessHeader() ;

      $this->log( 'GET url=' . $url, Logger::LOG_DEBUG, __METHOD__ ) ;
      $res    = Webs::restRequest( $url, null, $header ) ;
      if( empty( $res ) || $res[ Webs::REST_REQUEST_STATUS ] !== true )
      {
        $this->log( "ERROR : get '" . $getParams . "' : Unable to get a Session Token: retry attempt failed, stop here", Logger::LOG_ERROR, __METHOD__ ) ;
        return null ;
      }
    }
    if( ( $this->sessionToken != $originToken ) && !empty( $originToken ) ) $this->log( "Renewed Session Token = '" . $this->sessionToken . "'", Logger::LOG_INFO, __METHOD__ ) ;

    $this->log( "wsGet OK, res : " . json_encode( $res[ Webs::REST_REQUEST_RESULT ] ), Logger::LOG_DEBUG, __METHOD__ ) ;

    return $res[ Webs::REST_REQUEST_RESULT ] ;
  }


  public   function getEntriesListByQuery( $query )
  {
    $reqStr  = 'query?q=' ;
    $this->log( "Request => " . $reqStr . $query, Logger::LOG_DEBUG, __METHOD__ ) ;
    $reqStr .= rawurlencode( $query ) ;
    $res     = $this->wsGet( $reqStr ) ;
    $ret     = null ;
    if( !empty( $res ) && array_key_exists( 'records', $res ) )
    {
      $ret = $res[ 'records' ] ;
    }
    return $ret ;
  }

  /*
  SELECT Id,Name,Description,NumberOfEmployees,Phone,Website,BillingStreet,BillingPostalCode,BillingCity from Account where Phone like'%250547480043%25'
  */
  public  function  getQuery( $entityType, $field, $value, $operation, &$fields )
  {
    if( sizeof( $fields ) <= 1 )
    {
      $this->log( "Not enough fields to build a query", Logger::LOG_WARN, __METHOD__ ) ;
      return null ;
    }
    $res = 'SELECT ' . $fields[0] ;
    for( $i = 1 ; $i < sizeof( $fields ) ; $i++ )
    {
      $res .= ',' . $fields[$i] ;
    }
    $res .= ' from ' . $entityType . ' where ' . $field . ' ' ;
    if( $operation === 'like' )
    {
      $res .= $operation . " '%" . $value . "%'" ;
    }
    else if( $operation === 'equals' )
    {
      $res .= "= '" . $value . "'" ;
    }
    else
    {
      $res .= $operation . " '" . $value . "'" ;
    }
    return $res ;
  }
  

  /* *************************************************************************
     Internal Tools
  */
  private  function getEnvAccessData()
  {
    return $this->getConf( ConfManager::getConfPath( "environments", $this->tgtEnvName, "accessdata" ) ) ;
  }

  private  function getAccessHeader()
  {
    if( empty( $this->sessionToken ) ) return [] ;
    return [
     'Content-type: application/json',
     'Authorization: Bearer ' . $this->sessionToken
    ] ;
  }

  private  function  getSavedSession()
  {
    if( !Resources::existsDefaultDataFile() ) return null ;
    $session = Resources::readDefaultDataFile() ;
    $this->sessionToken = $session[ 'sessionToken' ] ;
    $this->callUrl      = $session[ 'callUrl'      ] ;
    $this->log( "Reading saved session '" . json_encode( $session ) . "'", Logger::LOG_INFO, __METHOD__ ) ;
    return $this->sessionToken ;
  }

  private  function  saveSession()
  {
    $session = [] ;
    $session[ 'sessionToken' ] = $this->sessionToken ;
    $session[ 'callUrl'      ] = $this->callUrl      ;
    $this->log( "Saving session  '" . json_encode( $session ) . "'", Logger::LOG_INFO, __METHOD__ ) ;
    Resources::writeDefaultDataFile( $session ) ;
  }
}
?>
