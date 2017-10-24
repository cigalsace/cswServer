<?php
    
date_default_timezone_set('Europe/Paris');

function get($var, $default=False) {
    $_GET_lower = array_change_key_case($_GET, CASE_LOWER);
    $val = $default;
    if (isset($_GET_lower[$var])) {
       	$val = $_GET_lower[$var];
    }
    return $val;
}

function getFileidentifier($filename) {
    $xpath_fileidentifier = './/gmd:fileIdentifier/gco:CharacterString/text()';
    $xml = simplexml_load_file($filename);
    $namespaces = $xml->getDocNamespaces(true);
    foreach ($namespaces as $key => $value) {
        $xml->registerXPathNamespace($key, $value);
    }
    try {
        $fileidentifier = $xml->xpath($xpath_fileidentifier);
        return $fileidentifier[0];        
    } catch (Exception $e) {
        return False;
    }
}

function getFiles($path, $files = array()){
    $fileext = pathinfo($path, PATHINFO_EXTENSION);
    if ($fileext == 'xml') {
        // Check if fileIdentifier exists to know if it's a metadata XML file
        $fileIdentifier = getFileidentifier($path);
        if ($fileIdentifier) {
            // $index = count($files) + 1;
            $lstat = lstat($path);
            $file['mtime'] = date('d/m/Y H:i:s', $lstat['mtime']);
            $file['size'] = $lstat['size'];
            $file['filetype'] = filetype($path);
            $file['fileext'] = $fileext;
            $file['path'] = $path;
            $file['fileidentifier'] = $fileIdentifier;
            $files[] = $file;
        }
    }
    // if $path is a directory => call getFiles() for each item (file or directory) of $path
    if (is_dir($path)) {
        $dir = opendir($path);
        while ($child = readdir($dir)) {
            if ($child != '.' && $child != '..') {
                $files = getFiles($path.DIRECTORY_SEPARATOR.$child, $files);
            }
        }
    }
    return $files;
}

function getPageURL() {
    $pageURL = 'http';
    $requestUrl = strtok($_SERVER["REQUEST_URI"],'?');
    if (isset($_SERVER["HTTPS"]) AND ($_SERVER["HTTPS"] == "on")) {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$requestUrl;
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$requestUrl;
    }
    return $pageURL;
}

// supprimer les accents d'un chaîne
function _removeAccents($string) {
    $accents_arr = array(
        'à', 'â', 'ä', 'á', 'ã', 'å',
        'î', 'ï', 'ì', 'í', 
        'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
        'ù', 'û', 'ü', 'ú', 
        'é', 'è', 'ê', 'ë', 
        'ç', 'ÿ', 'ñ',
        'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
        'Î', 'Ï', 'Ì', 'Í', 
        'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø', 
        'Ù', 'Û', 'Ü', 'Ú', 
        'É', 'È', 'Ê', 'Ë', 
        'Ç', 'Ÿ', 'Ñ'
    );
    $noaccents_arr = array(
        'a', 'a', 'a', 'a', 'a', 'a', 
        'i', 'i', 'i', 'i', 
        'o', 'o', 'o', 'o', 'o', 'o', 
        'u', 'u', 'u', 'u', 
        'e', 'e', 'e', 'e', 
        'c', 'y', 'n', 
        'A', 'A', 'A', 'A', 'A', 'A', 
        'I', 'I', 'I', 'I', 
        'O', 'O', 'O', 'O', 'O', 'O', 
        'U', 'U', 'U', 'U', 
        'E', 'E', 'E', 'E', 
        'C', 'Y', 'N'
    );
    $string = str_replace($accents_arr, $noaccents_arr, $string);
    return $string;
}

// Use of SimpleXML to filter files
function filterFiles($files, $xpath, $value) {
    $search = explode('+', $value);
    $keep_files = array();
    foreach ($files as $file) {
        $xml_file = file_get_contents($file['path']);
        $xmlDoc = new SimpleXMLElement($xml_file);
        $namespaces = $xmlDoc->getDocNamespaces(true);
        foreach ($namespaces as $key=>$value) {
            $xmlDoc->registerXPathNamespace($key, $value);
        }
        $elts = $xmlDoc->xpath($xpath);
        $count = 0;
        foreach ($search as $s) {
            $match = false;
            foreach ($elts as $elt) {      
                // echo trim(_removeAccents($elt)) . ' - ' . trim(_removeAccents($s));
                if (stripos(trim(_removeAccents($elt)), trim(_removeAccents($s))) !== false) {
                    $match = true;
                }
            }
            if ($match) {
                $count++;
            }
        }
        if ($count == count($search)) {
            $keep_files[] = $file;
        }
    }
    return $keep_files;
}