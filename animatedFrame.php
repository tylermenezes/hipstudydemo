<?php
	$hip = $_REQUEST["hip"];
	$font = $_REQUEST["font"];
	$animationLength = $_REQUEST["animationLength"];
	$timeout = $_REQUEST["timeout"];
	$frameDelta = $_REQUEST["frameDelta"];
	$hipImage = $_REQUEST["hipImage"];
?>
<script type="text/javascript">
	animationLength = <?php echo $animationLength; ?>;
	timeout = <?php echo $timeout; ?>;
	frameDelta = <?php echo $frameDelta; ?>;
	hipImage = '<?php echo $hipImage; ?>';
</script>
<script src="showHIP.php?phrase=<?php echo $hip; ?>&font=<?php echo $font; ?>"></script>