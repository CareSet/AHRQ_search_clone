<?php

	require_once('go_wayback.function.php');

	chdir('./www.qualitymeasures.ahrq.gov');

	$data = [];
	
	foreach(glob('*.html') as $file_name){
		$doc = new DOMdocument;
		//its messy html, so ignore the load errors... 
		@$doc->loadhtml(file_get_contents($file_name));
		$xpath = new DOMXPath($doc);
		

		$xpath_query = '//h3[@class="results-list-item-title"]/a';
		foreach($xpath->query($xpath_query) as $result_title_link){
			$anchor = $result_title_link->nodeValue;
			$href = $result_title_link->getAttribute('href');
			$tmp = [];
			$tmp['anchor'] = $anchor;
			$tmp['href'] = $href;
			$data[] = $tmp;
		}
	}

	//lets download the data from wayback machine..
	
	foreach($data as $i => $row){
		$results = go_wayback($row['href'],'.');
		$data[$i]['mirror_file'] = $results['saved_to_file'];
		$data[$i]['timestamp'] = $results['timestamp'];
	}

	chdir('..'); //go back to main dir

	//lets save a csv file... 

	$fp = fopen('measures_links.csv','w');
	
	fputcsv($fp,['guideline anchor', 'guideline url','mirror_file','timestamp']);

	foreach($data as $row){
		fputcsv($fp,$row);
	}




	$Measures_MD_text = "
AHRQ Measures
================
";


