<?php


/*
// Regex to filter files
$regex['anytext'] = "#.*(%value%).*#i";
$regex['title'] = '#<gmd:MD_DataIdentification>.*<gmd:citation>.*<gmd:CI_Citation>.*<gmd:title>\s*<gco:CharacterString>.*(%value%).*</gco:CharacterString>\s*</gmd:title>.*</gmd:CI_Citation>.*</gmd:citation>.*</gmd:MD_DataIdentification>#sim';
$regex['abstract'] = "#<gmd:abstract>\s*<gco:CharacterString>.*(%value%).*</gco:CharacterString>\s*</gmd:abstract>#sim";
$regex['keywords'] = "#<gmd:keyword>\s*<gco:CharacterString>.*(%value%).*</gco:CharacterString>\s*</gmd:keyword>#sim";
$regex['topiccategories'] = "#<gmd:topicCategory>\s*<gmd:MD_TopicCategoryCode>.*(%value%).*</gmd:MD_TopicCategoryCode>\s*</gmd:topicCategory>#sim";
*/

// Xpath to filter files
$xpath['anytext'] = '//*/text()';
$xpath['title'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:citation/gmd:CI_Citation/gmd:title/gco:CharacterString/text()';
$xpath['abstract'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:abstract/gco:CharacterString/text()';
$xpath['keywords'] = '//gmd:descriptiveKeywords/gmd:MD_Keywords/gmd:keyword/gco:CharacterString/text()';
$xpath['topiccategories'] = '//gmd:identificationInfo/gmd:MD_DataIdentification/gmd:topicCategory/gmd:MD_TopicCategoryCode/text()';

?>