<?php
namespace UserFiles\Connectors\KCRMSampleSalesforce ;

define( "CONNECTOR", "KCRMSampleSalesforce" ) ;


/**/
// Kiamo v6.x : CRM Connectors Utilities
// -----

// Utilities
use Kiamo\Bundle\AdminBundle\Utility\Connectors\ParameterBag                                    ;
/**/


/*
// Kiamo v7.x : CRM Connectors Utilities
// -----

// Utilities
use Kiamo\Admin\Utility\Connectors\ParameterBag                                    ;
*/

require_once __DIR__ . "/" . CONNECTOR . ".php" ;


class CommandLineTester
{
  const Verb = 'test' ;


  public    function __construct()
  {
    $connectorClass = "UserFiles\\Connectors\\" . CONNECTOR . "\\" . CONNECTOR ;
    $this->connector = new $connectorClass() ;
    $this->defineTestFunctions() ;
    if( $this->setTestId() ) $this->run() ;
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
    call_user_func( $this->testFunctions[ $this->testFunctionName ][ 'function' ] ) ;
  }


  // Test Functions
  // ---
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

    $this->testFunctions[ 'test02' ] = [
      'purpose'  => 'Test Connector conf Access',
      'function' => function()
      {
        $k = 'accessdata.platform.apiVersion' ;
        $v = $this->connector->getConf( "access", $k ) ;

        echo "k=" . $k . ", v=" . $v . "\n" ;
      } 
    ] ;
    
    $this->testFunctions[ 'test03' ] = [
      'purpose'  => 'Test Salesforce Authentication',
      'function' => function()
      {
        $st = $this->connector->interactionMgr->authenticate() ;
        echo "sessionToken = " . $st . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test04' ] = [
      'purpose'  => 'Test Salesforce Query Build',
      'function' => function()
      {
        $entityType = "Account" ;
        $field      = 'Phone' ;
        $value      = 'xxxxxxxxxx' ;
        $operation  = 'like' ;
        $fields     = [ 'Id','Name','Description','NumberOfEmployees','Phone','Website','BillingStreet','BillingPostalCode','BillingCity' ] ;
        $query      = $this->connector->interactionMgr->getQuery( $entityType, $field, $value, $operation, $fields ) ;
        echo "query = " . $query . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test05' ] = [
      'purpose'  => 'Test Salesforce Query Entries List (automatic authentication)',
      'function' => function()
      {
        $entityType = "Contact" ;
        $field      = 'FirstName' ;
        $value      = 'xxxxxxxxxxxxx' ;
        $operation  = 'like' ;
        $fields     = [ 'Id','FirstName','LastName','Phone','Email','AccountId' ] ;
        $res        = $this->connector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "res = " . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test06' ] = [
      'purpose'  => 'Test Salesforce Query Single Entry by Id (automatic authentication)',
      'function' => function()
      {
        $entityType = "Contact" ;
        $id         = "xxxxxxxxxxxxxxxxx" ;
        $entry      = $this->connector->interactionMgr->getSingleEntry( $entityType, $id ) ;
        echo "entry = " . json_encode( $entry, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test07' ] = [
      'purpose'  => 'Test Entities Manager getEntryLabel',
      'function' => function()
      {
        $entityType = "Contact" ;
        $id         = "xxxxxxxxxxxxxxxxxx" ;
        $entry      = $this->connector->interactionMgr->getSingleEntry( $entityType, $id ) ;

        $type       = $this->connector->entitiesMgr->getEntityType( $entityType ) ;
        $label      = $this->connector->entitiesMgr->getEntryLabel( $type, $entry ) ;
        echo "label = " . json_encode( $label, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test08' ] = [
      'purpose'  => 'Test Entities Manager getEntryInstance',
      'function' => function()
      {
        $entityType = "Contact" ;
        $id         = "xxxxxxxxxxxxxxxxxx" ;
        $entry      = $this->connector->interactionMgr->getSingleEntry( $entityType, $id ) ;

        $type       = $this->connector->entitiesMgr->getEntityType( $entityType ) ;
        $pentry     = $this->connector->entitiesMgr->getPackagedEntry( $type, $entry ) ;
        echo "entry = " . json_encode( $pentry, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test09' ] = [
      'purpose'  => 'Test Connector find Entry by id',
      'function' => function()
      {
        $entityType = "contact" ;
        $id         = "xxxxxxxxxxxxxxxxxx" ;
        $entry      = $this->connector->findEntryById( $entityType, $id ) ;

        if( $entry === null ) echo "! NO entry found for id=" . $id . "\n" ;
        else                  echo "OK : entry found for id=" . $id . " (see logs)\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test10' ] = [
      'purpose'  => 'Test Connector find Entry by query',
      'function' => function()
      {
        $entityType = "contact" ;
        $queryVal   = "xxxxxxxxxx" ;
        $entry      = $this->connector->findEntriesByQuery( $entityType, $queryVal ) ;

        if( $entry === null ) echo "! NO entry found for query=" . $queryVal . "\n" ;
        else                  echo "OK : entry found for query=" . $queryVal . " (see logs)\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test11' ] = [
      'purpose'  => 'Test Connector find One Entry (by ParameterBag)',
      'function' => function()
      {
        $entityType   = "contact" ;
        $pbParameter  = '' ;
        $pbContext    = [
          //'CCKContactId' => 'xxxxxxxxxxxxxxxxxxxxx',
          'CustNumber'   => 'xxxxxxxxxx',
        ] ;
        $parameterBag = new ParameterBag( $pbParameter, $pbContext ) ;
        $entry      = $this->connector->findOneEntry( $entityType, $parameterBag ) ;

        if( $entry === null ) echo "! NO entry found for parameterBag=" . json_encode( $pbContext ) . "\n" ;
        else                  echo "OK : entry found for parameterBag=" . json_encode( $pbContext ) . " (see logs)\n" ;
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

}

// Usage example :
// > php CommandLineTester.php -f --test=00
new CommandLineTester() ;
?>
