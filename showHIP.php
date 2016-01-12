<?php
header("Content-type: text/javascript");
$hipID = "id" . md5(microtime() . rand(0,100000));
?>

var <?php echo $hipID?>startTime;
var <?php echo $hipID?>time = 0;
var <?php echo $hipID?>p;
var <?php echo $hipID?>iteration = 0;

// These will be set from the user
var <?php echo $hipID?>animationLength;
var <?php echo $hipID?>timeout;
var <?php echo $hipID?>frameDelta;
var <?php echo $hipID?>hipImage;

//-------------------------------------------------------------
//
// Move object
//
//-------------------------------------------------------------
function <?php echo $hipID?>moveObj(obj) {
	var IE = /*@cc_on!@*/false;
	if(IE){
	    obj.style.setAttribute("left", <?php echo $hipID?>p[0]);
	    obj.style.setAttribute("top", <?php echo $hipID?>p[1]);
		obj.style.setAttribute("position", "absolute");
	}else{
		obj.style.left = <?php echo $hipID?>p[0];
		obj.style.top = <?php echo $hipID?>p[1];
	}
}


//-------------------------------------------------------------
//
// This function interpolates a curve given 4 points
//
// Input: ps an array: { x0, y0, x1, y1, x2, y2, x3, y3 }
//        pointer, a number between 0 and 1.
//
// Output: an array of length 2: { x, y } of the computed point
//         along the curve
//
//-------------------------------------------------------------
function <?php echo $hipID?>interpolate(ps, pointer) {
    var a0x = ps[6] - ps[4] - ps[0] + ps[2];
    var a0y = ps[7] - ps[5] - ps[1] + ps[3];

    var a1x = ps[0] - ps[2] - a0x;
    var a1y = ps[1] - ps[3] - a0y;

    var a2x = ps[4] - ps[0];
    var a2y = ps[5] - ps[1];

    var a3x = ps[2];
    var a3y = ps[3];

    <?php echo $hipID?>p = new Array();
    <?php echo $hipID?>p[0] = a0x * Math.pow(pointer, 3) + a1x * Math.pow(pointer, 2) + a2x * pointer + a3x;
    <?php echo $hipID?>p[1] = a0y * Math.pow(pointer, 3) + a1y * Math.pow(pointer, 2) + a2y * pointer + a3y;

    return <?php echo $hipID?>p;
}

//-------------------------------------------------------------
//
// Timers
//
//-------------------------------------------------------------
function <?php echo $hipID?>startTimer() {
    <?php echo $hipID?>startTime = new Date();
}

function <?php echo $hipID?>checkTimer() {
    var checkTime = new Date();

    // Compute the time for the first 10 frames
    var timer = checkTime.getTime() - <?php echo $hipID?>startTime.getTime();
    var delta = timer - 10 * <?php echo $hipID?>frameDelta;

    // Update the timeout
    <?php echo $hipID?>timeout = <?php echo $hipID?>timeout - delta / 10;
    if (<?php echo $hipID?>timeout < 0)
        <?php echo $hipID?>timeout = 0;
}


//-------------------------------------------------------------
//
// Main loop
//
//-------------------------------------------------------------
function <?php echo $hipID?>mainLoop() {
    // Update playing speed
    if (<?php echo $hipID?>iteration == 1)
        <?php echo $hipID?>startTimer();
    if (<?php echo $hipID?>iteration == 11)
        <?php echo $hipID?>checkTimer();

    // Compute the pointer
    <?php echo $hipID?>time = <?php echo $hipID?>time + <?php echo $hipID?>frameDelta;
    if (<?php echo $hipID?>time > <?php echo $hipID?>animationLength) {
        <?php echo $hipID?>time = <?php echo $hipID?>time % <?php echo $hipID?>animationLength;
        <?php echo $hipID?>iteration = 0;
    }

    // Update the position of all the images
    var num = 0;
    for (num = 0; num < <?php echo $hipID?>d.length; num++) {
        <?php echo $hipID?>p = <?php echo $hipID?>interpolate(<?php echo $hipID?>d[num], <?php echo $hipID?>time / <?php echo $hipID?>animationLength);
		<?php echo $hipID?>moveObj(document.getElementById('<?php echo $hipID?>JS' + num));
    }

    // Iterate
    <?php echo $hipID?>iteration++;
    setTimeout("<?php echo $hipID?>mainLoop()", <?php echo $hipID?>timeout);
}

function <?php echo $hipID?>showHip() {
	// Assign the local ones now in case the user changes them.
	<?php echo $hipID?>animationLength = animationLength;
	<?php echo $hipID?>timeout = timeout;
	<?php echo $hipID?>frameDelta = frameDelta;
	<?php echo $hipID?>hipImage = hipImage;
	
    var div = document.createElement('div');

    for (i = 0; i < <?php echo $hipID?>d.length; i++) {
        var image = document.createElement('img');
        image.setAttribute('id',  "<?php echo $hipID?>JS" + i);
        image.setAttribute('style', 'position:absolute;');
        image.setAttribute('src', <?php echo $hipID?>hipImage);
        div.appendChild(image);
    }

    var newDiv = '<div id="AnimatedHIPImage" style="position:relative;">' + div.innerHTML + '</div>';
    document.writeln(newDiv);
    <?php echo $hipID?>mainLoop();
}

var <?php echo $hipID?>d = [
<?php
	$c = file_get_contents("hips/" . $_REQUEST["font"] . "/" . $_REQUEST["phrase"] . ".1.HIP");
	$i = 0;
	$c = str_replace("\r\n", "\n", $c);
	$s = "";
	foreach(explode("\n", $c) as $line){
		if($i++ == 0 || $line == ""){
			continue;
		}
		$s .= ",\n[$line]";
	}
	echo substr($s, 2);
?>
];

<?php echo $hipID?>showHip();