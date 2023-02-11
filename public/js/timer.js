function updateTimer(deadline){
    var time = deadline - new Date();
    return{
        'hours': Math.floor( time/(1000*60*60) % 24 ),
        'minutes': Math.floor( time/(1000/60) % 60 ),
        'seconds': Math.floor( time/(1000) % 60 ),
        'total': time
    };
}

function animateClock(span){
    span.className  = 'turn';
    setTimeout(function(){
        span.className = '';

    }, 1000);
}

function startTimer(id, deadline){
    var timerInterval = setInterval(function(){
        var clock = document.getElementById(id);
        var timer = updateTimer(deadline);

        clock.innerHTML = '</span>'
            + '<span>' + timer.hours + '</span>'
            + '<span>' + timer.minutes + '</span>'
            + '<span>' + timer.seconds + '</span>';

        //animations
        var spans = clock.getElementsByTagName("span");
        animateClock(spans[3]);
        if(timer.seconds == 59) animateClock(spans[2]);
        if(timer.minutes == 59 && timer.seconds == 59) animateClock(spans[1]);
        if(timer.hours == 23 && timer.minutes == 59 && timer.seconds == 59) animateClock(spans[0]);


        // Checks for end time. Displays '0 0 0 0'
        if(timer.total < 1){
            clearInterval(timerInterval);
            clock.innerHTML = '<span>0</span><span>0</span><span>0</span>   ';
        }

    }, 1000);
}

window.onload = function(){
    var deadline = new Date("February 10, 2023 23:59:59");
    startTimer('clock', deadline);
}
