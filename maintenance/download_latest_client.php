<?php
	require_once(__DIR__ . "/../include/common.php");

	$download_page = file_get_contents("https://www.endless-online.com/downloads.html") or die("[" . date("Y-m-d H:i:s") . "] ERROR: Failed to get download page!\n");
	
	if (preg_match("/https:\/\/(www\.)?endless-online\.com\/client\/\S*\.zip/", $download_page, $matches))
	{
		$url = $matches[0];
		$download = basename($url);
		$version = rtrim($download, ".zip");
		
		if (!file_exists(__DIR__ . "/../updates/$version"))
		{
			print "[" . date("Y-m-d H:i:s") . "] Downloading new version '$version'\n";
			file_put_contents(__DIR__ . "/$download", file_get_contents($url));
			print "[" . date("Y-m-d H:i:s") . "] Extracting downloaded file $download\n";
			$zip = new ZipArchive();
			if ($res = $zip->open(__DIR__ . "/$download"))
			{
				mkdir(__DIR__ . "/../updates/$version");
				$zip->extractTo(__DIR__ . "/../updates/$version/");
				$zip->close();
				
				print "[" . date("Y-m-d H:i:s") . "] Generating hashmap for $version\n";
				// Get the file tree for the update
				$filelist = tree(__DIR__ . "/../updates/$version/", array(".", ".."));
				
				// Calculate the hashes for each file
				$hashes = array();
				foreach($filelist as $file)
					$hashes[$file] = md5_file(__DIR__ . "/../updates/$version/$file");
				
				file_put_contents(__DIR__ . "/../updates/$version.md5list", json_encode($hashes));
				
				// Update the latest.txt to point to the new version
				file_put_contents(__DIR__ . "/../updates/latest.txt", $version);
			}
			else
				print "[" . date("Y-m-d H:i:s") . "] ERROR: Failed to open downloaded file $download\n";
			
			print "[" . date("Y-m-d H:i:s") . "] Cleaning up download $download\n";
			unlink(__DIR__ . "/$download");
		}
	}
	else
		print "[" . date("Y-m-d H:i:s") . "] ERROR: Failed to find update on download page!\n";
?>
