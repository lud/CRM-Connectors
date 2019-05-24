<?php
return [
  'self'        => [
    'service'      => 'edeal',
    'version'      => 'genericsample',
  ],
  'protocol'    => [
    'definition'  => '201508_01',
  ],
  
  'environments' => [
    'test'         => [
      'accessdata'   => [
      
        'platform'      => [
          'url'           => 'http://xxxxxxxxxxxxx.e-deal.com/yyyyyyyyyyyyyy',
          'namespace'     => 'http://www.e-deal.com',
          'apiVersion'    => '201508',
        ],

        'authent'       => [
          'url'           => 'http://xxxxxxxxxxxxx.e-deal.com/yyyyyyyyyyyyyy/ws/SimpleWS?wsdl',
          'account'       => [
            'adminUser'     => [
              'username'       => 'xxxxxxxxxxx',
              'password'       => 'xxxxxxxxxx',
            ],
          ],
        ],

      ],

      'urls'         => [

        'view'          => [
          'baseUrl'       => 'https://xxxxxxxxxxxxx.e-deal.com/yyyyyyyyyyyyyy',

          'contact'       => [
            'prefix'        => '/read_person.fl?id=',
            'postfix'       => '',
          ],
          'company'       => [ 
            'prefix'        => '/read_enterprise.fl?id=',
            'postfix'       => '',
          ],
          'ticket'        => [ 
            'prefix'        => '/read_interaction.fl?id=',
            'postfix'       => '',
          ],
        ],

        'search'     => [
          'baseUrl'    => 'https://xxxxxxxxxxxxx.e-deal.com/yyyyyyyyyyyyyy',

          'contact'       => [
            'prefix'        => '/list_criteria.fl?lc=FUNCTIONS',
            'postfix'       => '',
          ],
          'company'       => [ 
            'prefix'        => '/list_criteria.fl?lc=ENTERPRISE',
            'postfix'       => '',
          ],
          'ticket'        => [ 
            'prefix'        => '/list_criteria.fl?lc=INTERTODO',
            'postfix'       => '',
          ],
        ],
      ],

    ],
  ],
  
  'entities'      => [
    'map'           => [
      'Person'        => 'contact',
      'Enterprise'    => 'company',
      'Interaction'   => 'ticket' ,
      'Correspondent' => 'customer' ,
    ],

    'contact'     => [
      'labels'      => [
        'entity'      => [
          'name'          => 'Client',
          'fieldDisplay'  => false,
        ],
        'entry'       => [
          'separator'     => ' ',
          'stringItems'   => [
            [
              'type'      => 'field',
              'value'     => 'lastname',
            ],
            [
              'type'      => 'field',
              'value'     => 'firstname',
            ],
          ],
        ],
      ],
      'map'         => [
        'PerID'                        => [ 'key' => 'id'         , 'label' => 'Identifiant'         , 'type' => 'id'    , 'display' => false, 'map' => 'CCKContactId'             ],
        'PerCivID:RefVal'              => [ 'key' => ''           , 'label' => 'Civilite'            , 'type' => 'string', 'display' => true , 'map' => 'contactTitle'             ],
        'PerFstName'                   => [ 'key' => 'firstname'  , 'label' => 'Prenom'              , 'type' => 'string', 'display' => true , 'map' => 'contactFirstName'         ],
        'PerName'                      => [ 'key' => 'lastname'   , 'label' => 'Nom'                 , 'type' => 'string', 'display' => true , 'map' => 'contactLastName'          ],
        'PerTitle'                     => [ 'key' => ''           , 'label' => 'Titre'               , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerPhone'                     => [ 'key' => 'phone'      , 'label' => 'Telephone'           , 'type' => 'phone' , 'display' => true , 'map' => 'contactPhoneNumber'       ],
        'PerMobile'                    => [ 'key' => 'mobile'     , 'label' => 'Mobile'              , 'type' => 'phone' , 'display' => true , 'map' => 'contactMobilePhoneNumber' ],
        'PerMail'                      => [ 'key' => 'email'      , 'label' => 'EMail'               , 'type' => 'email' , 'display' => true , 'map' => 'contactEmail'             ],
        'PerLngPrinc:RefVal'           => [ 'key' => ''           , 'label' => 'Langue'              , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerEntID'                     => [ 'key' => 'companyId'  , 'label' => "Id de l'entreprise"  , 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'             ],
        'PerEntID:EntCorpName'         => [ 'key' => ''           , 'label' => "Entreprise"          , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerRemarks'                   => [ 'key' => ''           , 'label' => 'Notes'               , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'PerAd1'                       => [ 'key' => ''           , 'label' => 'Adresse : Ligne 1'   , 'type' => 'string', 'display' => true , 'map' => 'contactPrimaryAddress'    ],
        'PerAd2'                       => [ 'key' => ''           , 'label' => 'Adresse : Ligne 2'   , 'type' => 'string', 'display' => true , 'map' => 'contactSecondaryAddress'  ],
        'PerAd3'                       => [ 'key' => ''           , 'label' => 'Adresse : Ligne 3'   , 'type' => 'string', 'display' => false, 'map' => ''                         ],
        'PerZip'                       => [ 'key' => ''           , 'label' => 'Code postal'         , 'type' => 'string', 'display' => true , 'map' => 'contactZipCode'           ],
        'PerCity'                      => [ 'key' => ''           , 'label' => 'Ville'               , 'type' => 'string', 'display' => true , 'map' => 'contactCity'              ],
        'PerDDC'                       => [ 'key' => ''           , 'label' => 'Date dernier contact', 'type' => 'string', 'display' => false, 'map' => ''                         ],
      ],
      'search'      => [
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>   'KiamoEDealESSContactPhone', 'entityField' =>        'phone', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '02'            => [ 'varName' =>                'CCKContactId', 'entityField' =>           'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '04'            => [ 'varName' =>                  'CustNumber', 'entityField' =>        'phone', 'operation' =>  'like',
                               'preTrt'  =>         'injectInPhoneNumber', 'eligibility' => 'couldBePhone', 'postTrt'   =>      '' ],
          '05'            => [ 'varName' =>                  'CustNumber', 'entityField' =>       'mobile', 'operation' =>  'like',
                               'preTrt'  =>         'injectInPhoneNumber', 'eligibility' => 'couldBePhone', 'postTrt'   =>      '' ],
          '06'            => [ 'varName' =>                 'EMailSender', 'entityField' =>        'email', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' => 'couldBeEmail', 'postTrt'   =>      '' ],
        ],
        'agentQuery'   => [
          '01'            => [                                             'entityField' =>       'mobile', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '02'            => [                                             'entityField' =>        'phone', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '03'            => [                                             'entityField' =>        'email', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '04'            => [                                             'entityField' =>     'lastname', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '05'            => [                                             'entityField' =>    'firstname', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '06'            => [                                             'entityField' =>           'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
        ],
        'getOneOfList'    => 'pickLastItem',
      ],
    ],
    'company'     => [
      'labels'      => [
        'entity'      => [
          'name'          => 'Société',
          'fieldDisplay'  => false,
        ],
        'entry'       => [
          'separator'     => ' ',
          'stringItems'   => [
            [
              'type'      => 'field',
              'value'     => 'name',
            ],
          ],
        ],
      ],
      'map'         => [
        'EntID'                        => [ 'key' => 'id'         , 'label' => 'Identifiant'         , 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'             ],
        'EntCorpName'                  => [ 'key' => 'name'       , 'label' => 'Nom'                 , 'type' => 'string', 'display' => true , 'map' => 'companyName'              ],
        'EntAcronym'                   => [ 'key' => ''           , 'label' => 'Acronyme'            , 'type' => 'string', 'display' => true , 'map' => ''                         ],
        'EntPhone'                     => [ 'key' => 'phone'      , 'label' => 'Telephone'           , 'type' => 'phone' , 'display' => true , 'map' => 'companyPhoneNumber'       ],
        'EntWeb'                       => [ 'key' => 'website'    , 'label' => 'Site Web'            , 'type' => 'url'   , 'display' => true , 'map' => ''                         ],
        'EntSector'                    => [ 'key' => ''           , 'label' => 'Secteur'             , 'type' => 'string', 'display' => true , 'map' => 'companyType'              ],
        'EntAd1'                       => [ 'key' => ''           , 'label' => 'Adresse : Ligne 1'   , 'type' => 'string', 'display' => true , 'map' => 'companyPrimaryAddress'    ],
        'EntAd2'                       => [ 'key' => ''           , 'label' => 'Adresse : Ligne 2'   , 'type' => 'string', 'display' => true , 'map' => 'companySecondaryAddress'  ],
        'EntAd3'                       => [ 'key' => ''           , 'label' => 'Adresse : Ligne 3'   , 'type' => 'string', 'display' => false, 'map' => ''                         ],
        'EntZip'                       => [ 'key' => ''           , 'label' => 'Code postal'         , 'type' => 'string', 'display' => true , 'map' => 'companyZipCode'           ],
        'EntCity'                      => [ 'key' => ''           , 'label' => 'Ville'               , 'type' => 'string', 'display' => true , 'map' => 'companyCity'              ],
      ],
      'search'      => [ 
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>      'KiamoEDealESSCompanyId', 'entityField' =>          'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '02'            => [ 'varName' =>                'CCKCompanyId', 'entityField' =>          'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '04'            => [ 'varName' =>                  'CustNumber', 'entityField' =>       'phone', 'operation' =>  'like',
                               'preTrt'  =>         'injectInPhoneNumber', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '05'            => [ 'varName' =>                  'CustNumber', 'entityField' =>      'mobile', 'operation' =>  'like',
                               'preTrt'  =>         'injectInPhoneNumber', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '06'            => [ 'varName' =>                 'EMailSender', 'entityField' =>       'email', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
        ],
        'agentQuery'   => [
          '01'            => [                                             'entityField' =>       'phone', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '02'            => [                                             'entityField' =>      'mobile', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '03'            => [                                             'entityField' =>       'email', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '04'            => [                                             'entityField' =>        'name', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '05'            => [                                             'entityField' =>          'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
        ],
        'getOneOfList'    => '',
      ],
    ],
    'ticket'      => [
      'labels'      => [
        'entity'      => [
          'name'          => 'Requête',
          'fieldDisplay'  => false,
        ],
        'entry'       => [
          'separator'     => ' ',
          'stringItems'   => [
            [
              'type'      => 'field',
              'value'     => 'id',
            ],
          ],
        ],
      ],
      'map'         => [
        'IntID'                        => [ 'key' => 'id'         , 'label' => 'Identifiant'              , 'type' => 'id'     , 'display' => true , 'map' => 'CCKTicketId'       ],
        'IntCrDt'                      => [ 'key' => ''           , 'label' => 'Cree le'                  , 'type' => 'date'   , 'display' => true , 'map' => 'ticketOpenDate'    ],
        'IntUpd'                       => [ 'key' => 'lastUpdate' , 'label' => 'Date de modif.'           , 'type' => 'date'   , 'display' => true , 'map' => ''                  ],
        'IntDate'                      => [ 'key' => 'date'       , 'label' => 'Date'                     , 'type' => 'date'   , 'display' => true , 'map' => ''                  ],
        'IntTimeBeg'                   => [ 'key' => 'timeBegin'  , 'label' => 'Heure de debut'           , 'type' => 'time'   , 'display' => true , 'map' => ''                  ],
        'IntTimeEnd'                   => [ 'key' => 'timeEnd'    , 'label' => 'Heure de fin'             , 'type' => 'time'   , 'display' => true , 'map' => ''                  ],
        'IntAtvID:RefVal'              => [ 'key' => 'activity'   , 'label' => 'Activite'                 , 'type' => 'string' , 'display' => true , 'map' => ''                  ],
        'IntSubject'                   => [ 'key' => 'subject'    , 'label' => 'Sujet'                    , 'type' => 'string' , 'display' => true , 'map' => 'ticketLabel'       ],
        'IntCatID:RefVal'              => [ 'key' => ''           , 'label' => 'Categorie'                , 'type' => 'string' , 'display' => true , 'map' => ''                  ],
        'IntInType'                    => [ 'key' => ''           , 'label' => 'Entrant/Sortant'          , 'type' => 'boolean', 'display' => true , 'map' => ''                  ],
        'IntStiID:RefVal'              => [ 'key' => 'status'     , 'label' => 'Etat'                     , 'type' => 'string' , 'display' => true , 'map' => 'ticketStatus'      ],
        'IntMedID:RefVal'              => [ 'key' => ''           , 'label' => 'Canal'                    , 'type' => 'string' , 'display' => true , 'map' => ''                  ],
        'IntDetails'                   => [ 'key' => ''           , 'label' => 'Details'                  , 'type' => 'string' , 'display' => true , 'map' => ''                  ],
        'IntDmdID'                     => [ 'key' => ''           , 'label' => 'Demande (Demande Id)'     , 'type' => 'id'     , 'display' => true , 'map' => ''                  ],
        'IntCreID'                     => [ 'key' => ''           , 'label' => 'Createur (Act Id)'        , 'type' => 'id'     , 'display' => true , 'map' => ''                  ],
        'IntEmetteur'                  => [ 'key' => ''           , 'label' => 'Emetteur (Act Id)'        , 'type' => 'id'     , 'display' => true , 'map' => ''                  ],
        'IntModID'                     => [ 'key' => ''           , 'label' => 'Modifie par (Act Id)'     , 'type' => 'id'     , 'display' => true , 'map' => ''                  ],
        'IntActID'                     => [ 'key' => ''           , 'label' => 'Acteurs'                  , 'type' => 'multi'  , 'display' => false, 'map' => ''                  ],
        'IntCorID'                     => [ 'key' => 'customerIds', 'label' => 'Correspondants'           , 'type' => 'multi'  , 'display' => true , 'map' => ''                  ],
        'IntParentOwners'              => [ 'key' => ''           , 'label' => 'Proprietaires des parents', 'type' => 'multi'  , 'display' => false, 'map' => ''                  ],
        'IntOrigID'                    => [ 'key' => ''           , 'label' => 'Origine (Int Id)'         , 'type' => 'id'     , 'display' => true , 'map' => ''                  ],
        'IntParLot'                    => [ 'key' => ''           , 'label' => 'IntParent (Int Id)'       , 'type' => 'id'     , 'display' => true , 'map' => ''                  ],
      ],
      'search'      => [ 
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>       'KiamoEDealESSTicketId', 'entityField' =>          'id', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [ 'varName' =>                 'CCKTicketId', 'entityField' =>          'id', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '03'            => [ 'varName' =>                'CCKContactId', 'entityField' =>   'contactId', 'operation' =>    'equals',
                               'preTrt'  =>                'getCustomers', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '04'            => [ 'varName' =>                'CCKCompanyId', 'entityField' =>   'companyId', 'operation' =>    'equals',
                               'preTrt'  =>                'getCustomers', 'eligibility' =>            '', 'postTrt'   =>          '' ],
        ],
        'agentQuery'   => [
          '01'            => [                                             'entityField' =>          'id', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [                                             'entityField' =>   'contactId', 'operation' =>    'equals',
                               'preTrt'  =>                'getCustomers', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [                                             'entityField' =>   'companyId', 'operation' =>    'equals',
                               'preTrt'  =>                'getCustomers', 'eligibility' =>            '', 'postTrt'   =>          '' ],
        ],
        'getOneOfList'    => '',
      ],
    ],
    'customer'    => [
      'map'         => [
        'CorID'                        => [ 'key' => 'id'         , 'label' => 'Identifiant'              , 'type' => 'id'     , 'display' => false, 'map' => ''                  ],
        'CorEntID'                     => [ 'key' => 'companyId'  , 'label' => "Id de l'entreprise"       , 'type' => 'id'     , 'display' => false, 'map' => ''                  ],
        'CorPerID'                     => [ 'key' => 'contactId'  , 'label' => "Id de la personne"        , 'type' => 'id'     , 'display' => false, 'map' => ''                  ],
      ],
    ],
  ],
] ;
?>
