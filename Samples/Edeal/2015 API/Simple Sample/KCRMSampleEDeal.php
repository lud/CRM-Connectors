<?php

namespace UserFiles\Connectors\KCRMSampleEDeal ;

define( "CONNECTOR", "KCRMSampleEDeal" ) ;


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


require_once( __DIR__ . '/nusoap-0.9.5/nusoap.php' ) ;

use \DateTime, \DateTimeZone ;


class KCRMSampleEDeal implements KiamoConnectorInterface, 
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
  const ServiceName = "EDeal" ;
  const ModuleName  = __CLASS__    ;
  const ModuleDesc  = self::ServiceName . " Connector Sample" ;

  public  function __construct()
  {
    $this->initConfig() ;
    $this->logger         = new Logger( $this->getConf( 'runtime', 'logLevel' ) ) ;

    $this->log( "------------------------------------------------------------------------------", Logger::LOG_INFOP, __METHOD__ ) ;
    $this->interactionMgr = new InteractionManagerEDeal( $this ) ;
    $this->entitiesMgr    = new EntitiesManager(         $this ) ;
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
      'service'       => 'edeal',
      'definition'    => '201508_01',
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
          'url'           => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
          'namespace'     => 'http://www.e-deal.com',
          'apiVersion'    => '201508',
        ],

        'authent'       => [
          'url'           => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/ws/SimpleWS?wsdl',
          'account'       => [
            'adminUser'     => [
              'username'       => 'xxxxxxxxxxxx',
              'password'       => 'xxxxxxxxxxxxx',
            ],
          ],
        ],
      ],

      // Direct View and Search URLs
      'urls'         => [
        'view'          => [
          'baseUrl'        => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',  // CRM platform instance URL
          'contact'        => [ 'prefix' => '/read_person.fl?id='            , 'postfix' => '' ],
          'company'        => [ 'prefix' => '/read_enterprise.fl?id='        , 'postfix' => '' ],
          'ticket'         => [ 'prefix' => '/read_interaction.fl?id='       , 'postfix' => '' ],
        ],
        'search'        => [
          'baseUrl'        => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',  // CRM platform instance URL
          'contact'        => [ 'prefix' => '/list_criteria.fl?lc=FUNCTIONS' , 'postfix' => '' ],
          'company'        => [ 'prefix' => '/list_criteria.fl?lc=ENTERPRISE', 'postfix' => '' ],
          'ticket'         => [ 'prefix' => '/list_criteria.fl?lc=INTERTODO' , 'postfix' => '' ],
        ],
      ],
    ] ;


    // External CRM Entities Mapping
    // ---
    $this->entityMappingConf = [
      // CRM entities definitions : fields, operations and mapping with Kiamo entities
      // Note :
      // - an entity is a "class", an entry is an actual "instance"
      'map'          => [
        'Person'        => 'contact' ,
        'Enterprise'    => 'company' ,
        'Interaction'   => 'ticket'  ,
        'Correspondent' => 'customer',
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
        'PerID'                => [ 'key' => 'id'       , 'label' => 'Identifiant'  , 'type' => 'id'    , 'display' => false, 'map' => 'CCKContactId'             ],
        'PerCivID:RefVal'      => [ 'key' => ''         , 'label' => 'Civilite'     , 'type' => 'string', 'display' => true , 'map' => 'contactTitle'             ],
        'PerFstName'           => [ 'key' => 'firstname', 'label' => 'Prenom'       , 'type' => 'string', 'display' => true , 'map' => 'contactFirstName'         ],
        'PerName'              => [ 'key' => 'lastname' , 'label' => 'Nom'          , 'type' => 'string', 'display' => true , 'map' => 'contactLastName'          ],
        'PerTitle'             => [ 'key' => ''         , 'label' => 'Titre'        , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerPhone'             => [ 'key' => 'phone'    , 'label' => 'Telephone'    , 'type' => 'phone' , 'display' => true , 'map' => 'contactPhoneNumber'       ],
        'PerMobile'            => [ 'key' => 'mobile'   , 'label' => 'Mobile'       , 'type' => 'phone' , 'display' => true , 'map' => 'contactMobilePhoneNumber' ],
        'PerMail'              => [ 'key' => 'email'    , 'label' => 'EMail'        , 'type' => 'email' , 'display' => true , 'map' => 'contactEmail'             ],
        'PerLngPrinc:RefVal'   => [ 'key' => ''         , 'label' => 'Langue'       , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerEntID'             => [ 'key' => 'companyId', 'label' => 'Id Entreprise', 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'             ],
        'PerEntID:EntCorpName' => [ 'key' => ''         , 'label' => 'Entreprise'   , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerRemarks'           => [ 'key' => ''         , 'label' => 'Notes'        , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerAd1'               => [ 'key' => ''         , 'label' => 'Adresse L#1'  , 'type' => 'string', 'display' => true , 'map' => 'contactPrimaryAddress'    ],
        'PerAd2'               => [ 'key' => ''         , 'label' => 'Adresse L#2'  , 'type' => 'string', 'display' => true , 'map' => 'contactSecondaryAddress'  ],
        'PerAd3'               => [ 'key' => ''         , 'label' => 'Adresse L#3'  , 'type' => 'string', 'display' => false, 'map' => ''                         ],
        'PerZip'               => [ 'key' => ''         , 'label' => 'Code postal'  , 'type' => 'string', 'display' => true , 'map' => 'contactZipCode'           ],
        'PerCity'              => [ 'key' => ''         , 'label' => 'Ville'        , 'type' => 'string', 'display' => true , 'map' => 'contactCity'              ],
        'PerDDC'               => [ 'key' => ''         , 'label' => 'Dernier appel', 'type' => 'string', 'display' => false, 'map' => ''                         ],
      ],
      
      // Search algorithms
      // where :
      // - we loop on each line
      // - we exit the loop as soon as a match is found
      'search'      => [
        // Search based on Kiamo input (for instance, a phone number passing through a SVI)
        'kiamoInputs'  => [
          '01'            => [ 'varName' => 'KiamoEDealContactPhone', 'entityField' =>        'phone', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '02'            => [ 'varName' =>           'CCKContactId', 'entityField' =>           'id', 'operation' => 'equals', 'preTrt' => ''                    ],
          '04'            => [ 'varName' =>             'CustNumber', 'entityField' =>        'phone', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '05'            => [ 'varName' =>             'CustNumber', 'entityField' =>       'mobile', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '06'            => [ 'varName' =>            'EMailSender', 'entityField' =>        'email', 'operation' =>  'like' , 'preTrt' => ''                    ],
        ],
        // A manual agent search string (in Kiwi)
        'agentQuery'   => [
          '01'            => [                                        'entityField' =>       'mobile', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '02'            => [                                        'entityField' =>        'phone', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '03'            => [                                        'entityField' =>        'email', 'operation' =>  'like' , 'preTrt' => ''                    ],
          '04'            => [                                        'entityField' =>     'lastname', 'operation' =>  'like' , 'preTrt' => ''                    ],
          '05'            => [                                        'entityField' =>    'firstname', 'operation' =>  'like' , 'preTrt' => ''                    ],
          '06'            => [                                        'entityField' =>           'id', 'operation' => 'equals', 'preTrt' => ''                    ],
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
        'EntID'       => [ 'key' => 'id'     , 'label' => 'Identifiant', 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'            ],
        'EntCorpName' => [ 'key' => 'name'   , 'label' => 'Nom'        , 'type' => 'string', 'display' => true , 'map' => 'companyName'             ],
        'EntAcronym'  => [ 'key' => ''       , 'label' => 'Acronyme'   , 'type' => 'string', 'display' => true , 'map' => ''                        ],
        'EntPhone'    => [ 'key' => 'phone'  , 'label' => 'Telephone'  , 'type' => 'phone' , 'display' => true , 'map' => 'companyPhoneNumber'      ],
        'EntWeb'      => [ 'key' => 'website', 'label' => 'Site Web'   , 'type' => 'url'   , 'display' => true , 'map' => ''                        ],
        'EntSector'   => [ 'key' => ''       , 'label' => 'Secteur'    , 'type' => 'string', 'display' => true , 'map' => 'companyType'             ],
        'EntAd1'      => [ 'key' => ''       , 'label' => 'Adresse L#1', 'type' => 'string', 'display' => true , 'map' => 'companyPrimaryAddress'   ],
        'EntAd2'      => [ 'key' => ''       , 'label' => 'Adresse L#2', 'type' => 'string', 'display' => true , 'map' => 'companySecondaryAddress' ],
        'EntAd3'      => [ 'key' => ''       , 'label' => 'Adresse L#3', 'type' => 'string', 'display' => false, 'map' => ''                        ],
        'EntZip'      => [ 'key' => ''       , 'label' => 'Code postal', 'type' => 'string', 'display' => true , 'map' => 'companyZipCode'          ],
        'EntCity'     => [ 'key' => ''       , 'label' => 'Ville'      , 'type' => 'string', 'display' => true , 'map' => 'companyCity'             ],
      ],
      
      // Search algorithms
      // where :
      // - we loop on each line
      // - we exit the loop as soon as a match is found
      'search'      => [
        // Search based on Kiamo input (for instance, a phone number passing through a SVI)
        'kiamoInputs'  => [
          '01'            => [ 'varName' => 'KiamoEDealCompanyId', 'entityField' =>     'id', 'operation' => 'equals', 'preTrt' => ''                    ],
          '02'            => [ 'varName' =>        'CCKCompanyId', 'entityField' =>     'id', 'operation' => 'equals', 'preTrt' => ''                    ],
          '04'            => [ 'varName' =>          'CustNumber', 'entityField' =>  'phone', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '05'            => [ 'varName' =>          'CustNumber', 'entityField' => 'mobile', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '06'            => [ 'varName' =>         'EMailSender', 'entityField' =>  'email', 'operation' =>  'like' , 'preTrt' => ''                    ],
        ],
        
        // A manual agent search string (in Kiwi)
        'agentQuery'   => [
          '01'            => [                                     'entityField' =>  'phone', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '02'            => [                                     'entityField' => 'mobile', 'operation' =>  'like' , 'preTrt' => 'injectInPhoneNumber' ],
          '03'            => [                                     'entityField' =>  'email', 'operation' =>  'like' , 'preTrt' => ''                    ],
          '04'            => [                                     'entityField' =>   'name', 'operation' =>  'like' , 'preTrt' => ''                    ],
          '05'            => [                                     'entityField' =>     'id', 'operation' => 'equals', 'preTrt' => ''                    ],
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
        'IntID'           => [ 'key' => 'id'         , 'label' => 'Identifiant'       , 'type' => 'id'     , 'display' => true , 'map' => 'CCKTicketId'    ],
        'IntCrDt'         => [ 'key' => ''           , 'label' => 'Cree le'           , 'type' => 'date'   , 'display' => true , 'map' => 'ticketOpenDate' ],
        'IntUpd'          => [ 'key' => 'lastUpdate' , 'label' => 'Date de modif.'    , 'type' => 'date'   , 'display' => true , 'map' => ''               ],
        'IntDate'         => [ 'key' => 'date'       , 'label' => 'Date'              , 'type' => 'date'   , 'display' => true , 'map' => ''               ],
        'IntTimeBeg'      => [ 'key' => 'timeBegin'  , 'label' => 'Heure de debut'    , 'type' => 'time'   , 'display' => true , 'map' => ''               ],
        'IntTimeEnd'      => [ 'key' => 'timeEnd'    , 'label' => 'Heure de fin'      , 'type' => 'time'   , 'display' => true , 'map' => ''               ],
        'IntAtvID:RefVal' => [ 'key' => 'activity'   , 'label' => 'Activite'          , 'type' => 'string' , 'display' => true , 'map' => ''               ],
        'IntSubject'      => [ 'key' => 'subject'    , 'label' => 'Sujet'             , 'type' => 'string' , 'display' => true , 'map' => 'ticketLabel'    ],
        'IntCatID:RefVal' => [ 'key' => ''           , 'label' => 'Categorie'         , 'type' => 'string' , 'display' => true , 'map' => ''               ],
        'IntInType'       => [ 'key' => ''           , 'label' => 'Entrant/Sortant'   , 'type' => 'boolean', 'display' => true , 'map' => ''               ],
        'IntStiID:RefVal' => [ 'key' => 'status'     , 'label' => 'Etat'              , 'type' => 'string' , 'display' => true , 'map' => 'ticketStatus'   ],
        'IntMedID:RefVal' => [ 'key' => ''           , 'label' => 'Canal'             , 'type' => 'string' , 'display' => true , 'map' => ''               ],
        'IntDetails'      => [ 'key' => ''           , 'label' => 'Details'           , 'type' => 'string' , 'display' => true , 'map' => ''               ],
        'IntDmdID'        => [ 'key' => ''           , 'label' => 'Demande (Id)'      , 'type' => 'id'     , 'display' => true , 'map' => ''               ],
        'IntCreID'        => [ 'key' => ''           , 'label' => 'Createur (Id)'     , 'type' => 'id'     , 'display' => true , 'map' => ''               ],
        'IntEmetteur'     => [ 'key' => ''           , 'label' => 'Emetteur (Id)'     , 'type' => 'id'     , 'display' => true , 'map' => ''               ],
        'IntModID'        => [ 'key' => ''           , 'label' => 'Modifie par (Id)'  , 'type' => 'id'     , 'display' => true , 'map' => ''               ],
        'IntActID'        => [ 'key' => ''           , 'label' => 'Acteurs'           , 'type' => 'multi'  , 'display' => false, 'map' => ''               ],
        'IntCorID'        => [ 'key' => 'customerIds', 'label' => 'Correspondants'    , 'type' => 'multi'  , 'display' => true , 'map' => ''               ],
        'IntParentOwners' => [ 'key' => ''           , 'label' => 'Parents'           , 'type' => 'multi'  , 'display' => false, 'map' => ''               ],
        'IntOrigID'       => [ 'key' => ''           , 'label' => 'Origine (Int Id)'  , 'type' => 'id'     , 'display' => true , 'map' => ''               ],
        'IntParLot'       => [ 'key' => ''           , 'label' => 'IntParent (Int Id)', 'type' => 'id'     , 'display' => true , 'map' => ''               ],
      ],

      // Search algorithms
      // where :
      // - we loop on each line
      // - we exit the loop as soon as a match is found
      'search'      => [ 
        // Search based on Kiamo input (for instance, a phone number passing through a SVI)
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>  'KiamoEDealTicketId', 'entityField' =>        'id', 'operation' => 'equals', 'preTrt' => ''             ],
          '02'            => [ 'varName' =>         'CCKTicketId', 'entityField' =>        'id', 'operation' => 'equals', 'preTrt' => ''             ],
          '03'            => [ 'varName' =>        'CCKContactId', 'entityField' => 'contactId', 'operation' => 'equals', 'preTrt' => 'getCustomers' ],
          '04'            => [ 'varName' =>        'CCKCompanyId', 'entityField' => 'companyId', 'operation' => 'equals', 'preTrt' => 'getCustomers' ],
        ],
        // A manual agent search string (in Kiwi)
        'agentQuery'   => [
          '01'            => [                                     'entityField' =>        'id', 'operation' => 'equals', 'preTrt' => ''             ],
          '02'            => [                                     'entityField' => 'contactId', 'operation' => 'equals', 'preTrt' => 'getCustomers' ],
          '02'            => [                                     'entityField' => 'companyId', 'operation' => 'equals', 'preTrt' => 'getCustomers' ],
        ],
      ],
    ] ;


    // CUSTOMER definition and mapping
    // ---
    // Note : the CUSTOMER is the mandatory link between a CONTACT or a COMPANY and the related TICKETS
    $this->customerConf = [
      'map'               => [
        'CorID'              => [ 'key' => 'id'       , 'label' => 'Identifiant'       , 'type' => 'id', 'display' => false, 'map' => '' ],
        'CorEntID'           => [ 'key' => 'companyId', 'label' => "Id de l'entreprise", 'type' => 'id', 'display' => false, 'map' => '' ],
        'CorPerID'           => [ 'key' => 'contactId', 'label' => "Id de la personne" , 'type' => 'id', 'display' => false, 'map' => '' ],
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
    case "customer" :
      $conf = &$this->customerConf ;
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
    $entry     = null ;

    $extType   = $this->entitiesMgr->getEntityType( $type ) ;
    $extFields = array_keys( $this->entitiesMgr->getEntityFields( $type ) ) ;
    $raw       = $this->interactionMgr->getSingleEntry( $extType, $id, $extFields ) ;

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
      $varName = $searchItem[ 'varName' ] ;

      // Search entries matching the current search item (eligibility, pre-treatment, post-treatment)
      $pbParamValue = $parameters->$varName ;
      $preparedResult = $this->findEntriesBySearchPattern( $type, $pbParamValue, $searchItem ) ;
      if( empty( $preparedResult ) ) continue ;
      

      // Select one of the list
      $res = $preparedResult[0]['item'] ;  // By default, select the first returned result
      
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
    $preTrt      = $searchPatternItem[ 'preTrt'      ] ;
    
    $this->log( "Searching entry type='" . $type . "', value='" . $paramValue . "', pattern=" . json_encode( $searchPatternItem ) . ", preTrt='" . $preTrt . "'", Logger::LOG_DEBUG, __METHOD__ ) ;

    // Skip empty values
    if( empty( $paramValue ) ) return null ;

    // Here can be formatted the passed param
    $preparedParamValue = $paramValue ;
    $customers          = []          ;  // Special case : tickets
    
    if( !empty( $preTrt ) && method_exists( $this, $preTrt ) )
    {
      // !!! Special case : tickets
      // In order to get tickets, you have to get the contact or company associated customers
      if( $preTrt === 'getCustomers' )
      {
        $preTrtData            = []           ;
        $preTrtData[ 'field' ] = $entityField ;
        $preTrtData[ 'value' ] = $paramValue  ;
        $customers             = $this->$preTrt( $preTrtData ) ;
        $this->log( "Pre-treatment '" . $preTrt . "' : " . $entityField . "=" . $paramValue . " => " . sizeof( $customers ) . " related customer(s) found", Logger::LOG_DEBUG, __METHOD__ ) ;
      }
      else
      {
        $preparedParamValue = $this->$preTrt( $paramValue ) ;
        $this->log( "Pre-treatment '" . $preTrt . "' : " . $entityField . "=" . $paramValue . " => '" . $preparedParamValue . "'", Logger::LOG_DEBUG, __METHOD__ ) ;
      }
    }

    // Search a match on the external Service
    $extType           = $this->entitiesMgr->getEntityType(               $type               ) ;
    $extField          = $this->entitiesMgr->getEntityField(              $type, $entityField ) ;
    $extFields         = array_keys( $this->entitiesMgr->getEntityFields( $type               ) ) ;
    $extRequestResults = [] ;

    // !!! Special case : tickets
    // Get tickets via the related customers
    if( $preTrt === 'getCustomers' )
    {
      $extField = $this->entitiesMgr->getEntityField( $type, 'customerIds' ) ;
      foreach( $customers as $customer )
      {
        $customerIdFieldPos = $this->entitiesMgr->getEntityFieldPosition( $type, 'id' ) ;
        $customerId         = $customer[ 'item' ][ $customerIdFieldPos ] ;
        if( empty( $customerId ) ) continue ;  // Just in case something goes wrong, no need to get all the platform tickets
        $tmpRes             = $this->interactionMgr->getEntriesList( $extType, $extField, $customerId, $operation, $extFields ) ;
        if( !empty( $tmpRes ) ) $extRequestResults = array_merge( $extRequestResults, $tmpRes ) ;
      }
    }
    else
    {
      $extRequestResults = $this->interactionMgr->getEntriesList( $extType, $extField, $preparedParamValue, $operation, $extFields ) ;
    }
    if( empty( $extRequestResults ) ) return null ;  // Return if no match
    
    // Here can be applied post treatments on the result list
    $preparedResults = &$extRequestResults ;
    
    return $preparedResults ;
  }

  // getCustomerIds (for given contactId or companyId)
  // ---
  public   function getCustomers( $data, $additionalData = null )
  {
    $res = [] ;

    $field = $data[ 'field' ] ;
    $value = $data[ 'value' ] ;

    // Searching customers corresponding to the entity Id
    $type       = 'customer' ;
    $etype      = $this->entitiesMgr->getEntityType(  $type ) ;
    $efield     = $this->entitiesMgr->getEntityField( $type, $field ) ;
    $operation  = "like" ;
    $efields    = array_keys( $this->entitiesMgr->getEntityFields( $type ) ) ;

    $res        = $this->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
    
    $this->log( "Found " . sizeof( $res ) . " customer(s) for " . $field . "=" . $value, Logger::LOG_DEBUG, __METHOD__ ) ;
    
    return $res ;
  }
  
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
   EDeal Interactions Manager
   ***
   Purpose :
   - Web Services authentication
   - search CRM entries matching the inputs (search string, id)
*/
class InteractionManagerEDeal
{
  public   function __construct( $_parent )
  {
    $this->_parent      = $_parent ;
    $this->accessData   = $this->_parent->getConf( "access", 'accessdata' ) ;
    $this->sessionToken = null ;
    
    $this->initSoapClient() ;

    $this->log( "INIT : OK", Logger::LOG_DEBUG, __METHOD__ ) ;
  }
  
  private  function initSoapClient()
  {
    $this->wsdl       = $this->_parent->getConf( "access", 'accessdata.authent.url' ) ;
    $this->_namespace = $this->_parent->getConf( "access", 'accessdata.platform.namespace' ) ;

    $this->client     = new \nusoap_client( $this->wsdl, false ) ;

    $this->client->soap_defencoding = 'UTF-8' ;
    $this->client->decode_utf8      = true ;
  }


  /* *************************************************************************
     Main
  */

  public   function getSingleEntry( $entityType, $entityId, $outfields )
  {
    $authenticated = $this->authenticate() ;
    if( $authenticated === false )
    {
      $this->log( "Authentication failure.", Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }

    $this->log( "Type = " . $entityType . ", Id = " . $entityId, Logger::LOG_INFO, __METHOD__ ) ;
    
    $params = [
      0 => $entityType,
      1 => $entityId,
      2 => $outfields  ] ;
    $res = $this->call( 'getSingleObject', $params ) ;
    
    if( empty( $res ) || ( array_key_exists( 'item', $res ) && empty( $res[ 'item' ] ) ) ) return null ;

    return $res[ 'item' ] ;
  }

  public   function getEntriesList( $entityType, $field, $value, $operation, $fields )
  {
    $authenticated = $this->authenticate() ;
    if( $authenticated === false )
    {
      $this->log( "Authentication failure.", Logger::LOG_ERROR, __METHOD__ ) ;
      return null ;
    }

    $this->log( "Querying type='" . $entityType . "', field=" . $field . "', value='" . $value . "', operation='" . $operation . "'...", Logger::LOG_INFOP, __METHOD__ ) ;
    $_query  = $this->getQuery( $entityType, $field, $value, $operation, $fields ) ;
    $params  = [
      0 => $entityType,
      1 => $fields, 
      2 => $_query
    ] ;
    $res = $this->call( 'getObjectList', $params ) ;

    if( empty( $res ) || ( array_key_exists( 'item', $res ) && empty( $res[ 'item' ] ) ) )
    {
      $this->log( "=> No match", Logger::LOG_INFOP, __METHOD__ ) ;
      return null ;
    }
    $this->log( "=> " . sizeof( $res[ 'item' ] ) . " match(es) found", Logger::LOG_INFOP, __METHOD__ ) ;
    if( sizeof( $res[ 'item' ] ) === 1 ) return [ $res[ 'item' ] ] ;

    return $res[ 'item' ] ;
  }


  /* *************************************************************************
     Main Tools
  */
  public   function authenticate()
  {
    $this->log( "Authentication attempt, url : " . $this->wsdl, Logger::LOG_INFO, __METHOD__ ) ;

    $authentData = $this->accessData[  'authent'  ] ;

    $username    = $authentData[ 'account' ][ 'adminUser' ][ 'username' ] ;
    $password    = $authentData[ 'account' ][ 'adminUser' ][ 'password' ] ;

    // Authenticate
    $params    = [ 0 => $username,
                   1 => $password ] ;
    $response = $this->client->call( 'authenticate', $params ) ;
    $res      = ( $response === 'true' ) ;

    // Authentication Failed
    if( $res !== true )
    {
      $this->log( "Authentication FAILED.", Logger::LOG_WARN, __METHOD__ ) ;
      return false ;
    }

    // Authentication OK
    $this->log( "Authentication OK.", Logger::LOG_INFO, __METHOD__ ) ;
    return true ;
  }


  public  function  getQuery( $entityType, $field, $value, $operation, &$fields )
  {
    $_queryStr = null ;
    switch( $operation )
    {
    case 'contains' :
      $_queryStr  = $field . " contains ('" . $value . "')" ;
      break ;
    default :
      $_queryStr = $field .      " like '%" . $value . "%'" ;
      break ;
    }
    $res = [ $_queryStr ] ;
    return $res ;
  }
  

  /* **************************************************************************
     Inner Tools
  */

  public function call( $functionName, $parameters, $inputHeaders = null, &$outputHeaders = null )
  {
    $res = null ;
    try
    {
      $this->log( "Calling ws='" . $functionName . "' with params='" . json_encode( $parameters ) . "'", Logger::LOG_VERBOSE, __METHOD__ ) ;
      $res = $this->client->call( $functionName, $parameters, $this->_namespace, $this->_namespace ) ;
    }
    catch( Exception $e )
    {
      $this->log( "CALL EXCEPTION ! : " . $e->getTraceAsString(), Logger::LOG_ERR, __METHOD__ ) ;
    }
    return $res ;
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
      $packagedEntry = $this->getPackagedEntry( $type, $externalInstanceData[ 'item' ] ) ;
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
    case 'contact'  :
    case 'company'  :
    case 'dossier'  :
    case 'ticket'   :
    case 'customer' :
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
        $labelField = $this->getEntityFieldPosition( $type, 'lastname' ) ;
        $res        = $values[ $labelField ] ;
        break ;
      case 'company' :
        $labelField = $this->getEntityFieldPosition( $type, 'name' ) ;
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
        $labelField = $this->getEntityFieldPosition( $type, $strItem[ 'value' ] ) ;
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

    // Map values with fields
    $_entityFields = $this->getEntityFields( $type ) ;
    $_values          = [] ;
    $res[ 'values' ]  = [] ;
    $i                = 0 ;
    foreach( $_entityFields as $name => $desc )
    {
      $cur = utf8_encode( $values[$i] ) ;
      array_push( $_values, $cur ) ;
      $res[ 'values' ][ $name ] = $cur ;
      $i++ ;
    }

    $res[ 'layout' ]  = $this->getEntityLayout(        $type          ) ;
    $_idField         = $this->getEntityFieldPosition( $type, 'id'    ) ;
    $res[ 'id'     ]  = $values[                       $_idField      ] ;
    $res[ 'exturl' ]  = $this->getEntryExternalUrl(    $type, $_values ) ;
    $res[ 'label'  ]  = $this->getEntryLabel(          $type, $_values ) ;

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
    $_idField    = $this->getEntityFieldPosition( $type, 'id' ) ;
    $id          = $values[ $_idField ] ;
    $urlPatterns = $this->getConf( "access", "urls.view" ) ;
    $urlPattern  = $urlPatterns[ $type ] ;
    $res         = $urlPatterns[ 'baseUrl' ] . $urlPattern[ 'prefix' ] . $id . $urlPattern[ 'postfix' ] ;
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

  public   function getEntityFieldPosition( $type, $internalKey )
  {
    $res = '' ;
    $map = $this->getEntityFields( $type ) ;
    $i = 0 ;
    foreach( $map as $key => $val )
    {
      if( $val[ 'key' ] === $internalKey )
      {
        break ;
      }
      $i++ ;
    }
    return $i ;
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
    echo "\nTest #" . $this->testId . " : '" . $this->testFunctions[ $this->testFunctionName ][ 'purpose' ] . "'\n---\n" ;
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
      'purpose'  => 'Test EDeal Authentication',
      'function' => function()
      {
        $st = $this->connector->interactionMgr->authenticate() ;
        $ok = ( $st === true ) ? 'Ok' : '!!! KO !!!' ;
        echo "Authentication : " . $ok . "\n" ;
      } 
    ] ;
    

    $this->testFunctions[ 'test02' ] = [
      'purpose'  => 'getSingleEntry',
      'function' => function()
      {
        $type    = 'contact' ;
        $etype   = $this->connector->entitiesMgr->getEntityType( $type ) ;
        $efields = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $id      = 'xxxxxxxxxxxxxxxxxxxx' ;
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
        $etype      = $this->connector->entitiesMgr->getEntityType( $type ) ;
        $efields    = array_keys( $this->connector->entitiesMgr->getEntityFields( $type ) ) ;
        $field      = 'phone' ;
        $efield     = $this->connector->entitiesMgr->getEntityField( $type, $field ) ;
        $value      = "xx xx xx xx" ;
        $operation  = "like" ;

        // Raw result
        $res        = $this->connector->interactionMgr->getEntriesList( $etype, $efield, $value, $operation, $efields ) ;
        echo "Raw result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n\n" ;

        // Packaged result
        $ret        = $this->connector->entitiesMgr->getPackagedEntry( $type, $res[0][ 'item' ] ) ;
        echo "Packaged result : \n" . json_encode( $ret, JSON_PRETTY_PRINT ) . "\n\n" ;

        // Kiamo Uniq result
        $ret        = $this->connector->entitiesMgr->getEntryInstance( $type, $res[0][ 'item' ] ) ;
        echo "Kiamo mapping to Instance   ==> class is '" . get_class( $ret ) . "'\n" ;

        // Kiamo List result
        $ret        = $this->connector->entitiesMgr->getEntriesCollection( $type, $res ) ;
        echo "Kiamo mapping to Collection ==> class is '" . get_class( $ret ) . "'\n" ;
      }
    ] ;


    $this->testFunctions[ 'test04' ] = [
      'purpose'  => 'findContactById',
      'function' => function()
      {
        $id         = "xxxxxxxxxxxxxxxx" ;
        $res        = $this->connector->findContactById( $id ) ;
        echo "Kiamo mapping to Instance ==> class is '" . get_class( $res ) . "'\n" ;
      }
    ] ;


    $this->testFunctions[ 'test05' ] = [
      'purpose'  => 'findOneContact',
      'function' => function()
      {
        $specialParameter                    = '' ;
        $context                             = [] ;
        $context[ 'CustNumber' ]             = "xxxxxxxxxx" ;
        $pb                                  = new ParameterBag( $specialParameter, $context ) ;
        $res                                 = $this->connector->findOneContact( $pb ) ;
        echo "Kiamo mapping to Instance ==> class is '" . get_class( $res ) . "'\n" ;
      }
    ] ;


    $this->testFunctions[ 'test06' ] = [
      'purpose'  => 'findContactsByQuery',
      'function' => function()
      {
        $query = "xxxxxxxxxxx" ;
        $pb    = new ParameterBag() ;
        $res   = $this->connector->findContactsByQuery( $query, $pb ) ;
        echo "Kiamo mapping to Collecton ==> class is '" . get_class( $res ) . "'\n" ;
      }
    ] ;


    $this->testFunctions[ 'test07' ] = [
      'purpose'  => 'getCustomers',
      'function' => function()
      {
        $field      = 'contactId' ;
        $value      = "xxxxxxxxxxxxxxxxxx" ;
        $data       = [
          'field'     => $field,
          'value'     => $value,
        ] ;
        $res        = $this->connector->getCustomers( $data ) ;
        echo "Result : \n" . json_encode( $res, JSON_PRETTY_PRINT ) . "\n" ;
      }
    ] ;


    $this->testFunctions[ 'test08' ] = [
      'purpose'  => 'findTicket',
      'function' => function()
      {
        $specialParameter                    = '' ;
        $context                             = [] ;
        $context[ 'CCKContactId' ]           = "xxxxxxxxxxxxxxxxxx" ;
        $pb                                  = new ParameterBag( $specialParameter, $context ) ;
        $res                                 = $this->connector->findOneTicket( $pb ) ;
        echo "Kiamo mapping to Instance ==> class is '" . get_class( $res ) . "'\n" ;
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