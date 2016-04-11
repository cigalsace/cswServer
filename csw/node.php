<?php
include_once('../config.php');
include_once('../helpers.php');

// Path of CSW node (directory of XML files)
$csw_path = '../nodes/node';

// Constraints: define constraints to filter XML (operator is "contains")
// $constraints['AnyText'] = ''; // Text in all file
// $constraints['Title'] = '2008'; // Text in title
// $constraints['Abstract'] = ''; // Text in abstract
// $constraints['Keywords'] = 'Alsace+données'; // Get only the XML files with this keywords
// $constraints['TopicCategories'] = 'imageryBaseMapsEarthCover'; // Get only the XML files with this topic categories
// $constraints['DataExtentDescription'] = ''; // Text in extent description
// $constraints['DataLanguages'] = ''; // Get only XML files with a specific language. ISO 3 letters language ('eng', 'fre', 'deu', etc.)
// $constraints['MdLanguage'] = ''; // Get only XML files with a specific language. ISO 3 letters language ('eng', 'fre', 'deu', etc.)
// $constraints['MdContactsName'] = 'Guillaume'; // Text in metadata contact name
// $constraints['MdContactsPosition'] = ''; // Text in metadata contact position
// $constraints['MdContactsOrganism'] = ''; // Text in metadata contact organism
// $constraints['DataPointOfContactsName'] = ''; // Text in data contact name
// $constraints['DataPointOfContactsPosition'] = ''; // Text in data contact position
// $constraints['DataPointOfContactsOrganism'] = ''; // Text in data contact organism
// $constraints['DataMaintenanceFrequency'] = ''; // Filter according maitenance frequency code

// Configuration of capabilities (GetCapabilities XML response)

// ServiceIdentification 
$ows_Title = 'Titre du flux';
$ows_Abstract = 'Résumé du flux.';
$ows_Keywords[] = 'Géoportail';
$ows_Keywords[] = 'Données ouvertes';
$ows_Keywords[] = 'Alsace';
$ows_Keywords[] = 'Orthophotographie';
$ows_Keywords[] = 'Alsace Champagne-Ardenne Lorraine';
$ows_Type = 'theme';
$ows_ServiceType = 'CSW';
$ows_ServiceTypeVersion = '2.0.2';
$ows_Fees = 'None';
$ows_AccessConstraints = 'None';

// ServiceProvider
$ows_ProviderName = 'Région Alsace Champagne-Ardenne Lorraine';
$ows_ProviderSite = 'https://www.cigalsace.org';
$ows_IndividualName = 'My NAME';
$ows_PositionName = 'Administrator';
$ows_Voice = '--';
$ows_Facsimile = '--';
$ows_DeliveryPoint = 'Adress';
$ows_City = 'City';
$ows_AdministrativeArea = 'Alsace Champagne-Ardenne Lorraine';
$ows_PostalCode = '00000';
$ows_Country = 'France';
$ows_ElectronicMailAddress = 'guillaume.ryckelynck@region-alsace.eu';
$ows_HoursOfService = '--';
$ows_ContactInstructions = '--';
$ows_Role = 'pointOfContact';
$ows_Get = getPageURL(); // URL of this PHP file 

include_once('../server.php');

?>
