<?php


	//there are 26 pages of results, starting with #1, as long as we get 100 results at once.  

	for($page = 1; $page <= 27; $page++){

		$url = "https://www.qualitymeasures.ahrq.gov/search?f_DocType=302&fLockTerm=Measure+Summaries&page=$page&pageSize=100";
		echo "$url\n";
		
		$cmd = "wget --mirror --convert-links --adjust-extension --page-requisites --no-parent '$url'";

		system($cmd);

	}

	

