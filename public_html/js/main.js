
$('.search-unit').on('click', function() {
    $(this).parent().toggleClass("open");
});


function showErrorBox(msg) {
    $('.error-box').html(msg);
    $('.error-box').addClass("show");
    setTimeout(hideErrorBox, 5000);
}
function hideErrorBox() {
    $('.error-box').removeClass("show");
}

function showWarningBox(msg) {
    $('.warning-box').html(msg);
    $('.warning-box').addClass("show");
    setTimeout(hideWarningBox, 5000);
}
function hideWarningBox() {
    $('.warning-box').removeClass("show");
}

function showSuccessBox(msg) {
    $('.success-box').html(msg);
    $('.success-box').addClass("show");
    setTimeout(hideSuccessBox, 5000);
}
function hideSuccessBox() {
    $('.success-box').removeClass("show");
}

function showInformationBox(msg) {
    $('.information-box').html(msg);
    $('.information-box').addClass("show");
    setTimeout(hideInformationBox, 5000);
}
function hideInformationBox() {
    $('.information-box').removeClass("show");
}





/*Class box text adjustment*/

function resizeText() {
    $('.class-box').each(function() {
        var classBox = $(this);
        var className = $(this).find('.class-name');

        className.css('fontSize', '16px');
        while(className.innerHeight() > classBox.innerHeight() || className.innerWidth() > classBox.innerWidth()-30) {
            className.css('fontSize', '-=1');
        }

    });
}
resizeText();
window.onresize = resizeText;