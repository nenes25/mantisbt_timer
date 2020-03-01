$(document).ready(function () {

    var timer = new easytimer.Timer();

    /**
     * Start Timer
     */
    $('#note-timer .startButton').click(function (e) {
        e.preventDefault();
        timer.start();
        return false;
    });

    /**
     * Pause Timer
     */
    $('#note-timer .pauseButton').click(function (e) {
        e.preventDefault();
        timer.pause();
        return false;
    });

    /**
     * Stop Timer : Add logged time in box
     */
    $('#note-timer .stopButton').click(function (e) {
        e.preventDefault();
        var elapsedTime = timer.getTimeValues().hours.toString().padStart(2,"0");
        elapsedTime += ':' +timer.getTimeValues().minutes.toString().padStart(2,"0");
        $('input[name="time_tracking"]').val(elapsedTime);
        timer.stop();
        return false;
    });

    /**
     * Reset Timer
     */
    $('#note-timer .resetButton').click(function (e) {
        e.preventDefault();
        timer.reset();
        return false;
    });

    /**
     * Timer events
     */
    timer.addEventListener('secondsUpdated', function (e) {
        $('#note-timer .timer').html(timer.getTimeValues().toString());
    });
    timer.addEventListener('started', function (e) {
        $('#note-timer .timer').html(timer.getTimeValues().toString());
    });
    timer.addEventListener('reset', function (e) {
        $('#note-timer .timer').html(timer.getTimeValues().toString());
    });
});