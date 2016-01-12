var startTime;
var time = 0;
var p;
var iteration = 0;

//-------------------------------------------------------------
//
// Move object
//
//-------------------------------------------------------------
function moveObj(obj) {

    obj.style.left = p[0];

    obj.style.top = p[1];

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
function interpolate(ps, pointer) {
    var a0x = ps[6] - ps[4] - ps[0] + ps[2];
    var a0y = ps[7] - ps[5] - ps[1] + ps[3];

    var a1x = ps[0] - ps[2] - a0x;
    var a1y = ps[1] - ps[3] - a0y;

    var a2x = ps[4] - ps[0];
    var a2y = ps[5] - ps[1];

    var a3x = ps[2];
    var a3y = ps[3];

    p = new Array();
    p[0] = a0x * Math.pow(pointer, 3) + a1x * Math.pow(pointer, 2) + a2x * pointer + a3x;
    p[1] = a0y * Math.pow(pointer, 3) + a1y * Math.pow(pointer, 2) + a2y * pointer + a3y;

    return p;
}

//-------------------------------------------------------------
//
// Timers
//
//-------------------------------------------------------------
function startTimer() {
    startTime = new Date();
}

function checkTimer() {
    var checkTime = new Date();

    // Compute the time for the first 10 frames
    var timer = checkTime.getTime() - startTime.getTime();
    var delta = timer - 10 * frameDelta; // if this is > 0 then too slow animation -> need to reduce timeout.

    // Update the timeout
    timeout = timeout - delta / 10;
    if (timeout < 0)
        timeout = 0;
}


//-------------------------------------------------------------
//
// Main loop
//
//-------------------------------------------------------------
function mainLoop() {
    // Update playing speed
    if (iteration == 1)
        startTimer();
    if (iteration == 11)
        checkTimer();

    // Compute the pointer
    time = time + frameDelta;
    if (time > animationLength) {
        time = time % animationLength;
        iteration = 0;
    }

    // Update the position of all the images
    var num = 0;
    for (num = 0; num < d.length; num++) {
        p = interpolate(d[num], time / animationLength);
        eval('moveObj(JS' + num + ');');
    }

    // Iterate
    iteration++;
    setTimeout("mainLoop()", timeout);
}

function showHip() {
    var div = document.createElement('div');

    for (i = 0; i < d.length; i++) {
        var image = document.createElement('img');
        image.setAttribute('id', 'JS' + i);
        image.setAttribute('style', 'position:absolute;');
        image.setAttribute('src', hipImage);
        div.appendChild(image);
    }

    var newDiv = '<div id="AnimatedHIPImage" style="position:relative;">' + div.innerHTML + '</div>';
    document.writeln(newDiv);
    mainLoop();
}