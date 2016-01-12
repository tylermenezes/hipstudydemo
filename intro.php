<h1>Microsoft HIP Study Employee Contest</h1>
<h2>Intro</h2>
<p>
	Thank you for participating in the HIP Study. This study is aimed at collecting information about how users
	perform on <acronym title="Human Interaction Proofs (aka CAPTCHAs)">HIPs</acronym> with different sets of
	paramaters.
</p>
<h2>Browser Compatibility</h2>
<p>
	This survey was tested on IE7, IE8, and Firefox 3.6; please use one of these browsers if possible. <strong>This survey
	requires Javascript enabled!</strong> You will not be able to continue without enabling it.
</p>
<p>
	If you encounter any problems, contact <a href="mailto:t-tymene">Tyler Menezes</a>.
</p>
<h2>Privacy</h2>
<p>
	<strong>This survey is not anonymous.</strong> By continuing, you agree to the following statement:
	<blockquote>
		<?php echo file_get_contents("privacy.txt"); ?>
	</blockquote>
</p>
<h2>Offical Rules</h2>
<p>
	<?php echo nl2br(file_get_contents("legal.txt")); ?>
</p>
<?php
	global $btnText;
	$btnText = "Accept and Continue";
?>