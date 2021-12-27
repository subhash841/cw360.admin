/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var base_url = $('body').attr('data-base_url');
showToast = function (msg, status) {
    if (status == '1') {
        $("#response_message").html('<div class="btn-lg bg-green">' + msg + '</div>').fadeIn(2000).delay(1000).fadeOut(2000);
    } else {
        $("#response_message").html('<div class="btn-lg bg-red">' + msg + '</div>').fadeIn(2000).delay(1000).fadeOut(2000);
    }
};

//common ajax call
function ajax_call(url, method, data, cb) {
    $.ajax({
        url: url,
        method: method,
        data: data
    }).done(function (result) {
        cb(result);
    });
}
//Multipart form submit
function ajax_call_multipart(url, method, param, cb) {
    $.ajax({
        url: url,
        method: method,
        data: param,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (result) {
        cb(result);
    });
}

//convert date digits into 2 digit
function changeDMS(dms) {
    return (dms < 10) ? '0' + dms : dms; //prepending 0 if date,minutes & seconds less than 10
}

//Date Format conversion
function convertDate(input) {
    var d = new Date(input);
    if (d == "Invalid Date" || input == null) {
        return "-";
    }

    var date = [changeDMS(d.getDate()), changeDMS(d.getMonth() + 1), d.getFullYear()].join('-');
    return date;
}

//Replace BR(<br />) tag to blank
function br2nl(string) {
    var regex = /<br\s*[\/]?>/gi;
    return string.replace(regex, "");
}

$(function () {
    // focus input elements after modal shown
    $("#stockModal").on("shown.bs.modal", function (event) {
        $("#stockModal input[type='text']").focus();
    });

    // Add update Stock modal
    $("#stockModal").on("show.bs.modal", function (event) {
        var base = "#stockModal ";
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");

        if (id == "0") {
            $(base + "[name='stock_name']").val('');
            $(base + "[name='stock_code']").val('');
        } else {
            var data = relatedTarget.attr("data-editjson");
            data = JSON.parse(data);
            var id = data.id;
            var name = data.name;
            var code = data.code;

            $(base + "[name='stockid']").val(id);
            $(base + "[name='stock_name']").val(name);
            $(base + "[name='stock_code']").val(code);
        }
    });

    //Add update stock master form
    $('form[name="addUpdateStock"]').on('submit', function (event) {
        event.preventDefault();
        var formdata = $(this).serialize();
        ajax_call(base_url + 'Stock/add_update_stock', 'POST', formdata, function (result) {
            result = JSON.parse(result);
            if (result.status) {
                showToast(result.message, "1");
                $('#stockModal [data-dismiss="modal"]').trigger('click');
                setTimeout(function () {
                    window.location.assign('stock_list');
                }, 2000);
            } else {
                showToast(result.message, "0");
            }
        });
    });

    //Add update stock period
    $('form[name="addUpdateStockPeriod"]').on('submit', function (event) {
        event.preventDefault();

        var stockgrp = $('#optgroup').val();
        if (stockgrp == null) {
            showToast("Please select stocks", '0');
        } else {
            var formdata = $(this).serialize();
            ajax_call(base_url + 'Stock/add_update_stock_period', 'POST', formdata, function (result) {
                result = JSON.parse(result);
                if (result['status']) {
                    showToast(result['message'], '1');
                } else {
                    showToast(result['message'], '0');
                }
            });
        }
    });
    //Add update Election period
    $('form[name="addUpdateElectionPeriod"]').on('submit', function (event) {
        event.preventDefault();
        if ($(this).valid()) {
            var partiesgrp = $('#optgroup').val();
            if (partiesgrp == null) {
                showToast("Please select stocks", '0');
            } else if (partiesgrp.length < 2) {
                showToast("Add more parties", '0');
            } else {
                var formdata = $(this).serialize();
                ajax_call(base_url + 'Election/addUpdateElectionPeriod', 'POST', formdata, function (result) {
                    result = JSON.parse(result);
                    if (result['status']) {
                        showToast(result['message'], '1');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000)
                    } else {
                        showToast(result['message'], '0');
                    }
                });
            }
        }

    });
//    $('form[name="deleteForecastByMax"]').on('submit', function (event) {
//        event.preventDefault();
//        if ($(this).valid()) {
//            var formdata = $(this).serialize();
//            ajax_call(base_url + 'Dashboard/deleteForecastByMax', 'POST', formdata, function (result) {
//                result = JSON.parse(result);
////                if (result['status']) {
////                    showToast(result['message'], '1');
////                    setTimeout(function () {
////                        window.location.reload();
////                    }, 2000)
////                } else {
////                    showToast(result['message'], '0');
////                }
//            });
//        }
//    });
    // make expert on Define expert page
    $(document).on('change', ".make-expert", function (e) {
        var _this = $(this);
        var userid = _this.val();
        var isexpert = _this.attr("data-isexpert");
        var param = {userid: userid, isexpert: isexpert};

        ajax_call(base_url + 'Stock/make_expert', "POST", param, function (response) {
            response = JSON.parse(response);

            $('.check' + userid).attr('data-isexpert', response.data.is_expert);
            if (response.data.is_expert == "1") {
                $('.check' + userid).prop("checked", true);
            } else {
                $('.check' + userid).prop("checked", false);
            }
        });
    });

    //show perticilar User's stock forecast details in popup
    $("#userStockForecastDetail").on("show.bs.modal", function (event) {
        var related = $(event.relatedTarget);
        var userid = related.attr("data-userid");
        var html = '';
        var rows = '';

        var param = {userid: userid};
        ajax_call(base_url + 'Stock/getUserStockForecastDetail', "POST", param, function (response) {
            response = JSON.parse(response);
            $("#userStockForecastDetail span.username").html(response[0].name + "'s");
            var isexpert_checked = (response[0].is_expert == "1") ? 'checked="checked"' : '';

            var is_expert = '<div class="">\
                                <input type="checkbox" id="' + userid + 'i" class="filled-in make-expert check' + userid + '" data-isexpert="' + response[0].is_expert + '" ' + isexpert_checked + ' value="' + userid + '">\
                                <label for="' + userid + 'i">Expert</label>\
                            </div>';
            for (var i in response) {
                rows += '<tr>\
                            <td>' + response[i].stock_name + '</td>\
                            <td>' + response[i].weekly_forecast + '</td>\
                            <td>' + response[i].monthly_forecast + '</td>\
                            <td>' + response[i].yearly_forecast + '</td>\
                        </tr>';
            }
            html += '<table class="table">\
                        <thead>\
                            <tr>\
                                <th>Stock</th>\
                                <th>Weekly Forecast</th>\
                                <th>Monthly Forecast</th>\
                                <th>Yearly Forecast</th>\
                            </tr>\
                        </thead>\
                        <tbody>' + rows + '</tbody>\
                        </table>';

            html += is_expert;
            $("#userStockForecastDetail .modal-body").html(html);
        });
    });

    //Start Stop Stock Forecasting
    $("#start_stop_stock_forecasting").on("show.bs.modal", function (event) {
        var base = "#start_stop_stock_forecasting ";
        var display_msg = "";
        var display_title = "";

        var related = $(event.relatedTarget);
        var is_result_out = related.attr("data-result");
        var stock_period_id = related.attr("data-stock_period_id");
        var result_type = related.attr("data-result_type");

        if (result_type == "stopweekly") {
            display_msg = "Are you sure you want to stop weekly forecasting?";
            display_title = "Stop forecast confirmation";
        }
        if (result_type == "stopmonthly") {
            display_msg = "Are you sure you want to stop monthly forecasting?";
            display_title = "Stop forecast confirmation";
        }
        if (result_type == "stopyearly") {
            display_msg = "Are you sure you want to stop Yearly forecasting?";
            display_title = "Stop forecast confirmation";
        }

//        if (is_result_out == "0") {
//            display_msg = "Are you sure you want to stop forecasting?";
//            display_title = "Stop forecast confirmation";
//        }
//        else {
//            display_msg = "Are you sure you want to start forecasting?";
//            display_title = "Start forecast confirmation";
//        }

        $(base + ".modal-title").html(display_title);
        $(base + ".modal-body .message").html(display_msg);
        $(base + ".modal-body #stock_period_id").val(stock_period_id);
        $(base + ".modal-body #is_result_out").val(is_result_out);
        $(base + ".modal-body #result_type").val(result_type);
    });

    $("#update_stock_endon_date").on("shown.bs.modal", function (event) {
        $("input").focus();
    });
    //Start Stop Stock Forecasting
    $("#update_stock_endon_date").on("show.bs.modal", function (event) {
        var base = "#update_stock_endon_date ";

        var related = $(event.relatedTarget);
        var weekly_end_date = related.attr("data-weekly_end_date");
        var monthly_end_date = related.attr("data-monthly_end_date");
        var yearly_end_date = related.attr("data-yearly_end_date");
        var stock_period_id = related.attr("data-stock_period_id");

        $(base + ".modal-body #weekly_end_date").val(weekly_end_date);
        $(base + ".modal-body #monthly_end_date").val(monthly_end_date);
        $(base + ".modal-body #yearly_end_date").val(yearly_end_date);
        $(base + ".modal-body #endon_date_stock_period_id").val(stock_period_id);
    });

    //Add update stock period
//    $('form[name="frm_update_stock_endon_date"]').on('submit', function (event) {
//        var weekly_end_date = $("#weekly_end_date").val();
//        var monthly_end_date = $("#monthly_end_date").val();
//        var yearly_end_date = $("#yearly_end_date").val();
//
//        if (weekly_end_date == "") {
//            showToast("Please enter weekly end date", '0');
//            return false;
//        }
//        if (monthly_end_date == "") {
//            showToast("Please enter monthly end date", '0');
//            return false;
//        }
//        if (yearly_end_date == "") {
//            showToast("Please enter Yearly end date", '0');
//            return false;
//        }
//    });

    $("#blogModal").on("shown.bs.modal", function (event) {
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");
        if (id != "0") {
            $("input").focus();
            $("textarea").focus();
        } else {
            $("input").blur();
            $("textarea").blur();
        }
    });
    // Show Add update Blog modal
    $("#blogModal").on("show.bs.modal", function (event) {
        var base = "#blogModal ";
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");

        if (id == "0") {
            $(base + "[name='blog_title']").val('');
            $(base + "[name='blog_description']").val('');
            $(base + "[name='blog_date']").val('');
            $(base + "[name='blog_img']").val('');
            //$(base + "[name='blog_date']").val('');
            //blog_category
            $("select[name='blog_category']").prop("selectedIndex", 0);
            $('select[name="blog_category"]').selectpicker('refresh');
            $("select[name='blog_subcategory']").prop("selectedIndex", 0);
            $('select[name="blog_subcategory"]').selectpicker('refresh');
            //$("#blog_desc_editor").Editor("setText", "");
        } else {
            var data = relatedTarget.attr("data-editjson");
            data = JSON.parse(data);
            var id = data.id;
            var title = data.title;
            //var description = data.description;
            var description = relatedTarget.attr("data-html");
            var blog_date = convertDate(data.blog_date);
            var blog_img = data.image;
            var category = data.category_id;
            var sub_category = data.sub_category_id;
            $(base + "[name='blogid']").val(id);
            $(base + "[name='blog_title']").val(title);
            //  $("#blog_desc_editor").Editor("setText", br2nl(description))
            $(base + "[name='blog_date']").val(blog_date);
            //$(base + "[name='blog_img']").val(blog_img);
            $(base + "[name='blog_img']").removeAttr('required');
            $(base + "select[name='blog_category']").val(category);
            $(base + 'select[name="blog_subcategory"]').val(sub_category);
            $('select[name="blog_category"]').selectpicker('refresh');
            $('select[name="blog_subcategory"]').selectpicker('refresh');
        }
    });

    var clkBtn = "";
    $('form[name="addUpdateBlog"] [type="submit"]').click(function (evt) {
        clkBtn = $(this);
    });


    //Add update stock period


    $('form[name="addUpdateBlog"]').on('submit', function (event) {
        event.preventDefault();
        var formdata = new FormData(this);
        var _this = $(this);
        $('input,button', _this).attr('disabled', 'disabled');
        if (validateform("addUpdateBlog")) {
            //console.log($('#blog_description').val());
            var editortext = CKEDITOR.instances["blog_desc_editor"].getData();
            editortext = htmlspecialchars(editortext);
            formdata.append('blog_description', editortext);
            ajax_call_multipart(base_url + 'Blogs/add_update_blog', 'POST', formdata, function (result) {
                result = JSON.parse(result);

                if (result['status']) {
                    showToast(result['message'], '1');
                    $('#blogModal [data-dismiss="modal"]').trigger('click');

                    if (clkBtn.hasClass('approveblog'))
                        approveblog($("input[name='blogid']", _this).val(), function () {
                            setTimeout(function () {
                                window.location.assign('index');
                            }, 2000);
                        });
                    else if (clkBtn.hasClass('rejectblog'))
                        rejectblog($("input[name='blogid']", _this).val(), function () {
                            setTimeout(function () {
                                window.location.assign('index');
                            }, 2000);
                        });
                    else
                        setTimeout(function () {
                            window.location.assign('index');

                        }, 2000);

                } else {

                    $('input,button', _this).removeAttr('disabled');
                    showToast(result['message'], '0');
                }
            });
        } else {
            $('input,button', _this).removeAttr('disabled');
        }

    });

    //show perticilar User's stock forecast details in popup
    $("#userBlogDetail").on("show.bs.modal", function (event) {
        var related = $(event.relatedTarget);
        var base = "#userBlogDetail ";

        var json = related.attr("data-json");
        var data = JSON.parse(json);
        var blogtitle = data.title;
        var description = related.attr("data-html");
        var blogdesc = description;
        var blogdate = convertDate(data.blog_date);
        var blogcreated = convertDate(data.created_date);

        $(base + ".blogtitle").html(blogtitle);
        $(base + ".blogdesc").html(blogdesc);
        $(base + ".blogdate").html(blogdate);
        $(base + ".blogcreated").html(blogcreated);
    });

    /****************************Blog Category***************************/

    //shown Blog Category Modal
    $("#categoryModal").on("shown.bs.modal", function (event) {
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");
        if (id != "0") {
            $("input").focus();
        } else {
            $("input").blur();
        }
    });

    // Show Add update Blog Category modal
    $("#categoryModal").on("show.bs.modal", function (event) {
        var base = "#categoryModal ";
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");

        if (id == "0") {
            $(base + "[name='category_name']").val('');
        } else {
            var data = relatedTarget.attr("data-editjson");
            data = JSON.parse(data);
            var id = data.id;
            var name = data.name;

            $(base + "[name='categoryid']").val(id);
            $(base + "[name='category_name']").val(name);
        }
    });

    //Add update Category period
    $('form[name="addUpdateBlogCategory"]').on('submit', function (event) {
        event.preventDefault();

        var param = $(this).serialize();
        //console.log(param);
        ajax_call(base_url + 'Blogs/addUpdateBlogCategory', "POST", param, function (result) {
            console.log(result);
            result = JSON.parse(result);
            if (result['status']) {
                showToast(result['message'], '1');
                $('#categoryModal [data-dismiss="modal"]').trigger('click');
                setTimeout(function () {
                    window.location.assign('category');
                }, 2000);
            } else {
                showToast(result['message'], '0');
            }
        });
    });
    /****************************Blog Category***************************/
    //shown Blog sub Category Modal
    $("#subCategoryModal").on("shown.bs.modal", function (event) {
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");
        if (id != "0") {
            $("input").focus();
        } else {
            $("input").blur();
        }
    });

    // Show Add update Blog Category modal
    $("#subCategoryModal").on("show.bs.modal", function (event) {
        var base = "#subCategoryModal ";
        var relatedTarget = $(event.relatedTarget);
        var id = relatedTarget.attr("data-id");

        if (id == "0") {
            $(base + "[name='sub_category_name']").val('');
        } else {
            var data = relatedTarget.attr("data-editjson");
            data = JSON.parse(data);
            var id = data.id;
            var name = data.name;
            var category = data.category_id;

            $(base + "[name='subcategoryid']").val(id);
            $(base + "[name='sub_category_name']").val(name);


            $(base + 'select[name="category_id"]').val(category);

            $(base + 'select[name="category_id"]').selectpicker('refresh');

        }
    });

    //Add update Category period
    $('form[name="addUpdateBlogSubCategory"]').on('submit', function (event) {
        event.preventDefault();

        var param = $(this).serialize();
        //console.log(param);
        ajax_call(base_url + 'Blogs/addUpdateBlogSubCategory', "POST", param, function (result) {
            console.log(result);
            result = JSON.parse(result);
            if (result['status']) {
                showToast(result['message'], '1');
                $('#categoryModal [data-dismiss="modal"]').trigger('click');
                setTimeout(function () {
                    window.location.assign('subcategory');
                }, 2000);
            } else {
                showToast(result['message'], '0');
            }
        });
    });

    //Active - Inactive Polls
    $(document).on('change', '.changeactivepoll', function (e) {

        var poll_id = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        var status = $(this).attr('data-status');
        if (type != "") {

            var param = {poll_id: poll_id, type: type, current: status};
            console.log(param);
            ajax_call(base_url + 'Poll/active_inactive_poll', "POST", param, function (result) {
                console.log(result);
                result = JSON.parse(result);
                if (result['status']) {
                    showToast(result['message'], '1');
                    setTimeout(function () {
                        window.location.assign("lists");
                    }, 2000);
                } else {
                    showToast(result['message'], '0');
                    setTimeout(function () {
                        window.location.assign("lists");
                    }, 2000);
                }
            });
        }
    });

    $(document).on('change', '.changeactive', function (e) {

        var id = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        var status = $(this).attr('data-status');
        if (type != "") {
            if (type == "subcategory") {
                var redirectto = base_url + "Blogs/subcategory";
            } else {
                var redirectto = base_url + "Blogs";
            }
            var param = {id: id, type: type, current: status};
            ajax_call(base_url + 'Blogs/changeActive', "POST", param, function (result) {

                result = JSON.parse(result);
                if (result['status']) {
                    showToast(result['message'], '1');
                    setTimeout(function () {
                        window.location.assign(redirectto);
                    }, 2000);
                } else {
                    showToast(result['message'], '0');
                    setTimeout(function () {
                        window.location.assign(redirectto);
                    }, 2000);
                }
            });
        }

    });


    function approveblog(e, f) {
        var param = {id: e};
        ajax_call(base_url + 'Blogs/approveblog', "POST", param, function (result) {
            result = JSON.parse(result);
            if (result['status']) {
                f();
            }
        });
    }

    function rejectblog(e, f) {
        var param = {id: e};
        ajax_call(base_url + 'Blogs/rejectblog', "POST", param, function (result) {

            result = JSON.parse(result);
            if (result['status']) {
                showToast(result['message'], '1');
                f();
            }
        });


    }

    $(document).on('keypress', '.blog_order', function (e) {
        var order = $(this).val();
        if ((e.which < 48 || e.which > 57)) {
            e.preventDefault();
        }

        if (e.keyCode == 13) {
            if (order == "") {
                showToast("Please enter blog sequence order", '0');
            }
            var id = $(this).attr('data-id');
            var param = {id: id, order: order};
            ajax_call(base_url + 'Blogs/checkBlogOrderExist', "POST", param, function (result) {
                result = JSON.parse(result);
                if (result['status']) {
                    var result1 = confirm(result['message']);
                    if (result1) {
                        ajax_call(base_url + 'Blogs/changeOrder', "POST", param, function (orderresult) {
                            orderresult = JSON.parse(orderresult);
                            if (orderresult['status']) {
                                showToast(orderresult['message'], '1');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                showToast(orderresult['message'], '0');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            }
                        });
                    }
                } else {
                    showToast(result['message'], '0');
                }
            });
        }
    });

    $('select[name="blog_category"]').on('change', function (e) {
        var currentcat = $(this).val();
        $("select[name='blog_subcategory'] option[data-catid=" + currentcat + "]").css('display', 'block');
        $("select[name='blog_subcategory'] option[data-catid != " + currentcat + "]").css('display', 'none');
        $("select[name='blog_subcategory'] option[value='']").css('display', 'block');
        $("select[name='blog_subcategory']").prop("selectedIndex", 0);
        $('select[name="blog_subcategory"]').selectpicker('refresh');

    });
    /****************************Blog Sub Category end***********************/

    function validateform(type) {
        var isValid = true;
        if (type == "addUpdateBlog") {

            var editortext = CKEDITOR.instances["blog_desc_editor"].getData();
            //$('#blog_description').val(editortext);
            //alert(editortext);
            var forname = "form[name=" + type + "]"
            if ($(forname + ' select[name="blog_category"]').val() == "") {
                isValid = false;
            }
            if ($(forname + ' input[name="blog_title"]').val() == "") {
                isValid = false;
            } else {
                var title = $(forname + ' input[name="blog_title"]').val();
                title = custom_stringify(title);
                $(forname + ' input[name="blog_title"]').val(title);
            }
            if (editortext == "") {
                isValid = false;
                $('#blog_description-error').css('display', 'block');
            } else {
                $('#blog_description-error').css('display', 'none');


                //$('#blog_description').val(editortext);
                //$(forname + ' textarea[name="blog_description"]').val(editortext);
            }
            if ($(forname + ' input[name="blog_date"]').val() == "") {
                isValid = false;
            }
            if ($(forname + ' select[name="blog_subcategory"]').val() == "") {
                isValid = false;
            }
            if ($(forname + ' select[name="blog_img"]').val() == "") {
                isValid = false;
            }
            if ($(forname + ' select[name="blog_type"]').val() == "") {
                isValid = false;
            }
            if ($(forname + ' select[name="meta_keywords"]').val() == "") {
                isValid = false;
            }
            if ($(forname + ' select[name="meta_description"]').val() == "") {
                isValid = false;
            }
//            if ($(forname + ' input[name="blog_img"]').val() == "") {
//                isValid = false;
//            }
        }

        return isValid;
    }

    //show perticilar User's stock forecast details in popup
    $("#viewPollDetails").on("show.bs.modal", function (event) {
        var related = $(event.relatedTarget);
        var pollid = related.attr("data-id");

        var html = '';
        var rows = '';
        var name = '';
        var choices = '';

        var param = {pollid: pollid};
        ajax_call(base_url + 'Poll/poll_detail', "POST", param, function (response) {
            response = JSON.parse(response);

            name = (response.raised_by_admin == "1") ? "Admin" : response.user;

            if (response.is_approved == "0" && response.is_rejected == "0") {
                $("button.btn-approve").show();
                $("button.btn-reject").show();
            } else if (response.is_approved == "1" || response.is_rejected == "1") {
                $("button.btn-approve").hide();
                $("button.btn-reject").hide();
            } else {
                $("button.btn-approve").show();
                $("button.btn-reject").show();
            }

            for (var i in response.choices) {
                choices += response.choices[i].choice + ", ";
            }

            html = '<div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Created By</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="username">' + name + '</span>\
                    </div>\
                    <div class="col-sm-3">\
                        <strong>Category</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="poll_cat">' + response.category + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Poll</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="poll_title">' + linkify(response.poll) + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Description</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="poll_desc">' + linkify(response.description) + '</span>\
                        ' + decodeHTMLEntities(response.preview) + '\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Choices</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="poll_choices">' + choices + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Total Votes</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="poll_total_votes">' + response.total_votes + '</span>\
                    </div>\
                    <div class="col-sm-3">\
                        <strong>Total Comments</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="poll_total_comments">' + response.total_comments + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Approved By</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="poll_total_comments">-</span>\
                    </div>\
                </div>';
            $("#viewPollDetails .modal-body").html(html);
            $("#viewPollDetails button.btn-approve").attr("data-poll_id", response.id);
        });
    });

    //Approve poll
    $("#viewPollDetails button.btn-approve").on('click', function (e) {
        e.preventDefault();
        var poll_id = $(this).attr("data-poll_id");

        var param = {poll_id: poll_id};
        ajax_call(base_url + 'Poll/approve_poll', "POST", param, function (response) {
            response = JSON.parse(response);

            if (response.status) {
                $('#viewPollDetails button[data-dismiss="modal"]').trigger('click');
                window.location.reload();
            }
        });
    });

    /*-------------Banned Words START------------------*/

    //click to update banned words
    $("#editwords").on("click", function (e) {
        e.preventDefault();
        $(".update-words").removeClass('hide');

        var data = $(this).attr("data-editjson");
        data = JSON.parse(data);
        $("#word_id").val(data.id);
        $("#words").focus();
        $("#words").val(data.keywords);
    });

    //update banned words
    $("#addeditwords").on("submit", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        ajax_call(base_url + "BannedWords/add_update_banned_words", "POST", data, function (response) {
            response = JSON.parse(response);
            if (response.status) {
                showToast(response.message, '1');
                setTimeout(function () {
                    window.location.assign('BannedWords');
                }, 1000);
            } else {

            }
        });
    });
    /*-------------Banned Words END------------------*/
});


function custom_stringify(string) {
    string = JSON.stringify(string);
    string = string.replace(new RegExp("'", 'g'), "&#39;");
    return string.replace(new RegExp('"', 'g'), "");
}

function htmlspecialchars(str) {
    if (typeof (str) == "string") {
        //str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
        //str = str.replace(/"/g, "&quot;");
        str = str.replace(/'/g, "&#039;");
        //str = str.replace(/</g, "&lt;");
        //str = str.replace(/>/g, "&gt;");
    }
    return str;
}

//$(document).ready( function() {
//$("#blog_desc_editor").Editor();                    
//});

/*--------------Delete Forecast Reason-----------------*/

$("#deleteReasonModal").on("shown.bs.modal", function (event) {
    var base = "#deleteReasonModal";
    var relatedTarget = $(event.relatedTarget);
    var id = relatedTarget.attr("data-id");
    $(base + " [name='forecastreasonid']").val(id);
});

$('form[name="deleteforecastreason"]').on('submit', function (event) {
    event.preventDefault();
    var page = $('#forecasttype').val();
    if (page == "Karnataka") {
        var url = 'Karnataka/Forecast/deleteforecastreason';
    } else if (page == "Gujrat") {
        var url = 'Gujrat/Forecast/deleteforecastreason';
    } else {
        var url = "";
    }

    if (url != "") {
        var param = $(this).serialize();
        //console.log(param);
        ajax_call(base_url + url, "POST", param, function (result) {
            console.log(result);
            result = JSON.parse(result);
            if (result['status']) {
                showToast(result['message'], '1');
                $('#deleteReasonModal [data-dismiss="modal"]').trigger('click');
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                showToast(result['message'], '0');
            }
        });
    }

});
/*--------------End Forecast Reason-----------------*/
/*--------------State -----------------*/
$("#stateModal").on("show.bs.modal", function (event) {

    var base = "#stateModal ";
    var relatedTarget = $(event.relatedTarget);
    var id = relatedTarget.attr("data-id");

    if (id == "0") {
        $('#defaultModalLabel').html('ADD');
        $(base + "[name='stateid']").val("0");
        $(base + "[name='state_name']").val('');
    } else {
        $('#defaultModalLabel').html('EDIT');
        var data = relatedTarget.attr("data-editjson");
        data = JSON.parse(data);
        var id = data.id;
        var name = data.name;

        $(base + "[name='stateid']").val(id);
        $(base + "[name='state_name']").val(name);
    }
});

$("#stateModal").on("shown.bs.modal", function (event) {
    var relatedTarget = $(event.relatedTarget);
    var id = relatedTarget.attr("data-id");
    if (id != "0") {
        $("input").focus();
    } else {
        $("input").blur();
    }
});

$('form[name="addUpdateState"]').on('submit', function (event) {
    event.preventDefault();

    var param = $(this).serialize();
    //console.log(param);
    ajax_call(base_url + 'Master/addUpdateState', "POST", param, function (result) {
        console.log(result);
        result = JSON.parse(result);
        if (result['status']) {
            showToast(result['message'], '1');
            $('#stateModal [data-dismiss="modal"]').trigger('click');
            setTimeout(function () {
                window.location.assign('states');
            }, 2000);
        } else {
            showToast(result['message'], '0');
        }
    });
});
/*--------------End State---------------*/
/*--------------Party-------------------*/
$('form[name="addeditparty"]').on('submit', function (event) {
    event.preventDefault();

    //var param = $(this).serialize();
    var formdata = new FormData(this);
    //console.log(param);
    ajax_call_multipart(base_url + 'Master/addUpdateParty', "POST", formdata, function (result) {
        console.log(result);
        result = JSON.parse(result);
        if (result['status']) {
            showToast(result['message'], '1');
            //$('#stateModal [data-dismiss="modal"]').trigger('click');
            setTimeout(function () {
                window.location.assign('parties');
            }, 2000);
        } else {
            showToast(result['message'], '0');
        }
    });
});
$(document).on('click', '#editparty', function (e) {
    var json = JSON.parse($(this).attr('data-editjson'));
    var base = 'addeditparty';
    var party_id = json.id;
    $('input[name=party_id]').val(json.id)
    $('input[name=party_name]').val(json.name)
    $('input[name=party_abbr]').val(json.abbreviation)
    $('input').focus();
    $('#imgPrime').attr('src', base_url + '../webportal/images/party_logos/' + json.icon);
    //$('#imgPrime').attr('src',base_url+'..images/party_logos/'+json.icon);// for live
    $('#imgPrime').css('display', 'block');
    $('#removethumb').css('display', 'block');
})

$(document).on('click', '.clearbtn', function (e) {
    $('input').blur();
})
/*-------------End Party----------------*/

/*-------------Survey ------------------*/
$(document).on('change', '.changeactivesurvey', function (e) {

    var survey_id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var status = $(this).attr('data-status');
    if (type != "") {

        var param = {survey_id: survey_id, type: type, current: status};
        console.log(param);
        ajax_call(base_url + 'Survey/active_inactive_survey', "POST", param, function (result) {
            console.log(result);
            result = JSON.parse(result);
            if (result['status']) {
                showToast(result['message'], '1');
                setTimeout(function () {
                    window.location.assign("lists");
                }, 2000);
            } else {
                showToast(result['message'], '0');
                setTimeout(function () {
                    window.location.assign("lists");
                }, 2000);
            }
        });
    }
});
$("#viewSurveyDetails").on("show.bs.modal", function (event) {
    var related = $(event.relatedTarget);
    var surveyid = related.attr("data-id");

    var html = '';
    var rows = '';
    var name = '';
    var choices = '';

    var param = {surveyid: surveyid};
    ajax_call(base_url + 'Survey/survey_detail', "POST", param, function (response) {
        response = JSON.parse(response);

        name = (response.raised_by_admin == "1") ? "Admin" : response.user;

        if (response.is_approved == "0" && response.is_rejected == "0") {
            $("button.btn-approve").show();
            $("button.btn-reject").show();
        } else if (response.is_approved == "1" || response.is_rejected == "1") {
            $("button.btn-approve").hide();
            $("button.btn-reject").hide();
        } else {
            $("button.btn-approve").show();
            $("button.btn-reject").show();
        }

        for (var i in response.choices) {
            choices += response.choices[i].choice + ", ";
        }

        html = '<div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Created By</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="username">' + name + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Survey</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="survey_title">' + linkify(response.question) + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Description</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="survey_desc">' + linkify(response.description) + '</span>\
                        ' + decodeHTMLEntities(response.preview) + '\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Choices</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="survey_choices">' + choices + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Total Votes</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="survey_total_votes">' + response.total_votes + '</span>\
                    </div>\
                    <div class="col-sm-3">\
                        <strong>Total Comments</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="survey_total_comments">' + response.total_comments + '</span>\
                    </div>\
                </div>';
        $("#viewSurveyDetails .modal-body").html(html);
        $("#viewSurveyDetails button.btn-approve").attr("data-survey_id", response.id);
    });
});
/*-----------End Survey-----------------*/
/*-------------Article ------------------*/
$(document).on('change', '.changeactivearticle', function (e) {

    var article_id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var status = $(this).attr('data-status');
    if (type != "") {

        var param = {article_id: article_id, type: type, current: status};
        console.log(param);
        ajax_call(base_url + 'RatedArticle/active_inactive_article', "POST", param, function (result) {
            console.log(result);
            result = JSON.parse(result);
            if (result['status']) {
                showToast(result['message'], '1');
                setTimeout(function () {
                    window.location.assign("lists");
                }, 2000);
            } else {
                showToast(result['message'], '0');
                setTimeout(function () {
                    window.location.assign("lists");
                }, 2000);
            }
        });
    }
});
$("#viewArticleDetails").on("show.bs.modal", function (event) {
    var related = $(event.relatedTarget);
    var articleid = related.attr("data-id");

    var html = '';
    var rows = '';
    var name = '';
    var choices = '';

    var param = {articleid: articleid};
    ajax_call(base_url + 'RatedArticle/article_detail', "POST", param, function (response) {
        response = JSON.parse(response);

        name = (response.raised_by_admin == "1") ? "Admin" : response.user;

        if (response.is_approved == "0" && response.is_rejected == "0") {
            $("button.btn-approve").show();
            $("button.btn-reject").show();
        } else if (response.is_approved == "1" || response.is_rejected == "1") {
            $("button.btn-approve").hide();
            $("button.btn-reject").hide();
        } else {
            $("button.btn-approve").show();
            $("button.btn-reject").show();
        }

        for (var i in response.choices) {
            choices += response.choices[i].choice + ", ";
        }

        html = '<div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Created By</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="username">' + name + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Article</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="article_title">' + linkify(response.question) + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Description</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="article_desc">' + linkify(response.description) + '</span>\
                        ' + decodeHTMLEntities(response.preview) + '\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Choices</strong>\
                    </div>\
                    <div class="col-sm-9">\
                        <span class="article_choices">' + choices + '</span>\
                    </div>\
                </div>\
                <div class="row m-b-15">\
                    <div class="col-sm-3">\
                        <strong>Total Votes</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="article_total_votes">' + response.total_votes + '</span>\
                    </div>\
                    <div class="col-sm-3">\
                        <strong>Total Comments</strong>\
                    </div>\
                    <div class="col-sm-3">\
                        <span class="article_total_comments">' + response.total_comments + '</span>\
                    </div>\
                </div>';
        $("#viewArticleDetails .modal-body").html(html);
        $("#viewArticleDetails button.btn-approve").attr("data-article_id", response.id);
    });
});
/*-----------End Survey-----------------*/

/*------------Uncommment this for Preview Functionality --------------------*/
$(document).bind("paste", "#preview", function (e) {
    //$('.linkpreview').remove();

    var pastedData = e.originalEvent.clipboardData.getData('text');
    //getpreview(pastedData);
    var linkpreviewcount = $('.linkpreview').length;
    if (linkpreviewcount == 0) {
        var urls = findUrls(pastedData);

        if (urls != null && urls != "null") {
            console.log(urls.length);
            getpreview(urls[0]);
//                for (var i = 0; i < parseInt(urls.length);i++) {
//                    var linkpreviewcount= $('.linkpreview').length;
//                    getpreview(urls[i]);
//                }
        }
        setTimeout(function () {
            var target = $('#preview').val();
            $('#preview').attr('data-oldtext', target);
        }, 100);
    }

});
$(document).on('keyup', '#preview', function (e)
{
    var target = $(this).val();
    if (target == "") {
        $('.linkpreview').remove();
        $(this).attr('data-oldtext', '');
        $('#previewdata').val('');
    } else {
        var urls = findUrls(target);
        if (urls != null && urls != "null") {
            var linkpreviewcount = $('.linkpreview').length;
            if (parseInt(linkpreviewcount) > parseInt(urls.length)) {
                $('.linkpreview:last').remove();
                $('#previewdata').val('');
            }
        }
    }
});
$(document).on('keypress', '#preview', function (e)
{
    var linkpreviewcount = $('.linkpreview').length;
    if (linkpreviewcount == 0) {
        if (e.which == 32 || e.which == 13) {
            var target = $(this).val();
            var oldtext = $(this).attr('data-oldtext');
            $(this).attr('data-oldtext', target);
            console.log(target);
            console.log(oldtext);
            if (oldtext != "") {
                target = target.replace(oldtext, '');
                console.log(target);
            }
            var urls = findUrls(target);
            console.log(urls);
            if (urls != null && urls != "null") {
                getpreview(urls[0]);
                //$('.linkpreview').remove();
                //for (var i = 0; i < parseInt(urls.length);i++) {
                //getpreview(urls[i]);
                //}
                //$(this).attr('data-oldtext',target);
            }
        }
    }
});

function getpreview(target) {
    console.log(target);
    $.ajax({
        url: base_url + 'Common/getmetatags',
        method: "POST",
        data: {url: target},
    }).done(function (result) {
        result = JSON.parse(result);
        console.log(result);
        if (result['status']) {
            //$('.linkpreview').remove();
            var url = result['data']['url'];
            var title = result['data']['title'];
            var image = result['data']['image'];
            var description = result['data']['description'];

            var html = '<div class="linkpreview">\
                                    <div class="row">\
                                        <div class="col m4 s12">\
                                            <div class="previewimg">\
                                            <img src="' + image + '" class="linkpreviewimg"/></div>\
                                        </div>\
                                        <div class="col m8 s12">\
                                            <div class="previewtext">\
                                                <h3 class="fs14px lightgray">' + title + '</h3>\
                                                <h5 class="fs12px lightgray">' + description + '</h5>\
                                                <a class="fs12px" target="_blank" href=http://' + url + '>' + url + '</a>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>';
            $('#preview').parent().parent().append(html);
            $('#previewdata').val(html);
        }
    });
    return true;
}



function findUrls(text) {
    //urls = text.match(/(\b(?:(?:https?|ftp|file|[A-Za-z]+):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$]))/i);
    urls = text.match(/(https?:\/\/[^\s]+)/g);
    return urls;
}

function decodeHTMLEntities(text) {
    var entities = [
        ['amp', '&'],
        ['apos', '\''],
        ['#x27', '\''],
        ['#x2F', '/'],
        ['#39', '\''],
        ['#47', '/'],
        ['lt', '<'],
        ['gt', '>'],
        ['nbsp', ' '],
        ['quot', '"']
    ];

    for (var i = 0, max = entities.length; i < max; ++i)
        text = text.replace(new RegExp('&' + entities[i][0] + ';', 'g'), entities[i][1]);

    return text;
}
/*------------Uncommment this for Preview Functionality till this--------------------*/
/*-------------------Linkify urls------------------*/
function linkify(inputText) {
    var replacedText, replacePattern1, replacePattern2, replacePattern3;

    //URLs starting with http://, https://, or ftp://
    replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');

    //Change email addresses to mailto:: links.
    replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
    replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1">$1</a>');

    return replacedText;
}
/*-------------------Linkify urls------------------*/