# Kiamo CRM Connector Samples

## Package Description



| Date    | 20190725  |
| :------ | --------- |
| Version | v1.3.0    |
| Author  | S.Iniesta |



------


[Introduction](#introduction)

&nbsp;&nbsp;&nbsp;&nbsp;[Purpose](#purpose)

&nbsp;&nbsp;&nbsp;&nbsp;[Description](#description)

[Design](#design)

[Connector](#connector)

&nbsp;&nbsp;&nbsp;&nbsp;[Kiamo Connector (Module)](#kiamoConnector(module))

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Creation](#creation)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Configuration](#configuration)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Module Logs](#moduleLogs)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Module Resources](#moduleResources)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Usage](#usage)

&nbsp;&nbsp;&nbsp;&nbsp;[Interaction Manager (SubModule)](#interactionManager(submodule))

&nbsp;&nbsp;&nbsp;&nbsp;[Entities Manager (SubModule)](#entitiesManager(submodule))

&nbsp;&nbsp;&nbsp;&nbsp;[Customization Manager (SubModule)](#customizationManager(submodule))

[Main Helpers](#mainHelpers)

&nbsp;&nbsp;&nbsp;&nbsp;[AutoLoader](#autoloader)

&nbsp;&nbsp;&nbsp;&nbsp;[Module](#module)

&nbsp;&nbsp;&nbsp;&nbsp;[ConfManager](#confmanager)

&nbsp;&nbsp;&nbsp;&nbsp;[Logger](#logger)

&nbsp;&nbsp;&nbsp;&nbsp;[SubModule](#submodule)

[Tools](#tools)

&nbsp;&nbsp;&nbsp;&nbsp;[datetimes](#datetimes)

&nbsp;&nbsp;&nbsp;&nbsp;[dict](#dict)

&nbsp;&nbsp;&nbsp;&nbsp;[files](#files)

&nbsp;&nbsp;&nbsp;&nbsp;[resources](#resources)

&nbsp;&nbsp;&nbsp;&nbsp;[strings](#strings)

&nbsp;&nbsp;&nbsp;&nbsp;[userdata](#userdata)

&nbsp;&nbsp;&nbsp;&nbsp;[uuids](#uuids)

&nbsp;&nbsp;&nbsp;&nbsp;[webs](#webs)

[Additional Tools](#additionalTools)

&nbsp;&nbsp;&nbsp;&nbsp;[Command Line Tester](#commandLineTester)

&nbsp;&nbsp;&nbsp;&nbsp;[Connector Checker](#connectorChecker)

&nbsp;&nbsp;&nbsp;&nbsp;[SVI Script Examples](#sviScriptExamples)


------



<a name="introduction"></a>
### Introduction

<a name="purpose"></a>
####  Purpose

The goal of this package is to provide CRM Connector Samples to a development team, based on a very simple design, with an integrated and extensible toolkit, and several implementation helpers.

Each sample can be used as a simple illustration, or as support to a more specific implementation.



<a name="description"></a>
####  Description

The following scheme presents a synthetic design of a Kiamo CRM Connector :

![Kiamo CRM Connector Design](https://github.com/openKiamo/CRM-Connectors/blob/master/_Docs/data/01_KiamoConnectorCRM.png)

It's mainly dedicated to gather external data and entities, corresponding to the inputs received by Kiamo, as a customer or a ticket description for instance.

The folder of a given CRM connector sample is a little folder tree :

* `<root>`        : the main module (implementation of the CRM connector) and its sub-modules,
  * the interaction manager, which creates and maintain a valid session with the external API, and communicates with the external services to gather the data required by the connector,
  * the entity manager, which maps the external data received from the APIs into a valid Kiamo structured form,
  * the customization manager, which implements the specific treatments (as phone number format, list sorting and filtering, ...).

* `conf`          : configuration files folder,

* `data`          : resources folder,

* `logs`          : log files folder,

* `tools`        : all the tools sources provided by the package.



Each  sample manages the connection with a specific external CRM.

The reference Kiamo documentation to implement a connector is unchanged : « `Development of CRM-ERP connectors` ».



The Kiamo deployment folder for a connector is :

`<Kiamo Folder>/data/userfiles/class/Connectors/<ConnectorName>`



The sample code and structure are quite easy to read and understand. The documentation provides additional details to understand the global idea and implementation particularities, for a better appropriation.

<u>Note</u> : in this document and the related code, the following notions will be used :

* `entity`, an entity representing a kind of item. *For instance* "contact", "company", "user's ticket", ...

* `entry`, an entity instance. *For instance*, the data block describing the "contact" M. Winston Churchill.

These two notions are used this way in all the connector samples, but are different of the ones present on the Kiamo connector function names.



The current CRM connector samples (may 2019) are the following :

* an **MS Dynamics 365** *(API v9.0, 2018)* generic connector,

* a **Salesforce Lightning** *(API v41.0, winter 2018)* generic connector,

* an **Edeal** *(API 2015)* generic connector.



------

<a name="design"></a>
### Design

The following scheme presents the typical architecture of a connector sample :

![Connector Sample Architecture](https://github.com/openKiamo/CRM-Connectors/blob/master/_Docs/data/02_ConnectorSampleDesign.png)



Basically, the design is the following :

* the Kiamo connector receives the search criteria from Kiamo (as a phone number, an email address, ...) and will return the found matching results,
* it uses an `InteractionManager` sub-module, which converts the search criteria into actual external services requests,
* the matching results are sent to the `EntitiesManager`, which converts the raw returned results into the Kiamo required data format,
* during this process, the `CustomizationManager` is used for any specific data treatment : data formatting, list and results sorting and filtering, ...
* all those classes use a common set of resources, configurations and toolkit :
  * a configuration, containing all the data required to connect and use the external service, and to map the entries between the external format into the Kiamo expected format,
  * daily logs,
  * resource files,
  * a toolkit (logger, confManager, webRequester, ...).



In more details, the design of those samples is split in 3 main parts :

* the Kiamo CRM connector :

  it's the main class.
  * It's mainly the visible bridge between Kiamo and the external CRM. It defines the kind of entities the connector can return, and the connector's features.
  * In the sample package, this class is mainly an empty shell, using it sub-modules to manage the actual tasks :
    * search and gather the external CRM data (session, access),
    * map the data,
    * apply the specific treatments (sort, filter, format, ...).

  The external entities search is driven by the provided inputs (as a phone number, an id, ...) and the configuration (action priority, specific treatment, ...).

* the sample architecture is composed of :

  * the Kiamo CRM Connector class (at the root of the folder, see upper).

    This class contains :

    * the usual Kiamo CRM connector features implementation,
    * a configuration manager, which ease the access to the configuration items,
    * a logs manager.

    Those helper instances are hold by this module, and propagated to the sub-modules (see below).

  * the connector's sub-modules :

    * the `InteractionManager` : manages the session and the requests to the external CRM API, returns the raw results (as they are returned by the APIs).

      This sub-module hides the session token management (get a valid one, save it for future request, renew it if expired, ...). This avoid useless external API calls.

    * the `EntitiesManager` : it knows the raw format of the API results, and the format expected by Kiamo.

      Using the configuration, it checks the returned data validity and maps the raw result into the expected Kiamo format (`EntityLayout`, `EntityInstance`, `EntitiesCollections`).

    * the `CustomizationManager` :  this class is dedicated to any specific treatment implementation required by the current integration, and the standard / default treatments easing the input / output manipulations.

      *For instance*, we'll find here *eligibility methods* (for example, a string with letters cannot be a phone number ; it's relevant not to call the external API to search entries by phone number with such string), *pre-treatments* (for example, remove all the space from an input phone number, or format it as it's stored in the external database), *post-treatments* (most relevant item of a returned list, as opened tickets for example), etc.

    Those sub-modules benefit of the helper instances of the parent module, as the configuration manager, the logs manager, ...

  * the package tree :

    * `conf` folder   : contains the configuration files, in particular the connector and the logger configurations,
    * `data` folder   : contains the module's resources. In the current design, it will contain a little cache file used to store the latest valid API session token.
    * `logs` folder   : logs of the package,
    * `tools` folder : toolkit of the package (see below),

* the package helpers :

  The implementation of the package helpers is present in the `tools` folder. There are three kind of helpers :

  * `Module` and `SubModule` : provide the logs and configuration access capabilities.
  * `autoload`, `ConfManager` and `Logger` : main helpers linked to the `Module` and `SubModule` classes.
  * All the other tools : they provide all kind of data and resource accesses and treatments.

It's of course possible to modify and extend this toolkit for any further need.



<a name="connector"></a>
### Connector

A Kiamo CRM connector can be implemented in one and only class.

In those samples, the implementation is split between a main module, the connector itself, and three sub-modules, each one attached to a specific responsibility set :

* the connector  :
  * implements the methods requested by the connector implementation documentation,
  * is driven by its configuration to request the external CRM and search the items matching the Kiamo inputs. It implements the configuration reading and execution.
* the sub-modules :
  * the `InteractionManager`  :
    * implements the external CRM authentication, the valid session token refresh mechanism, and the access to the CRM resources,
    * returns the raw results (no treatment applied on the results returned by the CRM),
  * the `EntitiesManager` :
    * "translates" and maps the raw results into valid Kiamo entities, based on the connector's configuration,
  * the `CustomizationManager` :
    * contains all eligibility, sorting, filtering and specific treatments functions, related to the current integration.



<a name="kiamoConnector(module)"></a>
#### Kiamo Connector (Module)

<a name="creation"></a>
#####   Creation

A Kiamo CRM connector creation must follow all the prerequisites described by the  « `Development of CRM-ERP connectors` » documentation.



In addition, in order to benefit of the package capabilities and helpers, it must :

* include the `autoloader`,
* add a `use` line for each used toolkit tool,
* extend the `Module` class,
* instantiate its sub-modules (`InteractionManager`, `EntitiesManager` and `CustomizationManager`).

```php
namespace <ConnectorNamespace> ;

require_once __DIR__ . "/tools/autoload.php" ;

use <ConnectorNamespace>\Module ;

(...)

class <ConnectorName> extends Module implements KiamoConnectorInterface, (...)
{
  (...)

  public function __construct()
  {
    parent::__construct() ;
    $this->interactionMgr    = new InteractionManager(   $this ) ;
    $this->entitiesMgr       = new EntitiesManager(      $this ) ;
    $this->customizationMgr  = new CustomizationManager( $this ) ;
  }

  (...)
}
```

The `autoloader` allows not to add one `require` line per tool used. Meanwhile, a `use` is strongly recommended to avoid possible name space collisions.

 When the connector is instantiated, the extended `Module` is initialized with the root path and the module name which is, by default, the class name. Based on this :

* the  `<root>` path, base of the whole module implementation, will be set up,
* the module name will induce :
  * the name of the dedicated configuration file (`<root>/conf/u_<ConnectorName>.php`), if this `<ConnectorName>` item is declared in the root configuration file `<root>/conf/_config.php`. The `ConfManager`  will use the module name to automatize the access to the module's configuration.
  * the creation of a `<root>/logs/<ConnectorName>` folder, where all the module and sub-modules logs will be written and managed,
  * a simplified management of the module's resources (in the dedicated `<root>/data/<ConnectorName>` folder).



<a name="configuration"></a>
#####   Configuration

The module configuration is located in the `conf` folder. It's mainly composed of :

* the root configuration files `_config.php` : the `ConfManager` uses this file to know the declared configuration items, and the path to access it.
* the logger's configuration file `t_logger.php` : it defines the logs level, the logs details and the logger behavior regarding the old logs files.
* the connector's configuration file `u_<ConnectorName>.php` : this file totally drives the way to access the external CRM, the way the returned data are formed and the way to search and treat those data.

The configuration root file is a php file containing :

```php
<?php
return [
  'tools' => [
    'key'   => 't',
    'items' => [
      'logger',
    ],
  ],
  'user'  => [
    'key'   => 'u',
    'items' => [
      '<ConnectorName>',
    ],
  ],
] ;
?>
```

It's loaded by the `ConfManager` and describes the declared configuration items (here, a logger **t**ool and a connector **u**ser files).

If another configuration file is required, either for a tool, a module or a sub-module, it must be declared in this file (otherwise it will not be accessible using the `ConfManager` helper capabilities).

See [ConfManager](#confManager) for further details.



The connector's configuration file format is the following :

* `self` block : connector description (name of the external service, connector version, ...),

* `protocol` block : external Web Service API description (version, ...),

* `environments` block : CRM environment list (test, preprod, prod, …). For each environment :
  * `accessdata` block : all the date required to access the environment and generate a session (url, key, credentials, security tokens, …),
  * `urls` block : all the data required to build the urls allowing the environment resource access (search page for each entity, entry page, ...).

* `entities` block: complete mapping between the CRM entities and Kiamo (field by field), and search algorithm description (which criteria is used in priority to search a match).

  * `map` block : map table `<CRMEntity> => <KiamoEntity>` (*for instance* : `‘Account’ => ‘company’`).

  * `<kiamoEntityType>` block : complete description of the mapping and the search logic :

    * `labels` block: all the data required to build the entity / entries labels :

      The label of an entry is a concatenation of raw strings and fields values, each item being joined by the separator string.

      ***Warning*** : if several connector blocks are used in the Kiamo SVI script (one per entity, usually), the interaction label will be the label built by the last one of them.

    * `map` block : list of all the fields composing an entry, whatever displayed on Kiwi or simply required to assemble the displayed data.

      *Example* : it's not necessary to display the internal customer Id in the agent GUI ; but this id is required to get related company or ticket entries. So it's necessary to get it while requesting the customer data.

      Each `map` block line  corresponds to one of the external CRM entry field. It's formatted the following way : `<crmFieldName> => [ key, label, type, display, map ]`, where :

      * `<crmFieldName>` is the entry field name in the CRM database.

      * `key` is the intenal key name, which will be used by the connector sample to describe and access this field.

        If `key` is empty, it means it's not often used by the implementation. The typical internal keys are `id`, `firstname`, `lastname`, `phone`, `mobile`, `email`, `contactId`, `companyId`, `ticketId`, `status`, …

        The entity manager provides a method easing the access to an entry field value through this internal key, which is a way to abstract the external CRM names and help the developer to focus on the main data through simple and direct keys.

        *For instance*, the `id` of any entry will always be accessed internally using `id` as key, even if the external CRM fields are respectively `ContactId`, `CompanyId`, `TicketId`, ...

      * `label` : label of the field to display on Kiwi (if displayed).

      * `type` : internal data type. This type will be mapped with the internal Kiamo types, in order to improve the display and add additional features on the agent interface.

        *For instance* a `phone` type will be mapped into the Kiamo `EntityField::TYPE_PHONE` type. On Kiwi, this field will be formatted as a phone number and enriched by a click to call capability.

        The main internal type are `id`, `string`, `phone`, `email`, `date`, `datetime`, `time`, `birthday`, `text`.

      * `display` : boolean driving if this field must be displayed or not, on the agent interface.

      * `map` : Kiamo Cross Canal variable name where the value of this field must be mapped. This mapping is of course optional, `map` can be empty.

    * `search` block : this block describes the search algorithm.

      The data of this block are used by the sample implementation while searching entries matching the Kiamo inputs. There are two kinds of search logics, and one additional method :

      * `kiamoInput` search :

        It's an entries search based on the Kiamo `ParameterBag`.

        The `ParameterBag` is filled with the interaction inputs (as the phone number related to an customer call, the email address related to a received email, ...), and other data added during the Kiamo SVI script execution.

        The `kiamoInput` search block is composed of lines, the first one executed before the second and so on. Each line correspond to an attempt to find match(es) between the input data and the external CRM database, based on a given entity field. As soon as at least one match is found, the search is over and the match returned.

        *For example* :

        > <u>Line #1</u> : use the `ParameterBag` `CustNumber`. Check if not empty, check if valid phone number, then search a match calling the external Web Service API, on the *fix phone number*.
        >
        > <u>Line #2</u> : use the same parameter, but this time looking for matches on the *mobile phone number*.
        >
        > <u>Line #3</u> : `ParameterBag` `EMailSender`, on the external *email address*.
        >
        > (...)

        Each line is composed of the following fields (which can remain empty if not required) :

        * `varName` : name of the `ParameterBag` variable,

        * `entityField` : entity internal field key, corresponding to an external field,

        * `operation` : internal name (key) of the search operation in the external CRM. *For instance* `like` or `equals` for SQL like requests,

        * `preTrt` : pre treatment to apply on the raw input data.

          *For example*, it's usual that phone numbers are not received formatted the exact same way than they are stored on the external CRM database. A typical phone number pre treatment could be to remove all spaces, country prefix, and so on.

          This field can be empty if no pre treatment is required.

          If not empty, it must be filled with the name (case sensitive) of a pre treatment method implemented in the `CustomizationManager` (either already provided in the current package, or implemented for a specific integration).

        * `eligibility` : method applied on the raw (or pre treated) input to check if the input is relevant in a given search context (and avoid useless external CRM requests otherwise).

          *For example*, it's no use to request a search on a *phone number* field  if the input contains alphabetic characters.

          Can be empty, or present in the `CustomizationManager`.

        * `postTrt` : post treatment to be applied on the matching results.

          *For example*, to find the better match if several entries are returned for a given search (and only one expected to be displayed on the agent GUI).

          Can be empty, or present in the `CustomizationManager`.

      * `agentQuery` search :

        It's exactly the same logic of the `kiamoInput` search block, excepted that :

        * this logic is applied on the manual agent search queries (`Search` button on Kiwi), meaning that we have a string, possibly partial, and of unknown type.
        * there is no `varName`, the variable is the search manual input string.

        Otherwise, the applied algorithm and behavior is the same than the `kiamoInput` one.

      * `getOneOfList`additionnal function:

        It's the default function applied if several entries are returned and only one is expected by Kiamo.

        If this variable remains empty, by default the first item of the returned list will be picked up.

        Otherwise, it must correspond to the name of a method implemented on the `CustomizationManager`.

        ***Important*** :  this method is called AFTER any post treatment, if present.



<a name="moduleLogs"></a>
#####   Module Logs

The module logs are written in the folder `<root>/logs/<ConnectorName>`.

The global logs configuration is defined in the file `<root>/conf/t_logger.php`.

The configuration defines the logs level and allows the older logs to be zipped or deleter.

See [Logger](#logger) for further details.



<a name="moduleResources"></a>
#####   Module Resources

To benefit of the resource tool helper capabilities, the resources of the module must be stored in the folder `<root>/data/<ConnectorName>`.

See [Resources](#resources) for further details.



<a name="usage"></a>
#####   Usage

The connector class extends the `Module` class, which provides the `Logger` and `ConfManager` capabilities :

* `Logger` :
  * `Logs` :

    Anywhere in any `Module` or `SubModule` code the `Logger` can be used :

    ```php
    $this->log( "---------", Logger::LOG_INFO, __METHOD__ ) ;
    $this->log( "INIT : OK", Logger::LOG_INFO, __METHOD__ ) ;
    ```

    The logs lines are appended in the file `<root>/logs/<ConnectorName>/<YYYYMMDD>.log` as following :

    ```verilog
    [20190429_102557][INFO ][             ][Logger::__construct ] ---------
    [20190429_102557][INFO ][             ][Logger::__construct ] INIT : OK
    ```

    where :

    - block #1 : datetime,

    - block #2 : level,

    - block #3 : `actionId`,

    - block #4 : origine module and method,

    - log.



  * `actionId` :

    The purpose setting such an `actionId` is to ease the logs reading / search.

    A log section can be decorated with an `actionId`, auto generated or provided by a specific implementation.

    The section must simply start and end with the `actionId` dedicated methods :

    ```php
    $this->setActionId() ;
    $this->log( "Log #01", Logger::LOG_INFO, __METHOD__ ) ;
    $this->log( "Log #02", Logger::LOG_INFO, __METHOD__ ) ;
    $this->clearActionId() ;
    ```

    The corresponding log lines are :

    ```verilog
    [20190429_102557][INFO ][5bd6d225ccee2][Logger::__construct ] Log #01
    [20190429_102557][INFO ][5bd6d225ccee2][Logger::__construct ] Log #02
    ```

    When relevant, the `actionId` can be specific :

    ```php
    $myId = (...)
    $this->setActionId( $myId ) ;
    $this->log( "Log #01", Logger::LOG_INFO, __METHOD__ ) ;
    $this->log( "Log #02", Logger::LOG_INFO, __METHOD__ ) ;
    $this->clearActionId() ;
    ```



* `ConfManager` :

  * Module configuration :

    Any configuration item can be accessed, anywhere on a `Module` or `SubModule` using the `getConf` method :

    ```php
    $var = $this->getConf( 'server.port' ) ;
    ```

    The item will automatically be read from the `<root>/conf/u_<ConnectorName>.php` configuration file. This file is only read on time, the first time any configuration item is accessed. It's loaded and remains in RAM after that.



  * Other configuration :

    Accessing any other configuration file / item is done using the `getGlobalConf` method :

    ```php
    $var = $this->getGlobalConf( 'tools.logger.behavior.dateFormat' ) ;
    ```

    In such case, the `ConfManager` follows the configuration path starting on the root configuration file `_config.php`. In the previous example, `tools` => `logger` => `behavior.dateFormat`.

    Using the same logic we could have accessed a connector's configuration item :

    ```php
    $var = $this->getGlobalConf( 'user.<ConnectorName>.self.name' ) ;
    ```



<a name="interactionManager(submodule)"></a>
####  Interaction Manager (SubModule)

This sub module manages all the interactions with the external CRM.

In the samples, the main methods implemented are :

* the two main search methods :

  * `getSingleEntry` : requests an entry from the external CRM, based on :
    * the entity type,
    * the entry id.
  * `getEntriesList` : gets n entries from the external CRM, based on :
    * the entity type,
    * the entity search field,
    * the search value (complete or partial),
    * the search operation (as `like`, `equals,` ... in SQL like requests),
    * the list of the entity fields required.

  Those two methods will automatically use the internal `InteractionManager` mechanisms to have and if necessary renew the external API access authorization.

  Those two methods return raw data as returned by the external API. The connector implementation will manage the way those methods are called, and the `EntitiesManager` will manage the mapping between the external data format and the format expected by Kiamo.

* the API access authorization management, usually though a session token. In such case it will :

  * implement the session token request and renewal,

  * the token storage, which be used for each request until it's expired.



<a name="entitiesManager(submodule)"></a>
####  Entities Manager (SubModule)

This sub module manages the mapping between the data returned by the external CRM APIs, and the Kiamo entities, based on the connector's configuration.

In the samples, the main implemented methods are :

* the two main mapping methods :

  * `getEntryInstance` : based on the entity type and a raw entry returned by an external CRM API, builds a Kiamo entity.
  * `getEntriesCollection` : same thing than the previous method, for an entries list.

* the methods required by the Kiamo connector :

  * `getEntityLayout` : returns a Kiamo entity pattern, composed of a fields list and some additional data,
  * `getEntitiesSearchUrl` : builds the entities search page URL, on the external CRM,
  * `getEntryExternalUrl` : builds external CRM entry page URL,
  * `getEntryLabel` : builds a given entry label (used as synthetic display on Kiwi),

* several configuration entry points access shortcuts, and the mapping between the internal keys, the external CRM field names and the Kiamo types.



<a name="customizationManager(submodule)"></a>
####  Customization Manager (SubModule)

The `CustomizationManager` sub module manages :

* the inputs eligibilities methods :

  Those methods parse the inputs and check whether they are eligible or not to a search on a given data type (as a phone number, a name, an email address, ...).

  The goal is to avoid useless requests to the external CRM.

* the inputs pre treatment methods, and the CRM responses post treatment methods :

  * The goal of the pre treatment methods is to format the input a proper way, in order they can match the external CRM data.

    *Example* : add a space character every two digits on a 10 digits input phone number.

  * The goal of the post treatment methods is to apply a treatment on a raw returned list of entries.

    *For instance*, enrich, sort, filter, choose the most relevant items, ..., of the returned list.

* `n => 1` list filters :

  Those methods are required when several matches can be returned by an API, and Kiamo expects only one result entry (ideally we have to select the most relevant, if possible).

  *For instance*, selection of the most relevant ticket of a given customer (older opened OR newer closed, or any other algorithm).

* any specific method required by the current integration.



<a name="mainHelpers"></a>
### Main Helpers


<a name="autoloader"></a>
####  AutoLoader

An auto loader is provided to ease the tools loading. Any `Module`, `SubModule` or class willing to use the toolkit should include the following line :

```php
    require_once <rootPath> . "tools/autoload.php" ;
```

 After this line, any tool can be used directly, or aliased :

```php
    use <ToolkitNamespace>\Module    ;
    use <ToolkitNamespace>\Resources ;
    use <ToolkitNamespace>\Uuids     ;

    class MyModule extends Module
    {
      (...)
```



<a name="module"></a>
####  Module

A `Module` is a class which purpose is to provide to a extending class all the main capabilities a module could need, as a Logger or a Configuration Manager for instance.

The `Module` class does not have to be described in detail.

Any extending class will be provided the following capabilities :

* Logger :

  * `log( $logStr, [ $logLevel, $caller ] )` => write a log in the daily log file,
  * actionId :
    * `setActionId( [ $actionId ] )`   => start a log section decorated by an unique actionId,
    * `clearActionId()`                              => stop to decorate the log with the last actionId,
    * `getActionId()`                                  => get the current action Id,

* ConfManager :

  * `getConf( $confPath )`                           => get an item of the module configuration.

  * `getGlobalConf( [ $confPath ] )`      => get an item of the global configuration.

    <u>Remark</u> : `$confPath` is either a string (‘.’ separator) or an array :

    * `getConf( 'runtime.datetimes.dateFormat' )`
    * `getConf( [ 'runtime', 'datetimes, 'dateFormat'] )`

 That means anywhere on the class implementation lines, the extending class can use :

```php
    $this->log( “This is a log”, Logger::LOG_INFO, __METHOD__ ) ;
```

which will generate a formatted log in the following file : `<logsPath>/<ClassName>/<YYYYMMDD>.log`

​    `[YYYYMMDD_hhmmss][INFO ][             ][<ClassName>::<MethodName>] This is a log`

or :

```php
    $dateFormat = $this->getConf( “runtime.datetimes.dateFormat” ) ;
```

which will get the value of the `dateFormat` key in the array returned by the following configuration file :

​    `<confPath>/u_<className>.php`

If the extending class is located at the root of the package and want to use the standard package structure and design, the `Module` constructor can be skipped (everything is automated).

Otherwise, all the folder locations and even the module name, driving the configuration file name, can be specified while building the extending class instance.

```php
class MyClass extends Module
{
  public function __construct()
  {
    parent::__construct( <PathToTheToolkit>,<LogsFolderPath>,<ConfFolderPath>,<ModuleName> ) ;
    (...)
```



<a name="confmanager"></a>
####  ConfManager

The `ConfManager` class does not have to be described in detail.

All the configuration files are PHP `key => value` arrays, wrote and used like JSON dictionaries.

A `ConfManager` instance is automatically created while instantiating a `Module`.

This class is an helper to manage and access the package configuration :

* the configuration root file is `<rootFolder>/conf/_config.php`. This file describes the declared configurations (package main classes and tools configurations). The Configuration Manager use it to resolve,  access and loads (on demand) the required configuration data.
* a configuration file is only loaded on demand (access to one of its’ items), and only one time (keeped in RAM once loaded the first time).

* the main Configuration Manager methods are :
  * `getConf( $itemPath )` : access to a configuration item. If `$itemPath` is empty, the whole configuration array is returned.

  * `isInConfig( $itemPath )` : check either or not a configuration item is present on the configuration array.

    <u>Warning</u> : the configuration must be loaded before using this method, otherwise the return will be `false` even if the item exists on the conf.

  * `loadConf( $confPath )` : force the load of a configuration. The `$confPath` must end with the configuration item name, as `'tools.logger'` or `'user.MyModule'` for instance.

    <u>Note</u> : most of the time it’s useless to force a configuration load. The use of `getConf` while accessing a conf item will automatically load it.



<a name="logger"></a>
####  Logger

The `Logger` class does not have to be described in detail.

This class is a logs manager helper. A Logger instance is automatically created while instantiating a `Module`.

The daily log files will be written in `<logsFolder>/<className>.` Note that if a `Module` uses a `SubModule`, the SubModule will have his own logs sub folder : `<logsFolder>/<subModuleClassName>`.

 It’s also possible to use the Logger capabilities as Logger class methods, without a Logger instance. In such case the logs file will be written in the `<logsFolder>` folder.

* The Logger configuration is file is `<rootPath>/conf/t_logger.php`, and defines :
  * the logs behavior (key : ‘`behavior`’) :

    * global log level (key : ‘`globalLogLevel`’), in :

      * `Logger::LOG_VERBOSE`,
      * `Logger::LOG_TRACE`,
      * `Logger::LOG_DEBUG`,
      * `Logger::LOG_INFO`,
      * `Logger::LOG_WARN`,
      * `Logger::LOG_ERROR`,
      * `Logger::LOG_CRITICAL`.

      Only the logs with a level upper or equals to this global level will be written.

    * date format ( key : ‘`dateFormat`’),

    * « smart » caller method name (key : ‘`smartMethodName`’) :

      * enabled (key : ‘`enabled`’) :
        * if `false`, the full caller method name will be written,
        * if `true`, the caller method name will be cropped to ease the logs reading.
      * Strict length (key : ‘`strictLength`’) : the logs block dedicated to the caller method name will be forced to this size (shorter filled of spaces, longer right truncated).

  * Logs files management (key : ‘`files`’) :

    * root logs folder (key : ‘`folder`’) : relative root logs folder path.

    * obsolete log files management (key : ‘`obsolete`’) :

      * zip (key : ‘`zipOlderThan`’) : the log files older than the defined number of days are individually zipped.
      * delete (key : ‘`deleteOlderThan`’) : the log files older than the defined number of days are deleted.

      Note : this is checked each time a new daily logs file must be created.



* The logs are written in daily files : `<rootFolder>/logs/<ModuleClassName>/YYYYMMDD.log`

* The main function is `log( $str, [ $level, $method, $actionId, $indentLevel ] )` :
  * `$str` the string to log,
  * `$level`, the log level (default value, `Logger::LOG_DEBUG`),
  * `$method`, name of the caller method. It’s recommanded to use the PHP « magic constant » `__METHOD__`.
  * `$actionId` : log action id. Except specific needs, it’s recommanded to use the `Module/SubModule` `setActionId` and `clearActionId` to decorate a logs section, and not using this manual parameter.
  * `$indentLevel` : int value indicating the number of left space to add before the log string (just after the method name block). Can be used to ease the logs readability in specific cases (but ignore it otherwise).

* Logs lines examples :

```
[20190429_102557][INFO ][             ][MyModule::__construct ] ---------
[20190429_102557][INFO ][             ][MyModule::__construct ] INIT : OK
```

where :

* 1st bloc is the log date

* 2nd is the log level

* 3rd the `actionId`

* 4th the caller method

* then the actual log.



<a name="submodule"></a>
####  SubModule

The purpose of a sub module is to provide a consistent set of features (database access, web service interface, …) to a main module.

 The purpose of the `SubModule` class is to inherit from their parent Module its main helpers (configuration manager, logger, …), in order they can generate logs or access configuration items without having to create their own helpers instances.

 As a parent `Module`, a sub module must extend the `SubModule` class :

```php
<?php
namespace <ConnectorNamespace> ;

require_once( __DIR__ . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . 'autoloader.php' ) ;

use <ConnectorNamespace>\ConfManager ;
use <ConnectorNamespace>\SubModule   ;

class MySubModule extends SubModule
{
  public   function __construct( $_parent )  // The _parent must be a Module
  {
    parent::__construct( $_parent, get_class( $_parent ), ConfManager::UserConfType ) ;
  }

  public   function doSomething( $args )
  {
    (...)
  }
  (...)
}
?>
```

 Then the sub-module will benefit of the same features than the parent `Module` : `log`, `setActionId`, `clearActionId`, `getConf`, `getGlobalConf`. The log and conf file of a sub module are the parent’s ones.

 <u>Note</u> :

> In the `__construct__`, the second parameter is the sub module name.
>
> If this name is different than the parent `Module` name, the `SubModule` will have its own logs, configuration and resource files. In the other hand in such case, you’ll need to access manually to the parent capabilities, as `$this->_parent-><capability>( ... ) ;`
>
> Otherwise, if the `SubModuleModule` has to access and log file of the parent `Module`, simply pass `get_class( $parent )` as second parameter.



-----

<a name="tools"></a>
### Tools

<a name="datetimes"></a>
####  datetimes

The `datetimes` lib provides a set of functions to manipulate and convert dates, times, formats, timestamps in second, millis, …

 In this lib, the default date format is `YYYYMMSS_hhmnss`. But actually, any date format is accepted.

The main features are date / time generation, conversions, operations, comparison.



<a name="dict"></a>
####  dict

The `dict` lib provides the `Dict` class, which is a quite complete `key => value` array manipulation helper, where value is either a raw data or a sub tree.

If a `Dict` is created over a given array, the following capabilities are provided :

* get : access to any array leaf, though its path.

  The path is either a string (‘.’ as separator) or an array of keys :

  `get( 'tools.logger.behavior.dateFormat'             )`

  `get( [ 'tools', 'logger', 'behavior', 'dateFormat'] )`

  An optional parameter is available, the `$strict` boolean (Default : `false`) :
  * if it’s `false`, `get` will return `null` if the path is not valid in the `Dict`,
  * if it’s `true` and the path not valid, an `Exception` will be raised.

* `set` : same as get, sets a value anywhere on the tree.

* `set( 'tools.logger.behavior.dateFormat'            , "Ymd_His" )`

  `set( [ 'tools', 'logger', 'behavior', 'dateFormat'], "Ymd_His" )`

  The optional parameter `$strict` is also available (Default : `false`) :

  * if it’s `false`, the whole path is created if needed,
  * if it’s `true` and the full path (except the last leaf) is not present in the tree, an `Exception` is raised.

  This way for instance, one only set can create the path `'tools.logger.behavior.dateFormat'` in an empty array.

* `del` : deletes a path in the `Dict`.

  If the path does not exists, do nothing (no ‘strict’ mode).

* `exists` : `true` if the path exists in the `Dict`, `false` otherwise.

  No ‘strict’ mode.

- `fromFile` : loads a file returning a `key => value` array, and updates the `Dict`.

  `fromFile( $filepath )`

  => the `$filepath` file content remplaces the current `Dict` content.

  `fromFile( $filepath, $atKeyPath )`

  => the `$filepath` file content is added at `$atKeyPath` path in the current `Dict` (non ‘strict’ mode).

* `json` : returns the JSON representation string of the current `Dict`.



In addition, the lib provide common `Dict` features :

* `Dict::splitKey( $key )` : convert a ‘`<key1>.<key2>. … . <key n>`’ string into a keys array (used as `Dict` path).

  *Example* : '`tools.logger.behavior.dateFormat`' => `[ 'tools', 'logger', 'behavior', 'dateFormat']`

* `Dict::joinKey( $key )` : converts a keys array into a formatted path string (mainly used for logging or display).

  *Example* : `[ 'tools', 'logger', 'behavior', 'dateFormat']` => '`tools.logger.behavior.dateFormat`'



<a name="files"></a>
####  files

`files` defines the static class `Files`, easing files manipulations :

* `Files::existsFile( $filepath )` : `true` or `false` depending if file or folder exists or not.

* `Files::srm( $filepath )` : deletes a file or a folder. Does nothing if file does not exists.

* `Files::fileInfos( $filepath )` : returns the file system data.

* `Files::folderFiles( $pattern [, $flags = 0 ] )` : returns the files corresponding to the provided pattern.

* `Files::zipFile( $filepath [, $deleteSource = true ] )` : zip the file in its own folder, deletes the source if required.



<a name="resources"></a>
####  resources

The static class `Resources` provides, globally, the same features of the `Files` class.

The purpose of the `Resources` class is to manipulate `Module` or `SubModule` resource files in their own resource folder `<rootFolder>/data/<ModuleName>`. The Module or SubModule will be provided a default resource file, or will simply manage its resource files through their base name.

*Example* :

`Resources::existsFile( ‘data.json’ )` will return `true` if the file ‘`data.json`’ exists in the `<rootFolder>/data/<ModuleName>` folder.



<a name="strings"></a>
####  strings

This static class provides basic string manipulation features.

* `Strings::strStartsWith( $sourceStr, $searchedStr )` : `true` or `false`.

* `Strings::adjust( $sourceStr, $size = -1, $border = RIGHT, $fill = ' ' )` : returns an adjusted length string, depending on the provided parameters :
  * `$size`              : fix length. Cropped or if required, filled right with the `$fill` character.
  * `$border`          : right, left or center adjustment.
  * `$fill`              : fill character

* `Strings::getJson( $data, $pretty = false )` : returns the JSON string representation of the provided data.

* `Strings::hprint( $data, $prefix = '', $postfix = '' )` : echo of the data in the Web Page.



<a name="userdata"></a>
####  userdata

This static class `UserData` eases the user data manipulation, as phone numbers, email addresses, …

* `couldBe` functions : checks if the string is eligible to a given kind of user data :
  * `UserData::couldBeId( $str )` : `true` if alphanum,
  * `UserData::couldBePhone( $str )` : `true` if possible phone number,
  * `UserData::couldBeEmail( $str )` : `true` if probable email address.

* `format` functions :
  * `formatTelNumberForSearch` : removes the non digit characters, and the ‘`0`’ prefix character from a phone number,
  * `formatTelNumberForDisplay` : keeps only, adds a ‘`0`’ prefix character if necessary.



<a name="uuids"></a>
####  uuids

Static class `Uuids`, generating uniq ids.

* `Uuids::get( $strong = false, $length = DEFAULT_SIZE )` : generates an uniq id.
  * if `$strong` is `false`, this id is simply based on the current timestamp ; otherwise, the id unicity is reinforced by a strong random number generator.
  * if `$length` is not provided, the default size is `32` characters.

* `Uuids::realrand( $min, $max )` : generates a random integer (strong random algorithm) between `$min` and `$max`.



<a name="webs"></a>
####  webs

Static REST requests helper, based on curl.

* `restRequest( $url, $data = null, $header = null, $authData = null, $verbose = false )` :

  returns `[ okFlag, curl_error, http_code, jsonResponse ]`

  * if `$data` is not `null` the request is a `POST`, otherwise a `GET`.



------

<a name="additionalTools"></a>
### Additional Tools

In addition to the package structure and the standard tools and helpers, a Command Line Test Helper is provided.

 The purpose of this helper is to ease the implementation and the tests of the features currently implemented without an actual production environment.



<a name="commandLineTester"></a>
####  Command Line Tester

It’s a file provided with each sample package : `CommandLineTester.php`

The Command Line Tester is called this way :

```SHELL
> php CommandLineTester.php -f --test=<testNb>
```

 The behavior is the following :

* the provided test number is checked, in order to verify a corresponding test function has been defined,

* in such case, the function is executed.

The tested `Module` and/or `SubModule` instances are created while the `CommandLineTester` is instantiated. The defined test functions are setup in an array. This way it’s easier to add and access the test functions.

Most of the time the sample package’s `CommandLineTester` contains the key tests used to verify the proper implementation behavior (authentication, single API request, user data management, …).

<a name="connectorChecker"></a>
####  Connector Checker

It's a folder present at the package root, containing a piece of PHP code that will be called through a Web Browser.

The purpose of this tool is to ease the connectors deployments.

When a connector is loaded by Kiamo, if any implementation or character encoding issue is present, unwanted and unfriendly side effect can occur in Kiamo, as white or partially displayed pages, error 500, ...

To avoid such kind of unpleasant disagreement, this tool will apply several basic checks :

* Compilation : no parse error is detected in the connector class,

* Instantiation : it's possible to instantiate the connector,

* Character encoding : all the files are UTF-8 encoded, or ASCII ANSI is no extended character is present. The checker will verify that rule on :
  * the connector's folder (non recursive),
  * the connector's configuration folder, if present (non recursive),
  * the connector's tools folder, if present (non recursive).

The Connector Checker's folder can be deployed in the Kiamo public folder :

​    `<KIAMO>\Kiamo\data\userfiles\public`

To check a Connector, if Kiamo is running, enter the following URL on a Web Browser :

​    `http://127.0.0.1/public/ConnectorSimpleChecker/?name=<YouConnectorFolderName>`

 The Connector Checker will print and point out the first issue found (or success).



<u>Note</u> : the character encoding detection has no way to be 100% accurate, so the Connector Checker can raise an erroneous character encoding issue. Knowing the character encoding is the last verification done, the Connector's code should be OK. Check the character encoding of the file pointed out by the Checker. If nothing's wrong, simply ignore the issue.



<a name="sviScriptExamples"></a>
####  SVI Script Examples

A basic SVI script example is provided at the root of the package

In this script, the connector is called 4 times :

* search of a **contact** corresponding to the input phone number,
* search of a **company** corresponding to previous contact if found, or the input phone number otherwise,
* search of an open **ticket** (linked to the found contact or company, if any),
* update of the **interaction label** (contact name in this example, if a contact has been found),

It's a simple and basic example of a Kiamo CRM Connector usage, to be enriched and customized at will.

