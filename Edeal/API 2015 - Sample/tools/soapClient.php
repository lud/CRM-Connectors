<?php

namespace KiamoConnectorSampleTools ;


require_once( __DIR__ . DIRECTORY_SEPARATOR . '/nusoap-0.9.5/nusoap.php' ) ;
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'logger.php'               ) ;

use KiamoConnectorSampleTools\Logger      ;


/***********************************************
  Soap Client
  */

// NuSoap version
class SoapClient
{
  public   function __construct( $_parent, $wsdl, $_namespace )
  {
    $this->_parent    = $_parent ;
    $this->wsdl       = $wsdl ;
    $this->_namespace = $_namespace ;

    $this->_parent->log( "INIT : WSDL = '" . $this->wsdl . "'", Logger::LOG_INFO, __METHOD__ ) ;

    $this->client = new \nusoap_client( $this->wsdl, false ) ;

    $this->_parent->log( 'INIT : OK', $level = Logger::LOG_INFO, __METHOD__ ) ;
  }
  
  public function __destruct()
  {
  }

  public function call( $functionName, $parameters, $inputHeaders = null, &$outputHeaders = null )
  {
    $res = null ;
    try
    {
      $this->_parent->log( "Calling ws='" . $functionName . "' with params='" . json_encode( $parameters ) . "'", Logger::LOG_VERBOSE, __METHOD__ ) ;
      $res = $this->client->call( $functionName, $parameters, $this->_namespace, $this->_namespace ) ;
    }
    catch( Exception $e )
    {
      $this->_parent->log( "CALL EXCEPTION ! : " . $e->getTraceAsString(), Logger::LOG_ERR, __METHOD__ ) ;
    }
    return $res ;
  }
}
?>
