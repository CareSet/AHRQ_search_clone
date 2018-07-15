<?php
	// It is not clear to me if the measures inventory and the main quality measures website are the same or different or what...
	// but the two search systems are different, the urls for the measures are formed differently.. 
	// It seems like they are two things doing the same thing... 
	// Of course, there is some difference, but I do not have time to understand precicely how they differ... 
	// today, we just need to clone.. 

	//it looks like the measures start with ids around 1000 and go to around 6000
	//but I have seen 999 return, which means that have to check the first 1000
	//so we are going to go from 1 to 1000

	$dir = 'measures_inventory';

//	chdir("./$dir");

	$start = 1;
	$end = 1010;

	for($i = $start; $i < $end ; $i++){

		$url = "https://www.qualitymeasures.ahrq.gov/hhs/content.aspx?id=$i";

		$html =file_get_contents($url);

		//but is this a valid page??
		//not if it says "The measure you are trying to view is not available."
		$bad_string = "The measure you are trying to view is not available.";
		if(strpos($html,$bad_string) !== false){
			//then do nothing...
			echo "$url has nothing \n";
		}else{
			echo "$url matches\n";
			$outfile = "$dir/measure_number_$i.html";
		
			if(!file_exists($outfile)){
				echo "Downloading $url\n";
				$cmd = "wget -O $outfile $url";
				system($cmd);
			}else{
				echo "Already downloaded \n";
			}
		}
	//too slow
	//		sleep(1); //be respectful
	}
