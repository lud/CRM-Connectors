<?php

set_error_handler(          "errorHandler"    ) ;
register_shutdown_function( "shutdownHandler" ) ;

$ErrLabelArr = [
  E_ERROR             => "FATAL",
  E_CORE_ERROR        => "FATAL",
  E_COMPILE_ERROR     => "FATAL",
  E_PARSE             => "FATAL",
  E_USER_ERROR        => "ERROR",
  E_RECOVERABLE_ERROR => "ERROR",
  E_WARNING           => "WARN_",
  E_CORE_WARNING      => "WARN_",
  E_COMPILE_WARNING   => "WARN_",
  E_USER_WARNING      => "WARN_",
  E_NOTICE            => "_INFO",
  E_USER_NOTICE       => "_INFO",
  E_STRICT            => "DEBUG",
  "KNONE"             => "     ",
] ;

/**/
// Kiamo v6.x : CRM Connectors Utilities
// -----

const KIAMO_ROOT            = __DIR__ . "/../../../../" ;
const KIAMO_CONNECTOR_TOOLS = KIAMO_ROOT . "www/Symfony/src/Kiamo/Bundle/AdminBundle/Utility/Connectors/" ;
if( !is_dir( KIAMO_CONNECTOR_TOOLS ) )
{
  echo "ERROR : Unable to find the path to the Kiamo Connector Utilities.<br/>==> Please manually setup this path in the 'ConnectorSimpleChecker/index.php' file." ;
  exit ;
}

require_once KIAMO_CONNECTOR_TOOLS . "ParameterBag.php"                                    ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityInstance.php"                         ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityInstanceCollection.php"               ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityField.php"                            ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityLayout.php"                           ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorInterface.php"              ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactInterface.php"       ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactUrlInterface.php"    ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactSearchInterface.php" ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanyInterface.php"       ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanyUrlInterface.php"    ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanySearchInterface.php" ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketInterface.php"        ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketUrlInterface.php"     ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketSearchInterface.php"  ;


// Utilities
use Kiamo\Bundle\AdminBundle\Utility\Connectors\ParameterBag                                    ;

// Entities
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityInstance                         ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityInstanceCollection               ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityField                            ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityLayout                           ;

// Interfaces
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorInterface              ;

// Interfaces : Contact
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorContactInterface       ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorContactUrlInterface    ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorContactSearchInterface ;

// Interface : Company
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorCompanyInterface       ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorCompanyUrlInterface    ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorCompanySearchInterface ;

// Interface : Ticket
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorTicketInterface        ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorTicketUrlInterface     ;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorTicketSearchInterface  ;
/**/


/*
// Kiamo v7.x : CRM Connectors Utilities
// -----

const KIAMO_ROOT            = __DIR__ . "/../../../../" ;
const KIAMO_CONNECTOR_TOOLS = KIAMO_ROOT . "www/Symfony/src/Kiamo/Admin/Utility/Connectors/" ;
if( !is_dir( KIAMO_CONNECTOR_TOOLS ) )
{
  echo "ERROR : Unable to find the path to the Kiamo Connector Utilities.<br/>==> Please manually setup this path in the 'ConnectorSimpleChecker/index.php' file." ;
  exit ;
}

require_once KIAMO_CONNECTOR_TOOLS . "ParameterBag.php"                                    ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityInstance.php"                         ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityInstanceCollection.php"               ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityField.php"                            ;
require_once KIAMO_CONNECTOR_TOOLS . "Entities/EntityLayout.php"                           ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorInterface.php"              ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactInterface.php"       ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactUrlInterface.php"    ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorContactSearchInterface.php" ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanyInterface.php"       ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanyUrlInterface.php"    ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorCompanySearchInterface.php" ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketInterface.php"        ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketUrlInterface.php"     ;
require_once KIAMO_CONNECTOR_TOOLS . "Interfaces/KiamoConnectorTicketSearchInterface.php"  ;


// Utilities
use Kiamo\Admin\Utility\Connectors\ParameterBag                                    ;

// Entities
use Kiamo\Admin\Utility\Connectors\Entities\EntityInstance                         ;
use Kiamo\Admin\Utility\Connectors\Entities\EntityInstanceCollection               ;
use Kiamo\Admin\Utility\Connectors\Entities\EntityField                            ;
use Kiamo\Admin\Utility\Connectors\Entities\EntityLayout                           ;

// Interfaces
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorInterface              ;

// Interfaces : Contact
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorContactInterface       ;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorContactUrlInterface    ;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorContactSearchInterface ;

// Interface : Company
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorCompanyInterface       ;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorCompanyUrlInterface    ;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorCompanySearchInterface ;

// Interface : Ticket
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorTicketInterface        ;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorTicketUrlInterface     ;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorTicketSearchInterface  ;
*/


if( !isset( $_GET[ 'name' ] ) )
{
  echo "Usage : &lt;URL&gt;?name=&lt;ConnectorName&gt;'<br/>" ;
  exit ;
}

$errorFound = 0 ;

$connectorName = $_GET[ 'name' ] ;
echo "Connector : '" . $connectorName . "'<br/>" ;
echo "<br/>" ;

$connectorPath = __DIR__ . '/../../class/Connectors/' . $connectorName ;
require_once $connectorPath . '/' . $connectorName . '.php' ;

$connectorClass = '\\UserFiles\\Connectors\\' . $connectorName . '\\' . $connectorName ;

$connectorInstance = new $connectorClass() ;

if( $errorFound <= 0 )
{
  $echoRes = "=> No error found." ;
  
  // Base folder
  $fcheckPath = $connectorPath ;
  if( is_dir( $fcheckPath ) )
  {
    $filesArr = getFolderContent( $fcheckPath, false, false, true, true ) ;
    foreach( $filesArr as $cfile )
    {
      $cfcs = getFileEncoding( $cfile ) ;
      if( ( $cfcs !== 'utf-8' ) && ( $cfcs !== 'ascii' ) )
      {
        $echoRes = "WARNING : wrong character encoding '" . $cfcs . "' detected (UTF-8 is mandatory) for file ==> " . $cfile ;
        break ;
      }
    }
  }

  // Configs folder
  $fcheckPath = $connectorPath . '/' . 'conf' ;
  if( is_dir( $fcheckPath ) )
  {
    $filesArr = getFolderContent( $fcheckPath, false, false, true, true ) ;
    foreach( $filesArr as $cfile )
    {
      $cfcs = getFileEncoding( $cfile ) ;
      if( ( $cfcs !== 'utf-8' ) && ( $cfcs !== 'ascii' ) )
      {
        $echoRes = "WARNING : wrong character encoding '" . $cfcs . "' detected (UTF-8 is mandatory) for file ==> " . $cfile ;
        break ;
      }
    }
  }
  
  // Tools folder
  $fcheckPath = $connectorPath . '/' . 'tools' ;
  if( is_dir( $fcheckPath ) )
  {
    $filesArr = getFolderContent( $fcheckPath, true, false, true, true ) ;
    foreach( $filesArr as $cfile )
    {
      $cfcs = getFileEncoding( $cfile ) ;
      if( ( $cfcs !== 'utf-8' ) && ( $cfcs !== 'ascii' ) )
      {
        $echoRes = "WARNING : wrong character encoding '" . $cfcs . "' detected (UTF-8 is mandatory) for file ==> " . $cfile ;
        break ;
      }
    }
  }

  echo $echoRes ;
}
else
{
  echo "<br/>" ;
  echo "==> ERROR(S) FOUND : " . $errorFound ;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function errLabel( $err_level )
{
  if( !array_key_exists( $err_level, $GLOBALS[ 'ErrLabelArr' ] ) ) return $GLOBALS[ 'ErrLabelArr' ][ E_WARNING ] ;
  return $GLOBALS[ 'ErrLabelArr' ][ $err_level ] ;
}

function errorHandler( $error_level, $error_message, $error_file, $error_line, $error_context )
{
  $error = [] ;
  $error[ "shutdown" ] = false          ;
  $error[ "level"    ] = $error_level   ;
  $error[ "message"  ] = $error_message ;
  $error[ "file"     ] = $error_file    ;
  $error[ "line"     ] = $error_line    ;
  $error[ "context"  ] = $error_context ;
  slog( $error ) ;
  return ;
  $error = "lvl: " . $error_level . " | msg:" . $error_message . " | file:" . $error_file . " | ln:" . $error_line ;
  switch( $error_level )
  {
  case E_ERROR :
  case E_CORE_ERROR :
  case E_COMPILE_ERROR :
  case E_PARSE :
    mylog( $error, "fatal" ) ;
    break ;
  case E_USER_ERROR :
  case E_RECOVERABLE_ERROR :
    mylog( $error, "error" ) ;
    break ;
  case E_WARNING :
  case E_CORE_WARNING :
  case E_COMPILE_WARNING :
  case E_USER_WARNING :
    mylog( $error, "warn" ) ;
    break ;
  case E_NOTICE :
  case E_USER_NOTICE :
    mylog( $error, "info" ) ;
    break ;
  case E_STRICT :
    mylog( $error, "debug" ) ;
    break;
  default:
    mylog( $error, "warn" ) ;
    break ;
  }
}

function shutdownHandler() //will be called when php script ends.
{
  $lasterror = error_get_last() ;

  $error = [] ;
  $error[ "shutdown" ] = true           ;
  $error[ "message"  ] = $lasterror['message'] ;
  $error[ "file"     ] = $lasterror['file'] ;
  $error[ "line"     ] = $lasterror['line'] ;
  $error[ "context"  ] = [] ;

  $error[ "level"    ] = $lasterror[ 'type' ] ;
  switch( $lasterror[ 'type' ] )
  {
  case E_ERROR:
  case E_CORE_ERROR:
  case E_COMPILE_ERROR:
  case E_USER_ERROR:
  case E_RECOVERABLE_ERROR:
  case E_CORE_WARNING:
  case E_COMPILE_WARNING:
  case E_PARSE:
    $error[ "level" ] = E_ERROR ;
    break ;
  }
  slog( $error ) ;
}

function mylog( $error, $errlvl )
{
  $GLOBALS[ 'errorFound' ]++ ;
  echo "[" . $errlvl . "] ==> " . $error . '<br/>' ;
}

function slog( $error )
{
  if( array_key_exists( 'errorFound', $GLOBALS ) ) $GLOBALS[ 'errorFound' ]++ ;
  
  $errStr = "" ;
  if( $error[ "shutdown" ] === true )
  {
    if( $error[ "level" ] !== E_ERROR ) return ;
    $errStr .= "[" . "SHUTDOWN" . "]" ;
  }
  /*
  else
  {
    $errStr .= "[" . "        " . "]" ;
  }
  */

  $errStr .= "[" . errLabel( $error[ "level" ] ) . "]" ;
  $errStr .= "[" . $error[ "level" ] . "]" ;

  $errStr .= "[" . $error[ "file"    ] . "]" ;
  $errStr .= "[" . $error[ "line"    ] . "]" ;
  $errStr .= "&nbsp;" . $error[ "message" ] ;
  
  echo $errStr . '<br/>' ;
}

function getFolderContent( $fpath, $recursive = false, $onlyFolders = false, $onlyFiles = false, $fullpath = false, &$results = array() )
{
  $FolderContentFiles   = 'files'   ;
  $FolderContentFolders = 'folders' ;

  $files = scandir( $fpath ) ;

  if( ( $onlyFolders == false ) && ( $onlyFiles == false ) )
  {
    if( !array_key_exists( $FolderContentFiles  , $results ) )
    {
      $results[ $FolderContentFiles ]   = array() ;
    }
    if( !array_key_exists( $FolderContentFolders, $results ) )
    {
      $results[ $FolderContentFolders ] = array() ;
    }
  }

  foreach( $files as $key => $value )
  {
    $path = $fpath . DIRECTORY_SEPARATOR . $value ;
    if( $fullpath == true )
    {
      $path = realpath( $fpath . DIRECTORY_SEPARATOR . $value ) ;
    }

    // Is a FILE
    if( !is_dir( $path ) )
    {
      if( $onlyFolders == false )
      {
        if( $onlyFiles == true )
        {
          $results[] = $path ;
        }
        else
        {
          $results[ $FolderContentFiles ][] = $path ;
        }
      }
    }
    // Is a FOLDER
    else if( $value != "." && $value != ".." )
    {
      if( $onlyFiles != true )
      {
        if( $onlyFolders == true )
        {
          $results[] = $path ;
        }
        else
        {
          $results[ $FolderContentFolders ][] = $path ;
        }
        if( $recursive == true )
        {
          getFolderContent( $path, $recursive, $onlyFolders, $onlyFiles, $fullpath, $results ) ;
        }
      }
      else
      {
        if( $recursive == true )
        {
          getFolderContent( $path, $recursive, $onlyFolders, $onlyFiles, $fullpath, $results ) ;
        }
      }
    }
  }

  return $results;
}

/*
https://pypi.org/project/chardet/

Detects :
---
  ASCII, UTF-8, UTF-16 (2 variants), UTF-32 (4 variants)
  Big5, GB2312, EUC-TW, HZ-GB-2312, ISO-2022-CN (Traditional and Simplified Chinese)
  EUC-JP, SHIFT_JIS, CP932, ISO-2022-JP (Japanese)
  EUC-KR, ISO-2022-KR (Korean)
  KOI8-R, MacCyrillic, IBM855, IBM866, ISO-8859-5, windows-1251 (Cyrillic)
  ISO-8859-5, windows-1251 (Bulgarian)
  ISO-8859-1, windows-1252 (Western European languages)
  ISO-8859-7, windows-1253 (Greek)
  ISO-8859-8, windows-1255 (Visual and Logical Hebrew)
  TIS-620 (Thai)
*/
function getFileEncoding( $fname )
{
  $csdcmd = ".\\chardetect.exe " . $fname ;
  $detectRes = exec( $csdcmd ) ;
  $exploded  = explode( " ", $detectRes ) ;
  $res = null ;
  if( count( $exploded ) >= 2 )
  {
    $res = strtolower( $exploded[1] ) ;
  }
  return $res ;
}
function checkFileEncoding( $fname, $charset = 'utf-8' )
{
  $detectedCS = getFileEncoding( $fname ) ;
  if( $detectedCS == strtolower( $charset ) )
  {
    return true ;
  }
  return false ;
}

?>
