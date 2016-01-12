<?php
global $allow_next;
$allow_next = false;
?>
<script>
	animationLength = 8000;
	timeout = 50;
	frameDelta = 60;
	hipImage = 'BlueE.gif';
	hipAnswer = '';
	endpoint = '';
</script>
<div id="timerArea" style="font-weight:bold;font-size:3em;">
	<span id="minutes"></span>:<span id="seconds"></span>
</div>
<div id="hipSolveArea" style="display:block;width:650px;margin:0 auto;text-align:center;">
	<div id="hip">
		<iframe style="border:none;width:100%" frameborder="0" id="hipFrame" src=""></iframe>
	</div>
	<div id="form">
			<input type="text" name="answerText" id="answerText" value="" autocomplete="off" style="width:100%;font-size:2em;text-align:center;text-transform:uppercase;" />
			<br /><input type="submit" name="answerButton" id="answerButton" value="Submit Answer" style="width:100%;" />
			<br /><small>If no HIP appears click Submit to continue.</small>
	</div>
</div>
<script language="JavaScript">
	function updateHip(){
		$.ajax({
					url: 'nexthip.php?domain=<?php echo Auth::$domain; ?>&user=<?php echo Auth::$user; ?>',
					success: function(data){
						var result = jQuery.parseJSON(data);
						
						animationLength = result.animationLength;
						timeout = result.timeout;
						frameDelta = result.frameDelta;
						hipImage = result.hipImage;
						endpoint = result.endpoint;
						font = result.font;
						
						hipAnswer = result.hip;

						$("#hipFrame").attr("src", endpoint + "?animationLength=" + animationLength + "&timeout=" + timeout + "&frameDelta=" + frameDelta + "&hipImage=" + hipImage + "&hip=" + hipAnswer + "&font=" + font);
					}
				});
	}
	
	donothing = false;
	
	function updateTimer(){
		var currentTime = (new Date()).getTime();
		var diff = endTime - currentTime;
		
		if(diff <= 1 || donothing){
			if(donothing){
				return;
			}
			donothing = true;
			window.onbeforeunload = null;
			$("#hipFrame").attr("src", "");
			$("#hipSolveArea").html("");
			$("#nextPage").removeAttr("aria-disabled");
			$("#nextPage").removeAttr("disabled");
			$("#progressForm").submit();
			return;
		}
		
		var minutes = parseInt(diff / (60 * 1000));
		var seconds = parseInt((diff / 1000) % 60);
		
		if(seconds.toString().length == 1){
			seconds = "0" + seconds.toString();
		}
		
		$("#timerArea #minutes").text(minutes);
		$("#timerArea #seconds").text(seconds);
	}
	
	$(function(){
		$("#answerText").keydown(function(e){
		    if (e.keyCode == 13) {
		        sendAnswer($("#answerText").val());
				$("#answerText").focus();
		    }
		});
	});

							
	$("#answerButton").click(function(){
								sendAnswer($("#answerText").val());
								return false;
							});


	function sendAnswer(userAnswer){
		$.ajax({
					type : "GET",
					url : "solvehip.php",
					data : ({
								"correct" : hipAnswer,
								"answer" : userAnswer,
								"time" : (new Date()).getTime() - startTime,
								"animationLength" : animationLength,
								"timeout" : timeout,
								"frameDelta" : frameDelta,
								"hipImage" : hipImage,
								"user" : "<?php echo Auth::$user; ?>",
								"domain" : "<?php echo Auth::$domain; ?>",
								"endpoint" : endpoint,
								"font" : font
							}),
					success : function(){
								updateHip();
								$("#answerText").val("");
								$("#answerText").focus();
							}
		});
	}
	
	function goodbye(e) {
		if(!e) e = window.event;
		if(!donothing){
			e.cancelBubble = true;
			e.returnValue = '** If you have already answered a question you will NOT be able to continue later! **';
			if (e.stopPropagation) {
				e.stopPropagation();
				e.preventDefault();
			}
		}
	}
	window.onbeforeunload=goodbye;

	
	$(document).ready(function(){
		updateHip();
		
		startTime = (new Date()).getTime();
		endTime = startTime + (10 * 60 * 1000);
		setInterval("updateTimer()", 250);
	});
</script>