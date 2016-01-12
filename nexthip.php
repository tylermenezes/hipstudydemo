<?php
	// NO U, Internet Explorer
	header("Expires: Tue, 01 Jan 1980 1:00:00 GMT");
	header("Pragma: no-cache");
	header("E-Tag: " . time() . rand(0,10000));
	
	$user = $_GET["user"];
	$domain = $_GET["domain"];
	
	$endpoints = array("animatedFrame.php");
	
	$endpoint = $endpoints[rand(0,count($endpoints)-1)];
	
	$animationLength	= 8000;
	$timeout			= 50;
	$frameDelta			= 60;
	$hipImage			= "BlueE.gif";
	
	$fonts = array("Arial", "Consolas", "Times New Roman");
	$font = $fonts[rand(0,count($fonts)-1)];
	
	if($endpoint == "animatedFrame.php"){
		if ($handle = opendir("hips/" . $font . "/")) {
			while (false !== ($file = readdir($handle))) {
				$file_parts = explode(".", $file);
				$hips[] = $file_parts[0];
			}
			closedir($handle);
		}
		
		$hip = $hips[rand(0, count($hips)-1)];
	}else{
		if($endpoint == "staticFrame.php"){
			file_put_contents("data/$domain-$user-count-static.txt", ++$noStatic);
		}else{
			file_put_contents("data/$domain-$user-count-attacked.txt", ++$noAttacked);
		}
		$hip = "";
		$characters = array("A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z");
		for($i = 0; $i < 5; ++$i){
			$hip .= $characters[rand(0, count($characters)-1)];
		}
	}
	
	echo json_encode(array("endpoint" => $endpoint, "animationLength" => $animationLength, "timeout" => $timeout, "frameDelta" => $frameDelta, "hipImage" => $hipImage, "hip" => $hip, "font" => $font));
?>