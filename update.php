<?php
	header("Content-Type: text/plain");
	$command="git pull";
	exec($command, $output);
	echo implode("\n", $output);
?>
