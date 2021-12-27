<section class="content">
	<div class="container-fluid">
		<div class="block-header">
        </div>
        <div class="row clearfix">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<div class="card">
                    <?php
                        $quizid = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                        $end_date = (@$quiz['end_date'] == "") ? "" : date( "d-m-Y", strtotime( @$quiz['end_date'] ) );
                        // PHP code to get the MAC address of Client
                        ?>
        			<div class="header">
                        <h2>
                           <?php echo (!empty($quizid))?'Edit':'Create';?>  Quiz
                        </h2>
                    </div>
                    <div class="body">
                    	
                        <form name="addUpdateQuiz" id="addUpdateQuiz" method="POST" autocomplete="off">
                        	<input type="hidden" name="quiz_id" id="quiz_id" value="<?= $quiz['quiz_id'] ?>">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-group">
                                            <label class="m-t-10">Select Category:</label>
                                            <div class="">
                                            <?php
                                                if ( ! empty( @$categories ) ) { ?>
                                                    <select class="form-control select2" name="question_category" id="question_category" required select2>
                                                        <option value="">Please Select Category</option>
                                                    <?php foreach ( @$categories  as $ca ):
                                                        if($ca['id'] == @$quiz['category']){ $selected='selected'; }else{ $selected=''; }
                                                    ?>
                                                     <option <?php echo $selected; ?> value="<?= $ca['id']; ?>" <?php echo $selected; ?>><?= $ca['name']; ?></option>
                                                    <?php
                                                    endforeach; ?>
                                                    </select>
                                                <?php }
                                            ?>
                                            </div>
                                        </div>
                                        <small class="text-danger categoryErr"></small>
                                    </div>

                                   
                                <div class="form-group form-float">
                                        <div class="form-group">
                                        <label class="m-t-10">Select Topic:</label>
                                        <select class="form-control select2" name="topics[]" id="topics" required select2 multiple="multiple">
                                        <option value="">Select Topic</option> 
                                        <?php 
                                        foreach ($topics as $key => $t):
                                            if(in_array($t['id'], explode(',', $quiz['topic_id']))) { $selected='selected' ; }else{ $selected=''; }
                                            echo '<option value="' . $t['id'] . '" '.$selected.'>' . $t['topic'] . '</option>';
                                        endforeach;
                                        ?> 
                                        </select>
                                        </div>
                                        <small class="text-danger topicErr"></small>
                                </div>
                                <div class="row">
                        		<div class="col-sm-12">
                        			<div class="form-group form-float">
                        				<div class="form-line">
                        					<input type="text" class="form-control" name="name" id="name" required="" maxlength="75" value="<?= @htmlspecialchars($quiz['name']) ?>">
                                            <label class="form-label">Quiz Name</label>
                        				</div>
                                         <strong><small class="text-danger nameErr"></small></strong>
                        			</div>
                        		</div>
                                <div class="col-sm-12">
                                      <label class="form-label">Description</label>
                        			<div class="form-group form-float">
                        				<div class="form-line">
                                            <textarea rows="4" class="form-control" name="description" id="description" required="required" maxlength="" placeholder="Quiz Description"><?= @$quiz['description'] ?></textarea>
                        				</div>
                        			</div>
                                     <strong><small class="text-danger descriptionErr"></small></strong>
                        		</div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="meta_keywords" id="meta_keywords" required="" maxlength="300" value="<?= @$quiz['meta_keywords'] ?>" aria-required="true"> 
                                            <label class="form-label">Meta Keywords</label>      
                                        </div>
                                         <strong><small class="text-danger meta_keywordsErr"></small></strong>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="meta_description" id="meta_description" required="" maxlength="300" value="<?= @$quiz['meta_description'] ?>" aria-required="true">
                                            <label class="form-label">Meta Description</label>
                                        </div>
                                         <strong><small class="text-danger meta_descriptionErr"></small></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="uploadFile" name="uploaded_filename" placeholder="Choose Cover Image" readonly="readonly" value="<?= @$quiz['image'] ?>">
                                                    <?php
                                                    if ( @$quiz['image'] == "" ) {
                                                            $required = 'required=""';
                                                    } else {
                                                            $required = '';
                                                    }
                                                    ?>
                                                    <div class="fileUpload btn btn-primary">
                                                        <span>Choose image</span>
                                                        <input id="uploadBtn" name="poll_img" type="file" class="upload" <?= $required ?> aria-required="true">
                                                    </div>
                                                    <br>
                                                    <i class="small">File size should be less than 1 MB and dimension should be minimum 200*200</i>
                                                </div>
                                                <div class="col-sm-3 uploaded-img-preview">
                                                    <div class="" style="height:90px; background:url(<?= @$quiz['image'] ?>) center center no-repeat;background-size:contain;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <p id="img_err" style="display:none;">* Please select valid Format(jpeg,jpg,png)</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control end_datetimepicker" name="end_date" id="end_date"  required="required" value="<?= $end_date;?>" style="background-color: transparent;" aria-required="true">
                                                <label class="form-label">End Date</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar" id="end_btnPicker"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-group">
                                        <label>Number of Questions</label>   
                                        <select class="form-control" name="total_questions" id="total_questions" required>
                                        <option value="">Select Total Questions</option>
                                        <?php 
                                        $questions = array(5,10);
                                        foreach ($questions as $key => $t):
                                            if($t == $quiz['total_questions']) { $selected='selected' ; }else{ $selected=''; }
                                            echo '<option value="' . $t . '" '.$selected.'>' . $t . '</option>';
                                        endforeach;
                                        ?>
                                        </select> 
                                        </div>
                                        <strong><small class="text-danger total_questionsErr"></small></strong>
                                    </div>

                                </div>

                                <div class="col-sm-6">
                                <label class="form-label">Published</label>
                                <a class="switch" data-id="1" data-type="topics" data-status="1">
                                    <?php
                                    if ( @$quiz['is_published'] == 1 ) {
                                        $checked = 'checked=""';
                                    } else {
                                        $checked = '';
                                    }
                                    ?>
                                    <label><input type="checkbox" name="is_published" id="is_published" value="1" <?= $checked;?> ><span class="lever switch-col-bluenew"></span></label>
                                </a>
                                </div>
                            </div>
                        	<div class="row">
                                <div class="col-sm-12 align-center">
                                    <button id="addelection" type="submit" class="btn btn-primary waves-effect"><?php echo (!empty($quizid))?'SAVE CHANGES':'SUBMIT';?> </button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
        		</div>
        	</div>
        </div>
	</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/adapters/jquery.js"></script>
<script>

	$(document).ready(function(){
        var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;
		$('.end_datetimepicker').datetimepicker({
            useCurrent: false,
            format: "DD-MM-YYYY",
            minDate: moment().millisecond(0).second(0).minute(0).hour(0),
            ignoreReadonly: true
        });

        $('#end_btnPicker').click(function () {
                    $('.end_datetimepicker').datetimepicker('show');
        });

            
        CKEDITOR.tools.callFunction(1, this);
        CKEDITOR.plugins.addExternal('simpleImageUpload', '<?php echo base_url();?>assets/ckeditor/plugins/simpleImageUpload/', 'plugin.js');

        CKEDITOR.on('instanceReady', function (evt) {
                var editor = evt.editor;
                editor.on('focus', function (e) {
                    $('.error').html('');
                });
            });

            
       /*  CKEDITOR.replace('description',{
                uploadUrl: "https://imgupload.crowdwisdom.co.in",
                removeButtons: "EasyImageUpload,Copy,Paste,PasteText,PasteFromWord,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Smiley,SpecialChar,PageBreak,Iframe,Format,ShowBlocks,About,Save,NewPage,Preview,Print,Templates,Cut,Table,HorizontalRule",
                extraPlugins: 'simpleImageUpload,easyimage',
                removePlugins: 'image',
                toolbarGroups: [
                    {name: 'document', groups: ['mode', 'document', 'doctools']},
                    {name: 'clipboard', groups: ['clipboard', 'undo']},
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
                    {name: 'about', groups: ['about']}
                ]
            });
 */

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


        $("form#addUpdateQuiz").on('submit',function(e){
            e.preventDefault();
            var err = [];
            showloader();
            var formdata = new FormData(this);  
            //var description = CKEDITOR.instances['description'].getData();
              //  formdata.append('description', description);
                ajax_call_multipart("<?php echo base_url(); ?>Quiz/create_update", "POST", formdata, function (result) {
                hideloader();
                data = JSON.parse(result);
                console.log(data);
                if (data.status == 'failure') {
                                if (data.error != "") {
                                    $.each(data.error, function (index, value) {
                                        if (index == 'name') {
                                            err.push('nameErr');
                                            $('.nameErr').text(data.error.name).css("color","#f44336");
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
                                
                        }
                 }else{

                    showToast(data.toast_message, '1');
                    setTimeout(function () {
                        window.location.assign("lists");
                    }, 2000);
                    
                }
            });
            //ajax_call("Quiz/create_update", "POST", data, function (result) {
            //    window.location.assign("<?php //echo base_url(); ?>Quiz/lists");
            //});
        });


        $(document).on('click', 'input', function () {
            $(this).text('');

        });




        /*$('#search_topics').on('keyup', function () {
        var topic = $(this).val();
        var cat = $('#question_category').val();
        if (topic && topic.length >= 2) {
            $('.searched_topics').html('');
                    //alert(data);
                    $.ajax({
                        url: "<?php echo base_url();?>/Quiz/fetchTopic",
                        method: "POST",
                        data: {p_category: topic, topic_id: JSON.stringify(selectedTopicId),category: cat},
                        dataType: "text",
                        success: function (data)
                        {
                            $('.searched_topics').append('');
                            var data1 = JSON.parse(data);

                            var addDivData = "";
                            //addDivData += '<ul class="suggestions">';
                            $.each(data1, function (index, item) {
                               
                                $('.searched_topics').append($("<div>", {class: "col-sm-12"})
                                    .append($("<a />", {class: "foundtopic nav-link", href: "#", "data-id": item.id, "data-name": item.topic}).html(item.topic)

                                        ));

                            });
                           
                        }
                    });
                } else {
                    $('.searched_topics').html("");
                }
        });*/


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
                $("#is_topic_change").val('1');
                selectedTopicId.push(addId);
                $(".error-topics").html('');
            });


            $(document).on('click', '.selected_topics .cancel', function (e) {
                $(this).closest('.selected-topic').remove();
                var index = selectedTopicId.indexOf($(this).prev().attr('data-id'));
                //console.log(index);
                if (index > -1) {
                    selectedTopicId.splice(index, 1);
                    $("#is_topic_change").val('1');
                }
            });


            $(".select2").select2({
              width: '100%',
            });

            $("#topics").select2({
               placeholder: 'Please Select Topic',
               ajax: { 
               url: '<?= base_url() ?>Quiz/fetchTopic',
               type: "post",
               dataType: 'json',
               delay: 250,
               data: function (params) {
                  return {
                    searchTerm: params.term, // search term
                    cat_id: $("#question_category").val() // Category ID
                  };
               },
               processResults: function (response) {
                    return {
                     results: response
                  };
               },
               cache: true
               }
            });


            $(".select2").on('change', function (e) { 
              $('.topics_sec').empty();
              selectedTopicId = "";
            });


            var base_url = "<?= base_url(); ?>";

            function showloader() {
                $('.loading').css({"display": 'flex'});
                $('body').css({'height': "100vh", 'overflow': "hidden"});
            }

            function hideloader() {
                $('.loading').fadeOut(800);
                $('body').css({'height': "100vh", 'overflow': "auto"});
            }



	});
</script>
