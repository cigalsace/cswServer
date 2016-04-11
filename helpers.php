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
    $requestUrl = strtok($_SERVER["REQUEST_URI"],'?');
    if ($_SERVER["HTTPS"] == "on") {
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
        foreach ($elts as $elt) {
            foreach ($search as $s) {
                if (stripos($elt, $s) !== false) {
                    $count++;
                }
            }
        }
        if ($count == count($search)) {
            $keep_files[] = $file;
        }
    }
    return $keep_files;
}

?>
