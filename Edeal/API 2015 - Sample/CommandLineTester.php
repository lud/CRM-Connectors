<?php

namespace UserFiles\Connectors\KConnectorGenericSampleEDeal ;


require_once __DIR__ . "/KConnectorGenericSampleEDeal.php" ;

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
        $sessionToken = $this->connector->interactionMgr->authenticate( $force ) ;
        echo "Session token : " . $sessionToken . "\n" ;
      } 
    ] ;

    $this->testFunctions[ 'test02' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type    = 'contact' ;
        $etype   = $this->connector->entitiesMgr->getEntityType( $type ) ;
        $id      = '000000000053c5c2' ;
        $efields = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res     = $this->connector->interactionMgr->getSingleEntry( $etype, $id, $efields ) ;
        var_dump( $res ) ;
        echo "Result : \n" . $res[3] . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test03' ] = [
      'purpose'  => 'getEntriesList',
      'function' => function()
      {
        $type       = "contact" ;
        $etype      = $this->connector->entitiesMgr->getEntityType(  $type ) ;
        $field      = 'phone' ;
        $efield     = $this->connector->entitiesMgr->getEntityField( $type, $field ) ;
        $value      = "05 47 48 00 00" ;
        //$value      = "05 47 48" ;
        $operation  = "like" ;
        $efields    = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res        = $this->connector->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
        var_dump( $res ) ;
      }
    ] ;

    $this->testFunctions[ 'test04' ] = [
      'purpose'  => 'getPackagedEntry',
      'function' => function()
      {
        $type       = "contact" ;
        $etype      = $this->connector->entitiesMgr->getEntityType(  $type ) ;
        $field      = 'phone' ;
        $efield     = $this->connector->entitiesMgr->getEntityField( $type, $field ) ;
        $value      = "05 47 48 00 00" ;
        //$value      = "05 47 48" ;
        $operation  = "like" ;
        $efields    = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res        = $this->connector->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
        var_dump( $res ) ;
        $ret        = $this->connector->entitiesMgr->getPackagedEntry( $type, $res[0][ 'item' ] ) ;
        //var_dump( $ret ) ;
        echo "Return : \n" . json_encode( $ret, JSON_PRETTY_PRINT ) . "\n" ;
        //echo "Return : \n" . $this->connector->entitiesMgr->getPackagedEntryStr( $ret ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test05' ] = [
      'purpose'  => 'getEntryInstance',
      'function' => function()
      {
        $type       = "contact" ;
        $etype      = $this->connector->entitiesMgr->getEntityType(  $type ) ;
        $field      = 'phone' ;
        $efield     = $this->connector->entitiesMgr->getEntityField( $type, $field ) ;
        $value      = "05 47 48 00 00" ;
        //$value      = "05 47 48" ;
        $operation  = "like" ;
        $efields    = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res        = $this->connector->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
        var_dump( $res ) ;
        $ret        = $this->connector->entitiesMgr->getEntryInstance( $type, $res[0][ 'item' ] ) ;
        echo "Return : \n" . gettype( $ret ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test06' ] = [
      'purpose'  => 'getEntriesCollection (several res)',
      'function' => function()
      {
        $type       = "contact" ;
        $etype      = $this->connector->entitiesMgr->getEntityType(  $type ) ;
        $field      = 'phone' ;
        $efield     = $this->connector->entitiesMgr->getEntityField( $type, $field ) ;
        //$value      = "05 47 48 00 00" ;
        $value      = "05 47 48" ;
        $operation  = "like" ;
        $efields    = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res        = $this->connector->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
        var_dump( $res ) ;
        $ret        = $this->connector->entitiesMgr->getEntriesCollection( $type, $res ) ;
        echo "Return : \n" . gettype( $ret ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test07' ] = [
      'purpose'  => 'findContactById',
      'function' => function()
      {
        $id         = "000000000053c5c2" ;
        $res        = $this->connector->findContactById( $id ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test08' ] = [
      'purpose'  => 'findOneContact',
      'function' => function()
      {
        $specialParameter                    = '' ;
        $context                             = [] ;
        $context[ 'CustNumber' ]             = "0547480000" ;
        $pb                                  = new ParameterBag( $specialParameter, $context ) ;
        $res                                 = $this->connector->findOneContact( $pb ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;


    $this->testFunctions[ 'test09' ] = [
      'purpose'  => 'findContactsByQuery',
      'function' => function()
      {
        $query = "becq" ;
        $query = "05 47 48" ;
        $pb    = new ParameterBag() ;
        $res   = $this->connector->findContactsByQuery( $query, $pb ) ;
        //echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
        echo "Return : \n" . gettype( $res ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test10' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type    = 'company' ;
        $etype   = $this->connector->entitiesMgr->getEntityType( $type ) ;
        $id      = '0000000000004fc4' ;
        $efields = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res     = $this->connector->interactionMgr->getSingleEntry( $etype, $id, $efields ) ;
        var_dump( $res ) ;
      }
    ] ;

    $this->testFunctions[ 'test11' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type    = 'ticket' ;
        $etype   = $this->connector->entitiesMgr->getEntityType( $type ) ;
        $id      = '0000000000687814' ;
        $efields = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res     = $this->connector->interactionMgr->getSingleEntry( $etype, $id, $efields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;

    $this->testFunctions[ 'test12' ] = [
      'purpose'  => 'findCustomer',
      'function' => function()
      {
        $type       = "customer" ;
        $etype      = $this->connector->entitiesMgr->getEntityType(  $type ) ;
        $field      = 'contactId' ;
        $efield     = $this->connector->entitiesMgr->getEntityField( $type, $field ) ;
        $value      = "000000000053c5c2" ;
        $operation  = "like" ;
        $efields    = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res        = $this->connector->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
        var_dump( $res ) ;
      }
    ] ;

    $this->testFunctions[ 'test13' ] = [
      'purpose'  => 'findTicket',
      'function' => function()
      {
        $type       = "ticket" ;
        $etype      = $this->connector->entitiesMgr->getEntityType(  $type ) ;
        $field      = 'customerIds' ;
        $efield     = $this->connector->entitiesMgr->getEntityField( $type, $field ) ;
        //$value      = "000000000067c5c4" ;
        //$value      = "000000000067ebca" ;
        //$value      = "0000000000686d15" ;
        $value      = "0000000000687803" ;
        $operation  = "like" ;
        $efields    = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $res        = $this->connector->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
        var_dump( $res ) ;
      }
    ] ;

    $this->testFunctions[ 'test14' ] = [
      'purpose'  => 'custom::getCustomers',
      'function' => function()
      {
        $field      = 'contactId' ;
        $value      = "000000000053c5c2" ;
        $data       = [
          'field'     => $field,
          'value'     => $value,
        ] ;
        $res        = $this->connector->customizationMgr->getCustomers( $data ) ;
        var_dump( $res ) ;
      }
    ] ;

    $this->testFunctions[ 'test15' ] = [
      'purpose'  => 'findEntriesBySearchPattern',
      'function' => function()
      {
        $type              = 'ticket' ;
        $value             = "000000000053c5c2" ;
        $searchPatternItem = [ 'varName' =>                'CCKContactId', 'entityField' =>   'contactId', 'operation' =>    'equals',
                               'preTrt'  =>                'getCustomers', 'eligibility' =>            '', 'postTrt'   =>          '' ] ;
        $res               = $this->connector->findEntriesBySearchPattern( $type, $value, $searchPatternItem ) ;
        var_dump( $res ) ;
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
    $this->connector = new KConnectorGenericSampleEDeal() ;

    call_user_func( $this->testFunctions[ $this->testFunctionName ][ 'function' ] ) ;
  }
}

// Usage example :
// > php CommandLineTester.php -f --test=10
new CommandLineTester() ;
?>
