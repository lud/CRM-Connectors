<?php
return [
  'self'        => [
    'service'      => 'salesforce',
    'version'      => 'sample',
  ],
  'protocol'    => [
    'definition'  => 'W2018_41_0',
  ],
  
  'environments' => [
    'test'         => [
      'accessdata'   => [
      
        'platform'      => [
          'url'           => 'https://xxxxxxxxxxxx.my.salesforce.com',
          'apiVersion'    => '41.0',
        ],

        'authent'       => [
          'url'           => 'https://login.salesforce.com/services/oauth2/token',
          'grant_type'    => 'password',
          'account'       => [
            'data'          => [
              'client_id'      => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
              'client_secret'  => 'xxxxxxxxxxxxxxxxxxx',
            ],
            'adminUser'     => [
              'username'       => 'xxxxxxxx@xxxxx.xxx',
              'password'       => 'xxxxxxxxx',
              'security_token' => 'xxxxxxxxxxxxxxxxxxxxxxxx',
            ],
          ],
        ],

      ],

      'urls'         => [

        'view'          => [
          'baseUrl'       => 'https://xxxxxxxxxxxx.lightning.force.com',

          'contact'       => [
            'prefix'        => '/one/one.app#/sObject/',
            'postfix'       => '/view',
          ],
          'company'       => [ 
            'prefix'        => '/one/one.app#/sObject/',
            'postfix'       => '/view',
          ],
          'ticket'        => [ 
            'prefix'        => '/one/one.app#/sObject/',
            'postfix'       => '/view',
          ],
        ],

        'search'     => [
          'baseUrl'    => 'https://xxxxxxxxxxxx.lightning.force.com',

          'contact'       => [
            'prefix'        => '/one/one.app#/home',
            'postfix'       => '',
          ],
          'company'       => [ 
            'prefix'        => '/one/one.app#/home',
            'postfix'       => '',
          ],
          'ticket'        => [ 
            'prefix'        => '/one/one.app#/home',
            'postfix'       => '',
          ],
        ],
      ],

    ],
  ],
  
  'entities'      => [
    'map'           => [
      'Contact'       => 'contact',
      'Account'       => 'company',
      'Case'          => 'ticket' ,
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
        'Id'                           => [ 'key' => 'id'       , 'label' => 'Identifiant'         , 'type' => 'id'    , 'display' => false, 'map' => 'CCKContactId'              ],
        'Title'                        => [ 'key' => ''         , 'label' => 'Civilite'            , 'type' => 'string', 'display' => true , 'map' => 'contactTitle'              ],
        'FirstName'                    => [ 'key' => 'firstname', 'label' => 'Prenom'              , 'type' => 'string', 'display' => true , 'map' => 'contactFirstName'          ],
        'LastName'                     => [ 'key' => 'lastname' , 'label' => 'Nom'                 , 'type' => 'string', 'display' => true , 'map' => 'contactLastName'           ],
        'Salutation'                   => [ 'key' => ''         , 'label' => 'Titre'               , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'Phone'                        => [ 'key' => 'phone'    , 'label' => 'Telephone'           , 'type' => 'phone' , 'display' => true , 'map' => 'contactPhoneNumber'        ],
        'MobilePhone'                  => [ 'key' => 'mobile'   , 'label' => 'Mobile'              , 'type' => 'phone' , 'display' => true , 'map' => 'contactMobilePhoneNumber'  ],
        'Email'                        => [ 'key' => 'email'    , 'label' => 'EMail'               , 'type' => 'email' , 'display' => true , 'map' => 'contactEmail'              ],
        'AccountId'                    => [ 'key' => 'companyId', 'label' => "Id de l'entreprise"  , 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'              ],
        'MailingStreet'                => [ 'key' => ''         , 'label' => 'Adresse'             , 'type' => 'string', 'display' => true , 'map' => 'contactPrimaryAddress'     ],
        'MailingPostalCode'            => [ 'key' => ''         , 'label' => 'Code postal'         , 'type' => 'string', 'display' => true , 'map' => 'contactZipCode'            ],
        'MailingCity'                  => [ 'key' => ''         , 'label' => 'Ville'               , 'type' => 'string', 'display' => true , 'map' => 'contactCity'               ],
        'LastViewedDate'               => [ 'key' => ''         , 'label' => 'Date dernier contact', 'type' => 'string', 'display' => false, 'map' => ''                          ],
      ],
      'search'      => [
        'kiamoInputs'  => [
          '01'            => [ 'varName' => 'KiamoSalesforceESSContactId', 'entityField' =>        'phone', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '02'            => [ 'varName' =>                'CCKContactId', 'entityField' =>           'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>      '' ],
          '04'            => [ 'varName' =>                  'CustNumber', 'entityField' =>        'phone', 'operation' =>  'like',
                               'preTrt'  =>           'getRawPhoneNumber', 'eligibility' => 'couldBePhone', 'postTrt'   =>      '' ],
          '05'            => [ 'varName' =>                  'CustNumber', 'entityField' =>       'mobile', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' => 'couldBePhone', 'postTrt'   =>      '' ],
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
        'Id'                           => [ 'key' => 'id'       , 'label' => 'Identifiant'         , 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'              ],
        'Name'                         => [ 'key' => 'name'     , 'label' => 'Nom'                 , 'type' => 'string', 'display' => true , 'map' => 'companyName'               ],
        'Description'                  => [ 'key' => ''         , 'label' => 'Description'         , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'NumberOfEmployees'            => [ 'key' => ''         , 'label' => 'Nb Employés'         , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'Phone'                        => [ 'key' => 'phone'    , 'label' => 'Telephone'           , 'type' => 'phone' , 'display' => true , 'map' => 'companyPhoneNumber'        ],
        'Website'                      => [ 'key' => 'website'  , 'label' => 'Site Web'            , 'type' => 'url'   , 'display' => true , 'map' => ''                          ],
        'BillingStreet'                => [ 'key' => ''         , 'label' => 'Adresse'             , 'type' => 'string', 'display' => true , 'map' => 'companyPrimaryAddress'     ],
        'BillingPostalCode'            => [ 'key' => ''         , 'label' => 'Code postal'         , 'type' => 'string', 'display' => true , 'map' => 'companyZipCode'            ],
        'BillingCity'                  => [ 'key' => ''         , 'label' => 'Ville'               , 'type' => 'string', 'display' => true , 'map' => 'companyCity'               ],
      ],
      'search'      => [ 
        'kiamoInputs'  => [
          '01'            => [ 'varName' => 'KiamoSalesforceESSCompanyId', 'entityField' =>          'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '02'            => [ 'varName' =>                'CCKCompanyId', 'entityField' =>          'id', 'operation' => 'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '04'            => [ 'varName' =>                  'CustNumber', 'entityField' =>       'phone', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
          '05'            => [ 'varName' =>                  'CustNumber', 'entityField' =>      'mobile', 'operation' =>  'like',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>      '' ],
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
        'Id'                           => [ 'key' => 'id'       , 'label' => 'Identifiant'              , 'type' => 'id'     , 'display' => true , 'map' => 'CCKTicketId'        ],
        'CreatedDate'                  => [ 'key' => ''         , 'label' => 'Cree le'                  , 'type' => 'date'   , 'display' => true , 'map' => 'ticketOpenDate'     ],
        'LastModifiedDate'             => [ 'key' => 'lastUpdate', 'label' => 'Date de modif.'          , 'type' => 'date'   , 'display' => true , 'map' => ''                   ],
        'LastViewedDate'               => [ 'key' => 'lastViewed', 'label' => 'Date de dernier accès'   , 'type' => 'date'   , 'display' => true , 'map' => ''                   ],
        'Subject'                      => [ 'key' => ''         , 'label' => 'Sujet'                    , 'type' => 'string' , 'display' => true , 'map' => ''                   ],
        'Description'                  => [ 'key' => ''         , 'label' => 'Description'              , 'type' => 'string' , 'display' => true , 'map' => ''                   ],
        'Status'                       => [ 'key' => 'status'   , 'label' => 'Etat'                     , 'type' => 'string' , 'display' => true , 'map' => 'ticketStatus'       ],
        'ContactId'                    => [ 'key' => 'contactId', 'label' => 'Contact'                  , 'type' => 'id'     , 'display' => true , 'map' => ''                   ],
        'AccountId'                    => [ 'key' => 'companyId', 'label' => 'Société'                  , 'type' => 'id'     , 'display' => true , 'map' => ''                   ],
      ],
      'search'      => [ 
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>  'KiamoSalesforceESSTicketId', 'entityField' =>          'id', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [ 'varName' =>                 'CCKTicketId', 'entityField' =>          'id', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '03'            => [ 'varName' =>                'CCKContactId', 'entityField' =>   'contactId', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '04'            => [ 'varName' =>                'CCKCompanyId', 'entityField' =>   'companyId', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
        ],
        'agentQuery'   => [
          '01'            => [                                             'entityField' =>          'id', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [                                             'entityField' =>   'contactId', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [                                             'entityField' =>   'companyId', 'operation' =>    'equals',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
        ],
        'getOneOfList'    => '',
      ],
    ],
  ],
] ;
?>
