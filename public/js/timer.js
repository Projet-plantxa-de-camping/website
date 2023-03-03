function updateTimer(deadline) {
    var time = deadline - new Date();
    return {
        hours: Math.floor(time / (1000 * 60 * 60)),
        minutes: Math.floor((time / 1000 / 60) % 60),
        seconds: Math.floor((time / 1000) % 60),
        total: time,
    };
}

function animateClock(span) {
    span.className = "turn";
    setTimeout(function () {
        span.className = "";
    }, 1000);
}

function startTimer(id, deadline) {
    var timerInterval = setInterval(function () {
        var clock = document.getElementById(id);
        var timer = updateTimer(deadline);

        clock.innerHTML =
            '<span>' +
            timer.hours +
            '</span><span>' +
            timer.minutes +
            '</span><span>' +
            timer.seconds +
            '</span>';


        // Checks for end time. Displays '0 0 0 0'
        if (timer.total < 1) {
            clearInterval(timerInterval);
            clock.innerHTML = '<span>0</span><span>0</span><span>0</span>';
        }
    }, 1000);
}

window.onload = function () {
    var deadline = new Date("February 25, 2023 15:49:59");
    startTimer("clock", deadline);
};
