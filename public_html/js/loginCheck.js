/*===LOGIN AREA SHOW ANIMATION =====*/
setTimeout(function() {
    console.log("show");
    try {
        document.getElementById("login-area").className += " login-show";
    } catch(e) {
        console.log("No login area");
    }
}, 100)



function attempt() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.loader').addClass('show');

    $.ajax({
        url:'login',
        type:'POST',
        data: {
            name:$('#username').val(),
            password:$('#password').val(),
            _token:$('#token').val()
        },
        error: function(data) {
            console.log(data);
        },
        success: function(res) {
            console.log(res);
            $('.loader').removeClass('show');
            if(res != "true") {
                showErrorBox("Incorrect combination of username and password!<br/> Please try again.");
                setTimeout(hideErrorBox, 4000);
            } else {
                window.location.replace("dashboard")
            }
        }
    });
    return false;   
}


