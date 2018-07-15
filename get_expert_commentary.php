<?php


	$dir = "expert_commentary";

	chdir("./$dir");


	$expert_comments_page = "https://www.qualitymeasures.ahrq.gov/expert";

	$doc = new DOMdocument;
	//its messy html, so ignore the load errors... 
	@$doc->loadhtml(file_get_contents($expert_comments_page));
	$xpath = new DOMXPath($doc);


	$data = [];
		
	$xpath_query = '//a';
	echo "Procesing matching anchors\n";
	foreach($xpath->query($xpath_query) as $this_link){
		$anchor = $this_link->nodeValue;
		$href = $this_link->getAttribute('href');
		echo "found $href\n";
		if(strpos($href,'expert-commentary') !== false){
			$tmp = [];
			$tmp['anchor'] = $anchor;
			$tmp['href'] = $href;
			$data[] = $tmp;
		}
	}

	//lets download the data from wayback machine..
	
	foreach($data as $i => $row){
	}



