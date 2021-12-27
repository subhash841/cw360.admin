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
                            <?= $Page_type; ?>
                        </h2>
                    </div>
                    <?php
                    $blog_id = $this ->uri->segment(3) != "0" ? $this ->uri->segment(3) : "0";
                    $blog_date = (@$Blogs['blog_date'] == "") ? "" : date( "d-m-Y", strtotime( @$Blogs['blog_date'] ) );
                    ?>
                    <div class="body">
                        <?php //print_r($Blog_detail); exit; ?>
                        <div class="" id="blogdetailPage" data-blogid="<?= $blog_id; ?>">
                            <form name="addUpdateBlog"   method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="blog_title" value="<?= htmlspecialchars(@$Blogs['title']);?>" required aria-required="true" maxlength="75">
                                                <label class="form-label active">Title</label>
                                            </div>
                                             <strong><small class="text-danger blog_titleErr"></small></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float" style="margin-bottom:5px;">
                                            <div class="input-group date"  style="margin-bottom:5px;">
                                                <div class="form-line">
                                                    <input type="text" class="form-control blog_datetimepicker" name="blog_date" id="blog_date" value="<?= @$blog_date;?>" required="" style="background-color: transparent;" autocomplete="off" aria-required="true">
                                                    <label class="form-label">Blog Date</label>
                                                </div>
                                                <span class="input-group-addon" >
                                                    <span class="glyphicon glyphicon-calendar" id="blog_btnPicker"></span>
                                                </span>
                                            </div>
                                            <strong><small class="text-danger blog_dateErr"></small></strong>
                                        </div>
                                    </div>

                                <div class="col-sm-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control select2" name="topics[]" id="topics" required select2 multiple> 
                                                       <?php 
                                                       foreach ($topics as $key => $t):
                                                        if(in_array($t['id'], explode(',', $Blogs['topic_id']))) {$selected='selected'; }else{ $selected=''; }
                                                        echo '<option value="' . $t['id'] . '" '.$selected.'>' . $t['topic'] . '</option>';
                                                    endforeach;
                                                    ?> 
                                                </select>
                                            </div>
                                            <strong><small class="text-danger topicsErr"></small></strong>
                                        </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                       <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" required="" name="meta_keywords" id="meta_keywords"  maxlength="300" value="<?= @$Blogs['meta_keywords'] ?>" aria-required="true">                                            
                                            <label class="form-label">Meta Keywords</label>
                                        </div>
                                        <small class="text-danger meta_keywordsErr"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" required="" name="meta_description" id="meta_description"  maxlength="300" value="<?= @$Blogs['meta_description'] ?>" aria-required="true">                                            
                                            <label class="form-label">Meta Description</label>
                                        </div>
                                        <small class="text-danger meta_descriptionErr"></small>
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <div class="form-line form-float">
                                    <textarea rows="4" class="form-control no-resize poll_detail_change"  name="description" id="description"  placeholder="Rules & Updates"><?= @$Blogs['description'] ?></textarea>
                                </div>
                                <small class="text-danger descriptionErr"></small>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input type="text" id="uploadFile" name="uploaded_filename"  placeholder="Choose Blog Image" readonly="readonly" value="<?= @$Blogs['image'] ?>">
                                                <?php
                                                if ( @$Blogs['image'] == "" ) {
                                                    $required = 'required=""';
                                                } else {
                                                    $required = '';
                                                }
                                                ?>
                                                <div class="fileUpload btn btn-primary">
                                                    <span>Choose Blog image</span>
                                                    <input id="uploadBtn" name="poll_img"  type="file" class="upload" <?= $required ?> aria-required="true">
                                                </div>
                                                <br>
                                                <i class="small">File size should be less than 1 MB and dimension should be minimum 200*200</i>
                                            </div>
                                            <div class="col-sm-3 uploaded-img-preview">
                                                <div class="" style="height:90px; background:url(<?= @$Blogs['image'] ?>) center center no-repeat;background-size:contain;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <p id="img_err" style="display:none;">* Please select valid Format(jpeg,jpg,png)</p>
                                </div>
                            </div>

                            <div class="col-md-12">

                                        <!--<label class="form-label">Description</label>
                                        <div class="form-group form-float">
                                            <div id="blog_desc_editor"></div>
                                            <label id="blog_description-error" class="editorerror" >This field is required.</label>
                                        </div>-->

                                        <input type="hidden" name="blogid" id="blogid" value="<?= @$Blogs['id']; ?>">

                                        <?php if ( @$is_approve == 0 && $blog_id != 0 ) { ?>

                                            <button type="submit" class="btn btn-success waves-effect approveblog">Save and Approve</button>
                                            <button type="submit" class="btn btn-danger waves-effect rejectblog">Save and Reject</button>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-success waves-effect">Save</button>
                                        <?php } ?>
                            </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</section>

<!--<script src="/assets/ckeditor/ckeditor.js"></script>
<script src="/assets/ckeditor/config.js"></script>
<script src="/assets/ckeditor/styles.js"></script>-->
<script src="//cdn.ckeditor.com/4.10.0/standard-all/ckeditor.js"></script>
<script>
    $(function () {

        var placeholder = "Select Topic";
        $(".select2").select2({
         placeholder: placeholder,

     });
         var base_url = "<?= base_url(); ?>";

        $('.blog_datetimepicker').datetimepicker({
            useCurrent: false,
            format: "DD-MM-YYYY",
            ignoreReadonly: true
        });

        $('#blog_btnPicker').click(function () {
            $('.blog_datetimepicker').datetimepicker('show');
        });


         $("#uploadBtn").on("change", function () {
                var file = $(this)[0].files[0];
                const fileType = file['type'];
                var img_valid = image_ext(fileType);

                if(img_valid == 1){

                var imageData = new FormData();
                imageData.append('file', file);
                $('#img_err').html('');


                ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                    $("#uploadBtn").closest(".form-group").find("#uploadFile").val(result);
                    $(".uploaded-img-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
                });

                }else{
                      $('#img_err').show().css("color","#f44336");
                      $('#uploadBtn').val('');
                }
            });

        CKEDITOR.tools.callFunction(1, this);
        CKEDITOR.plugins.addExternal('simpleImageUpload', '<?php echo base_url();?>assets/ckeditor/plugins/simpleImageUpload/', 'plugin.js');
            CKEDITOR.on('instanceReady', function (evt) {
                var editor = evt.editor;
                editor.on('focus', function (e) {
                    $('.error').html('');
                });
            });


           /* CKEDITOR.replace('description',{
                uploadUrl: "https://imgupload.crowdwisdom.co.in",
                removeButtons: "EasyImageUpload",
                extraPlugins: 'simpleImageUpload,easyimage',
                removePlugins: 'image',
                toolbarGroups: [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},

                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                {name: 'styles', groups: ['styles']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']},


                ]
            });*/


            CKEDITOR.replace('description',{
                uploadUrl: "https://imgupload.crowdwisdom.co.in",
                removeButtons: "EasyImageUpload",
                extraPlugins: 'simpleImageUpload,easyimage,font',
                removePlugins: 'image',
                toolbarGroups: [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                {name: 'styles', groups: ['styles']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']},
                ]
            });

            
            /*CKEDITOR.replace('blog_desc_editor');*/

            $(document).ready(function(){

                var selectedTopicId = [];

                $('#search_topics').on('keyup',function(){

                    var topic = $(this).val();
                    console.log(topic.length);

                    if(topic && topic.length>=2){
                        $('.searched_topics').html('');
                        //alert(data);
                        $.ajax({
                            url: "<?php echo base_url();?>/Poll/fetchdata",
                            method: "POST",
                            data:{p_category:topic, topics: JSON.stringify(selectedTopicId)},
                            dataType: "text",
                            success: function(data)
                            {
                                $('.searched_topics').append('');
                                var data1 = JSON.parse(data);

                                var addDivData = "";
                                //addDivData += '<ul class="suggestions">';
                                $.each(data1, function (index, item) {
                                     /*console.log(value.id);
                                     console.log(value.text);*/

                                     // addDivData += "<li data-sug-id='" + item.id + "' data-sug-name='"+ item.topic +"'>" + item.topic + "</li>";
                                     //$('#result').append(option);
                                     $('.searched_topics').append( $("<div>", {class: "col-sm-12"})
                                        .append($("<a />", {class: "foundtopic nav-link", href: "#", "data-id": item.id, "data-name": item.topic}).html(item.topic)

                                            ));

                                 });
                                 //addDivData += '</ul>';

                                //$('.searched_topics').html(addDivData);
                            }
                        });
                    }

                    else {
                        $('.searched_topics').html("");
                    }



                });

                // $('li').click(function(){
                //     var nameValue = $(this).attr("#data-sug-name");
                //     alert('Hi');
                //     $('#p_category').val(nameValue);
                // });
                $(document).on('click', 'a.foundtopic', function (e) {
                    e.preventDefault();
                    var addId = $(this).attr('data-id');
                    var selected = $("<div>", {class: "btn bg-teal m-t-5 m-r-10 selected-topic"})
                    .append('<input type="hidden" name="topics[]" value="' + $(this).attr('data-id') + '" data-id="' + $(this).attr('data-id') + '">' + $(this).attr('data-name'))
                    .append($("<i>", {class: "cancel", style: "cursor:pointer"}).html('&nbsp; &times;')
                        )


                    $(this).closest('.searched_topics').parent();
                    $('.selected_topics').show();
                    $('.selected_topics .row').append(selected);
                    $("#search_topics").val('').trigger("keyup");
                    //$("#is_topic_change").val('1');
                    selectedTopicId.push(addId);
                    $(".error-topics").html('');
                });

                $(document).on('click', '.selected_topics .cancel', function (e) {
                    $(this).closest('.selected-topic').remove();
                    var index = selectedTopicId.indexOf($(this).prev().attr('data-id'));
                    if (index > -1) {
                        selectedTopicId.splice(index, 1);
                        //$("#is_topic_change").val('1');
                    }
                });


                var clkBtn = "";
                $('form[name="addUpdateBlog"] [type="submit"]').click(function (evt) {
                    clkBtn = $(this);
                }); 

                $('form[name="addUpdateBlog"]').on("submit", function (e) {
                    e.preventDefault();
                    var err = [];
                    var formdata = new FormData(this);
                    var _this = $(this);
                    $("input[name='blogid']", _this).val();
                    //console.log(formdata);
                    showloader();
                    var description = CKEDITOR.instances['description'].getData();
                    formdata.append('description', description);
                    ajax_call_multipart("<?php echo base_url(); ?>Blogs/add_update_blog", "POST", formdata, function (result) {
                            //result = JSON.parse(result);
                            hideloader();
                            data = JSON.parse(result);
                            console.log(data);
                            if (data.status == 'failure') {
                                        $.each(data.error, function (index, value) {
                                        if (index == 'blog_title') {
                                            err.push('blog_titleErr');
                                            $('.blog_titleErr').text(data.error.blog_title).css("color","#f44336");
                                        }else if(index == 'blog_date') {
                                            err.push('blog_dateErr');
                                            $('.blog_dateErr').text(data.error.blog_date).css("color","#f44336");
                                        }else if (index == 'meta_keywords') {
                                            err.push('meta_keywordsErr');
                                            $('.meta_keywordsErr').text(data.error.meta_keywords).css("color","#f44336");
                                        }else if (index == 'meta_description') {
                                            err.push('meta_descriptionErr');
                                            $('.meta_descriptionErr').text(data.error.meta_description).css("color","#f44336");
                                        }else if (index == 'description') {
                                            err.push('descriptionErr');
                                            $('.descriptionErr').text(data.error.description).css("color","#f44336");
                                        }
                            });

                            }else{

                            if (clkBtn.hasClass('approveblog')){
                                showToast(data.message,data.status);
                                approveblog($("input[name='blogid']", _this).val(), function () {
                                    setTimeout(function () {
                                       window.location.replace(base_url + "Blogs/index");
                                    }, 2000);
                                });
                            }else if (clkBtn.hasClass('rejectblog')){
                                showToast(data.message,data.status);
                                rejectblog($("input[name='blogid']", _this).val(), function () {    
                                    setTimeout(function () {
                                      window.location.replace(base_url + "Blogs/index");
                                    }, 2000);
                                });

                            }else{
                                    showToast(data.message,data.status);
                                    setTimeout(function () {
                                    window.location.replace(base_url + "Blogs/index");

                                }, 2000);

                            }
                           
                                  
                        }

                    });
                });



                function approveblog(e, f) {
                    var param = {id: e};
                    ajax_call('Blogs/approveblog', "POST", param, function (result) {
                        result = JSON.parse(result);
                        if (result['status']) {
                            f();
                        }
                    });
                }

                function rejectblog(e, f) {
                    var param = {id: e};
                    ajax_call('Blogs/rejectblog', "POST", param, function (result) {

                        result = JSON.parse(result);
                        if (result['status']) {
                            showToast(result['message'], '1');
                            f();
                        }
                    });
                }


                function showloader() {
                    $('.loading').css({"display": 'flex'});
                    $('body').css({'height': "100vh", 'overflow': "hidden"});
                }


                function hideloader() {
                    $('.loading').fadeOut(800);
                    $('body').css({'height': "100vh", 'overflow': "auto"});
                }




            });


});
</script>



