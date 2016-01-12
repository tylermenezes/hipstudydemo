<?php
function getHipForUser($domain, $user){
	$hip = "CCCPO";
	$endpoint = "hipframe.php";
	
	$animationLength = 8000;
	$timeout = 50;
	$frameDelta = 60;
	$hipImage = "BlueE.gif";
	
	return json_encode(array("endpoint" => $endpoint, "animationLength" => $animationLength, "timeout" => $timeout, "frameDelta" => $frameDelta, "hipImage" => $hipImage, "hip" => $hip));
}
?>