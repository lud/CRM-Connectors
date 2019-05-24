<?php

namespace UserFiles\Connectors\KConnectorGenericSampleSalesforce ;


require_once __DIR__ . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "autoload.php" ;


use KiamoConnectorSampleTools\ConfManager ;
use KiamoConnectorSampleTools\Logger      ;
use KiamoConnectorSampleTools\SubModule   ;


class CustomizationManager extends SubModule
{
  public   function __construct( $_parent )  // The _parent must be a module
  {
    parent::__construct( $_parent, get_class( $_parent ), ConfManager::UserConfType ) ;
  }


  /* *************************************************************************
     Main
  */

  /* **********************************
     Eligibility Tools
  */

  // Could be : Id
  // ---
  public   function couldBeId( $val )
  {
    // At least one character
    if( empty( $val ) ) return false ;
    // Nothing but alphanums
    return empty( preg_replace( '/[0-9A-Za-z]/', '', $val ) ) ;
  }

  // Could be : Phone
  // ---
  public   function couldBePhone( $val )
  {
    // At least one digit
    if( !preg_match( '/\d/', $val ) ) return false ;
    // Nothing but digits and allowed characters
    return empty( preg_replace( '/[0-9()\[\]+-. ]/', '', $val ) ) ;
  }

  // Could be : Email
  // ---
  public   function couldBeEmail( $val )
  {
    // Note : filter_var is not powerful ; only ok for simple emails.
    return !empty( filter_var( $val, FILTER_VALIDATE_EMAIL ) ) ;
  }

  // Could be : Global
  // ---
  public   function couldBe( $type, $val )
  {
    $res = true ;
    switch( $type )
    {
    case 'id' :
      $res = $this->couldBeId( $val ) ;
      break ;
    case 'phone'  :
    case 'mobile' :
      $res = $this->couldBePhone( $val ) ;
      break ;
    case 'email' :
      $res = $this->couldBeEmail( $val ) ;
      break ;
    default :
      break ;
    }
    return $res ;
  }

  
  /* **********************************
     Pre-treatment Tools
  */

  // Inject In Phone Number
  // ---
  // data : the phone number string to treat
  public   function injectInPhoneNumber( $data, $additionalData = [ 'char' => ' ' ] )
  {
    if( ( strlen( $data ) == 10 ) and ( $data[0] == '0' ) )
    {
      $tmpSplit = str_split( $data, 2 ) ;
      $res = implode( $additionalData[ 'char' ], $tmpSplit ) ;
      return $res ;
    }
    return $data ;
  }


  public   function getRawPhoneNumber( $data, $additionalData = [ 'char' => ' ' ] )
  {
    if( ( strlen( $data ) == 10 ) and ( $data[0] == '0' ) )
    {
      $res = $data ;  // Actually, do nothing (tests purpose)
      return $res ;
    }
    return $data ;
  }


  /* **********************************
     Get One Of Tools
  */

  public   function pickLastItem( $resultsArray )
  {
    return end( $resultsArray ) ;
  }



  /* *************************************************************************
     Main Tools
  */


  /* *************************************************************************
     Internal Tools
  */
}
?>
