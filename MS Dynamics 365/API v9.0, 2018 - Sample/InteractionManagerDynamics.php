<?php

namespace UserFiles\Connectors\KConnectorGenericSampleDynamics ;


require_once __DIR__ . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "autoload.php" ;


use KiamoConnectorSampleTools\ConfManager ;
use KiamoConnectorSampleTools\Logger      ;
use KiamoConnectorSampleTools\Resources   ;
use KiamoConnectorSampleTools\SubModule   ;
use KiamoConnectorSampleTools\Webs        ;


class InteractionManagerDynamics extends SubModule
{
  public   function __construct( $_parent )  // The _parent must be a module
  {
    parent::__construct( $_parent, get_class( $_parent ), ConfManager::UserConfType ) ;
    $this->tgtEnvName = $_parent->targetEnvironment ;
    $this->session    = $this->getSavedSession() ;
  }


  /* *************************************************************************
     Main
  */

  // contacts(<contactId>)
  public   function getSingleEntry( $entityType, $entityId )
  {
    $this->log( "Type = " . $entityType . ", Id = " . $entityId, Logger::LOG_INFO, __METHOD__ ) ;
    $reqStr = $entityType . '(' . $entityId . ')' ;
    $this->log( "Request => " . $reqStr, Logger::LOG_DEBUG, __METHOD__ ) ;
    $res = $this->wsGet( $reqStr ) ;
    return $res ;
  }

  // contacts?$select=contactid,salutation,firstname,lastname,jobtitle,telephone1,mobilephone,emailaddress1,_parentcustomerid_value,description,address1_line1,address1_postalcode,address1_city&$filter=contains(mobilephone,'XXXXXXXXXX')
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
    if( ( $force === false ) && !empty( $this->session ) ) return $this->session ;
    if( empty( $this->tgtEnvName ) ) return null ;

    $this->log( "Target environment              : '" . $this->tgtEnvName . "'", Logger::LOG_INFO, __METHOD__ ) ;

    $header      = [
      'Content-type: application/x-www-form-urlencoded'
    ] ;
    $authentUrl  = $this->getAuthentUrl() ;

    // First use a refresh token approach if it's possible
    $grantType = 'refresh_token' ;
    if( empty( $this->session ) )
    {
      $grantType = 'password' ;
    }
    
    // Build authent data
    $data = $this->getAuthentData( $grantType ) ;
    if( empty( $data ) && $grantType === 'refresh_token' )
    {
      $grantType = 'password' ;
      $data = $this->getAuthentData( $grantType ) ;
    }
    
    // Authentication attempt
    while( true )  // Try to refresh the session token, then try the password mode
    {
      $this->log( "Authentication attempt, mode ='" . $grantType . "', url : " . $authentUrl, Logger::LOG_INFO, __METHOD__ ) ;
      $res = Webs::restRequest( $authentUrl, $data, $header ) ;
      if( empty( $res ) || $res[ Webs::REST_REQUEST_STATUS ] !== true )
      {
        if( $grantType === 'password' )
        {
          $this->log( "ERROR : Unable to authenticate  : " . json_encode( $res ), Logger::LOG_ERROR, __METHOD__ ) ;
          $this->session = [] ;
        }
        else
        {
          $this->log( "Unable to refresh the authentication token. Retry in 'password' mode", Logger::LOG_INFOP, __METHOD__ ) ;
          $grantType = 'password' ;
          $data = $this->getAuthentData( $grantType ) ;
          continue ;
        }
      }
      else
      {
        $this->log( "Authentication SUCCESS : " . json_encode( $res, JSON_PRETTY_PRINT ), Logger::LOG_INFO, __METHOD__ ) ;
        $this->saveSession( $res[ Webs::REST_REQUEST_RESULT ][ 'access_token'  ], $res[ Webs::REST_REQUEST_RESULT ][ 'refresh_token' ] ) ;
      }
      break ;
    }

    return $this->session ;
  }


  public   function wsGet( $getParams )
  {
    if( empty( $this->session ) ) $this->authenticate( true ) ;
    if( empty( $this->session ) )
    {
      $this->log( 'Unable to get a valid Session, do nothing', Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }
    $apiUrl = $this->getAPIUrl() ;
    $url    = $apiUrl . '/' . $getParams ;
    $header = $this->getAccessHeader() ;

    $this->log( 'GET url=' . $url, Logger::LOG_DEBUG, __METHOD__ ) ;
    $res    = Webs::restRequest( $url, null, $header ) ;
    if( empty( $res ) || $res[ Webs::REST_REQUEST_STATUS ] !== true )
    {
      $this->log( "Resource not found : " . json_encode( $res ), Logger::LOG_INFO, __METHOD__ ) ;
      if( $res[ Webs::REST_REQUEST_HTTPCODE ] === 404 )
      {
        $this->log( "Resource not found : " . json_encode( $res ), Logger::LOG_INFO, __METHOD__ ) ;
        return null ;
      }

      if( $res[ Webs::REST_REQUEST_HTTPCODE ] === 400 )
      {
        $this->log( "Wrong parameter passed : " . json_encode( $res ), Logger::LOG_INFO, __METHOD__ ) ;
        return null ;
      }

      $this->log( "Issue in initial request : " . json_encode( $res ), Logger::LOG_WARN, __METHOD__ ) ;

      // Refresh session token (can have expired), then retry
      $this->authenticate( true ) ;
      if( empty( $this->session ) )
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

    $this->log( "wsGet OK, res : " . json_encode( $res[ Webs::REST_REQUEST_RESULT ] ), Logger::LOG_DEBUG, __METHOD__ ) ;

    return $res[ Webs::REST_REQUEST_RESULT ] ;
  }


  public   function getEntriesListByQuery( $query )
  {
    $this->log( "Request => " . $query, Logger::LOG_DEBUG, __METHOD__ ) ;
    $res     = $this->wsGet( $query ) ;
    $ret     = null ;
    if( !empty( $res ) && array_key_exists( 'value', $res ) )
    {
      $ret = $res[ 'value' ] ;
    }
    if( empty( $ret ) )
    {
      $this->log( '-> No match...', Logger::LOG_DEBUG, __METHOD__ ) ;
    }
    else
    {
      $this->log( '-> ' . sizeof( $ret ) . " match(es).", Logger::LOG_DEBUG, __METHOD__ ) ;
    }
    return $ret ;
  }


  /* QUERY string builder (SELECT + FILTER)
  
  contacts?$select=contactid,firstname,lastname,jobtitle,telephone1,mobilephone,emailaddress1,description&$filter=contains(mobilephone,'06')
  */
  public   function  getQuery( $entityType, $field, $value, $operation, &$fields )
  {
    $reqStr  = $entityType . '?' ;
    $selStr  = $this->getSelect( $entityType, $fields ) ;
    if( !empty( $selStr ) )
    {
      $reqStr .= $selStr . '&' ;
    }
    $fltStr  = $this->getFilter( $field, $value, $operation ) ;
    if( empty( $fltStr ) )
    {
      $this->log( "Invalid filter, cannot build query for entity='" . $entityType . "' with field='" . $field . "', value='" . $value . "', operation='" . $operation . "', fields='" . implode( ',', $fields ) . "'", Logger::LOG_WARN, __METHOD__ ) ;
      return null ;
    }
    $reqStr .= $fltStr ;
    return $reqStr ;
  }


  /* *************************************************************************
     Minor Tools
  */

  private  function getAuthentData( $grantType )
  {
    if( !( $grantType === 'password' || $grantType === 'refresh_token' ) )
    {
      $this->log( "Wrong grant type '" . $grantType . "' => expected 'password' or 'refresh_token'", Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }
    
    $accessData  = $this->getEnvAccessData( $this->tgtEnvName ) ;
    $authentData = $accessData[ 'authent'  ] ;
    $platformUrl = $this->getPlatformUrl() ;

    $data             = [
      'grant_type'      => $grantType,
      'client_id'       => $authentData[  'account' ][ 'data'      ][ 'client_id'     ],
      'client_secret'   => $authentData[  'account' ][ 'data'      ][ 'client_secret' ],
      'resource'        => $platformUrl,
    ] ;
    if( $grantType === 'password' )
    {
      $data[ 'username' ] = $authentData[ 'account' ][ 'adminUser' ][ 'username'      ] ;
      $data[ 'password' ] = $authentData[ 'account' ][ 'adminUser' ][ 'password'      ] ;
    }
    else
    {
      if( empty( $this->session ) )
      {
        $this->log( "Can't use grant type '" . $grantType . "' => expected a previous saved session available", Logger::LOG_WARN, __METHOD__ ) ;
        return null ;
      }
      $data[ 'refresh_token' ] = $this->session[ 'refreshToken' ] ;
    }

    return $data ;
  }

  private  function getAuthentUrl()
  {
    if( !empty( $this->session ) && array_key_exists( 'authentUrl', $this->session ) ) return $this->session[ 'authentUrl' ] ;
    
    $accessData       = $this->getEnvAccessData( $this->tgtEnvName ) ;
    $platformData     = $accessData[ 'platform' ] ;
    $authentData      = $accessData[ 'authent'  ] ;

    $tenantId           = $platformData[ 'tenantId'   ] ;
    $authentUrlPrefix   = $authentData[  'urlPrefix'  ] ;
    $authentUrlPostfix  = $authentData[  'urlPostfix' ] ;
    $authentUrl         = $authentUrlPrefix  . $tenantId     . $authentUrlPostfix  ;
    
    return $authentUrl ;
  }

  private  function getPlatformUrl()
  {
    if( !empty( $this->session ) && array_key_exists( 'platformUrl', $this->session ) ) return $this->session[ 'platformUrl' ] ;
    
    $accessData       = $this->getEnvAccessData( $this->tgtEnvName ) ;
    $platformData     = $accessData[ 'platform' ] ;

    $tenantName         = $platformData[ 'tenantName' ] ;
    $platformUrlPrefix  = $platformData[ 'urlPrefix'  ] ;
    $platformUrlPostfix = $platformData[ 'urlPostfix' ] ;
    $platformUrl        = $platformUrlPrefix . $tenantName   . $platformUrlPostfix ;

    return $platformUrl ;
  }

  private  function getAPIUrl()
  {
    if( !empty( $this->session ) && array_key_exists( 'apiUrl', $this->session ) ) return $this->session[ 'apiUrl' ] ;
    
    $accessData       = $this->getEnvAccessData( $this->tgtEnvName ) ;
    $platformData     = $accessData[ 'platform' ] ;

    $platformUrl        = $this->getPlatformUrl() ;
    $apiUrlPrefix       = $platformData[ 'apiPrefix'  ] ;
    $apiVersion         = $platformData[ 'apiVersion' ] ;
    $apiUrl             = $platformUrl       . $apiUrlPrefix . $apiVersion         ;

    return $apiUrl ;
  }


  /* SELECT entity fields string builder

       '$select=contactid,firstname,lastname,jobtitle,telephone1,mobilephone,emailaddress1,description'
  */
  private function  getSelect( $entityType, &$fields )
  {
    $res = '' ;
    if( empty( $fields ) || !is_array( $fields ) )
    {
      $this->log( "Invalid fields list to build a select : " . $fields, Logger::LOG_WARN, __METHOD__ ) ;
      return null ;
    }
    $res .= '$select=' ;
    $first = true ;
    foreach( $fields as $key => $val )
    {
      if( $first === true )
      {
        $first = false ;
      }
      else
      {
        $res .= ',' ;
      }
      $res .= $val ;
    }
    return $res ;
  }


  /* FILTER entity fields string builder
     
       $filter=contains(mobilephone,'06')                                 # operation = contains
       $filter=telephone1 eq '0547480043'                                 # operation = equals
       $filter=_customerid_value eq 76c8b845-aaeb-e711-a94d-000d3a209848  # operation = equalsraw
  */
  private function  getFilter( $field, $value, $operation )
  {
    if( empty( $field ) || empty( $value ) || empty( $operation ) )
    {
      $this->log( "Missing parameters to build filter : field='" . $field . "', value='" . $value . "', operation='" . $operation . "'", Logger::LOG_WARN, __METHOD__ ) ;
      return null ;
    }

    $res = '$filter=' ;
    switch( $operation )
    {
    case 'contains' :
      $res .= "contains(" ;
      $res .= $field ;
      $res .= ',' ;
      $res .= "'" . $value .  "'" ;
      $res .= ")" ;
      break ;
    case 'equals' :
      $res .= $field ;
      $res .= "%20eq%20" ;
      $res .= "'" ;
      $res .= $value ;
      $res .= "'" ;
      break ;
    case 'equalsraw' :
      $res .= $field ;
      $res .= "%20eq%20" ;
      $res .= $value ;
      break ;
    default :
      $res  = null ;
      break ;
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
    if( empty( $this->session ) ) return [] ;
    return [
      'Authorization: Bearer ' . $this->session[ 'accessToken' ],
      'Accept: application/json',
      'Content-Type: application/json; charset=utf-8',
      'OData-MaxVersion: 4.0',
      'OData-Version: 4.0',
    ] ;
  }

  private  function  getSavedSession()
  {
    if( !Resources::existsDefaultDataFile() ) return [] ;
    $this->session = Resources::readDefaultDataFile() ;
    $this->log( "Reading saved session '" . json_encode( $this->session ) . "'", Logger::LOG_INFOP, __METHOD__ ) ;
    return $this->session ;
  }

  private  function  saveSession( $accessToken, $refreshToken )
  {
    if( empty( $this->session ) )
    {
      $this->session[ 'platformUrl'  ] = $this->getPlatformUrl() ;
      $this->session[ 'apiUrl'       ] = $this->getAPIUrl()      ;
      $this->session[ 'authentUrl'   ] = $this->getAuthentUrl()  ;
    }
    $this->session[   'accessToken'  ] = $accessToken ;
    $this->session[   'refreshToken' ] = $refreshToken ;

    $this->log( "Saving session  '" . json_encode( $this->session ) . "'", Logger::LOG_INFOP, __METHOD__ ) ;
    Resources::writeDefaultDataFile( $this->session ) ;
  }
}
?>
