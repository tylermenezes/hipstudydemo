<?php
	$hip = $_REQUEST["hip"];
	$font = $_REQUEST["font"];
	
	foreach(str_split($hip) as $letter){
?>
		<img src="ships/<?php echo $font . "/" .  getRandomLetterImage($letter, $font) ?>" />
		<?php
	}
	
function getRandomLetterImage($letter, $font){
		$fonts = array();
	if ($handle = opendir("ships/" . $font . "/")) {
		while (false !== ($file = readdir($handle))) {
			$file_parts = explode(".", $file);
			if($letter == $file_parts[1]){
				$fonts[] = $file;
			}
		}
		closedir($handle);
	}
	return $fonts[rand(0,count($fonts)-1)];	
}
?>