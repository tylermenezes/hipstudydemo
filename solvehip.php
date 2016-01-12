<?php	
	$correct = $_REQUEST["correct"];
	$answer = strtoupper($_REQUEST["answer"]);
	$time = $_REQUEST["time"];
	$animationLength = $_REQUEST["animationLength"];
	$timeout = $_REQUEST["timeout"];
	$frameDelta = $_REQUEST["frameDelta"];
	$hipImage = $_REQUEST["hipImage"];
	$endpoint = $_REQUEST["endpoint"];
	$font = $_REQUEST["font"];
	
	$user = $_REQUEST["user"];
	$domain = $_REQUEST["domain"];
	
	$file = "results/$domain-$user.csv";
	
	if(!file_exists($file)){
		//touch($file);
		//file_put_contents($file, "Correct, User, Timestamp, Font, Animation Length, Timeout, Frame Delta, Image, Endpoint\n");
	}
	
	//$string = "$correct, $answer, $time, $font, $animationLength, $timeout, $frameDelta, $hipImage, $endpoint\n";
	//$fh = fopen($file, "a");
	//fwrite($fh, $string);
	//fclose($fh);
?>