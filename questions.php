<?php
	global $allow_next, $page;
	$allow_next = true;
	$page = 4;
?>
<?php if(!file_exists("results/" . Auth::$domain . "-" . Auth::$user . ".csv")){ ?>
	<h1>You didn't answer any questions!</h1>
	<p>You can't take the survey until you answer at least one HIP. <a href="">Click here to restart the survey.</a></p>
<?php }else{ ?>
<p>
	Please complete the following quick survey to complete the study and qualify for the Kinect bundle. The last question is optional.
</p>
	<form>
		<h2>Knowing that it significantly improves on the security of your online accounts, if you had the same success rate would you continue signing up for an account when presented with an Animated HIP for:</h2>
			<?php drawChoiceTable("q1", array("Yes", "Not Sure", "No", "I would not sign up regardless"), array("Bank Account", "Email Account", "Ebay Account", "App Store")); ?>
		<h2>Any other comments regarding the Animated HIPs?</h2>
			<textarea name="q2_comments" id="q2_comments" cols="100" rows="10"></textarea>
	</form>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#nextPage").click(function(){
			checkedBoxes = new Object();
			$(".choice").each(function(){
				if(checkedBoxes[$(this).attr("name")] == null){
					checkedBoxes[$(this).attr("name")] = false;
				}
				if($(this).attr("type") == "radio" && $(this).attr("checked")){
					checkedBoxes[$(this).attr("name")] = $(this).attr("value");
				}else if($(this).attr("type") == "text" && $(this).attr("value") != "" && $(this).attr("value")){
					checkedBoxes[$(this).attr("name")] = $(this).attr("value");
				}
			});
			for(var b in checkedBoxes){
				if(checkedBoxes[b] == false){
					alert("You did not answer all questions.");
					return false;
				}
			}
			
			checkedBoxes["q2_comments"] = $("#q2_comments").val();
			
			$.ajax({
					type : "GET",
					url : "answerQuestions.php?username=<?php echo Auth::$user; ?>&domain=<?php echo Auth::$domain;?>",
					data : checkedBoxes,
					success : function(){
						$("#progressForm").submit();
					}
			});
			return false;
		});
	});
</script>
<?php
function drawChoiceTable($namespace, $choices, $types){
	?>
	<table class="survey-question" id="<?php echo $namespace?>">
		<thead>
			<tr class="mainhead">
				<th>&nbsp;</th>
				<?php foreach($choices as $choice){ ?>
					<th><?php echo $choice; ?></th>	
				<?php } ?>
			</tr>
		</thead>
		<?php foreach($types as $type){ ?>
			<tr>
				<th scope="row" class="rowhead"><?php echo $type; ?></th>
				<?php foreach($choices as $choice){?>
					<td><input class="choice" type="radio" name="<?php echo $namespace . "_" . $type; ?>" value="<?php echo $choice; ?>" /></td>
				<?php } ?>
			</tr>
		<?php } ?>
	</table>
	<?php
}
?>