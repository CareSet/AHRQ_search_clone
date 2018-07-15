<?php


/*
	This is a generic function to download data from the wayback machine...
	First you start with some urls that hopefully might have been backed up..
	Then we will check to see if there are actually saved copies in 
	wayback machine and then try and download the latest copy..

*/

if(get_included_files()[0] == __FILE__){


	$test_urls = [
		'https://www.guideline.gov/summaries/summary/51178/cataracts-in-adults-management',
	];

	go_wayback($test_urls, './tmp');

}





function go_wayback($file_links = null,$save_to_dir = null){

	if(is_null($file_links) || is_null($save_to_dir)){ 
		echo "Error: I really need a list of zip code urls and a place where to save the archives on the local disk";
		exit();

	}


	$arrayOfLines = [];
	foreach($file_links as $this_file_link){
		$this_file_link_encoded = urlencode($this_file_link);
		$archive_list = "http://web.archive.org/cdx/search/cdx?url=$this_file_link_encoded";

		$str = file_get_contents($archive_list);

	//from: http://stackoverflow.com/a/28725803/144364
		$this_arrayOfLines = explode("\n",
                	    str_replace(array("\r\n","\n\r","\r"),"\n",$str)
            	);

		$arrayOfLines = array_merge($arrayOfLines, $this_arrayOfLines);

	}

	$last_timestamp = 0;

	$total_to_do = count($arrayOfLines);
	$i = 0;
	foreach($arrayOfLines as $file_string){
		if(strlen($file_string) == 0){
			continue;
		}
		$i++;
		$string_array = explode(' ',$file_string);

		//get the data points we need from the string array...
		$timestamp = $string_array[1];
		if($timestamp > $last_timestamp){
			//we only care if this is an html file...
			if($string_array[3] == 'text/html'){
				//then our assumption is wrong, this is a zip file
				$lastest_line = $file_string;
				$last_timestamp = $timestamp;
			}
		}
	}

	$string_array = explode(' ',$lastest_line);
	
	$file_url = $string_array[2];



	//and finally use the timestamp and the file_url to calculate the download url for the file on archive.org
	$download_url = "https://web.archive.org/web/$timestamp/$file_url";

	$get_file = true;

      	//use native php functions to calculate the file name from the file_url
       	//this lets us future proof...
      	$path = parse_url($file_url, PHP_URL_PATH);
      	$path_parts = pathinfo($path);
       	$file_name = $path_parts['basename'];
	$save_to_file = $save_to_dir . '/' . $file_name;

		
	if(file_exists($save_to_file)){
		//why would we download it again?
		echo "We already have $save_to_file\n";
		$get_file = false;

		if(filesize($save_to_file) == 0){
			//then the download failed last time..
			$get_file = true;
			echo "But it is zero length... downloading again\n";
		}

	}



	if($get_file){
		$wget_command = "wget -O $save_to_file $download_url";
		
		echo "getting\n $download_url\n to\n $save_to_file\n";
		exec($wget_command);


		$left = $total_to_do - $i;
		echo "done. $left left..\n";
		//be respectful to the api...
		sleep(1);
	}


}//end function


