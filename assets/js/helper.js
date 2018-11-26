

function validateEmail(email) {
    var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    return emailRegex.test(email);
}

function validateUrl(url) 
{
    var urlRegex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
    return urlRegex.test(url);
}

function hasNumber(String) {
  return /\d/.test(String);
}

function getFormObj(formid) {
    formdata = $("#" + formid).serializeArray();

    obj = new Object();
    for (i in formdata) {
        if (formdata[i].value !== "") {
            obj[formdata[i].name] = formdata[i].value;
        }
    }

    return obj;
}

function showLoadingDiv() {

    $(".modal-backdrop.loading.normal").remove();
    var html = "<div class=\"modal-backdrop loading normal\" style=\"position:fixed;z-index:3060;height:100%;top:0px;left:0px;bottom:0px;right:0px\"><span style='z-index:10;position:absolute;top:35%;left:45%;text-align;center'>\
    <h2 style='color:#fff;font-size:17px;margin:0px;line-height:0px'>\
    <img src=''/></h2></span></div>";
    $("body").append(html);
}

function stopLoadingDiv() {
    $(".loading.normal").remove();
}

function userLogout() {
    var thispath = document.location.pathname;
    thispath = thispath.substring(0, thispath.lastIndexOf("/"));
    thispath = thispath.substring(0, thispath.lastIndexOf("/"));
    console.log(thispath);

    showLoadingDiv();
    $.ajax({
        type: "GET",
        url: "controllers/logoutController.php",
        success: function(data) {
            window.location = './';
        },
        error: function(data) {
            console.log(data);
            window.location = './';
        }

    });
}


