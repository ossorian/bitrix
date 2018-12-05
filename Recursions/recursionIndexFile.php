<?php
function getBranch($dir) {
	
	static $arProhibited = array('bitrix', 'upload', 'opendata');
	static $branchAmount = 0;

	if (in_array(basename($dir), $arProhibited)) return;
	$dir .= '/';
	echo ++$branchAmount.') '.$dir.'<br>'; 

	if (is_dir($dir)) {
		
		$curDir = opendir($dir);
		while (($file = readdir($curDir)) !== false) {
			if ($file=="." || $file=="..") continue;
			
			if (is_dir($dir.$file)) getBranch($dir.$file);
			elseif ($file=="index.php") echo "<i>$file</i><br>";
		}
		closedir($curDir);	
	}
}

getBranch($_SERVER["DOCUMENT_ROOT"]);
