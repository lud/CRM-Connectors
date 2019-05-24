<?php

namespace UserFiles\Connectors\KConnectorGenericSampleDynamics ;


require_once __DIR__ . "/KConnectorGenericSampleDynamics.php" ;

use Kiamo\Bundle\AdminBundle\Utility\Connectors\ParameterBag ;


class CommandLineTester
{
  const Verb          = 'test' ;


  public    function __construct()
  {
    $this->defineTestFunctions() ;
    if( $this->setTestId() ) $this->run() ;
  }

  
  private  function defineTestFunctions()
  {
    $this->testFunctions = [] ;

    $this->testFunctions[ 'test00' ] = [
      'purpose'  => 'Void execution',
      'function' => function()
      {
        echo "Do nothing...\n" ;
      } 
    ] ;

    $this->testFunctions[ 'test01' ] = [
      'purpose'  => 'authenticate',
      'function' => function()
      {
        $force   = true ;
        $session = $this->connector->interactionMgr->authenticate( $force ) ;
        echo "Session : " . json_encode( $session ) . "\n" ;
      } 
    ] ;

    $this->testFunctions[ 'test02' ] = [
      'purpose'  => 'get urls',
      'function' => function()
      {
        $authUrl = $this->connector->interactionMgr->getAuthentUrl() ;
        $platUrl = $this->connector->interactionMgr->getPlatformUrl() ;
        $apisUrl = $this->connector->interactionMgr->getAPIUrl() ;
        echo "URL Authent  : " . $authUrl . "\n" ;
        echo "URL Platform : " . $platUrl . "\n" ;
        echo "URL API      : " . $apisUrl . "\n" ;
      } 
    ] ;

    $this->testFunctions[ 'test03' ] = [
      'purpose'  => 'get authent data',
      'function' => function()
      {
        $authData = $this->connector->interactionMgr->getAuthentData( 'refresh_token' ) ;
        echo "Data Authent  : " . json_encode( $authData, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;

    $this->testFunctions[ 'test04' ] = [
      'purpose'  => 'wsGet',
      'function' => function()
      {
        $request = 'contacts?$select=contactid,salutation,firstname,lastname,jobtitle,telephone1,mobilephone,emailaddress1,_parentcustomerid_value,description,address1_line1,address1_postalcode,address1_city&$filter=contains(mobilephone,' . "'06')" ;
        $request = 'contacts(xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx)?$select=contactid,firstname,lastname,jobtitle,telephone1,mobilephone,emailaddress1,description' ;
        $request = 'contacts(xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx)' ;
        $res     = $this->connector->interactionMgr->wsGet( $request ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test05' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type  = 'contacts' ;
        $id    = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' ;
        $res   = $this->connector->interactionMgr->getSingleEntry( $type, $id ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test06' ] = [
      'purpose'  => 'getEntriesList',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "contacts" ;
        $field      = "mobilephone" ;
        $value      = "06xxxxxxxx" ;
        $value      = "06" ;
        //$value      = "066666666" ;
        $operation  = "contains" ;
        $fields     = [ 'contactid', 'salutation', 'firstname', 'lastname', 'jobtitle', 'telephone1', 'mobilephone', 'emailaddress1', '_parentcustomerid_value', 'description', 'address1_line1', 'address1_postalcode', 'address1_city' ] ;
        $res        = $this->connector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test07' ] = [
      'purpose'  => 'getPackagedEntry',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "contacts" ;
        $field      = "mobilephone" ;
        $value      = "06xxxxxxxx" ;
        $value      = "06" ;
        //$value      = "066666666" ;
        $operation  = "contains" ;
        $fields     = [ 'contactid', 'salutation', 'firstname', 'lastname', 'jobtitle', 'telephone1', 'mobilephone', 'emailaddress1', '_parentcustomerid_value', 'description', 'address1_line1', 'address1_postalcode', 'address1_city' ] ;
        $res        = $this->connector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        $ret        = $this->connector->entitiesMgr->getPackagedEntry( $type, $res[0] ) ;
        echo "Return : \n" . json_encode( $ret, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test08' ] = [
      'purpose'  => 'getEntryInstance',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "contacts" ;
        $field      = "mobilephone" ;
        $value      = "06xxxxxxxx" ;
        $value      = "06" ;
        //$value      = "066666666" ;
        $operation  = "contains" ;
        $fields     = [ 'contactid', 'salutation', 'firstname', 'lastname', 'jobtitle', 'telephone1', 'mobilephone', 'emailaddress1', '_parentcustomerid_value', 'description', 'address1_line1', 'address1_postalcode', 'address1_city' ] ;
        $res        = $this->connector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        $ret        = $this->connector->entitiesMgr->getEntryInstance( $type, $res[0] ) ;
        echo "Return : \n" . gettype( $ret ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test09' ] = [
      'purpose'  => 'getEntriesCollection (several res)',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "contacts" ;
        $field      = "mobilephone" ;
        $value      = "06xxxxxxxx" ;
        $value      = "06" ;
        //$value      = "066666666" ;
        $operation  = "contains" ;
        $fields     = [ 'contactid', 'salutation', 'firstname', 'lastname', 'jobtitle', 'telephone1', 'mobilephone', 'emailaddress1', '_parentcustomerid_value', 'description', 'address1_line1', 'address1_postalcode', 'address1_city' ] ;
        $res        = $this->connector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        $ret        = $this->connector->entitiesMgr->getEntriesCollection( $type, $res ) ;
        echo "Return : \n" . gettype( $ret ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test10' ] = [
      'purpose'  => 'findContactById',
      'function' => function()
      {
        $id         = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" ;
        $res        = $this->connector->findContactById( $id ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test11' ] = [
      'purpose'  => 'findOneContact',
      'function' => function()
      {
        $specialParameter                    = '' ;
        $context                             = [] ;
        $context[ 'CustNumber' ]             = "xxxxxxxxxx" ;
        $pb                                  = new ParameterBag( $specialParameter, $context ) ;
        $res                                 = $this->connector->findOneContact( $pb ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test12' ] = [
      'purpose'  => 'findContactsByQuery',
      'function' => function()
      {
        $query = "xxxxxxxxxx" ;
        $query = "01xxxxxxxx" ;
        $pb    = new ParameterBag() ;
        $res   = $this->connector->findContactsByQuery( $query, $pb ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test13' ] = [
      'purpose'  => 'findTicketsByQuery',
      'function' => function()
      {
        $query = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" ;
        $pb    = new ParameterBag() ;
        $res   = $this->connector->findTicketsByQuery( $query, $pb ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test14' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type  = 'incidents' ;
        $id    = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' ;
        $res   = $this->connector->interactionMgr->getSingleEntry( $type, $id ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test15' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type  = 'accounts' ;
        $id    = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' ;
        $res   = $this->connector->interactionMgr->getSingleEntry( $type, $id ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test16' ] = [
      'purpose'  => 'getEntityType',
      'function' => function()
      {
        $type = 'incidents' ;
        $res  = $this->connector->entitiesMgr->getEntityType( $type ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    /* Test function pattern
    $this->testFunctions[ 'testXX' ] = [
      'purpose'  => '',
      'function' => function()
      {
      }
    ] ;
    */
  }

  private  function usage()
  {
    echo "\n" ;
    echo "Usage\n" ;
    echo "-----\n" ;
    echo '> php CommandLineTester.php -f --test="<testId>"' . "\n" ;
    echo '  ==> execution du test <testId>.' . "\n" ;
  }

  private  function setTestId()
  {
    $this->testId = -1 ;
    $args   = getopt( null, [ self::Verb . ":" ] ) ;
    if( !array_key_exists( self::Verb, $args ) )
    {
      $this->usage() ;
      return false ;
    }
    $this->testId           = $args[ self::Verb ] ;
    if( strlen( $this->testId ) == 1 ) $this->testId = '0' . $this->testId ;
    $this->testFunctionName = self::Verb . $this->testId ;
    if( !array_key_exists( $this->testFunctionName, $this->testFunctions ) )
    {
      echo "\n" ;
      echo "ERROR : no such test '" . $this->testFunctionName . "'...\n" ;
      echo "==> Exit." ;
      echo "\n" ;
      return false ;
    }
    return true ;
  }
  
  private  function run()
  {
    echo 'Test #' . $this->testId . " : '" . $this->testFunctions[ $this->testFunctionName ][ 'purpose' ] . "'\n---\n" ;
    $this->connector = new KConnectorGenericSampleDynamics() ;

    call_user_func( $this->testFunctions[ $this->testFunctionName ][ 'function' ] ) ;
  }
}

// Usage example :
// > php CommandLineTester.php -f --test=10
new CommandLineTester() ;
?>
