<?php

error_reporting(E_ALL);

// Xpaths to filter files
$xpath['anytext'] = '//*/text()';
$xpath['title'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:citation/gmd:CI_Citation/gmd:title/gco:CharacterString/text()';
$xpath['abstract'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:abstract/gco:CharacterString/text()';
$xpath['subject'] = '//gmd:descriptiveKeywords/gmd:MD_Keywords/gmd:keyword/gco:CharacterString/text()';
$xpath['topiccategories'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:topicCategory/gmd:MD_TopicCategoryCode/text()';
$xpath['dataextentdescription'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:extent/gmd:EX_Extent/gmd:description/gco:CharacterString/text()';
$xpath['datalanguages'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:language/gmd:LanguageCode/@codeListValue';
$xpath['mdlanguage'] = '//gmd:language/gmd:LanguageCode/@codeListValue';
$xpath['mdcontactsname'] = '//gmd:contact/gmd:CI_ResponsibleParty/gmd:individualName/gco:CharacterString/text()';
$xpath['mdcontactsposition'] = '//gmd:contact/gmd:CI_ResponsibleParty/gmd:positionName/gco:CharacterString/text()';
$xpath['mdcontactsorganism'] = '//gmd:contact/gmd:CI_ResponsibleParty/gmd:organisationName/gco:CharacterString/text()';
$xpath['datapointofcontactsname'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:pointOfContact/gmd:CI_ResponsibleParty/gmd:individualName/gco:CharacterString/text()';
$xpath['datapointofcontactsposition'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:pointOfContact/gmd:CI_ResponsibleParty/gmd:positionName/gco:CharacterString/text()';
$xpath['datapointofcontactsorganism'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:pointOfContact/gmd:CI_ResponsibleParty/gmd:organisationName/gco:CharacterString/text()';
$xpath['datamaintenancefrequency'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:resourceMaintenance/gmd:MD_MaintenanceInformation/gmd:maintenanceAndUpdateFrequency/gmd:MD_MaintenanceFrequencyCode/@codeListValue';