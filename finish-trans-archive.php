<?php
//$folder = '"d:/ETC TransGuru/MatrixSwitchClientV2.Packet.Finish-Transaction"';	// Path to Transaction Folder
$folder = 'd:\\ETC\ TransGuru\\MatrixSwitchClientV2.Packet.Finish-Transaction';
$limit_date = time() - (3600*1);	// Limit Under 24 Hour

while (true) {
	$files = scandir($folder);
	$countOK = 0;
	$countOver = 0;
	foreach ($files as $fn) {
		if (strpos($fn, '-')===false) continue;
		$a = explode('-', $fn);
		if (count($a)<4) continue;
		if (substr($a[3],0,1)!='E') continue;	// E[X/E]0[4/5]
		$Ydir = substr($a[0],4);
		$Mdir = substr($a[0],4,2);
		$Ddir = substr($a[0],6,2);
		$Hdir = substr($a[1],0,2);
		if (! file_exists("$folder/$Ydir")) mkdir("$folder/$Ydir");
		if (! file_exists("$folder/$Ydir/$Mdir")) mkdir("$folder/$Ydir/$Mdir");
		if (! file_exists("$folder/$Ydir/$Mdir/$Ddir")) mkdir("$folder/$Ydir/$Mdir/$Ddir");
		if (! file_exists("$folder/$Ydir/$Mdir/$Ddir/$Hdir")) mkdir("$folder/$Ydir/$Mdir/$Ddir/$Hdir");
		$tm = mktime($Hdir,0,0,$Mdir,$Ddir,$Ydir);
		if ($tm < $limit_date) {
			$old_file = "$folder/$fn";
			$new_file = "$folder/$Ydir/$Mdir/$Ddir/$Hdir/$fn";
			echo 'Move [', $old_file, '] => [', $new_file, ']', PHP_EOL;
			//rename($old_file, $new_file);
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
