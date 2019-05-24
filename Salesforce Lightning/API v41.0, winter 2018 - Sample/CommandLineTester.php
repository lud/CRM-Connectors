<?php

namespace UserFiles\Connectors\KConnectorGenericSampleSalesforce ;


require_once __DIR__ . "/KConnectorGenericSampleSalesforce.php" ;

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
        $force        = true ;
        $sessionToken = $this->sfConnector->interactionMgr->authenticate( $force ) ;
        echo "Session token : " . $sessionToken . "\n" ;
      } 
    ] ;

    $this->testFunctions[ 'test02' ] = [
      'purpose'  => 'wsGet',
      'function' => function()
      {
        $request = 'query?q=' . rawurlencode( "SELECT Id,Title,FirstName,LastName,Salutation,Phone,MobilePhone,Email,AccountId,MailingStreet,MailingPostalCode,MailingCity,LastViewedDate from Contact where Phone like '%0547480000%'" ) ;
        $res = $this->sfConnector->interactionMgr->wsGet( $request ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test03' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type  = 'Contact' ;
        $id    = '0030Y00000jY4lPQAS' ;
        $res   = $this->sfConnector->interactionMgr->getSingleEntry( $type, $id ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test04' ] = [
      'purpose'  => 'getEntriesListByQuery',
      'function' => function()
      {
        $query = "SELECT Id,Title,FirstName,LastName,Salutation,Phone,MobilePhone,Email,AccountId,MailingStreet,MailingPostalCode,MailingCity,LastViewedDate from Contact where Phone like '%054748004%'" ;
        $res   = $this->sfConnector->interactionMgr->getEntriesListByQuery( $query ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test05' ] = [
      'purpose'  => 'getEntriesList',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "Contact" ;
        $field      = "Phone" ;
        $value      = "0547480000" ;
        $operation  = "like" ;
        $fields     = [ 'Id', 'Title', 'FirstName', 'LastName', 'Salutation', 'Phone', 'MobilePhone', 'Email', 'AccountId', 'MailingStreet', 'MailingPostalCode', 'MailingCity','LastViewedDate' ] ;
        $res        = $this->sfConnector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test06' ] = [
      'purpose'  => 'getPackagedEntry',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "Contact" ;
        $field      = "Phone" ;
        $value      = "0547480000" ;
        $operation  = "like" ;
        $fields     = [ 'Id', 'Title', 'FirstName', 'LastName', 'Salutation', 'Phone', 'MobilePhone', 'Email', 'AccountId', 'MailingStreet', 'MailingPostalCode', 'MailingCity','LastViewedDate' ] ;
        $res        = $this->sfConnector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        $ret        = $this->sfConnector->entitiesMgr->getPackagedEntry( $type, $res[0] ) ;
        echo "Return : \n" . json_encode( $ret, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test07' ] = [
      'purpose'  => 'getEntryInstance',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "Contact" ;
        $field      = "Phone" ;
        $value      = "0547480000" ;
        $operation  = "like" ;
        $fields     = [ 'Id', 'Title', 'FirstName', 'LastName', 'Salutation', 'Phone', 'MobilePhone', 'Email', 'AccountId', 'MailingStreet', 'MailingPostalCode', 'MailingCity','LastViewedDate' ] ;
        $res        = $this->sfConnector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        $ret        = $this->sfConnector->entitiesMgr->getEntryInstance( $type, $res[0] ) ;
        echo "Return : \n" . gettype( $ret ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test08' ] = [
      'purpose'  => 'getEntriesCollection (several res)',
      'function' => function()
      {
        $type       = "contact" ;
        $entityType = "Contact" ;
        $field      = "Phone" ;
        $value      = "054748004" ;
        $operation  = "like" ;
        $fields     = [ 'Id', 'Title', 'FirstName', 'LastName', 'Salutation', 'Phone', 'MobilePhone', 'Email', 'AccountId', 'MailingStreet', 'MailingPostalCode', 'MailingCity','LastViewedDate' ] ;
        $res        = $this->sfConnector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        $ret        = $this->sfConnector->entitiesMgr->getEntriesCollection( $type, $res ) ;
      }
    ] ;

    $this->testFunctions[ 'test09' ] = [
      'purpose'  => 'findContactById',
      'function' => function()
      {
        $id         = "0031n00001sqQCrAAM" ;
        $res        = $this->sfConnector->findContactById( $id ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test10' ] = [
      'purpose'  => 'findOneContact',
      'function' => function()
      {
        $specialParameter                    = '' ;
        $context                             = [] ;
        $context[ 'CustNumber' ]             = "054748004" ;
        $pb                                  = new ParameterBag( $specialParameter, $context ) ;
        $res                                 = $this->sfConnector->findOneContact( $pb ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;


    $this->testFunctions[ 'test11' ] = [
      'purpose'  => 'findContactsByQuery',
      'function' => function()
      {
        $query = "054748004" ;
        $pb    = new ParameterBag() ;
        $res   = $this->sfConnector->findContactsByQuery( $query, $pb ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test12' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type  = 'Case' ;
        $id    = '5000Y00000dHW6fQAG' ;
        $res   = $this->sfConnector->interactionMgr->getSingleEntry( $type, $id ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test13' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type  = 'Account' ;
        $id    = '0010Y00000rvhDCQAY' ;
        $res   = $this->sfConnector->interactionMgr->getSingleEntry( $type, $id ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test14' ] = [
      'purpose'  => 'getEntityType',
      'function' => function()
      {
        $type = 'Case' ;
        $res  = $this->sfConnector->entitiesMgr->getEntityType( $type ) ;
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
    $this->sfConnector = new KConnectorGenericSampleSalesforce() ;

    call_user_func( $this->testFunctions[ $this->testFunctionName ][ 'function' ] ) ;
  }
}

// Usage example :
// > php CommandLineTester.php -f --test=10
new CommandLineTester() ;
?>
