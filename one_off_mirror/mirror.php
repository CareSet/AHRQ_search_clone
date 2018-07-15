<?php

	//just a quick way to call a longer wget command...
	//wisdom from https://gist.github.com/dannguyen/03a10e850656577cfb57

	if(!isset($argv[1])){
		echo "Usage: php mirror.php {url_to_mirror}";
		exit();
	}

	$url = $argv[1];

	$cmd = "wget --adjust-extension --span-hosts --convert-links --backup-converted  --timestamping --page-requisites $url";

	system($cmd);


