# Kiamo CRM Connector Samples

## Set Description



| Date    | 20191016  |
| :------ | --------- |
| Version | v2.0.0    |
| Author  | S.Iniesta |



------


[Introduction](#introduction)

&nbsp;&nbsp;&nbsp;&nbsp;[Purpose](#purpose)

&nbsp;&nbsp;&nbsp;&nbsp;[Description](#description)

[Design](#design)

[Connector](#connector)

&nbsp;&nbsp;&nbsp;&nbsp;[Kiamo Connector](#kiamoConnector)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Configuration](#configuration)

&nbsp;&nbsp;&nbsp;&nbsp;[Interaction Manager](#interactionManager)

&nbsp;&nbsp;&nbsp;&nbsp;[Entities Manager](#entitiesManager)

[Main Helpers](#mainHelpers)

&nbsp;&nbsp;&nbsp;&nbsp;[Logger](#logger)

&nbsp;&nbsp;&nbsp;&nbsp;[Webs](#webs)

&nbsp;&nbsp;&nbsp;&nbsp;[Command Line Tester](#commandLineTester)

[Additional Tools](#additionalTools)

&nbsp;&nbsp;&nbsp;&nbsp;[Connector Checker](#connectorChecker)

&nbsp;&nbsp;&nbsp;&nbsp;[SVI Script Examples](#sviScriptExamples)


------



<a name="introduction"></a>
### Introduction

<a name="purpose"></a>
####  Purpose

The goal of this set is to provide CRM Connector Samples to a development team, based on a very simple design.

Each sample can be used as a simple illustration, or as support to a more specific implementation.

<u>Note</u> : In each sample is present, at the end of the file, the `CommandLineTester` class, which helps the tests and integration phases by allowing the developper to run methods of the connector via a simple Command Line Shell. The best way to discover and appropriate a connector may be to read and, when the connector is set up, to run the basic connector's main components tests located in the `CommandLineTester` class.



<a name="description"></a>
####  Description

The following scheme presents a synthetic design of a Kiamo CRM Connector :

![Kiamo CRM Connector Design](https://github.com/openKiamo/CRM-Connectors/blob/master/_resources/01_KiamoConnectorCRM.png)

It's mainly dedicated to gather external data and entities, corresponding to the inputs received by Kiamo, as a customer or a ticket description for instance.

The folder of a given CRM connector sample is composed of :

* the implementation of the CRM connector, which is usually composed of :
  * the main Kiamo connector class,
  * the interaction manager class, which creates and maintain a valid session with the external API, and communicates with the external services to gather the data required by the connector,
  * the entity manager class, which maps the external data received from the APIs into a valid Kiamo structured form,
  * some helper tools, as a logger for instance.
* the `readme.md` file, the connector's documentation.


Each sample manages the connection with a specific external CRM.

The reference Kiamo documentation to implement a connector is unchanged : « `Development of CRM-ERP connectors` ».



The Kiamo deployment folder for a connector is :

`<Kiamo Folder>/data/userfiles/class/Connectors/<ConnectorName>`



The sample code and structure are quite easy to read and understand. The documentation provides additional details to understand the global idea and implementation particularities, for a better appropriation.

<u>Note</u> : in this document and the related code, the following notions will be used :

* `entity`, an entity representing a kind of item. *For instance* "contact", "company", "user's ticket", ...

* `entry`, an entity instance. *For instance*, the data block describing the "contact" M. Winston Churchill.

These two notions are used this way in all the connector samples, but are different of the ones present on the Kiamo connector function names.



The current CRM connector samples (may 2019) are the following :

* an **MS Dynamics 365** *(API v9.0, 2018)* connector sample,

* a **Salesforce Lightning** *(API v41.0, winter 2018)* connector sample,

* an **Edeal** *(API 2015)* connector sample.



------

<a name="design"></a>
### Design

The following scheme presents the typical architecture of a connector sample :

![Connector Sample Architecture](https://github.com/openKiamo/CRM-Connectors/blob/master/_resources/02_ConnectorSampleDesign.png)



Basically, the design is the following :

* the Kiamo connector receives the search criteria from Kiamo (as a phone number, an email address, ...) and will return the found matching results,
* the connector's configuration is initialized when a connector instance is built, and will be used by the sub-classes instances. It contains all the data required to connect and use the external service, and to map the entries between the external format into the Kiamo expected format,
* it uses an `InteractionManager` sub-class instance, which converts the search criteria into actual external services requests,
* the matching results are sent to the `EntitiesManager` sub-class instance, which converts the raw returned results into the Kiamo required data format,
* in addition, some helpers can be present, as a logger, a webRequester, the CommandLineTester, ...).



In more details, the design of those samples is split in 3 main parts :

* the Kiamo CRM connector :

  it's the main class.
  * It's mainly the visible bridge between Kiamo and the external CRM. It defines the kind of entities the connector can return, and the connector's features.
  * In the sample package, this class is mainly an empty shell, using it sub-classes to manage the actual tasks :
    * search and gather the external CRM data (session, access),
    * map the data,
    * apply the specific treatments (sort, filter, format, ...).

  The external entities search is driven by the provided inputs (as a phone number, an id, ...) and the configuration (action priority, specific treatment, ...).

* the sample architecture is composed of :

  * the Kiamo CRM Connector class (at the root of the folder, see upper).

    This class contains :

    * the usual Kiamo CRM connector features implementation,
    * the connector's configuration.

  * the connector's sub-classes :

    * the `InteractionManager` : manages the session and the requests to the external CRM API, returns the raw results (as they are returned by the APIs).

      This sub-module hides the session token management (get a valid one, save it for future request, renew it if expired, ...). This avoid useless external API calls.

    * the `EntitiesManager` : it knows the raw format of the API results, and the format expected by Kiamo.

      Using the configuration, it checks the returned data validity and maps the raw result into the expected Kiamo format (`EntityLayout`, `EntityInstance`, `EntitiesCollections`).


<a name="connector"></a>
### Connector

A Kiamo CRM connector can be implemented in one and only class.

In those samples, the implementation is split between a main module, the connector itself, and two sub-classes, each one attached to a specific responsibility set :

* the connector  :
  * implements the methods requested by the connector implementation documentation,
  * is driven by its configuration to request the external CRM and search the items matching the Kiamo inputs. It implements the configuration reading and execution.
* the sub-classes :
  * the `InteractionManager`  :
    * implements the external CRM authentication, the valid session token refresh mechanism, and the access to the CRM resources,
    * returns the raw results (no treatment applied on the results returned by the CRM),
  * the `EntitiesManager` :
    * "translates" and maps the raw results into valid Kiamo entities, based on the connector's configuration.



<a name="kiamoConnector"></a>
#### Kiamo Connector

<a name="configuration"></a>
#####   Configuration

The connector's configuration file format is the following :

* `self` conf : connector description (name of the external service, connector version, ...),

* `runtime` conf : mainly the Logs level,

* `access` conf : all the data required to access the external CRM :

  * `accessdata` block : all the data required to access the environment and generate a session (url, key, credentials, security tokens, …),

  * `urls` block : all the data required to build the urls allowing the environment resource access (search page for each entity, entry page, ...).

* `entityMapping` conf : map table `<CRMEntity> => <KiamoEntity>` (*for instance* : `‘Account’ => ‘company’`).

* `<kiamoEntityType>` block : complete mapping between the CRM entities and Kiamo (field by field), and search algorithm description (which criteria is used in priority to search a match) :

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

        If not empty, it must be filled with the name (case sensitive) of a pre treatment method implemented in the connector's main class.

    * `agentQuery` search :

      It's exactly the same logic of the `kiamoInput` search block, excepted that :

      * this logic is applied on the manual agent search queries (`Search` button on Kiwi), meaning that we have a string, possibly partial, and of unknown type.
      * there is no `varName`, the variable is the search manual input string.

      Otherwise, the applied algorithm and behavior is the same than the `kiamoInput` one.


<a name="interactionManager"></a>
####  Interaction Manager

This sub-class manages all the interactions with the external CRM.

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



<a name="entitiesManager"></a>
####  Entities Manager

This sub-class manages the mapping between the data returned by the external CRM APIs, and the Kiamo entities, based on the connector's configuration.

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



<a name="mainHelpers"></a>
### Main Helpers


<a name="logger"></a>
####  Logger

The `Logger` class does not have to be described in detail.

The daily log files will be written in the connector's root folder.

* The logs are written in daily files : `YYYYMMDD.log`

* The main function is `log( $str, [ $level, $method, $actionId, $indentLevel ] )` :
  * `$str` the string to log,
  * `$level`, the log level (default value, `Logger::LOG_DEBUG`),
  * `$method`, name of the caller method. It’s recommanded to use the PHP « magic constant » `__METHOD__`.
  * `$indentLevel` : int value indicating the number of left space to add before the log string (just after the method name block). Can be used to ease the logs readability in specific cases (but ignore it otherwise).

* Logs lines examples :

```
[20190429_102557][INFO ][MyModule::__construct ] ---------
[20190429_102557][INFO ][MyModule::__construct ] INIT : OK
```

where :

* 1st bloc is the log date

* 2nd is the log level

* 3rd the caller method

* then the actual log.



<a name="webs"></a>
####  Webs

Static REST requests helper, based on curl.

* `restRequest( $url, $data = null, $header = null, $authData = null, $verbose = false )` :

  returns `[ okFlag, curl_error, http_code, jsonResponse ]`

  * if `$data` is not `null` the request is a `POST`, otherwise a `GET`.



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

The tested connector instance is created while the `CommandLineTester` is instantiated. The defined test functions are setup in an array. This way it’s easier to add and access the test functions.

Most of the time the sample package’s `CommandLineTester` contains the key tests used to verify the proper implementation behavior (authentication, single API request, user data management, …).


------

<a name="additionalTools"></a>
### Additional Tools


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

