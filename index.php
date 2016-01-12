<?php
// NO U, Internet Explorer
header("Expires: Tue, 01 Jan 1980 1:00:00 GMT");
header("Pragma: no-cache");
header("E-Tag: " . time() . rand(0,10000));
require_once("auth.php");
$page = (isset($_REQUEST["page"])) ? $_REQUEST["page"] : 1;

$total_pages = 4;
$total_captchas = 0;
$total_steps = ($total_pages * 10) + $total_captchas;
$progress = ($page - 1) * 10; // This can be overridden by pages.
$btnText = "Continue";

$allow_next = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.js"></script>
		<title>HIP Study</title>
		<link rel="stylesheet" href="main.css" />
		<link rel="stylesheet" href="css/blitzer/jquery-ui-1.8.4.custom.css" />
	</head>
	<body>
		<div id="message"></div>
		<div id="canvas">
			<?php
				switch($page){
					default:
					case 1:
						$page = 1;
						require_once("intro.php");
						break;
					case 2:
						require_once("instructions.php");
						break;	
					case 3:
						require_once("study.php");
						break;
					case 4:
						require_once("questions.php");
						break;
					case 5:
						require_once("thanks.php");
						break;
				}
			?>
		</div>
		<div id="bottom">
			<div id="progress">
				<p>
					<form method="post" id="progressForm">
						<input type="hidden" name="page" value="<?php echo $page + 1 ?>" />
						<script type="text/javascript">
							document.writeln('<input type="submit" name="confirm_policy" id="nextPage" value="<?php echo $btnText; ?>" <?php global $allow_next; if(!$allow_next){ echo 'disabled="disabled"'; }?> />');
						</script>
						<noscript>
							It looks like you have Javascript turned off. You'll need to turn it on before you continue.
						</noscript>
					</form>
				</p>
				<div id="bar">
					<div id="progressbar"></div>
				</div>
			</div>
			<div id="footer">
				This survey is <strong>not</strong> anonymous. Your responses will be associated with your alias, <em><?php echo Auth::$domain . '\\' . Auth::$user?></em>, in accordance
				with our <a href="privacy.txt" onclick="$('#message').load('privacy.txt').attr('title', 'Privacy').dialog({modal:true, draggable:false, resizable:false});return false;">privacy policy</a>
				and <a href="legal.txt" onclick="$('#message').load('legal.txt').attr('title', 'Official Rules').dialog({modal:true, draggable:false, resizable:false});return false;">official rules</a>.
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#progressbar").progressbar({
					value: <?php echo 100 * ($progress / $total_steps) ?>
				});
				$("button, input:submit").button();
			});
		</script>
	</body>
</html>
