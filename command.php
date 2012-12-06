<?php
	header("Content-Type: text/plain");
	$command="mysqldump -hmysql.thedox.z8.ru -udbu_thedox_9 -p69sl3ar0TNW db_thedox_18 > dump.sql";
	exec($command, $output);
	echo implode("\n", $output);
?>
