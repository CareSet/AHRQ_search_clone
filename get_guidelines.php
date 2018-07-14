<?php


	//there are 15 pages of results, starting with #1, as long as we get 100 results at once.  

	for($page = 1; $page <= 16; $page++){

		$url = "https://www.guideline.gov/search?f_DocType=0&fLockTerm=Guideline+Summaries&page=$page&pageSize=100";
		echo "$url\n";
		
		$cmd = "wget --mirror --convert-links --adjust-extension --page-requisites --no-parent '$url'";

		system($cmd);

	}

	

