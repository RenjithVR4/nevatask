var messages = {
    init: function () {
        this.listUsers();
        this.sendMessage();
        this.listMessages();
        this.paginationEvent();
    },
    filterPage: 1,
    listUsers: function () {
        var _this = this;
        var data = {};

        showLoadingDiv();
        $.ajax({
            type: "GET",
            url: "./controllers/userController.php/listing",
            dataType: 'json',
            data: data,
            success: function (data) {
                stopLoadingDiv();
                if (!data.error) {
                    console.log(data['data']);
                    var userData = data['data'];
                    console.log(data['userdata']);
                    $("#userProfile").text(data['userdata']['name']);
                    var renderlist = '';

                    for (i in userData) {

                        renderlist += '<option value=' + userData[i].iduser + '>' + userData[i].name + '</option>'
                    }
                    console.log(renderlist);

                    $("#usersList").append(renderlist);

                } else {
                    console.log(data.error);
                }
            },
            error: function (data) {
                stopLoadingDiv();
                if (data.status === 401) {
                    toastr.warning("Session Expired", "Warning!");
                    setTimeout(function () {
                        window.location = "./";
                    }, 1000);
                } else {
                    console.log(data.error);
                }

            }
        });
    },
    sendMessage: function () {
        var data = {};
        $("#sayHi").click(function () {

            var sendmessageTo = $("#usersList").val();

            if (!sendmessageTo) {
                var msg = "Please select a user";
                toastr.error(msg, 'Invalid Input');
                return false;
            }

            if (sendmessageTo) {
                data['receivedby'] = sendmessageTo.trim();
            }

            $.ajax({
                url: "./controllers/messageController.php",
                type: "POST",
                data: data,
                success: function (data) {
                    stopLoadingDiv();
                    if (!data.error) {
                        var msg = "send message to " + sendmessageTo + " the user succesfully"
                        toastr.success(msg, 'Success');
                    } else {
                        console.log(data.error);
                        toastr.error(data.error, 'Error');
                    }

                },
                error: function (data) {
                    stopLoadingDiv();
                    if (data.status === 401) {
                        console.log(data.status);
                        toastr.warning("Session Expired", "Warning!");
                        setTimeout(function () {
                            window.location = "./";
                        }, 1000);
                    }
                }
            });
        });
    },
    listMessages: function () {
        var _this = this;
        var data = {};

        showLoadingDiv();
        $.ajax({
            type: "GET",
            url: "./controllers/messageController.php/listing",
            dataType: 'json',
            data: data,
            success: function (data) {
                stopLoadingDiv();
                if (!data.error) {
                    _this.renderMessages(data);
                } else {
                    $("#content-body").html("<tr><td colspan='11'>" + data.error + "</td></tr>");
                }
            },
            error: function (data) {
                stopLoadingDiv();
                if (data.status === 401) {
                    toastr.warning("Session Expired", "Warning!");
                    setTimeout(function () {
                        window.location = "./";
                    }, 1000);
                } else {
                    $("#content-body").html("<tr><td colspan='11'>No messages are available.</td></tr>");
                }

            }
        });
    },
    renderMessages: function (data) {
        _this = this;
        var obj = data['data'];

        console.log(obj);

        if (obj.length < 10) {
            $(".next").addClass("disabled");
            $(".prev").addClass("disabled");
        } else {
            $(".next").removeClass("disabled");
        }

        var content = "";
        var createdDate = '';

        var row = '<tr class="id">' +
            '<th class="min-width">{idmessage}</th>' +
            '<th class="min-width">{name}</th>' +
            '<td class="min-width">{createddate}</td>' +
            "</tr>";

        for (i in obj) {
            str = row;

            for (j in obj[i]) {
                thisvalue = obj[i][j];


                if (!thisvalue) {
                    thisvalue = "----";
                }

                if (thisvalue == "" || thisvalue == null) {
                    thisvalue = "----";
                }

                if (obj[i]['createddate']) {
                    createdDate = moment(obj[i]['created']).format('D-MMM-YYYY hh:mm a');
                }

                str = str.replace("{createddate}", createdDate);
                str = str.replace("{" + j + "}", thisvalue);

            }

            content += str;
        }

        $("#content-body").html(content);
    },
    paginationEvent: function () {

        _this = this;
        console.log(_this.filterPage);
        if (_this.filterPage <= 1) {
            $(".prev").addClass("disabled");
        }

        $(".prev").off("click").on("click", function () {

            _this.filterPage--;

            if (_this.filterPage <= 1) {
                $(".prev").addClass("disabled");
            }

            var filtervalue = new Object();
            filtervalue['page'] = _this.filterPage;

            _this.getmessagesPagination(filtervalue);
        });

        $(".next").off("click").on("click", function () {

            _this.filterPage++;
            if (_this.filterPage >= 1) {
                $(".prev").removeClass("disabled");
            }

            var filtervalue = new Object();
            filtervalue['page'] = _this.filterPage;

            _this.getmessagesPagination(filtervalue);
        });
    },
    getmessagesPagination: function (filterdata) {
        _this = this;

        showLoadingDiv();
        $.ajax({
            type: "GET",
            url: "./controllers/messageController.php/listing",
            data: filterdata,
            success: function (data) {
                stopLoadingDiv();
                console.log(data);
                if (!data.error) {
                    _this.renderMessages(data);
                } else {
                    $("#content-body").html("<tr><td colspan='11'>" + data.error + "</td></tr>");
                }
            },
            error: function (data) {
                stopLoadingDiv();

                if (data.status === 401) {
                    toastr.warning("Session Expired", "Warning!");
                    setTimeout(function () {
                        window.location = "./";
                    }, 1000);
                } else {
                    $("#content-body").html("<tr><td colspan='11'>No messages are available.</td></tr>");
                }
            }
        });

        return false;
    },
}

$(document).ready(function () {
    messages.init();
});