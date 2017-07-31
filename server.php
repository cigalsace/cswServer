<?php
// Get "request" parameter from URL
$request = strtolower(get('request'));

if ($request == 'getrecords') {
    // Get files from $csw_path
	$files = getFiles($csw_path);

    // Filter files list according to $constraintKeywords if defined
    foreach ($constraints as $key => $constraint) {
        $type = strtolower($key);
        $files = filterFiles($files, $xpath[$type], $constraint);
    }
    
	// Get "constraint" parameter from URL
	// Format: "constraint=anyText+LIKE+'%ortho%'&"
	$constraint = get('constraint');

    // Get XML file content and filter with constraint search value if necessary
	if ($constraint) {
        // Clean constraint parameter and get search value
		// preg_match("#.*(AnyText|Title|Abstract|Subject|Modified|Identifier).*'%(.*)%'#i", $constraint, $matches);
		preg_match("#.*(AnyText|Title|Abstract|Subject|Modified|Identifier).*'\*(.*)\*'#i", $constraint, $matches);
        $type = strtolower($matches[1]);
        $files = filterFiles($files, $xpath[$type], $matches[2]);
	}

	$numberOfRecordsMatched = count($files);   

	// Get "maxrecords" parameter from URL
	$maxrecords = get('maxrecords');

	// Get "startposition" parameter from URL
	$startposition = get('startposition') - 1;
	
    
	// Nb results
	$nb_results = count($files) - $startposition;
	if ($nb_results > $maxrecords) {
		$nb_results = $maxrecords;
	}

	$nextRecord = $startposition + $nb_results + 1;
    if ($nextRecord > $numberOfRecordsMatched) {
        $nextRecord = $numberOfRecordsMatched+1;
    }

	// Get XML files content
	$xml_content = '';
	// for ($i = $startposition; $i < $startposition+$maxrecords; $i++) {
	for ($i = $startposition; $i < $nb_results; $i++) {
        if ($i < count($files) and is_file($files[$i]['path'])) {
		    $xml_file = file($files[$i]['path']);
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

	// header('Content-Type: application/xml; charset=utf-8');
	echo $xml;
	
} elseif ($request == 'getrecordbyid') {
    // Get files from $csw_path
	$files = getFiles($csw_path);
	// $nb_files = count($files);
    
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
	echo '"Request" parameter is wrong or missing ("getrecords", "getrecordbyid", "getcapabilities" or "describerecord").';
	
}