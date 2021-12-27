<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Topics List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#topicModal" data-id="0">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Topic</th>
                                        <th class="text-center" width="100">Date</th>
                                        <th class="text-center notexport">Image</th>
                                        <th class="text-center notexport">Icon</th>
                                        <th class="text-center notexport">Action</th>
                                        <th class="text-center notexport">Trending</th>
                                        <th class="text-center notexport">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($topics as $key => $list ):
                                            $num = $key + 1;
                                            $newvalue = $list[ 'is_active' ] == 1 ? "checked" : "";
                                            $istrending = $list[ 'is_trending' ] == 1 ? "checked" : "";
                                            $list=str_replace(array( '\'' ), "&#8217;", $list);
                                            echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list[ 'categoryname' ] . '</td>
                                                <td>' . $list[ 'topic' ] . '</td>
                                                <td class="text-center">' . $list[ 'created_date' ] . '</td>
                                                <td class="text-center">
                                                        <div class="" style="height:68px; background:url(' . $list[ 'image' ] . ') center center no-repeat;background-size:contain;"></div>
                                                </td>
                                                <td class="text-center">
                                                        <div class="" style="height:68px; background:url(' . $list[ 'icon' ] . ') center center no-repeat;background-size:contain;"></div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#topicModal" data-id="' . $list[ 'id' ] . '" data-editjson=\'' . json_encode($list) . '\' ><i class="material-icons">&#xE254;</i></a>&nbsp;&nbsp;
                                                </td>
                                                <td>
                                                    <a class="switch changeTrendingTopic" data-id="' . $list[ 'id' ] . '" data-type="topics" data-status=' . $list[ 'is_trending' ] . '>
                                                        <label><input type="checkbox" ' . $istrending . '><span class="lever switch-col-bluenew"></span></label>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="switch changeActiveTopic" data-id="' . $list[ 'id' ] . '" data-type="topics" data-status=' . $list[ 'is_active' ] . '>
                                                        <label><input type="checkbox" ' . $newvalue . '><span class="lever switch-col-bluenew"></span></label>
                                                    </a>
                                                </td>
                                            </tr>';
                                    endforeach;
                                    ?>
                                    <!--<a href="#" data-toggle="modal" data-target="#delcategoryModal" data-id="' . $list['id'] . '"><i class="material-icons">&#xE872;</i></a>-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
</section>

<div class="modal fade" id="topicModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">  
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"></h4>
            </div>
            <form name="addUpdateTopic" id="form_validation" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate">
                <div class="modal-body">
                    <input type="hidden" name="topicid" id="topicid" value="0">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="topic_name" required maxlength="40">
                            <label class="form-label">Topic Name</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <select class="form-control show-tick topic_cat" tabindex="-98" name="blog_id" required="" >
                            <option value="">Select Category</option>
                            <?php
                            foreach ( $blog_category as $row ) {
                                    echo '<option value="' . $row[ 'id' ] . '"> ' . $row[ 'name' ] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="hidden" id="uploadFile" name="uploaded_filename" placeholder="Choose Cover Image" readonly="readonly">
                                    <div class="fileUpload btn btn-primary">
                                        <span>Choose image</span>
                                        <input id="uploadBtn" name="topic_img" type="file" class="upload" required="" aria-required="true">
                                    </div>
                                    <br>
                                    <i class="small">File size should be less than 1 MB and dimension should be minimum 200*200</i>
                                    <br>
                                     <i class="imgerror"></i>
                                </div>
                                <div class="col-sm-3 uploaded-img-preview">
                                    <!--<div class="" style="height:90px; background:url(https://imageupload.localhost.com/images/DCk2wQqBDk.jpg) center center no-repeat;background-size:contain;"></div>-->
                                </div>
                            </div>
                             <p id="img_err" style="display:none;">* Please select valid Format(jpeg,jpg,png)</p>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="hidden" id="uploadFile" name="uploaded_icon_filename" placeholder="Choose icon" readonly="readonly">
                                    <div class="fileUpload btn btn-primary">
                                        <span>Choose icon</span>
                                        <input id="uploadIconBtn" name="topic_icon" type="file" class="upload" required="" aria-required="true">
                                    </div>
                                    <br>
                                    <i class="small">File size should be less than 1 MB and dimension should be minimum 100*100</i>
                                    <br>
                                    <i class="iconerror"></i>
                                </div>
                                <div class="col-sm-3 uploaded-icon-preview">
                                    <!--<div class="" style="height:90px; background:url(https://imageupload.localhost.com/images/DCk2wQqBDk.jpg) center center no-repeat;background-size:contain;"></div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-float m-t-10">
                        <input type="checkbox" id="basic_checkbox_2" class="filled-in chk-col-light-blue" name="topic_trending" value="1">
                        <label for="basic_checkbox_2">Trending Topic</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">SAVE CHANGES</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
//image file change function 

//        $('#uploadBtn').change(function (e) {
//            var file = this.files[0];
//            console.log(file.type);
//            if ((file.type == "image/jpeg" && file.size < 800000)) {
//                var img = URL.createObjectURL(file);
//                $('.avatar-img').css('background-image', 'url(' + img + ')');
//                $('#navigation-bar .pro-image').css('background-image', 'url(' + img + ')');
//                $('#avatar_upload_form').submit();
//            } else {
//                $(".show-msg").html("<div class='btn btn-danger'>Select valid image or image size should be less than 1 mb</div>").fadeIn(2000).delay(2000).fadeOut(2000);
//                return false;
//            }
//        });
        $(document).on('show.bs.modal', '.modal', function () {
            $('.imgerror').html('');
            $('.iconerror').html('');
        });


         $('input[name="topic_name"]').on('change', function(){
            var tp_name = $('input[name="topic_name"]').val().trim();
            $('input[name="topic_name"]').val(tp_name);
        });

         
        $("#uploadBtn").on("change", function (e) {
            

            var file = $(this)[0].files[0];
            const fileType = file['type'];
            var img_valid = image_ext(fileType);
             if(img_valid == 1){
             $('#img_err').html('');
            var _URL = window.URL || window.webkitURL;
            var file = $(this)[0].files[0];
            var imageData = new FormData();
            imageData.append('file', file);

            var iw, ih = 0;
            var img = new Image();


            img.onload = function () {
                iw = this.width;
                ih = this.height;
                var file_size = file.size;
                file_size = (file_size/1024)/1024;
                //if (iw <= 200 && ih >= 200) {
                if (file_size <= 1) {

                    $('.imgerror').html('');
                    $(".imgerror").removeAttr("style");
                ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                $("#uploadBtn").closest(".form-group").find("#uploadFile").val(result);
                $(".uploaded-img-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
                });

                } else {
                    $('#uploadFile').val('');
                    $('input[name="topic_img"]').val('');
                    /*$('.uploaded-img-preview > div').css('background-image', 'none');*/
                    //$('.imgerror').html('*Only Upload File with minimum dimension 200x200');
                    $('.imgerror').html('*Only Upload File with minimum file size of 1 MB');
                    $('.imgerror').css('color', 'red');
                }

            }

            img.src = _URL.createObjectURL(file);

             }else{
                 $('#img_err').show().css("color","#f44336");
                 $('#uploadBtn').val('');
             }



           
          
        });


        /*$("#uploadBtn").on("change", function (e) {
          
            var _URL = window.URL || window.webkitURL;
            var file = $(this)[0].files[0];
            var imageData = new FormData();
            imageData.append('file', file);
            var iw, ih = 0;
            var img = new Image();
            img.onload = function () {
                iw = this.width;
                ih = this.height;

              ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                $("#uploadBtn").closest(".form-group").find("#uploadFile").val(result);
                $(".uploaded-img-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
            });
         }
            img.src = _URL.createObjectURL(file);
          
        });*/



        $("#uploadIconBtn").on("change", function (e) {
         
            var _URL = window.URL || window.webkitURL;
            var file = $(this)[0].files[0];

            var imageData = new FormData();
            imageData.append('file', file);

            var iw, ih = 0;
            var img = new Image();
            console.log(img)
            img.onload = function () {
                iw = this.width;
                ih = this.height;
                var file_size = file.size;
                file_size = (file_size/1024)/1024;
                if (file_size <= 1) {
                //if (iw <= 100 && ih <= 100) {

                    $('.iconerror').html('');
                    $(".iconerror").removeAttr("style");

                    ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                        $("#uploadIconBtn").closest(".form-group").find("#uploadFile").val(result);
                        $(".uploaded-icon-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
                    });

                } else {
                    $('#uploadIconBtn').val('');
                    $('input[name="topic_icon"]').val('');
                    /*$('.uploaded-icon-preview > div').css('background-image', 'none');*/
                    //$('.iconerror').html('*Only Upload File with dimension 100x100');
                    $('.iconerror').html('*Only Upload File with minimum file size of 1 MB');
                    $('.iconerror').css('color', 'red');
                }
            };
            img.src = _URL.createObjectURL(file);
        });




      /*  $("#uploadIconBtn").on("change", function (e) {
         
            var _URL = window.URL || window.webkitURL;
            var file = $(this)[0].files[0];

            var imageData = new FormData();
            imageData.append('file', file);

            var iw, ih = 0;
            var img = new Image();
            console.log(img)
            img.onload = function () {
                iw = this.width;
                ih = this.height;

                ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                        $("#uploadIconBtn").closest(".form-group").find("#uploadFile").val(result);
                        $(".uploaded-icon-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
                    });

               

            };
            img.src = _URL.createObjectURL(file);
        });*/




</script>
