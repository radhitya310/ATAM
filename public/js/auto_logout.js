// untuk auto logout
$(document).ready(function () {
    // const timeout = 900000;  // 900000 ms = 15 minutes
    const timeout = 5000;
    var idleTimer = null;
    $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
        clearTimeout(idleTimer);

        idleTimer = setTimeout(function () {
            document.getElementById('logoutClick').click();
        }, timeout);
    });
    $("body").trigger("mousemove");
});
