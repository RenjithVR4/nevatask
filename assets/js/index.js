var index = {
    init: function() {
        this.flipformEvent();
        this.validateForm();
    },
    flipformEvent: function(){
        $("#usercreateDiv").hide();

        $("#registerForm").click(function(){
            if($("#usercreateDiv:hidden")){
                $("#userloginDiv").slideToggle(1000);
                $("#usercreateDiv").slideToggle(1000);  
            }  
        });

        $("#loginForm").click(function(){
            if($("#userloginDiv:hidden")){
                $("#usercreateDiv").slideToggle(1000);
                $("#userloginDiv").slideToggle(1000); 
            }  
        });
    },
    validateForm: function() {
        var _this = this;
        var data = {};

        $("#createuserForm").submit(function(e) {

            var name = $("#userName").val();
            var email = $("#userEmail").val();
            var password = $("#userPassword").val();
            var confirmPassword = $("#confirmPassword").val();


            if (!name) {
                var msg = "Please enter Name";
                toastr.error(msg, 'Invalid Input');
                return false;
            } else {
                if ($.isNumeric(name.trim())) {
                    var msg = "Please enter valid Name";
                    toastr.error(msg, 'Invalid Input');
                    return false;
                }
            }

            if (!email) {
                var msg = "Please enter Email";
                toastr.error(msg, 'Invalid Input');
                return false;
            } else {
                if (!validateEmail(email.trim())) {
                    var msg = "Please enter valid Email";
                    toastr.error(msg, 'Invalid Input');
                    return false;
                }
            }

            if (!password) {
                var msg = "Please enter password";
                toastr.error(msg, 'Invalid Input');
                return false;
            }

            if (!confirmPassword) {
                var msg = "Please confirm password";
                toastr.error(msg, 'Invalid Input');
                return false;
            }

            if(password !== confirmPassword){
                var msg = "Please enter valid confirmation password";
                toastr.error(msg, 'Passwords are not matching!');
                return false;
            }

            if(name){
                data['name'] = name.trim();
            }

            if(email){
                data['email'] = email.trim();
            }

            if(password){
                data['password'] = password.trim();
            }

            _this.createUser(data)
            return false;
            e.preventDefault();

        });

        $("#loginuserForm").submit(function(e) {

            var email = $("#loginEmail").val();
            var password = $("#loginPassword").val();

            if (!email) {
                var msg = "Please enter Email";
                toastr.error(msg, 'Invalid Input');
                return false;
            } else {
                if (!validateEmail(email.trim())) {
                    var msg = "Please enter valid Email";
                    toastr.error(msg, 'Invalid Input');
                    return false;
                }
            }

            if (!password) {
                var msg = "Please enter password";
                toastr.error(msg, 'Invalid Input');
                return false;
            }

            if(email){
                data['email'] = email.trim();
            }

            if(password){
                data['password'] = password.trim();
            }

            _this.userLogin(data)
            return false;
            e.preventDefault();

        });

    },
    createUser: function(data) {
        var _this = this;
        showLoadingDiv();
        $.ajax({
            url: "./controllers/userController.php",
            type: "POST",
            data: data,
            success: function(data) {
                stopLoadingDiv();
                console.log(data);
                if (!data.error) {
                    var msg = "Registered the user succesfully"
                    toastr.success(msg, 'Success');
                    var delay = 1000;
                    setTimeout(function() {
                        window.location = "./";
                    }, delay);
                } else {
                    console.log(data.error);
                    toastr.error(data.error, 'Error');
                }

            },
            error: function(data) {
                stopLoadingDiv();
                if (data.status === 401) {
                    console.log(data.status);
                    toastr.warning("Session Expired", "Warning!");
                    setTimeout(function() {
                        window.location = "./";
                    }, 1000);
                }
            }
        });
    },
    userLogin: function(data) {
        showLoadingDiv()
        var _this = this;
        $.ajax({
            type: "POST",
            url: "controllers/loginController.php",
            data: data,
            success: function(data) {
                stopLoadingDiv()
                if (data.error) {
                    toastr.error(data.error, "Error");
                } else {
                    msg = "Credentials are matched"
                    toastr.success(msg, 'Success');
                    var delay = 1000;
                    setTimeout(function() {
                        window.location = "./messages.php";
                    }, delay);
                }
            },
            error: function(data) {
                stopLoadingDiv()
                console.log(data);
                toastr.error(data.statusText, "Error");
            }
        });
    },
}


$(document).ready(function() {
    index.init();
});