# Kiamo CRM Connector Samples

## MS Dynamics



| Date    | 20191015  |
| :------ | --------- |
| Version | v1.0.0    |
| Author  | S.Iniesta |



------


[Introduction](#introduction)

&nbsp;&nbsp;&nbsp;&nbsp;[Purpose](#purpose)

&nbsp;&nbsp;&nbsp;&nbsp;[Description](#description)

[Connector Sample](#connectorSample)

&nbsp;&nbsp;&nbsp;&nbsp;[Kiamo Connector](#kiamoConnector)

&nbsp;&nbsp;&nbsp;&nbsp;[Interaction Manager](#interactionManager)

&nbsp;&nbsp;&nbsp;&nbsp;[Entities Manager](#entitiesManager)

&nbsp;&nbsp;&nbsp;&nbsp;[Command Line Tester](#commandLineTester)



------



<a name="introduction"></a>
### Introduction

<a name="purpose"></a>
####  Purpose

This folder contains the sample of a Kiamo CRM Connector for **MS Dynamics** *(API v9.0)*.
This sample can be used as a simple illustration or as support to a more specific implementation.

<u>Note</u> : the best way to discover and appropriate the connector may be to read and, when the connector is set up, to run the basic connector's main components tests, located in the `CommandLineTester` class at the end of the file.



<a name="description"></a>
####  Description

In addition to this documentation, the package contains the connector sample in one single file :

* '<ConnectorName>'.php : the connector sample.

The reference Kiamo documentation to implement a connector is unchanged : « `Development of CRM-ERP connectors` ».

The Kiamo deployment folder for a connector is :
`<Kiamo Folder>/data/userfiles/class/Connectors/<ConnectorName>`

The sample code and structure are quite easy to read and understand. The documentation provides additional details to understand the global idea and implementation particularities, for a better appropriation.

<u>Note</u> : in this document and the related code, the following notions will be used :

* `entity`, an entity representing a kind of item. *For instance* "contact", "company", "user's ticket", ...

* `entry`, an entity instance. *For instance*, the data block describing the "contact" M. Winston Churchill.

These two notions are used this way in all the connector samples, but are different of the ones present on the Kiamo connector function names.

------

<a name="connectorSample"></a>
### Connector Sample

The Connector Sample file contains :

* the actual Kiamo CRM Connector class (plus the required configuration),
* an Integration Manager class, which hold the responsibility to interact with the external CRM (authentication, Web Services requests),
* an Entities Manager class, which hold the responsibility to map the raw received results into Kiamo formatted data,
* a command line tester, which helps the integration and the main feature tests step by step.
* some helpers (a simple logger, a CURL requests manager, ...).

Basically, a classic use case is the following :

* the Kiamo connector receives the search criteria from Kiamo (as a phone number, an email address, ...) and will return the found matching results,
* it uses his `InteractionManager` instance, which converts the search criteria into actual external services requests,
* the matching results are sent to the `EntitiesManager` instance, which converts the raw returned results into the Kiamo required data format.

It's of course possible to modify and extend this design at will.


<a name="kiamoConnector"></a>
####  Kiamo Connector

This class is the actual Kiamo Connector.

It contains :

* the implementation of the expected Kiamo Connector Interfaces (connector, contact, company, ...),
* the connector's configuration (platform access credentials and URLs, entities description and mapping, ...),
* the runtime instances :
  * Interaction Manager,
  * Entities Manager,
  * Logger (the log files are written in the connector's folder).


<a name="interactionManager"></a>
####  Interaction Manager

This class manages all the interactions with the external CRM.

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

  Those two methods will automatically get or renew the external API access authorization.

  Those two methods return raw data as returned by the external API. The connector implementation will manage the way those methods are called, and the `EntitiesManager` will manage the mapping between the external data format and the format expected by Kiamo.


<a name="entitiesManager"></a>
####  Entities Manager

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

<a name="commandLineTester"></a>
####  Command Line Tester

The Command Line Tester is a tool that is designed to :

* be used through a command line shell,
* help the integration and the test of the main features of a connector, step by step.

The purpose is to help the definition in very few lines, and the execution though a simple cmd shell line, of any kind of connector test.

This class is only instantiated if the php file is executed by php using a command line shell, otherwise it's ignored.

Basically, you will find the following kind of tests :

* the external CRM authentication test (get a session token),
* an external CRM query string build,
* the main external CRM Web Service function requests (get item by id, search items by pattern, ...),
* the test of the mapping between raw returns and Kiamo items or lists,
* the end to end connector main functions tests,
* ...

The Command Line Tester is called this way :

```SHELL
> php <ConnectorName>.php -f --test=<testNb>
```

 The behavior is the following :

* the provided test number is checked, in order to verify a corresponding test function has been defined,

* in such case, the function is executed.

It's highly recommended :

* to have a look to these tests in order to understand the very few key entry points of the connector sample
* to customize and use them to test the initial steps of an integration, before any code modification in the connector's module,
* to add and run any test you need to verify your connector's customization.
