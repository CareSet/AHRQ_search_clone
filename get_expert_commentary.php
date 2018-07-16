<?php


	$dir = "expert_commentary";


	//parse the following html files, looking for anchors with links
	//matching the paried text.. then download the paired text. 
	$worklist = [
		'./one_off_mirror/www.guideline.gov/expert.html' => 'expert-commentary',
		'./one_off_mirror/www.guideline.gov/syntheses/index.html' => 'synthesis',
		'./one_off_mirror/www.qualitymeasures.ahrq.gov/expert.html' => 'expert-commentary',
		];

	$data = [];
	foreach($worklist as $source_file => $filter){

		$doc = new DOMdocument;
		//its messy html, so ignore the load errors... 
//		echo "Starting download...";
		$html_text = file_get_contents($source_file);
//		echo "done. \nLoading DOM..";
		@$doc->loadhtml($html_text);
		$xpath = new DOMXPath($doc);
//		echo "done. \n";

		
		$xpath_query = '//a';
//		echo "Procesing matching anchors\n";
		foreach($xpath->query($xpath_query) as $this_link){
			$anchor = $this_link->nodeValue;
			$href = $this_link->getAttribute('href');
//			echo "found $href\n";
			if(strpos($href,$filter) !== false){
//				echo "This link matches our current filter:$filter!! so we are going to mirror it!!\n";
				$tmp = [];
				$tmp['anchor'] = $anchor;
				$tmp['href'] = $href;
				$data[] = $tmp;
			}
		}

	}

	chdir("./$dir");
	foreach($data as $i => $row){
		$href = $row['href']; //now I have href..

		$parsed = parse_url($href);
		$domain_name = $parsed['host'];
		$pathinfo = pathinfo($parsed['path']);
		$dirname = $pathinfo['dirname'];
		$basename = $pathinfo['basename'];
        	$out_file_name = substr($basename,0,245); //file names can be too long..
		$file_to_test = "./$domain_name/$dirname/$out_file_name.html";
		
		
		echo "Looking for $file_to_test\n";

		if(!file_exists($file_to_test)){
			echo "Missing file\n";

			$cmd = "wget -O $file_to_test --span-hosts  --backup-converted  --timestamping --page-requisites $href";
			system($cmd);
			echo "
###########################################################################################################
###########################################################################################################
FINISHED $href
###########################################################################################################
###########################################################################################################
\n\n";


		}else{
			echo "Got file $file_to_test... moving right along...\n";
		}

	}



