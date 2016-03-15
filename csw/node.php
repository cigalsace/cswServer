<?php
include_once('../helpers.php');

// Path of CSW node (directory of XML files)
$csw_path = '../nodes/node';

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
// include_once('../test.php');
?>
