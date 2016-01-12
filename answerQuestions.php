<?php
	$results = $_REQUEST;
	$user = $results["username"];
	$domain = $results["domain"];
	unset($results["username"]);
	unset($results["domain"]);
	
	$h = "";
	$o = "";
	foreach($results as $question=>$result){
		$h .= "$question,";
		$o .= "$result,";
	}
	
	$file = "results/questions-$domain-$user.csv";
	
	if(!file_exists($file)){
		touch($file);
	}
	file_put_contents($file, $h . "\n" . $o);
	print_r($_REQUEST);
?>