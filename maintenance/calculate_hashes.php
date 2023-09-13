<?php
	if ($argc != 2)
		die("USAGE: calculate_hashes.php VERSION\n");
	
	require_once(__DIR__ . "/../include/common.php");

	$ver = $argv[1];
	
	// Calculate hashes for all files if we specify ALL, otherwise just the update provided
	if ($ver == "ALL")
	{
		$updates = array_filter(glob(__DIR__ . "/../updates/*"), "is_dir");
		$check = array();
		foreach($updates as $update)
			$check[] = basename($update);
	}
	else
		$check = array($ver);
	
	foreach($check as $version)
	{
		// Sanity check to make sure the version exists
		if (file_exists(__DIR__ . "/../updates/$version"))
		{
			// Get the file tree for the update
			$filelist = tree(__DIR__ . "/../updates/$version/", array(".", ".."));
			
			// Calculate the hashes for each file
			$hashes = array();
			foreach($filelist as $file)
				$hashes[$file] = md5_file(__DIR__ . "/../updates/$version/$file");
			
			file_put_contents(__DIR__ . "/../updates/$version.md5list", json_encode($hashes));
		}
		else
			die("Could not find version $version");
	}
?>