<?php

namespace UserFiles\Connectors\KCRMSampleDynamics ;

define( "CONNECTOR", "KCRMSampleDynamics" ) ;


/**/
// Kiamo v6.x : CRM Connectors Utilities
// -----

const KIAMO_ROOT            = __DIR__ . "/../../../../../" ;
const KIAMO_CONNECTOR_TOOLS = KIAMO_ROOT . "www/Symfony/src/Kiamo/Bundle/AdminBundle/Utility/Connectors/" ;

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

const KIAMO_ROOT            = __DIR__ . "/../../../../../" ;
const KIAMO_CONNECTOR_TOOLS = KIAMO_ROOT . "www/Symfony/src/Kiamo/Admin/Utility/Connectors/" ;

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


use \DateTime, \DateTimeZone ;


class KCRMSampleDynamics implements KiamoConnectorInterface, 
                                    KiamoConnectorContactInterface,       // Contact
                                    KiamoConnectorContactUrlInterface,    // Contact Url
                                    KiamoConnectorContactSearchInterface, // Contact Search
                                    KiamoConnectorCompanyInterface,       // Company
                                    KiamoConnectorCompanyUrlInterface,    // Company URL
                                    KiamoConnectorCompanySearchInterface, // Company Search
                                    KiamoConnectorTicketInterface,        // Ticket
                                    KiamoConnectorTicketUrlInterface,     // Ticket URL
                                    KiamoConnectorTicketSearchInterface   // Ticket Search
{
  const ServiceName = "Dynamics" ;
  const ModuleName  = __CLASS__    ;
  const ModuleDesc  = self::ServiceName . " Connector Sample" ;

  public  function __construct()
  {
    $this->initConfig() ;
    $this->logger         = new Logger( $this->getConf( 'runtime', 'logLevel' ) ) ;

    $this->log( "------------------------------------------------------------------------------", Logger::LOG_INFOP, __METHOD__ ) ;
    $this->interactionMgr = new InteractionManagerDynamics( $this ) ;
    $this->entitiesMgr    = new EntitiesManager(              $this ) ;
    $this->log( "INIT : OK", Logger::LOG_INFOP, __METHOD__ ) ;
  }
  
  
  /* **************************************************************************
     Connector Configuration
  */
  private function initConfig()
  {
    // Connector's configuration
    // ---
    $this->selfConf = [
      'service'       => 'dynamics',
      'definition'    => '2018_09_0',
    ] ;


    // Runtime configuration
    // ---
    $this->runtimeConf = [
      'logLevel'     => Logger::LOG_DEBUG,
    ] ;


    // External CRM Access configuration
    // ---
    $this->accessConf = [
      // Access URLs and credentials
      'accessdata'   => [
        'platform'      => [
          'tenantName'     => 'xxxxxxxxxxxxxxxx',
          'tenantId'       => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
          'urlPrefix'      => 'https://',
          'urlPostfix'     => '.crm4.dynamics.com',
          'apiPrefix'      => '/api/data/v',
          'apiVersion'     => '9.0',
        ],

        'authent'       => [
          'urlPrefix'      => 'https://login.microsoftonline.com/',
          'urlPostfix'     => '/oauth2/token',
          'account'        => [
            'data'            => [
              'client_id'        => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
              'client_secret'    => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=',
            ],
            'adminUser'       => [
              'username'         => 'xxxxxxxxxxx@xxxxxxxxxxx.onmicrosoft.com',
              'password'         => 'xxxxxxxxxxxxxx',
            ],
          ],
        ],
      ],

      // Direct View and Search URLs
      'urls'         => [
        'view'          => [
          'baseUrl'        => 'https://xxxxxxxxx.crm4.dynamics.com',  // CRM platform instance URL
          'contact'        => [ 'prefix' => '/main.aspx', 'postfix' => '&pagetype=entityrecord#' ],
          'company'        => [ 'prefix' => '/main.aspx', 'postfix' => '&pagetype=entityrecord#' ],
          'ticket'         => [ 'prefix' => '/main.aspx', 'postfix' => '&pagetype=entityrecord#' ],
        ],
        'search'        => [
          'baseUrl'        => 'https://xxxxxxxxx.crm4.dynamics.com',  // CRM platform instance URL
          'contact'        => [ 'prefix' => '/main.aspx', 'postfix' => '' ],
          'company'        => [ 'prefix' => '/main.aspx', 'postfix' => '' ],
          'ticket'         => [ 'prefix' => '/main.aspx', 'postfix' => '' ],
        ],
      ],
    ] ;


    // External CRM Entities Mapping
    // ---
    $this->entityMappingConf = [
      // CRM entities definitions : fields, operations and mapping with Kiamo entities
      // Note :
      // - an entity is a "class", an entry is an actual "instance"
      'map'           => [
        'contacts'       => 'contact',
        'accounts'       => 'company',
        'incidents'      => 'ticket' ,
      ],
    ] ;


    // CONTACT definition and mapping
    // ---
    $this->contactConf = [
      'labels'      => 
      [
        // Entity label
        'entity'      => [
          'name'          => 'Client',
          'fieldDisplay'  => false,
        ],
        // Entry label
        'entry'       => [
          [ 'type' =>  'field', 'value' => 'firstname' ],
          [ 'type' => 'string', 'value' => ' '         ],
          [ 'type' =>  'field', 'value' => 'lastname'  ],
        ],
      ],
      
      // Fields Mapping
      // where :
      // - the key   is the CRM entry's field name
      // - 'key'     is the internal connector key
      // - 'label'   is the Kiwi label
      // - 'type'    is the Kiamo field type
      // - 'display' is the flag to display or not the field in Kiwi
      // - 'map'     is the Kiamo variable where to map the field value
      'map'         => [
        'contactid'               => [ 'key' => 'id'       , 'label' => 'Identifiant'       , 'type' => 'id'    , 'display' => false, 'map' => 'CCKContactId'              ],
        'salutation'              => [ 'key' => ''         , 'label' => 'Civilite'          , 'type' => 'string', 'display' => true , 'map' => 'contactTitle'              ],
        'firstname'               => [ 'key' => 'firstname', 'label' => 'Prenom'            , 'type' => 'string', 'display' => true , 'map' => 'contactFirstName'          ],
        'lastname'                => [ 'key' => 'lastname' , 'label' => 'Nom'               , 'type' => 'string', 'display' => true , 'map' => 'contactLastName'           ],
        'jobtitle'                => [ 'key' => ''         , 'label' => 'Titre'             , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'telephone1'              => [ 'key' => 'phone'    , 'label' => 'Telephone'         , 'type' => 'phone' , 'display' => true , 'map' => 'contactPhoneNumber'        ],
        'mobilephone'             => [ 'key' => 'mobile'   , 'label' => 'Mobile'            , 'type' => 'phone' , 'display' => true , 'map' => 'contactMobilePhoneNumber'  ],
        'emailaddress1'           => [ 'key' => 'email'    , 'label' => 'EMail'             , 'type' => 'email' , 'display' => true , 'map' => 'contactEmail'              ],
        '_parentcustomerid_value' => [ 'key' => 'companyId', 'label' => "Id de l'entreprise", 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'              ],
        'description'             => [ 'key' => ''         , 'label' => 'Description'       , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'address1_line1'          => [ 'key' => ''         , 'label' => 'Adresse'           , 'type' => 'string', 'display' => true , 'map' => 'contactPrimaryAddress'     ],
        'address1_postalcode'     => [ 'key' => ''         , 'label' => 'Code postal'       , 'type' => 'string', 'display' => true , 'map' => 'contactZipCode'            ],
        'address1_city'           => [ 'key' => ''         , 'label' => 'Ville'             , 'type' => 'string', 'display' => true , 'map' => 'contactCity'               ],
      ],
      
      // Search algorithms
      // where :
      // - we loop on each line
      // - we exit the loop as soon as a match is found
      'search'      => [
        // Search based on Kiamo input (for instance, a phone number passing through a SVI)
        'kiamoInputs'  => [
          '01'            => [ 'varName' => 'KiamoDynamicsContactNumber', 'entityField' =>     'phone', 'operation' =>  'contains' ],
          '02'            => [ 'varName' =>               'CCKContactId', 'entityField' =>        'id', 'operation' => 'equalsraw' ],
          '04'            => [ 'varName' =>                 'CustNumber', 'entityField' =>     'phone', 'operation' =>  'contains' ],
          '05'            => [ 'varName' =>                 'CustNumber', 'entityField' =>    'mobile', 'operation' =>  'contains' ],
          '06'            => [ 'varName' =>                'EMailSender', 'entityField' =>     'email', 'operation' =>  'contains' ],
        ],
        // A manual agent search string (in Kiwi)
        'agentQuery'   => [
          '01'            => [                                            'entityField' =>    'mobile', 'operation' =>  'contains' ],
          '02'            => [                                            'entityField' =>     'phone', 'operation' =>  'contains' ],
          '03'            => [                                            'entityField' =>     'email', 'operation' =>  'contains' ],
          '04'            => [                                            'entityField' =>  'lastname', 'operation' =>  'contains' ],
          '05'            => [                                            'entityField' => 'firstname', 'operation' =>  'contains' ],
          '06'            => [                                            'entityField' =>        'id', 'operation' => 'equalsraw' ],
        ],
      ],
    ] ;
        

    // COMPANY definition and mapping
    // ---
    $this->companyConf = [
      'labels'      => [
        // Entity label
        'entity'      => [
          'name'          => 'Société',
          'fieldDisplay'  => false,
        ],
        // Entry label
        'entry'       => [
          [ 'type' => 'field', 'value' => 'name' ],
        ],
      ],
      
      // Fields Mapping
      // where :
      // - the key   is the CRM entry's field name
      // - 'key'     is the internal connector key
      // - 'label'   is the Kiwi label
      // - 'type'    is the Kiamo field type
      // - 'display' is the flag to display or not the field in Kiwi
      // - 'map'     is the Kiamo variable where to map the field value
      'map'         => [
        'accountid'           => [ 'key' => 'id'   , 'label' => 'Identifiant', 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'              ],
        'name'                => [ 'key' => 'name' , 'label' => 'Nom'        , 'type' => 'string', 'display' => true , 'map' => 'companyName'               ],
        'description'         => [ 'key' => ''     , 'label' => 'Description', 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'numberofemployees'   => [ 'key' => ''     , 'label' => 'Nb Employés', 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'telephone1'          => [ 'key' => 'phone', 'label' => 'Telephone'  , 'type' => 'phone' , 'display' => true , 'map' => 'companyPhoneNumber'        ],
        'address1_line1'      => [ 'key' => ''     , 'label' => 'Adresse'    , 'type' => 'string', 'display' => true , 'map' => 'companyPrimaryAddress'     ],
        'address1_postalcode' => [ 'key' => ''     , 'label' => 'Code postal', 'type' => 'string', 'display' => true , 'map' => 'companyZipCode'            ],
        'address1_city'       => [ 'key' => ''     , 'label' => 'Ville'      , 'type' => 'string', 'display' => true , 'map' => 'companyCity'               ],
      ],
      
      // Search algorithms
      // where :
      // - we loop on each line
      // - we exit the loop as soon as a match is found
      'search'      => [
        // Search based on Kiamo input (for instance, a phone number passing through a SVI)
        'kiamoInputs'  => [
          '01'            => [ 'varName' => 'KiamoDynamicsCompanyId', 'entityField' =>     'id', 'operation' => 'equalsraw' ],
          '02'            => [ 'varName' =>           'CCKCompanyId', 'entityField' =>     'id', 'operation' => 'equalsraw' ],
          '04'            => [ 'varName' =>             'CustNumber', 'entityField' =>  'phone', 'operation' =>  'contains' ],
          '05'            => [ 'varName' =>             'CustNumber', 'entityField' => 'mobile', 'operation' =>  'contains' ],
          '06'            => [ 'varName' =>            'EMailSender', 'entityField' =>  'email', 'operation' =>  'contains' ],
        ],
        
        // A manual agent search string (in Kiwi)
        'agentQuery'   => [
          '01'            => [                                        'entityField' =>  'phone', 'operation' =>  'contains' ],
          '02'            => [                                        'entityField' => 'mobile', 'operation' =>  'contains' ],
          '03'            => [                                        'entityField' =>  'email', 'operation' =>  'contains' ],
          '04'            => [                                        'entityField' =>   'name', 'operation' =>  'contains' ],
          '05'            => [                                        'entityField' =>     'id', 'operation' => 'equalsraw' ],
        ],
      ],
    ] ;
        
    // TICKET definition and mapping
    // ---
    $this->ticketConf = [
      'labels'      => [
        // Entity label
        'entity'      => [
          'name'          => 'Requête',
          'fieldDisplay'  => false,
        ],
        // Entry label
        'entry'       => [
          [ 'type'      => 'field', 'value'     => 'id' ],
        ],
      ],

      // Fields Mapping
      // where :
      // - the key   is the CRM entry's field name
      // - 'key'     is the internal connector key
      // - 'label'   is the Kiwi label
      // - 'type'    is the Kiamo field type
      // - 'display' is the flag to display or not the field in Kiwi
      // - 'map'     is the Kiamo variable where to map the field value
      'map'         => [
        'incidentid'        => [ 'key' => 'id'       , 'label' => 'Identifiant'     , 'type' => 'id'     , 'display' => false, 'map' => 'CCKTicketId'    ],
        'createdon'         => [ 'key' => ''         , 'label' => 'Cree le'         , 'type' => 'date'   , 'display' => true , 'map' => 'ticketOpenDate' ],
        'modifiedon'        => [ 'key' => 'lastUpdate', 'label' => 'Date de modif.' , 'type' => 'date'   , 'display' => true , 'map' => ''               ],
        'title'             => [ 'key' => ''         , 'label' => 'Sujet'           , 'type' => 'string' , 'display' => true , 'map' => ''               ],
        'description'       => [ 'key' => ''         , 'label' => 'Description'     , 'type' => 'string' , 'display' => true , 'map' => ''               ],
        'statecode'         => [ 'key' => 'status'   , 'label' => 'Etat'            , 'type' => 'string' , 'display' => true , 'map' => 'ticketStatus'   ],
        'ticketnumber'      => [ 'key' => 'tkNb'     , 'label' => 'Numéro de ticket', 'type' => 'string' , 'display' => true , 'map' => ''               ],
        '_customerid_value' => [ 'key' => 'contactId', 'label' => 'Contact'         , 'type' => 'id'     , 'display' => true , 'map' => ''               ],
        '_accountid_value'  => [ 'key' => 'companyId', 'label' => 'Société'         , 'type' => 'id'     , 'display' => true , 'map' => ''               ],
      ],

      // Search algorithms
      // where :
      // - we loop on each line
      // - we exit the loop as soon as a match is found
      'search'      => [ 
        // Search based on Kiamo input (for instance, a phone number passing through a SVI)
        'kiamoInputs'  => [
          '01'            => [ 'varName' => 'KiamoDynamicsTicketId', 'entityField' =>        'id', 'operation' => 'equalsraw' ],
          '02'            => [ 'varName' =>           'CCKTicketId', 'entityField' =>        'id', 'operation' => 'equalsraw' ],
          '03'            => [ 'varName' =>          'CCKContactId', 'entityField' => 'contactId', 'operation' => 'equalsraw' ],
          '04'            => [ 'varName' =>          'CCKCompanyId', 'entityField' => 'companyId', 'operation' => 'equals' ],
        ],
        // A manual agent search string (in Kiwi)
        'agentQuery'   => [
          '01'            => [                                       'entityField' =>        'id', 'operation' => 'equalsraw' ],
          '02'            => [                                       'entityField' => 'contactId', 'operation' => 'equalsraw' ],
          '02'            => [                                       'entityField' => 'companyId', 'operation' => 'equalsraw' ],
        ],
      ],
    ] ;

  }

  public   function getConf( $confKey, $key = null )
  {
    $conf = null ;
    switch( $confKey )
    {
    case "self" :
      $conf = &$this->selfConf ;
      break ;
    case "runtime" :
      $conf = &$this->runtimeConf ;
      break ;
    case "access" :
      $conf = &$this->accessConf ;
      break ;
    case "entities" :
      $conf = &$this->entityMappingConf ;
      break ;
    case "contact" :
      $conf = &$this->contactConf ;
      break ;
    case "company" :
      $conf = &$this->companyConf ;
      break ;
    case "ticket" :
      $conf = &$this->ticketConf ;
      break ;
    }
    return $conf == null ? null : $this->getInDict( $conf, $key ) ;
  }


  /* **************************************************************************
     GLOBAL Connector
  */

  static public function setLang( $lang )
  {
  }

  public function setCid( $cid )
  {
    $this->_cid = $cid ;
  }

  static public function getType()
  {
    return self::ModuleDesc ;
  }


  /* **************************************************************************
     GLOBAL Connector Instance
  */

  public function isActivatable()
  {
    return true ;
  }

  public function setActivationInfos( $infos )
  {
  }
  
  public function getActivationInfos()
  {
    return [] ;
  }


  /* **************************************************************************
     Entities : contact
  */

  // INTERFACE : Contact
  // ---
  public function contactIsActive()
  {
    return true ;
  }

  public function getContactLabel()
  {
    $type = 'contact' ;
    return $this->getEntityLabel( $type ) ;
  }

  public function getContactLayout()
  {
    $type = 'contact' ;
    return $this->getEntityLayout( $type ) ;
  }
  
  public function findContactById( $id )
  {
    $type = 'contact' ;
    return $this->findEntryById( $type, $id ) ;
  }

  public function findOneContact( ParameterBag $parameters )
  {
    $type = 'contact' ;
    return $this->findOneEntry( $type, $parameters ) ;
  }

  // INTERFACE : Contact Search
  // ---
  public function findContactsByQuery( $query, ParameterBag $parameters )
  {
    $type = 'contact' ;
    return $this->findEntriesByQuery( $type, $query ) ;
  }

  // INTERFACE : Contact Url
  // ---
  public function getContactsCrmSearchUrl()
  {
    $type = 'contact' ;
    return $this->getEntitiesCrmSearchUrl( $type ) ;
  }


  /* **************************************************************************
     Entities : company
  */

  // INTERFACE : Company
  // ---
  public function companyIsActive()
  {
    return true ;
  }

  public function getCompanyLabel()
  {
    $type = 'company' ;
    return $this->getEntityLabel( $type ) ;
  }

  public function getCompanyLayout()
  {
    $type = 'company' ;
    return $this->getEntityLayout( $type ) ;
  }
  
  public function findCompanyById( $id )
  {
    $type = 'company' ;
    return $this->findEntryById( $type, $id ) ;
  }

  public function findOneCompany( ParameterBag $parameters )
  {
    $type = 'company' ;
    return $this->findOneEntry( $type, $parameters ) ;
  }

  // INTERFACE : Company Search
  // ---
  public function findCompaniesByQuery( $query, ParameterBag $parameters )
  {
    $type = 'company' ;
    return $this->findEntriesByQuery( $type, $query ) ;
  }

  // INTERFACE : Company Url
  // ---
  public function getCompaniesCrmSearchUrl()
  {
    $type = 'company' ;
    return $this->getEntitiesCrmSearchUrl( $type ) ;
  }


  /* **************************************************************************
     Entities : ticket
  */

  // INTERFACE : Ticket
  // ---
  public function ticketIsActive()
  {
    return true ;
  }

  public function getTicketLabel()
  {
    $type = 'ticket' ;
    return $this->getEntityLabel( $type ) ;
  }

  public function getTicketLayout()
  {
    $type = 'ticket' ;
    return $this->getEntityLayout( $type ) ;
  }
  
  public function findTicketById( $id )
  {
    $type = 'ticket' ;
    return $this->findEntryById( $type, $id, false ) ;
  }

  public function findOneTicket( ParameterBag $parameters )
  {
    $type = 'ticket' ;
    return $this->findOneEntry( $type, $parameters ) ;
  }

  // INTERFACE : Ticket Search
  // ---
  public function findTicketsByQuery( $query, ParameterBag $parameters )
  {
    $type = 'ticket' ;
    return $this->findEntriesByQuery( $type, $query ) ;
  }

  // INTERFACE : Ticket Url
  // ---
  public function getTicketsCrmSearchUrl()
  {
    $type = 'ticket' ;
    return $this->getEntitiesCrmSearchUrl( $type ) ;
  }


  /* **************************************************************************
     TOOLS Entities and Entries Generic :
  */

  private  function getEntityLabel( $type )
  {
    return $this->getConf( $type, "labels.entity.name" ) ;
  }

  private  function getEntityLayout( $type )
  {
    return $this->entitiesMgr->getEntityLayout( $type ) ;
  }
  

  // Get the external entry by its id (already known, one way or the other)
  public  function findEntryById( $type, $id, $updateInteractionLabel = true )
  {
    $this->log( "Find " . $type . " by id : " . $id, Logger::LOG_INFO, __METHOD__ ) ;
    $entry   = null ;

    $extType = $this->entitiesMgr->getEntityType( $type ) ;
    $raw     = $this->interactionMgr->getSingleEntry( $extType, $id ) ;

    if( empty( $raw ) )
    {
      $this->log( "=> Not found : " . $type . " id : " . $id, Logger::LOG_INFO, __METHOD__ ) ;
      return null ;
    }

    $this->log(   "=> Found : "     . $type . " id : " . $id, Logger::LOG_INFO, __METHOD__ ) ;
    $entry = $this->entitiesMgr->getEntryInstance( $type, $raw, $updateInteractionLabel ) ;

    return $entry ;
  }

  
  // Search matches using the ParameterBag provided by Kiamo (Media interaction)
  public   function findOneEntry( $type, &$parameters )
  {
    $this->log( "Find one " . $type, Logger::LOG_INFO, __METHOD__ ) ;
    $entry = null ;


    // Loop on the 'kiamoInputs' search parameters
    $searchPattern = $this->entitiesMgr->getEntitySearchPatternKiamoInputs( $type ) ;
    $res           = null ;
    foreach( $searchPattern as $searchItem )
    {
      $varName      = $searchItem[ 'varName' ] ;
      
      // Search entries matching the current search item
      $pbParamValue = $parameters->$varName ;
      $preparedResult = $this->findEntriesBySearchPattern( $type, $pbParamValue, $searchItem ) ;
      if( empty( $preparedResult ) ) continue ;

      // Select one of the list
      $res = $preparedResult[0] ;  // By default, select the first returned result
      
      // One match has been found and treated : break the search loop here
      break ;
    }

    if( empty( $res ) )
    {
      $this->log( "=> No match found", Logger::LOG_INFO, __METHOD__ ) ;
      return null ;
    }

    $this->log(   "=> Match found", Logger::LOG_INFO, __METHOD__ ) ;
    $entry = $this->entitiesMgr->getEntryInstance( $type, $res ) ;

    return $entry ;
  }


  // Search matches by query (an agent using the search button)
  public  function findEntriesByQuery( $type, $query )
  {
    $this->log( "Find " . $type . "s by query : '" . $query . "'", Logger::LOG_INFO, __METHOD__ ) ;
    $collection = null ;


    // Loop on the 'agentQuery' search parameters
    $searchPattern = $this->entitiesMgr->getEntitySearchPatternAgentQuery( $type ) ;
    $res           = null ;
    foreach( $searchPattern as $searchItem )
    {
      // Search entries matching the current search item
      $res = $this->findEntriesBySearchPattern( $type, $query, $searchItem ) ;
      if( empty( $res ) ) continue ;
      
      // At least one match has been found and treated : break the search loop here
      break ;
    }

    if( empty( $res ) )
    {
      $this->log( "=> No match found", Logger::LOG_INFO, __METHOD__ ) ;
      return new EntityInstanceCollection( $this->getEntityLayout( $type ) ) ;
    }

    $this->log(   "=> Match(es) found : " . sizeof( $res ), Logger::LOG_INFO, __METHOD__ ) ;
    $collection = $this->entitiesMgr->getEntriesCollection( $type, $res ) ;

    return $collection ;
  }


  // Search entries by search pattern :
  // ---
  // -> skip empty values
  // -> apply eligibility requirements, if any
  // -> apply pre-treatment on the provided value, if defined
  // -> apply post-treatment on the returned results, if defined
  private  function findEntriesBySearchPattern( $type, $paramValue, $searchPatternItem )
  {
    $entityField = $searchPatternItem[ 'entityField' ] ;
    $operation   = $searchPatternItem[ 'operation'   ] ;
    
    $this->log( "Searching entry type='" . $type . "', value='" . $paramValue . "', pattern=" . json_encode( $searchPatternItem ), Logger::LOG_DEBUG, __METHOD__ ) ;

    // Skip empty values
    if( empty( $paramValue ) ) return null ;


    // Here can be formatted the passed param
    $preparedParamValue = $paramValue ;
    

    // Search a match on the external Service
    $extType           = $this->entitiesMgr->getEntityType(               $type               ) ;
    $extField          = $this->entitiesMgr->getEntityField(              $type, $entityField ) ;
    $extFields         = array_keys( $this->entitiesMgr->getEntityFields( $type               ) ) ;
    $query             = $this->interactionMgr->getQuery(                 $extType, $extField, $preparedParamValue, $operation, $extFields ) ;
    $extRequestResults = $this->interactionMgr->getEntriesListByQuery(     $query              ) ;
    if( empty( $extRequestResults ) ) return null ;  // Return if no match
    

    // Here can be applied post treatments on the result list
    $preparedResults = &$extRequestResults ;

    
    return $preparedResults ;
  }

  private  function getEntitiesCrmSearchUrl( $type )
  {
    return $this->entitiesMgr->getEntitiesSearchUrl( $type ) ;
  }


  /* **************************************************************************
     Inner Tools
  */

  public   function log( $str, $level = Logger::LOG_DEBUG, $method = '', $indentLevel = 0 )
  {
    $this->logger->log( $str, $level, $method, $indentLevel ) ;
  }

  public   function getInDict( $dict, $key = null )
  {
    if( $key === null ) return $dict ;

    $_sk = $this->_splitKey( $key ) ;

    $cur = &$dict ;
    foreach( $_sk as $_k )
    {
      if( !is_array( $cur ) || !array_key_exists( $_k, $cur ) ) return null ;
      $cur = &$cur[ $_k ] ;
    }
    return $cur ;
  }

  private function _splitKey( $key )
  {
    if( empty( $key ) ) return $key ;

    $res = null ;
    if( is_string( $key ) )
    {
      $res = explode( '.', $key ) ;
    }
    else
    {
      $res = &$key ;
    }
    return $res ;
  }

}


/* ****************************************************************************
   Dynamics Interactions Manager
   ***
   Purpose :
   - Web Services authentication
   - search CRM entries matching the inputs (search string, id)
*/
class InteractionManagerDynamics
{
  public   function __construct( $_parent )
  {
    $this->_parent      = $_parent                             ;
    $this->accessData   = $this->_parent->getConf( "access", 'accessdata' ) ;
    $this->sessionToken = null                                 ;
    
    $this->log( "INIT : OK", Logger::LOG_DEBUG, __METHOD__ ) ;
  }


  /* *************************************************************************
     Main
  */

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
  public   function authenticate()
  {
    $header      = [
      'Content-type: application/x-www-form-urlencoded'
    ] ;
    $authentUrl  = $this->getAuthentUrl() ;
    $grantType   = 'password' ;
    $data        = $this->getAuthentData( $grantType ) ;

    $this->log( "Authentication attempt, mode ='" . $grantType . "', url : " . $authentUrl, Logger::LOG_INFO, __METHOD__ ) ;
    $res = Webs::restRequest( $authentUrl, $data, $header ) ;
    if( empty( $res ) || $res[ Webs::REST_REQUEST_STATUS ] !== true )
    {
      $this->log( "ERROR : Unable to authenticate  : " . json_encode( $res ), Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }
    $this->log( "Authentication SUCCESS : " . json_encode( $res, JSON_PRETTY_PRINT ), Logger::LOG_INFO, __METHOD__ ) ;
    $this->sessionToken = $res[ Webs::REST_REQUEST_RESULT ][ 'access_token' ] ;

    return $this->sessionToken ;
  }


  public   function wsGet( $getParams )
  {
    $originToken = $this->sessionToken ;
    if( empty( $this->sessionToken ) ) $this->authenticate() ;
    if( empty( $this->sessionToken ) )
    {
      $this->log( 'No access token : Unable to get a Session Token', Logger::LOG_ERROR, __METHOD__ ) ;
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
      $this->authenticate() ;
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

    $this->log( "wsGet OK, res : " . json_encode( $res[ Webs::REST_REQUEST_RESULT ] ), Logger::LOG_DEBUG, __METHOD__ ) ;

    return $res[ Webs::REST_REQUEST_RESULT ] ;
  }


  public   function getEntriesListByQuery( $query )
  {
    $this->log( "Request => " . $query, Logger::LOG_DEBUG, __METHOD__ ) ;
    $res = $this->wsGet( $query ) ;
    $ret = null ;
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
  public  function  getQuery( $entityType, $field, $value, $operation, &$fields )
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


  /* **************************************************************************
     Inner Tools
  */

  private  function getAuthentData( $grantType )
  {
    if( !( $grantType === 'password' || $grantType === 'refresh_token' ) )
    {
      $this->log( "Wrong grant type '" . $grantType . "' => expected 'password' or 'refresh_token'", Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }
    
    $authentData = $this->accessData[ 'authent' ] ;
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
      $this->log( "Can't use grant type '" . $grantType . "' (the refresh token mode is not managed in this module)", Logger::LOG_WARN, __METHOD__ ) ;
      return null ;
    }

    return $data ;
  }

  private  function getAuthentUrl()
  {
    $platformData       = $this->accessData[ 'platform' ] ;
    $authentData        = $this->accessData[ 'authent'  ] ;

    $tenantId           = $platformData[ 'tenantId'   ] ;
    $authentUrlPrefix   = $authentData[  'urlPrefix'  ] ;
    $authentUrlPostfix  = $authentData[  'urlPostfix' ] ;
    $authentUrl         = $authentUrlPrefix . $tenantId . $authentUrlPostfix  ;
    
    return $authentUrl ;
  }

  private  function getPlatformUrl()
  {
    $platformData       = $this->accessData[ 'platform' ] ;

    $tenantName         = $platformData[ 'tenantName' ] ;
    $platformUrlPrefix  = $platformData[ 'urlPrefix'  ] ;
    $platformUrlPostfix = $platformData[ 'urlPostfix' ] ;
    $platformUrl        = $platformUrlPrefix . $tenantName . $platformUrlPostfix ;

    return $platformUrl ;
  }

  private  function getAPIUrl()
  {
    $platformData       = $this->accessData[ 'platform' ] ;

    $platformUrl        = $this->getPlatformUrl() ;
    $apiUrlPrefix       = $platformData[ 'apiPrefix'  ] ;
    $apiVersion         = $platformData[ 'apiVersion' ] ;
    $apiUrl             = $platformUrl . $apiUrlPrefix . $apiVersion ;

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

  private  function getAccessHeader()
  {
    if( empty( $this->sessionToken ) ) return null ;
    return [
      'Authorization: Bearer ' . $this->sessionToken,
      'Accept: application/json',
      'Content-Type: application/json; charset=utf-8',
      'OData-MaxVersion: 4.0',
      'OData-Version: 4.0',
    ] ;
  }

  private  function log( $str, $level = Logger::LOG_DEBUG, $method = '', $indentLevel = 0 )
  {
    $this->_parent->logger->log( $str, $level, $method, $indentLevel ) ;
  }
}


/* ****************************************************************************
   Entities Manager
   ***
   Definitions :
   - Entity : type of entry, as a contact or a ticket for instance
   - Entry  : instance of an entity. Mr John Foo's contact entity data, for instance.
   Purpose :
   - Web Services authentication
   - search CRM entries matching the inputs (search string, id)
*/
class EntitiesManager
{
  public   function __construct( $_parent )  // The _parent must be a module
  {
    $this->_parent = $_parent ;

    $this->log( "INIT : OK", Logger::LOG_DEBUG, __METHOD__ ) ;
  }


  /* *************************************************************************
     Main
  */
  public   function getEntryInstance( $type, $externalInstanceData, $updateInteractionLabel = true )
  {
    $res = null ;

    $packagedEntry = $this->getPackagedEntry( $type, $externalInstanceData ) ;
    $this->log( "Entry : " . $this->getPackagedEntryStr( $packagedEntry ), Logger::LOG_DEBUG, __METHOD__ ) ;

    $interactionLabel = $packagedEntry[ 'label'  ] ;
    if( $updateInteractionLabel === false ) $interactionLabel = '' ;

    $res = new EntityInstance(
      $packagedEntry[ 'layout' ],
      $packagedEntry[ 'id'     ],
      $packagedEntry[ 'values' ],
      $packagedEntry[ 'exturl' ],
      $interactionLabel
    ) ;

    switch( $type )
    {
    case 'contact' :
      $res->setContactId( $packagedEntry[ 'id' ] ) ;
      break ;
    case 'company' :
      $res->setCompanyId( $packagedEntry[ 'id' ] ) ;
      break ;
    case 'file'    :
      $res->setFileId(    $packagedEntry[ 'id' ] ) ;
      break ;
    case 'ticket'  :
      $res->setTicketId(  $packagedEntry[ 'id' ] ) ;
      break ;
    default :
      break ;
    }
    
    return $res ;
  }


  // Map Entities
  public   function getEntriesCollection( $type, $entriesArr )
  {
    $res = new EntityInstanceCollection( $this->getEntityLayout( $type ) ) ;
    if( empty( $entriesArr ) ) return $res ;

    $this->log( "Building entries collection...", Logger::LOG_INFOP, __METHOD__ ) ;
    foreach( $entriesArr as $externalInstanceData )
    {
      $packagedEntry = $this->getPackagedEntry( $type, $externalInstanceData ) ;
      $this->log( "=> adding entry : " . $this->getPackagedEntryStr( $packagedEntry ), Logger::LOG_DEBUG, __METHOD__ ) ;
      $res->add( $packagedEntry[ 'id'     ],
                 $packagedEntry[ 'values' ],
                 $packagedEntry[ 'exturl' ],
                 $packagedEntry[ 'label'  ] ) ;
    }
    $this->log( "Building entries collection : DONE", Logger::LOG_DEBUG, __METHOD__ ) ;
      
    return $res ;
  }


  /* *************************************************************************
     Main Entities Tools
  */
  
  // Entity Type Mapping
  // ---
  // inout =  true ==> arg type is external, expected res is internal
  // inout = false ==> arg type is internal, expected res is external
  public   function getEntityType( $type, $inout = true )
  {
    $map = $this->getConf( "entities", "map" ) ;
    
    $res = 'NO_MATCH' ;
    switch( $type )
    {
    case 'contact' :
    case 'company' :
    case 'dossier' :
    case 'ticket'  :
      foreach( $map as $key => $val )
      {
        if( $val === $type )
        {
          $res = $key ;
          break ;
        }
      }
      break ;
    default  :
      foreach( $map as $key => $val )
      {
        if( $key === $type )
        {
          $res = $val ;
          break ;
        }
      }
      break ;
    }
    return $res ;
  }
  
  // Entity Layout
  // ---
  public   function getEntityLayout( $type )
  {
    $entityLabel        = $this->getEntityLabel(        $type ) ;
    $entityFieldDisplay = $this->getEntityFieldDisplay( $type ) ;
    $layout             = new EntityLayout( $entityLabel, $entityFieldDisplay ) ;

    $_entityFields = $this->getEntityFields( $type ) ;
    foreach( $_entityFields as $name => $desc )
    {
      $displayFlag          = $desc[ 'display' ] ;
      $kiamoDataType        = $this->mapDataType( $desc[ 'type' ] ) ;
      $label                = $desc[ 'label'   ] ;
      $kiamoVariableMapping = $desc[ 'map'     ] ;
      $layout->addField( $name, $label, $kiamoDataType, $kiamoVariableMapping, $displayFlag ) ;
    }
    return $layout ;
  }
  

  public   function getEntitiesSearchUrl( $type, $additionalData = '' )
  {
    $res         = null ;
    $urlPatterns = $this->getConf( "access", "urls.search" ) ;
    $urlPattern  = $urlPatterns[ $type ] ;
    $res         = $urlPatterns[ 'baseUrl' ] . $urlPattern[ 'prefix' ] . $additionalData . $urlPattern[ 'postfix' ] ;
    return $res ;
  }

  
  /* *************************************************************************
     Main Entries Tools
  */

  // Entry Label
  // ---
  
  public   function getEntryLabel( $type, $values )
  {
    // Get the entry label as (if) defined in conf
    $res = $this->_getConfiguredEntryLabel( $type, $values ) ;
    if( empty( $res ) )  // Default value
    {
      switch( $type )
      {
      case 'contact' :
        $labelField = $this->getEntityField( $type, 'lastname' ) ;
        $res        = $values[ $labelField ] ;
        break ;
      case 'company' :
        $labelField = $this->getEntityField( $type, 'name' ) ;
        $res        = $values[ $labelField ] ;
        break ;
      case 'file'    :
      case 'ticket'  :
      default :
        break ;
      }
    }
    return $res ;
  }

  private  function _getConfiguredEntryLabel( $type, $values )
  {
    $res = '' ;
    $elPattern = $this->getEntryLabelPattern( $type ) ;
    if( empty( $elPattern ) ) return $res ;
    foreach( $elPattern as $strItem )
    {
      $value = '' ;
      if(      $strItem[ 'type' ] === 'string' )
      {
        $value      = $strItem[ 'value' ] ;
      }
      else if( $strItem[ 'type' ] === 'field'  )
      {
        $labelField = $this->getEntityField( $type, $strItem[ 'value' ] ) ;
        $value      = $values[ $labelField ] ;
      }
      if(  empty( $value ) ) continue ;
      $res .= $value ;
    }
    return $res ;
  }

  public   function getPackagedEntry( $type, $values )
  {
    $res = [] ;

    $res[ 'layout' ]  = $this->getEntityLayout(     $type          ) ;
    $res[ 'values' ]  = $values                                      ;
    $_idField         = $this->getEntityField(      $type, 'id'    ) ;
    $res[ 'id'     ]  = $values[                    $_idField      ] ;
    $res[ 'exturl' ]  = $this->getEntryExternalUrl( $type, $values ) ;
    $res[ 'label'  ]  = $this->getEntryLabel(       $type, $values ) ;

    return $res ;
  }
  public   function getPackagedEntryStr( $packagedEntry )
  {
    $res  = "" ;
    $res .=       "id=" .              $packagedEntry[ 'id'     ]       ;
    $res .= ", label='" .              $packagedEntry[ 'label'  ] . "'" ;
    $res .= ", values=" . json_encode( $packagedEntry[ 'values' ] )     ;
    $res .= ", exturl=" .              $packagedEntry[ 'exturl' ]       ;
    return $res ;
  }
  
  public   function getEntryExternalUrl( $type, $values )
  {
    $res         = null ;
    $_idField    = $this->getEntityField( $type, 'id' ) ;
    $id          = $values[ $_idField ] ;
    $exttype     = $this->getEntityType( $type ) ;
    $exttype     = substr( $exttype, 0, -1 ) ;
    $urlPatterns = $this->getConf( "access", "urls.view" ) ;
    $urlPattern  = $urlPatterns[ $type ] ;
    $res         = $urlPatterns[ 'baseUrl' ] . $urlPattern[ 'prefix' ] . '?etn=' . $exttype . '&id=%7b' . $id . '%7d' . $urlPattern[ 'postfix' ] ;
    return $res ;
  }

  
  /* *************************************************************************
     Internal Tools
  */
  
  // Get Configuration
  // ---
  public   function getEntityConf( $type )
  {
    return $this->getConf( $type ) ;
  }

  public   function getEntityLabelConf( $type )
  {
    return $this->getConf( $type, "labels.entity" ) ;
  }

  public   function getEntityLabel( $type )
  {
    return $this->getConf( $type, "labels.entity.name" ) ;
  }

  public   function getEntityFieldDisplay( $type )
  {
    return $this->getConf( $type, "labels.entity.fieldDisplay" ) ;
  }

  public   function getEntryLabelPattern( $type )
  {
    return $this->getConf( $type, "labels.entry" ) ;
  }

  public   function getEntityFields( $type )
  {
    return $this->getConf( $type, "map" ) ;
  }

  public   function getEntityField( $type, $internalKey )
  {
    $res = '' ;
    $map = $this->getEntityFields( $type ) ;
    foreach( $map as $key => $val )
    {
      if( $val[ 'key' ] === $internalKey )
      {
        $res = $key ;
        break ;
      }
    }
    return $res ;
  }

  public   function getEntitySearchPatternKiamoInputs( $type )
  {
    return $this->getConf( $type, "search.kiamoInputs" ) ;
  }

  public   function getEntitySearchPatternAgentQuery( $type )
  {
    return $this->getConf( $type, "search.agentQuery" ) ;
  }

  public   function getEntitySearchGetOneOfMethod( $type )
  {
    return $this->getConf( $type, "search.getOneOfList" ) ;
  }
  
  // Map Kiamo Data Type
  private  function mapDataType( $dataType )
  {
    $res = null ;
    switch( $dataType )
    {
    case 'text' :
      $res = EntityField::TYPE_TEXT ;
      break ;
    case 'date' :
      $res = EntityField::TYPE_DATE ;
      break ;
    case 'datetime' :
      $res = EntityField::TYPE_DATETIME ;
      break ;
    case 'tzdatetime' :
      $res = EntityField::TYPE_TZDATETIME ;
      break ;
    case 'time' :
      $res = EntityField::TYPE_TIME ;
      break ;
    case 'tztime' :
      $res = EntityField::TYPE_TZTIME ;
      break ;
    case 'birthday' :
      $res = EntityField::TYPE_BIRTHDAY ;
      break ;
    case 'phone' :
      $res = EntityField::TYPE_PHONE ;
      break ;
    case 'email' :
      $res = EntityField::TYPE_EMAIL ;
      break ;
    case 'id' :
    case 'url' :
    case 'multi' :
    case 'array' :
    case 'json' :
    case 'int' :
    case 'float' :
    case 'boolean' :
    case 'string' :
    default :
      $res = EntityField::TYPE_STRING ;
      break ;
    }
    return $res ;
  }

  /* **************************************************************************
     Inner Tools
  */

  private  function log( $str, $level = Logger::LOG_DEBUG, $method = '', $indentLevel = 0 )
  {
    $this->_parent->logger->log( $str, $level, $method, $indentLevel ) ;
  }
  
  private  function getConf( $confKey, $key = null )
  {
    return $this->_parent->getConf( $confKey, $key ) ;
  }
}


/* ****************************************************************************
   Logger Helper
*/
class Logger
{
  const LOG_ALL                    =  0 ;
  const LOG_VERBOSE                =  1 ;
  const LOG_VERBOZE                =  1 ;
  const LOG_TRACE                  =  2 ;
  const LOG_DEBUG                  =  3 ;
  const LOG_INFOP                  =  4 ;
  const LOG_INFO                   =  5 ;
  const LOG_WARN                   =  6 ;
  const LOG_WARNING                =  6 ;
  const LOG_ERR                    =  7 ;
  const LOG_ERROR                  =  7 ;
  const LOG_CRITICAL               =  8 ;
  const LOG_NONE                   =  9 ;
  
  public    function __construct( $_maxLogLevel )
  {
    $this->initConf( $_maxLogLevel ) ;
    $this->log( "INIT : OK", self::LOG_TRACE, __METHOD__ ) ;
  }
  
  public    function initConf( $_maxLogLevel )
  {
    $this->timezone        = 'Europe/Paris' ;
    $this->maxLogLevel     = $_maxLogLevel  ;
    $this->adjustMethodLen = 50             ;
  }

  public   function log( $str, $level = self::LOG_DEBUG, $method = '', $indentLevel = 0 )
  {
    if( $level < $this->maxLogLevel ) return ;

    // Prepare the log line
    $methodStr = $this->_getMethodStr( $method ) ;
    $indentStr = '' ;
    $indentStr = str_pad( $indentStr, $indentLevel * 2 + 1 ) ;
    $now       = $this->getTimeNow() ;
    $resStr    = self::bracket( $now ) . self::getLogLevelStr( $level ) . $methodStr . $indentStr . $str . "\r\n" ;

    // Write log (with lock mechanism)
    $this->_setLogFile() ;
    $fp = fopen( $this->logfile, 'a+' ) ;
    if( flock( $fp, LOCK_EX | LOCK_NB ) )
    {
      fseek( $fp, SEEK_END ) ;
      fputs( $fp, $resStr  ) ;
      flock( $fp, LOCK_UN  ) ;
    }
    fclose( $fp ) ;
  }

  protected function getDateNow()
  {
    return ( new DateTime( 'now', new DateTimeZone( $this->timezone ) ) )->format( 'Ymd' ) ; 
  }
  protected function getTimeNow()
  {
    return ( new DateTime( 'now', new DateTimeZone( $this->timezone ) ) )->format( 'Ymd_His' ) ; 
  }

  private  function _setLogFile()
  {
    $this->logfile = __DIR__ . DIRECTORY_SEPARATOR . $this->getDateNow() . ".log" ;
  }

  protected function _getMethodStr( $method )
  {
    $tmpSlashArr = explode( '\\', $method ) ;
    $method      = end( $tmpSlashArr ) ;
    $method      = $this->_adjustMethod( $method ) ;
    return self::bracket( $method ) ;
  }

  protected static function getLogLevelStr( $level )
  {
    switch( $level )
    {
    case self::LOG_VERBOSE :
      return "[VERBZ]" ;
    case self::LOG_TRACE :
      return "[TRACE]" ;
    case self::LOG_DEBUG :
      return "[DEBUG]" ;
    case self::LOG_INFO :
      return "[INFO ]" ;
    case self::LOG_INFOP :
      return "[INFOP]" ;
    case self::LOG_WARN :
    case self::LOG_WARNING :
      return "[WARNG]" ;
    case self::LOG_ERR :
    case self::LOG_ERROR :
      return "[ERROR]" ;
    case self::LOG_CRITICAL :
      return "[CRITK]" ;
    default :
      return "[     ]" ;
    }
  }

  protected static function bracket( $sstr )
  {
    return '[' . $sstr . ']' ;
  }

  private  function _adjustMethod( $methodName )
  {
    $_len = strlen( $methodName ) ;
    if( $_len === $this->adjustMethodLen )
    {
      return $methodName ;
    }
    else if( $_len > $this->adjustMethodLen )
    {
      return substr( $methodName, 0, $this->adjustMethodLen ) ;
    }
    else
    {
      $_delta = $this->adjustMethodLen - $_len ;
      $_post  = str_repeat( ' ', $_delta ) ;
      return $methodName . $_post ;
    }
  }
}


/* ****************************************************************************
   Web Requests Helper
*/
class Webs
{
  const CURL_ERROR_CODES = array(
     0 => 'CURLE_OK', 
     1 => 'CURLE_UNSUPPORTED_PROTOCOL', 
     2 => 'CURLE_FAILED_INIT', 
     3 => 'CURLE_URL_MALFORMAT', 
     4 => 'CURLE_URL_MALFORMAT_USER', 
     5 => 'CURLE_COULDNT_RESOLVE_PROXY', 
     6 => 'CURLE_COULDNT_RESOLVE_HOST', 
     7 => 'CURLE_COULDNT_CONNECT', 
     8 => 'CURLE_FTP_WEIRD_SERVER_REPLY',
     9 => 'CURLE_REMOTE_ACCESS_DENIED',
    11 => 'CURLE_FTP_WEIRD_PASS_REPLY',
    13 => 'CURLE_FTP_WEIRD_PASV_REPLY',
    14=>'CURLE_FTP_WEIRD_227_FORMAT',
    15 => 'CURLE_FTP_CANT_GET_HOST',
    17 => 'CURLE_FTP_COULDNT_SET_TYPE',
    18 => 'CURLE_PARTIAL_FILE',
    19 => 'CURLE_FTP_COULDNT_RETR_FILE',
    21 => 'CURLE_QUOTE_ERROR',
    22 => 'CURLE_HTTP_RETURNED_ERROR',
    23 => 'CURLE_WRITE_ERROR',
    25 => 'CURLE_UPLOAD_FAILED',
    26 => 'CURLE_READ_ERROR',
    27 => 'CURLE_OUT_OF_MEMORY',
    28 => 'CURLE_OPERATION_TIMEDOUT',
    30 => 'CURLE_FTP_PORT_FAILED',
    31 => 'CURLE_FTP_COULDNT_USE_REST',
    33 => 'CURLE_RANGE_ERROR',
    34 => 'CURLE_HTTP_POST_ERROR',
    35 => 'CURLE_SSL_CONNECT_ERROR',
    36 => 'CURLE_BAD_DOWNLOAD_RESUME',
    37 => 'CURLE_FILE_COULDNT_READ_FILE',
    38 => 'CURLE_LDAP_CANNOT_BIND',
    39 => 'CURLE_LDAP_SEARCH_FAILED',
    41 => 'CURLE_FUNCTION_NOT_FOUND',
    42 => 'CURLE_ABORTED_BY_CALLBACK',
    43 => 'CURLE_BAD_FUNCTION_ARGUMENT',
    45 => 'CURLE_INTERFACE_FAILED',
    47 => 'CURLE_TOO_MANY_REDIRECTS',
    48 => 'CURLE_UNKNOWN_TELNET_OPTION',
    49 => 'CURLE_TELNET_OPTION_SYNTAX',
    51 => 'CURLE_PEER_FAILED_VERIFICATION',
    52 => 'CURLE_GOT_NOTHING',
    53 => 'CURLE_SSL_ENGINE_NOTFOUND',
    54 => 'CURLE_SSL_ENGINE_SETFAILED',
    55 => 'CURLE_SEND_ERROR',
    56 => 'CURLE_RECV_ERROR',
    58 => 'CURLE_SSL_CERTPROBLEM',
    59 => 'CURLE_SSL_CIPHER',
    60 => 'CURLE_SSL_CACERT',
    61 => 'CURLE_BAD_CONTENT_ENCODING',
    62 => 'CURLE_LDAP_INVALID_URL',
    63 => 'CURLE_FILESIZE_EXCEEDED',
    64 => 'CURLE_USE_SSL_FAILED',
    65 => 'CURLE_SEND_FAIL_REWIND',
    66 => 'CURLE_SSL_ENGINE_INITFAILED',
    67 => 'CURLE_LOGIN_DENIED',
    68 => 'CURLE_TFTP_NOTFOUND',
    69 => 'CURLE_TFTP_PERM',
    70 => 'CURLE_REMOTE_DISK_FULL',
    71 => 'CURLE_TFTP_ILLEGAL',
    72 => 'CURLE_TFTP_UNKNOWNID',
    73 => 'CURLE_REMOTE_FILE_EXISTS',
    74 => 'CURLE_TFTP_NOSUCHUSER',
    75 => 'CURLE_CONV_FAILED',
    76 => 'CURLE_CONV_REQD',
    77 => 'CURLE_SSL_CACERT_BADFILE',
    78 => 'CURLE_REMOTE_FILE_NOT_FOUND',
    79 => 'CURLE_SSH',
    80 => 'CURLE_SSL_SHUTDOWN_FAILED',
    81 => 'CURLE_AGAIN',
    82 => 'CURLE_SSL_CRL_BADFILE',
    83 => 'CURLE_SSL_ISSUER_ERROR',
    84 => 'CURLE_FTP_PRET_FAILED',
    84 => 'CURLE_FTP_PRET_FAILED',
    85 => 'CURLE_RTSP_CSEQ_ERROR',
    86 => 'CURLE_RTSP_SESSION_ERROR',
    87 => 'CURLE_FTP_BAD_FILE_LIST',
    88 => 'CURLE_CHUNK_FAILED'
  ) ;


  const REST_REQUEST_STATUS   = 0 ;
  const REST_REQUEST_CURLCODE = 1 ;
  const REST_REQUEST_HTTPCODE = 2 ;
  const REST_REQUEST_RESULT   = 3 ;
  
  // Result : [ okFlag, curl_error, http_code, jsonResponse ]
  public static function restRequest( $url, $data = null, $header = null )
  {
    // Init
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url ) ;

    // POST Data (otherwise, GET)
    if( !empty( $data ) )
    {
      $dataString = http_build_query( $data ) ;
      curl_setopt( $ch, CURLOPT_POST        , true        ) ;
      curl_setopt( $ch, CURLOPT_POSTFIELDS  , $dataString ) ;
    }
    
    // Header
    if( !empty( $header ) )
    {
      curl_setopt( $ch, CURLOPT_HTTPHEADER  , $header     ) ;
    }

    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true        ) ; 

    // Call
    $result = curl_exec( $ch ) ;

    // Result
    $cerr = curl_errno(   $ch ) ;
    $info = curl_getinfo( $ch ) ;

    $res = [ true, self::CURL_ERROR_CODES[ $cerr ], $info[ 'http_code' ], null ] ;
    if( !$cerr )
    {
      $res[ self::REST_REQUEST_RESULT ] = json_decode( $result, true ) ;
      if( $res[ self::REST_REQUEST_HTTPCODE ] != 200 ) $res[ self::REST_REQUEST_STATUS ] = false ;
    }
    else
    {
      //echo "ERROR : " . $res[ self::REST_REQUEST_CURLCODE ] . "\n" ;
      $res[ self::REST_REQUEST_STATUS ] = false ;
    }
    //echo "Full result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
    curl_close( $ch ) ;

    return $res ;
  }
}


/* ****************************************************************************
   Command Line Tester
*/
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
    echo '> php <ConnectorName>.php -f --test="<testId>"' . "\n" ;
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
    echo '\nTest #' . $this->testId . " : '" . $this->testFunctions[ $this->testFunctionName ][ 'purpose' ] . "'\n---\n" ;
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

    $this->testFunctions[ 'test01' ] = [
      'purpose'  => 'Test Dynamics Authentication',
      'function' => function()
      {
        $st = $this->connector->interactionMgr->authenticate() ;
        echo "sessionToken = " . $st . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test02' ] = [
      'purpose'  => 'Test Basic Dynamics Web Service Query',
      'function' => function()
      {
        $request = 'contacts?$select=contactid,salutation,firstname,lastname,jobtitle,telephone1,mobilephone,emailaddress1,_parentcustomerid_value,description,address1_line1,address1_postalcode,address1_city&$filter=contains(mobilephone,' . "'xxxxxxxxxx')" ;
        $request = 'contacts(xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx)?$select=contactid,firstname,lastname,jobtitle,telephone1,mobilephone,emailaddress1,description' ;
        $request = 'contacts(xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx)' ;
        $res     = $this->connector->interactionMgr->wsGet( $request ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test03' ] = [
      'purpose'  => 'Test Dynamics Query Entries List (automatic authentication)',
      'function' => function()
      {
        $entityType = "contacts" ;
        $field      = "mobilephone" ;
        $value      = "xxxxxxxxxx" ;
        $operation  = "contains" ;
        $fields     = [ 'contactid', 'salutation', 'firstname', 'lastname', 'jobtitle', 'telephone1', 'mobilephone', 'emailaddress1', '_parentcustomerid_value', 'description', 'address1_line1', 'address1_postalcode', 'address1_city' ] ;
        $res        = $this->connector->interactionMgr->getEntriesList( $entityType, $field, $value, $operation, $fields ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test04' ] = [
      'purpose'  => 'Test Dynamics Query Single Entry by Id (automatic authentication)',
      'function' => function()
      {
        $type  = 'contacts' ;
        $id    = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' ;
        $res   = $this->connector->interactionMgr->getSingleEntry( $type, $id ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test05' ] = [
      'purpose'  => 'Test Entities Manager getEntryLabel',
      'function' => function()
      {
        $entityType = 'contacts' ;
        $id         = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' ;
        $entry      = $this->connector->interactionMgr->getSingleEntry( $entityType, $id ) ;

        $type       = $this->connector->entitiesMgr->getEntityType( $entityType ) ;
        $label      = $this->connector->entitiesMgr->getEntryLabel( $type, $entry ) ;
        echo "label = " . json_encode( $label, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test06' ] = [
      'purpose'  => 'Test Entities Manager getEntryInstance',
      'function' => function()
      {
        $entityType = 'contacts' ;
        $id         = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' ;
        $entry      = $this->connector->interactionMgr->getSingleEntry( $entityType, $id ) ;

        $type       = $this->connector->entitiesMgr->getEntityType( $entityType ) ;
        $pentry     = $this->connector->entitiesMgr->getPackagedEntry( $type, $entry ) ;
        echo "entry = " . json_encode( $pentry, JSON_PRETTY_PRINT ) . "\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test07' ] = [
      'purpose'  => 'Test Connector find Entry by id',
      'function' => function()
      {
        $entityType = 'contacts' ;
        $id         = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' ;
        $entry      = $this->connector->findEntryById( $entityType, $id ) ;

        if( $entry === null ) echo "! NO entry found for id=" . $id . "\n" ;
        else                  echo "OK : entry found for id=" . $id . " (see logs)\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test08' ] = [
      'purpose'  => 'Test Connector find Entry by query',
      'function' => function()
      {
        $entityType = 'contacts' ;
        $queryVal   = "xxxxxxxxxx" ;
        $entry      = $this->connector->findEntriesByQuery( $entityType, $queryVal ) ;

        if( $entry === null ) echo "! NO entry found for query=" . $queryVal . "\n" ;
        else                  echo "OK : entry found for query=" . $queryVal . " (see logs)\n" ;
      } 
    ] ;


    $this->testFunctions[ 'test09' ] = [
      'purpose'  => 'Test Connector find One Entry (by ParameterBag)',
      'function' => function()
      {
        $entityType   = "contacts" ;
        $pbParameter  = '' ;
        $pbContext    = [
          //'CCKContactId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
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


// Enable command line test if ran by a command shell
if( php_sapi_name() == 'cli' )
{
  // Usage example :
  // > php <ConnectorName>.php -f --test=00
  new CommandLineTester() ;
}
?>