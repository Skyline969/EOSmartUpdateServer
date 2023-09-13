<?php
	function tree($path, $exclude = array())
	{
		$files = array();
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $splfileinfo)
			if (!in_array(basename($splfileinfo), $exclude))
				$files[] = str_replace($path, '', '' . $splfileinfo);
		return $files;
	}
?>