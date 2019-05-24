<?php
return [
  'self'        => [
    'service'      => 'dynamics',
    'version'      => 'sample',
  ],
  'protocol'    => [
    'definition'  => '2018_09_0',
  ],
  
  'environments' => [
    'test'         => [
      'accessdata'   => [
      
        'platform'      => [
          'tenantName'    => 'xxxxxx',
          'tenantId'      => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
          'urlPrefix'     => 'https://',
          'urlPostfix'    => '.crm4.dynamics.com',
          'apiPrefix'     => '/api/data/v',
          'apiVersion'    => '9.0',
        ],

        'authent'       => [
          'urlPrefix'     => 'https://login.microsoftonline.com/',
          'urlPostfix'    => '/oauth2/token',
          'account'       => [
            'data'          => [
              'client_id'      => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
              'client_secret'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            ],
            'adminUser'     => [
              'username'       => 'xxxxxxxxx@xxxxxxxxxxxxxxxxx.onmicrosoft.com',
              'password'       => 'xxxxxxxxxxxxxxxx',
            ],
          ],
        ],

      ],

      'urls'         => [

        'view'          => [
          'baseUrl'       => 'https://xxxxxx.crm4.dynamics.com',

          'contact'       => [
            'prefix'        => '/main.aspx',
            'postfix'       => '&pagetype=entityrecord#',
          ],
          'company'       => [ 
            'prefix'        => '/main.aspx',
            'postfix'       => '&pagetype=entityrecord#',
          ],
          'ticket'        => [ 
            'prefix'        => '/main.aspx',
            'postfix'       => '&pagetype=entityrecord#',
          ],
        ],

        'search'     => [
          'baseUrl'    => 'https://xxxxxx.crm4.dynamics.com',

          'contact'       => [
            'prefix'        => '/main.aspx',
            'postfix'       => '',
          ],
          'company'       => [ 
            'prefix'        => '/main.aspx',
            'postfix'       => '',
          ],
          'ticket'        => [ 
            'prefix'        => '/main.aspx',
            'postfix'       => '',
          ],
        ],
      ],

    ],
  ],
  
  'entities'      => [
    'map'           => [
      'contacts'      => 'contact',
      'accounts'      => 'company',
      'incidents'     => 'ticket' ,
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
        'contactid'                    => [ 'key' => 'id'       , 'label' => 'Identifiant'         , 'type' => 'id'    , 'display' => false, 'map' => 'CCKContactId'              ],
        'salutation'                   => [ 'key' => ''         , 'label' => 'Civilite'            , 'type' => 'string', 'display' => true , 'map' => 'contactTitle'              ],
        'firstname'                    => [ 'key' => 'firstname', 'label' => 'Prenom'              , 'type' => 'string', 'display' => true , 'map' => 'contactFirstName'          ],
        'lastname'                     => [ 'key' => 'lastname' , 'label' => 'Nom'                 , 'type' => 'string', 'display' => true , 'map' => 'contactLastName'           ],
        'jobtitle'                     => [ 'key' => ''         , 'label' => 'Titre'               , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'telephone1'                   => [ 'key' => 'phone'    , 'label' => 'Telephone'           , 'type' => 'phone' , 'display' => true , 'map' => 'contactPhoneNumber'        ],
        'mobilephone'                  => [ 'key' => 'mobile'   , 'label' => 'Mobile'              , 'type' => 'phone' , 'display' => true , 'map' => 'contactMobilePhoneNumber'  ],
        'emailaddress1'                => [ 'key' => 'email'    , 'label' => 'EMail'               , 'type' => 'email' , 'display' => true , 'map' => 'contactEmail'              ],
        '_parentcustomerid_value'      => [ 'key' => 'companyId', 'label' => "Id de l'entreprise"  , 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'              ],
        'description'                  => [ 'key' => ''         , 'label' => 'Description'         , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'address1_line1'               => [ 'key' => ''         , 'label' => 'Adresse'             , 'type' => 'string', 'display' => true , 'map' => 'contactPrimaryAddress'     ],
        'address1_postalcode'          => [ 'key' => ''         , 'label' => 'Code postal'         , 'type' => 'string', 'display' => true , 'map' => 'contactZipCode'            ],
        'address1_city'                => [ 'key' => ''         , 'label' => 'Ville'               , 'type' => 'string', 'display' => true , 'map' => 'contactCity'               ],
      ],
      'search'      => [
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>      'KiamoDynamicsContactId', 'entityField' =>        'phone', 'operation' => 'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
          '02'            => [ 'varName' =>                'CCKContactId', 'entityField' =>           'id', 'operation' => 'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
          '03'            => [ 'varName' =>                  'CustNumber', 'entityField' =>        'phone', 'operation' =>  'contains',
                               'preTrt'  =>           'getRawPhoneNumber', 'eligibility' => 'couldBePhone', 'postTrt'   =>          '' ],
          '04'            => [ 'varName' =>                  'CustNumber', 'entityField' =>       'mobile', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' => 'couldBePhone', 'postTrt'   =>          '' ],
          '05'            => [ 'varName' =>                 'EMailSender', 'entityField' =>        'email', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' => 'couldBeEmail', 'postTrt'   =>          '' ],
        ],
        'agentQuery'   => [
          '01'            => [                                             'entityField' =>       'mobile', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
          '02'            => [                                             'entityField' =>        'phone', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
          '03'            => [                                             'entityField' =>        'email', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
          '04'            => [                                             'entityField' =>     'lastname', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
          '05'            => [                                             'entityField' =>    'firstname', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
          '06'            => [                                             'entityField' =>           'id', 'operation' => 'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>             '', 'postTrt'   =>          '' ],
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
        'accountid'                    => [ 'key' => 'id'       , 'label' => 'Identifiant'         , 'type' => 'id'    , 'display' => false, 'map' => 'CCKCompanyId'              ],
        'name'                         => [ 'key' => 'name'     , 'label' => 'Nom'                 , 'type' => 'string', 'display' => true , 'map' => 'companyName'               ],
        'description'                  => [ 'key' => ''         , 'label' => 'Description'         , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'numberofemployees'            => [ 'key' => ''         , 'label' => 'Nb Employés'         , 'type' => 'string', 'display' => true , 'map' => ''                          ],
        'telephone1'                   => [ 'key' => 'phone'    , 'label' => 'Telephone'           , 'type' => 'phone' , 'display' => true , 'map' => 'companyPhoneNumber'        ],
        'address1_line1'               => [ 'key' => ''         , 'label' => 'Adresse'             , 'type' => 'string', 'display' => true , 'map' => 'companyPrimaryAddress'     ],
        'address1_postalcode'          => [ 'key' => ''         , 'label' => 'Code postal'         , 'type' => 'string', 'display' => true , 'map' => 'companyZipCode'            ],
        'address1_city'                => [ 'key' => ''         , 'label' => 'Ville'               , 'type' => 'string', 'display' => true , 'map' => 'companyCity'               ],
      ],
      'search'      => [ 
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>      'KiamoDynamicsCompanyId', 'entityField' =>          'id', 'operation' => 'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [ 'varName' =>                'CCKCompanyId', 'entityField' =>          'id', 'operation' => 'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '03'            => [ 'varName' =>                  'CustNumber', 'entityField' =>       'phone', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '04'            => [ 'varName' =>                  'CustNumber', 'entityField' =>      'mobile', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '05'            => [ 'varName' =>                 'EMailSender', 'entityField' =>       'email', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
        ],
        'agentQuery'   => [
          '01'            => [                                             'entityField' =>       'phone', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '02'            => [                                             'entityField' =>      'mobile', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '03'            => [                                             'entityField' =>       'email', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '04'            => [                                             'entityField' =>        'name', 'operation' =>  'contains',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
          '05'            => [                                             'entityField' =>          'id', 'operation' => 'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>          '' ],
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
        'incidentid'                   => [ 'key' => 'id'       , 'label' => 'Identifiant'              , 'type' => 'id'     , 'display' => false, 'map' => 'CCKTicketId'        ],
        'createdon'                    => [ 'key' => ''         , 'label' => 'Cree le'                  , 'type' => 'date'   , 'display' => true , 'map' => 'ticketOpenDate'     ],
        'modifiedon'                   => [ 'key' => 'lastUpdate', 'label' => 'Date de modif.'          , 'type' => 'date'   , 'display' => true , 'map' => ''                   ],
        'title'                        => [ 'key' => ''         , 'label' => 'Sujet'                    , 'type' => 'string' , 'display' => true , 'map' => ''                   ],
        'description'                  => [ 'key' => ''         , 'label' => 'Description'              , 'type' => 'string' , 'display' => true , 'map' => ''                   ],
        'statecode'                    => [ 'key' => 'status'   , 'label' => 'Etat'                     , 'type' => 'string' , 'display' => true , 'map' => 'ticketStatus'       ],
        'ticketnumber'                 => [ 'key' => 'tkNb'     , 'label' => 'Numéro de ticket'         , 'type' => 'string' , 'display' => true , 'map' => ''                   ],
        '_customerid_value'            => [ 'key' => 'contactId', 'label' => 'Contact'                  , 'type' => 'id'     , 'display' => true , 'map' => ''                   ],
        '_accountid_value'             => [ 'key' => 'companyId', 'label' => 'Société'                  , 'type' => 'id'     , 'display' => true , 'map' => ''                   ],
      ],
      'search'      => [ 
        'kiamoInputs'  => [
          '01'            => [ 'varName' =>       'KiamoDynamicsTicketId', 'entityField' =>          'id', 'operation' =>    'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>             '' ],
          '02'            => [ 'varName' =>                 'CCKTicketId', 'entityField' =>          'id', 'operation' =>    'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>             '' ],
          '03'            => [ 'varName' =>                'CCKContactId', 'entityField' =>   'contactId', 'operation' =>    'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>             '' ],
          '04'            => [ 'varName' =>                'CCKCompanyId', 'entityField' =>   'companyId', 'operation' =>    'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>             '' ],
        ],
        'agentQuery'   => [
          '01'            => [                                             'entityField' =>          'id', 'operation' =>    'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>             '' ],
          '02'            => [                                             'entityField' =>   'contactId', 'operation' =>    'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>             '' ],
          '03'            => [                                             'entityField' =>   'companyId', 'operation' =>    'equalsraw',
                               'preTrt'  =>                            '', 'eligibility' =>            '', 'postTrt'   =>             '' ],
        ],
        'getOneOfList'    => '',
      ],
    ],
  ],
] ;
?>
