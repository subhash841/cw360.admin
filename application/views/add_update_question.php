<?php
	$selected_choice_1 = $selected_choice_2 = $selected_choice_3 = $selected_choice_4 ='';	
	if(!empty($choices)){
		$correct_choice = array_column($choices,'correct_choice');		
		if($correct_choice[0] == 'yes'){
			$selected_choice_1 = 'checked';
		}
		else if($correct_choice[1] == 'yes'){
			$selected_choice_2 = 'checked';
		}
		else if($correct_choice[2] == 'yes'){
			$selected_choice_3 = 'checked';
		}
		else if($correct_choice[3] == 'yes'){
			$selected_choice_4 = 'checked';
		}		
	}
    else{
        $selected_choice_1 = 'checked'; 
    }    	
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
        </div>
        <div class="row clearfix">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<div class="card">
                     <?php
                        $questionid = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                        ?>
        			<div class="header">
                        <h2>
                            <?php echo (!empty($questionid))?'Edit':'Create';?>  Question
                        </h2>
                    </div>
                    <div class="body">
                   
                        <form name="addUpdateQuestion" id="addUpdateQuestion" method="POST" autocomplete="off">
                        	<input type="hidden" name="question_id" id="question_id" value="<?= $question['id'] ?>">
                        	<div class="row">
                                <!--<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="search_topics" id="search_topics" maxlength="75" aria-required="true">
                                            <label class="form-label">Add Quiz</label>
                                            <p class="error-topics"></p>
                                        </div>


                                        <div class="form-group searched_topics position-absolute w-75 bg-light p-t-10" style="position: absolute; background: white; left: 0; z-index: 10;">

                                        </div>


                                        
                                        <div class="form-group selected_topics">
                                            <label class="m-t-10">Selected Quiz:</label>
                                            <div class="row px-4 col-xs-12">
                                            <?php
                                                /*$selectedTopicIds = array ();
                                                if ( ! empty( @$quiz_associated ) ) {
                                                    foreach ( @$quiz_associated  as $qa ):
                                                    ?>
                                                     <div class="btn bg-teal m-t-5 m-r-10 selected-topic">
                                                        <input type="hidden" name="quiz[]" value="<?= $qa[ 'quiz_id' ] ?>" data-id="<?= $qa[ 'quiz_id' ] ?>"><?= $qa[ 'name' ] ?>
                                                        <i class="cancel" style="cursor:pointer">&nbsp; ×</i>
                                                    </div>
                                                    <?php
                                                    endforeach;
                                                }*/
                                            ?>
                                        </div>
                                    </div>
                                    <small class="text-danger topicsErr"></small>
                            </div>
                            </div>-->
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-group">
                                            <label class="m-t-10">Selected Category:</label>
                                            <div class="">
                                            <?php
                                                $selectedTopicIds = array ();
                                                if ( ! empty( @$categories ) ) { ?>
                                                    <select class="form-control select2" name="question_category" id="question_category" required select2>
                                                        <option value="">Please Select Category</option>
                                                    <?php foreach ( @$categories  as $ca ):
                                                        if($ca['id'] == @$question['category']){ $selected='selected'; }else{ $selected=''; }
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
                                </div>


                                <div class="col-sm-12">
                                <div class="form-group form-float">
                                        <div class="form-group">
                                        <label class="m-t-10">Select Topic:</label>
                                        <select class="form-control topics_sec" name="topics[]" id="topics" required  multiple="multiple"> 
                                        <?php 
                                        foreach ($topics as $key => $t):
                                            if(in_array($t['id'], explode(',', $question['topic_id']))) {$selected='selected'; }else{ $selected=''; }
                                            echo '<option value="' . $t['id'] . '" '.$selected.'>' . $t['topic'] . '</option>';
                                        endforeach;
                                        ?> 
                                        </select>
                                        </div>
                                </div>
                                </div>


                                <!--<div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-group">
                                            <label class="m-t-10">Select Topics:</label>
                                            <div class="">
                                            <?php
                                                //$selectedTopicIds = array ();
                                                //if ( ! empty( @$topics ) ) { ?>
                                                    <select class="form-control select3 question_topics" name="topics[]" id="question_topics" multiple="multiple" required select2>
                                                        
                                                    <?php /*foreach ( @$topics  as $ta ):
                                                        //if($ta['id'] == @$question['topic_id']){ $selected='selected'; }else{ $selected=''; }
                                                        if(in_array($ta['id'], @$question['topic_id'])){ $selected='selected'; }else{ $selected=''; }
                                                    ?>
                                                     <option <?php echo $selected; ?> value="<?= $ta['id']; ?>" <?php echo $selected; ?>><?= $ta['name']; ?></option>
                                                    <?php
                                                    endforeach;*/ ?>
                                                    </select>
                                                <?php //}
                                            ?>
                                            </div>
                                        </div>
                                        <small class="text-danger categoryErr"></small>
                                    </div>
                                </div>-->

                                <!-- <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="search_topics" id="search_topics" maxlength="75" aria-required="true">
                                            <label class="form-label">Add Topics</label>
                                            <p class="error-topics"></p>
                                        </div>


                                        <div class="form-group searched_topics position-absolute w-75 bg-light p-t-10" style="position: absolute; background: white; left: 0; z-index: 10;">

                                        </div>


                                        
                                        <div class="form-group selected_topics">
                                            <label class="m-t-10">Selected Topics:</label>
                                            <div class="row px-4 col-xs-12 topics_sec">
                                                <?php
                                                $selectedTopicIds = array ();
                                                if ( ! empty( @$question['topics_associated'] ) ) {
                                                    foreach ( @$question['topics_associated']  as $ta ):
                                                     /* $selectedTopicIds[] = $ta[ 'id' ];*/
                                                     array_push($selectedTopicIds,$ta[ 'id' ]);
                                                     ?>
                                                     <div class="btn bg-teal m-t-5 m-r-10 selected-topic">
                                                        <input type="hidden" name="topics[]" value="<?= $ta[ 'id' ] ?>" data-id="<?= $ta[ 'id' ] ?>"><?= $ta[ 'topic' ] ?>
                                                        <i class="cancel" style="cursor:pointer">&nbsp; ×</i>
                                                    </div>
                                                    <?php
                                                endforeach;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <small class="text-danger topicsErr"></small>
                                </div>
                            </div> -->
                            </div>
                        	<div class="row">
                        		<div class="col-sm-12">
                        			<div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="question" id="question" required="" maxlength="50" value="<?= @$question['question'] ?>" aria-required="true">
                                            <label class="form-label">Question</label>
                                        </div>
                                        <strong><small class="text-danger questionErr"></small></strong>
                                    </div>
                                  

                        		</div>
                        	</div>
                        <div class="row">    
                        <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" name="question_desc" required="required" maxlength="300"><?= @$question['description'] ?></textarea>
                                            <label class="form-label">Question Description</label>
                                        </div>
                                    </div>
                                </div>
                        	
                            <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="question_meta_keywords" id="question_meta_keywords" required="" maxlength="300" value="<?= @$question['meta_keywords']?>" aria-required="true"> 
                                            <label class="form-label">Meta Keywords</label>      
                                        </div>
                                        <strong><small class="text-danger meta_keywordsErr"></small></strong>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="question_meta_description" id="question_meta_description" required="" maxlength="300" value="<?= @$question['meta_description'] ?>" aria-required="true">
                                            <label class="form-label">Meta Description</label>
                                        </div>
                                        <strong><small class="text-danger meta_descriptionErr"></small></strong>
                                    </div>
                                    
                                </div>
                        	<div class="">
                        		<div class="col-sm-6">
                        			<div class="row">
                        				<div class = "col-sm-1">                      					

                                            <input name="selected_choice" type="radio" id="radio_1" <?php echo $selected_choice_1?>>
                                            <label for="radio_1" style="margin-top: 7px"></label>
                                            
                        				</div>
                        				<div class="col-sm-10">
                        					<div class="form-group form-float">
                                        		<div class="form-line">
                                            		<input type="text" class="form-control" name="choices[]" id="choice1" required="required" maxlength="30" value="<?= @$choices[ 0 ][ 'choice' ] ?>" aria-required="true">     
                                                    <label class="form-label">Enter Choice 1</label>                                  
                                                </div>
                                    		</div>	
                        				</div>                        				
                        			</div>                                
                                </div>
                                <div class="col-sm-6">
                                	<div class="row">
                                		<div class="col-sm-1">                                			
                                            <input name="selected_choice" type="radio" id="radio_2" <?php echo $selected_choice_2?>>
                                            <label for="radio_2" style="margin-top: 7px"></label>
                                		</div>
                                		<div class="col-sm-10">
                                			<div class="form-group form-float">
                                        		<div class="form-line">
                                            		<input type="text" class="form-control" name="choices[]" id="choice2" required="required" maxlength="30" value="<?= @$choices[ 1 ][ 'choice' ] ?>" aria-required="true">
                                                     <label class="form-label">Enter Choice 2</label>                                  
                                                </div>
                                    		</div>
                                		</div>                                		
                                	</div>                              
                                </div>
                        	</div>
                        	<div class="add-more-choices">
                        		<div class="col-sm-6">
                        			<div class='row'>
                        				<div class='col-sm-1'>                        					
                                			<!--<input type ='radio' name='selected_choice' id="selected_choice_3" required="required" <?php echo $selected_choice_3?>>-->
                                            <input name="selected_choice" id="radio_3"
                                            type="radio"  <?php echo $selected_choice_3?>>
                                            <label for="radio_3" style="margin-top: 7px"></label>
                                		</div>
                        				<div class='col-sm-10'>
                        					<div class="form-group form-float">
                                        		<div class="form-line">
                                            		<input type="text" class="form-control" name="choices[]" id="choice3" required="required" maxlength="30" value="<?= @$choices[ 2 ][ 'choice' ] ?>" aria-required="true">    
                                                     <label class="form-label">Enter Choice 3</label>                                  
                                                </div>
                                    		</div>
                        				</div>                       				
                        			</div>
                        		</div>                         
                            	<div class="col-sm-6">
                                	<div class='row'>
                                		<div class='col-sm-1'>
                                			<!--<input type ='radio' name='selected_choice' id="selected_choice_4" required="required" <?php echo $selected_choice_4?>>-->
                                            <input name="selected_choice" type="radio" id="radio_4" <?php echo $selected_choice_4?>>
                                            <label for="radio_4" style="margin-top: 7px"></label>
                                		</div>
                                		<div class='col-sm-10'>
                                			<div class="form-group form-float">
                                        		<div class="form-line">
                                            		<input type="text" class="form-control" name="choices[]" id="choice4" required="required" maxlength="30"  value="<?= @$choices[ 3 ][ 'choice' ] ?>" aria-required="true">
                                            		<label class="form-label">Enter Choice 4</label>
                                        		</div>
                                    		</div>		
                                		</div>                                		
                                	</div>                                 
                                </div>	
                        	</div>                        	
                        	<div class="">
                        		<div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="uploadFile" name="uploaded_filename" placeholder="Choose Cover Image" readonly="readonly" value="<?= @$question['image'] ?>">
                                                    <?php
                                                    if ( @$question['image'] == "" ) {
                                                            $required = 'required=""';
                                                    } else {
                                                            $required = '';
                                                    }
                                                    ?>
                                                    <div class="fileUpload btn btn-primary">
                                                        <span>Choose image</span>
                                                        <input id="uploadBtn" name="question_img" type="file" class="upload"  aria-required="true">
                                                    </div>
                                                    <br>
                                                    <i class="small">File size should be less than 1 MB and dimension should be minimum 200*200</i>
                                                </div>
                                                <div class="col-sm-3 uploaded-img-preview">
                                                    <div class="" style="height:90px; background:url(<?= @$question['image'] ?>) center center no-repeat;background-size:contain;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <p id="img_err" style="display:none;">* Please select valid Format(jpeg,jpg,png)</p>
                                </div>
                        	</div>

                            <div class="col-sm-6">
                                <label class="form-label">Published</label>
                                <a class="switch" data-id="1" data-type="topics" data-status="1">
                                    <?php
                                    if ( @$question['is_published'] == 1 ) {
                                        $checked = 'checked=""';
                                    } else {
                                        $checked = '';
                                    }
                                    ?>
                                    <label><input type="checkbox" name="is_published" id="is_published" value="1" <?= $checked;?> ><span class="lever switch-col-bluenew"></span></label>
                                </a>
                            </div>


                        	<div class="">
                                <div class="col-sm-12 align-center">
                                    <button id="addelection" type="submit" class="btn btn-primary waves-effect"><?php echo (!empty($questionid))?'SAVE CHANGES':'SUBMIT';?> </button>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
        		</div>
        	</div>
        </div>
	</div>
</section>
<script type="text/javascript">
	$(function () {
		$('#quiz_group').multiSelect();

       /* $('#user_selected').change(function(){
            var value = $(this).val();
            // Set selected 
            $('#sel_users').val(value);
            $('#sel_users').select2().trigger('change');

          });*/
		
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



        $("form#addUpdateQuestion").on("submit", function (e){ 

            e.preventDefault();
            var err = [];
            showloader();
            var data = $(this).serialize();             
            var selected_choice  = $('input[name=selected_choice]:checked', '#addUpdateQuestion').attr('id');
            data = data+'&selected_choice='+ selected_choice;      
            ajax_call("Quiz/addUpdateQuestion", "POST", data, function (result) {
            hideloader();
            data = JSON.parse(result);
            console.log(data);
            if (data.status == 'failure') {
                    if (data.error != "") {
                                    $.each(data.error, function (index, value) {
                                        if (index == 'question') {
                                            err.push('questionErr');
                                            $('.questionErr').text(data.error.question).css("color","#f44336");
                                        }else if (index == 'meta_keywords') {
                                            err.push('meta_keywordsErr');
                                            $('.meta_keywordsErr').text(data.error.meta_keywords).css("color","#f44336");
                                        }else if (index == 'meta_description') {
                                            err.push('meta_descriptionErr');
                                            $('.meta_descriptionErr').text(data.error.meta_description).css("color","#f44336");
                                        }
                            });
                                
                        }

                }else{

                    showToast(data.toast_message, '1');
                     setTimeout(function () {
                        // window.location.assign("question_list");
                        location.reload();

                    // setTimeout(function () {Z[,9]
                    window.location.assign("quest_list");
                    }, 2000);
                    
                }
          
            });
        });



        var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;
        $('#search_topics').on('keyup', function () {

        var topic = $(this).val();
        var cat = $('#question_category').val();
        //console.log(topic.length);

        if (topic && topic.length >= 2) {
            $('.searched_topics').html('');
                    $.ajax({
                        url: "<?php echo base_url();?>/Quiz/fetchTopic",
                        method: "POST",
                        data: {p_category: topic, topic_id: JSON.stringify(selectedTopicId), category: cat},
                        dataType: "text",
                        success: function (data)
                        {
                            $('.searched_topics').append('');
                            var data1 = JSON.parse(data);

                            var addDivData = "";
                            
                            $.each(data1, function (index, item) {                                
                                $('.searched_topics').append($("<div>", {class: "col-sm-12"})
                                    .append($("<a />", {class: "foundtopic nav-link", href: "#", "data-id": item.id, "data-name": item.topic}).html(item.topic)));
                            });                            
                        }
                    });
                } else {
                    $('.searched_topics').html("");
                }
            });


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
           $("#topics").empty();
          });

        

        $("#question_topics").select2({
              width: '100%',
                allowClear: true
          });

        function showloader() {
                $('.loading').css({"display": 'flex'});
                $('body').css({'height': "100vh", 'overflow': "hidden"});
            }

        function hideloader() {
                $('.loading').fadeOut(800);
                $('body').css({'height': "100vh", 'overflow': "auto"});
            }




        /*$(".select2").on('change', function (e) { 

            var cat = $('#question_category').val();

              $.ajax({
                        url: "<?php echo base_url();?>/Quiz/fetchTopicList",
                        method: "POST",
                        data: {category: cat},
                        dataType: "text",
                        success: function (data)
                        {
                            $('.searched_topics').append('');
                            var data1 = JSON.parse(data);

                            var addDivData = "";
// $('#question_topics').val(null).trigger('change');
                            
                            $.each(data1, function (index, item) {                                
                                //$('.question_topics').append($("<option />", {class: "foundtopic nav-link", href: "#", "data-id": item.id, "data-name": item.topic}).html(item.topic));
                                //$('.question_topics').empty();
                                //$('.question_topics').select2('data', null);
                                //$('.question_topics').val(null)
                                $('.question_topics').append("<option value="+item.id+">"+item.topic+"</option>");
                            });                            
                        }
                    });
          });*/

	});
</script>
