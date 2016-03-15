<?php

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
    $fileidentifier = $xml->xpath($xpath_fileidentifier);
    return $fileidentifier[0];
}

function getFiles($path, $files = array()){
    $fileext = pathinfo($path, PATHINFO_EXTENSION);
    if ($fileext == 'xml') {
        $index = count($files) + 1;
        $lstat = lstat($path);
        $files[$index]['mtime'] = date('d/m/Y H:i:s', $lstat['mtime']);
        $files[$index]['size'] = $lstat[size];
        $files[$index]['filetype'] = filetype($path);
        $files[$index]['fileext'] = $fileext;
        $files[$index]['path'] = $path;
        $files[$index]['fileidentifier'] = getFileidentifier($path);
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
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

?>
