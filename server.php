<?php
// Get "request" parameter from URL
$request = strtolower(get('request'));

if ($request == 'getrecords') {
    // Get files from $csw_path
	$files = getFiles($csw_path);
	$nb_files = count($files);
	
	// Get "constraint" parameter from URL
	// Format: "constraint=anyText+LIKE+'%ortho%'&"
	$constraint = get('constraint');
    
    // Clean constraint parameter to get search value
    $search = '';
	if ($constraint) {
		preg_match("#.*'%(.*)%'#i", $constraint, $matches);
		$search = explode('+', $matches[1]);
	}

    // Get XML file content and filter with constraint search value if necessary
	$keep_files = $files;
	if ($constraint) {
        $keep_files = array();
	    foreach ($files as $file) {
		    $xml_file = strip_tags(file_get_contents($file['path']));
		    $xml_file = file_get_contents($file['path']);
		    echo $xml_file;
		    $count = 0;
		    foreach ($search as $s) {
		        $s = trim($s);
			    if (stripos($xml_file, $s)) {
			        $count++;
			    }
			}
			if ($count == count($search)) {
			    $keep_files[] = $file;
			}
		}
	}
	$numberOfRecordsMatched = count($keep_files);

	// Get "maxrecords" parameter from URL
	$maxrecords = get('maxrecords');

	// Get "startposition" parameter from URL
	$startposition = get('startposition') - 1;
	
	// Nb results
	$nb_results = count($keep_files) - $startposition;
	if ($nb_results > $maxrecords) {
		$nb_results = $maxrecords;
	}
	
	//$nextRecord = $startposition + $maxrecords + 1;
	$nextRecord = $startposition + $nb_results + 1;
	if ($nextRecord = 1) {
	    $nextRecord = 0;
	}

	// Get XML files content
	$xml_content = '';
	for ($i = $startposition; $i < $startposition+$maxrecords; $i++) {
	        if (is_file($keep_files[$i]['path'])) {
		    $xml_file = file($keep_files[$i]['path']);
		    unset($xml_file[0]);
		    $xml = implode("\n", $xml_file);
		    $xml_content .= $xml;
		}
	}

	// Get timestamp
	$timestamp = date(DATE_ISO8601);

	$xml = '';
	$xml .= '<csw:GetRecordsResponse xmlns:csw="http://www.opengis.net/cat/csw/2.0.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.opengis.net/cat/csw/2.0.2 http://schemas.opengis.net/csw/2.0.2/CSW-discovery.xsd">';
	$xml .= '<csw:SearchStatus timestamp="'.$timestamp.'"/>';
	$xml .= '<csw:SearchResults numberOfRecordsMatched="'.$numberOfRecordsMatched.'" numberOfRecordsReturned="'.$nb_results.'" elementSet="full" nextRecord="'.$nextRecord.'">';
	$xml .= $xml_content;
	$xml .= '</csw:SearchResults>';
	$xml .= '</csw:GetRecordsResponse>';

	header('Content-Type: application/xml; charset=utf-8');
	echo $xml;
	
} elseif ($request == 'getrecordbyid') {
    // Get files from $csw_path
	$files = getFiles($csw_path);
	$nb_files = count($files);
    
    // Get "id" parameter from URL
	$id = get('id');
	
	$file_error = True;
	foreach ($files as $file) {
	    if ($file['fileidentifier'] == $id) {
	        $file_error = False;
	        $xml_file = file($file['path']);
	        unset($xml_file[0]);
    		$xml_content = implode('', $xml_file);
    		$xml = '';
		    $xml .= '<csw:GetRecordByIdResponse xmlns:csw="http://www.opengis.net/cat/csw/2.0.2">';
		    $xml .= $xml_content;
		    $xml .= '</csw:GetRecordByIdResponse>';
		    
		    header('Content-Type: application/xml; charset=utf-8');
    		echo $xml;
	    }
	}
	if ($file_error) {
	    echo 'File '.$id.' note found.';
	}

} elseif ($request == 'getcapabilities') {
    // Include getcapabilities.php file (config in file directely)
    include_once('getcapabilities.php');
    header('Content-Type: application/xml; charset=utf-8');
    echo $getcapabilities_xml;
    
} elseif ($request == 'describerecord') {
    // Include describerecord.php file (config in file directely)
    include_once('describerecord.php');
    header('Content-Type: application/xml; charset=utf-8');
    echo $describerecord_xml;

} else {
	// Prameter "request" not exist
	echo '"Request" parameter is wrong or missing ("getrecords", "getrecordbyid", "getcapabilities" or "describerecord".';
	
}

?>
