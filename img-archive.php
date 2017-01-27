<?php
$img_path = "x:/img";				// Path to Image folder
$limit_date = time() - (3600*24);	// Limit Under 24 Hour

while (true) {
	$files = scandir($img_path);
	$countOK = 0;
	$countOver = 0;
	foreach ($files as $fn) {
		if (strpos($fn, '.jpg')===false) continue;
		$a = explode('_', $fn);
		if (count($a)<1) continue;
		if (substr($a[0],0,1)!='P') continue;	// P0XX
		if (substr($a[1],0,1)!='L') continue;	// L0X
		if (substr($a[3],0,1)!='D') continue;	// D20XX
		$Ydir = substr($a[3],1);
		$Mdir = $a[4];
		$Ddir = $a[5];
		$Hdir = substr($a[6],1);
		if (! file_exists("$img_path/$Ydir")) mkdir("$img_path/$Ydir");
		if (! file_exists("$img_path/$Ydir/$Mdir")) mkdir("$img_path/$Ydir/$Mdir");
		if (! file_exists("$img_path/$Ydir/$Mdir/$Ddir")) mkdir("$img_path/$Ydir/$Mdir/$Ddir");
		if (! file_exists("$img_path/$Ydir/$Mdir/$Ddir/$Hdir")) mkdir("$img_path/$Ydir/$Mdir/$Ddir/$Hdir");
		$tm = mktime($Hdir,0,0,$Mdir,$Ddir,$Ydir);
		if ($tm < $limit_date) {
			$old_file = "$img_path/$fn";
			$new_file = "$img_path/$Ydir/$Mdir/$Ddir/$Hdir/$fn";
			echo 'Move [', $old_file, '] => [', $new_file, ']', PHP_EOL;
			rename($old_file, $new_file);
			$countOK++; 
		}
		else $countOver++;
	}
	echo 'Total File = ', count($files), PHP_EOL;
	echo 'Count OK = ', $countOK, PHP_EOL;
	echo 'Count Over = ', $countOver, PHP_EOL;

	for ($i=0; $i<30; $i++) {
		echo 'Wait next cycle ... ', $i, PHP_EOL;
		sleep(1);
	}
}
echo PHP_EOL, 'Program Terminate', PHP_EOL;
?>
