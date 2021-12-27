<style>
    .delete_choice{
        cursor:pointer;
        position: absolute;
        top: 0;
        right: 4%;
        z-index: 1;
        font-size: large;
    }
    .display-delete{
        display: none;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="card">
                    <?php
                        $prediction_id = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                        $start_date = (@$prediction_data['start_date']  == "") ? "" : date( "d-m-Y", strtotime( @$prediction_data['start_date'] ) );
                        $end_date = (@$prediction_data['end_date'] == "") ? "" : date( "d-m-Y", strtotime( @$prediction_data['end_date'] ) );
                        $fpt_start_date = (@$prediction_data['fpt_start_date'] == "") ? "" : date( "d-m-Y", strtotime( @$prediction_data['fpt_start_date'] ) );
                        $fpt_end_date = (@$prediction_data['fpt_end_date'] == "") ? "" : date( "d-m-Y", strtotime( @$prediction_data['fpt_end_date'] ) );
                         $start_time  =  (@$prediction_data['start_date'] == "") ? "" : date("H:i:s", strtotime($prediction_data['start_date']));
                        $end_time = (@$prediction_data['end_date'] == "") ? "" : date("H:i:s", strtotime($prediction_data['end_date']));

                       
                    ?>
                    <div class="header">
                        <h2>
                            <?php echo (!empty($prediction_id))?'Edit':'Create';?> Predictions
                        </h2>
                    </div>
                    <div class="body">
                        <form name="addUpdatePrediction" id="addUpdatePrediction" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <!--action=create_update-->
                            <input type="hidden" name="predictions_id" id="predictions_id" value="<?= @$prediction_data['id'] ?>">
                            <input type="hidden" name="old_game_id" id="old_game_id" value="<?= $prediction_data['game_id'] ?>">

                            <div class="row">
                                 <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                        <select class="form-control select2" name="game_id" id="game_id" required select2> 
                                              <option value="">Please select game</option> 
                                                <?php
                                                foreach ($games as $key => $g):
                                                if($g['id'] == @$prediction_data['game_id']){ $selected='selected'; }else{ $selected=''; }
                                                 echo '<option value="' . $g['id'] . '" '.$selected.'>' . $g['title'] . '</option>';
                                                endforeach;
                                                ?> 
                                        </select>
                                     </div>
                                 </div>
                             </div>
                  <!--               <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                        <select class="form-control select2" name="topic_id[]" id="topic_id" required select2 multiple="multiple"> 
                                                <?php
                                                foreach ($topics as $key => $t):
                                                if($t['id'] == @$topics){ $selected='selected'; }else{ $selected=''; }
                                                 echo '<option '.$selected.'value="' . $t['id'] . '" '.$selected.'>' . $t['topic'] . '</option>';
                                                endforeach;
                                                ?> 
                                        </select>
                                       
                                     </div>
                                 </div>
                             </div> -->
                            



                               <!-- <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                  <select name="game_id[]" id="game_id" class="form-control games_list myselect" multiple="multiple">
                                                </select>
                                             
                                            </div>
                                        </div>
                                    </div> -->

                                  <!--   <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="search_games" id="search_games" maxlength="75" aria-required="true">
                                                <label class="form-label">Add Games</label>
                                                <p class="error-topics"></p>
                                            </div>


                                            <div class="form-group searched_topics position-absolute w-75 bg-light p-t-10" style="position: absolute; background: white; left: 0; z-index: 10;">
                                            </div>

                                            <div class="form-group selected_topics">
                                                <label class="m-t-10">Selected Games:</label>
                                                <div class="row px-4 col-xs-12">
                                                    <?php
                                                    $selectedTopicIds = array ();
                                                    if ( ! empty( @$prediction_data['topics_associated'] ) ) {
                                                        foreach ( @$prediction_data['topics_associated']   as $ta ):
                                                            $selectedTopicIds[] = $ta[ 'id' ];
                                                           ?>
                                                           <div class="btn bg-teal m-t-5 m-r-10 selected-topic">
                                                            <input type="hidden" name="game_id[]" value="<?= $ta[ 'id' ] ?>" data-id="<?= $ta[ 'id' ] ?>"><?= $ta[ 'title' ] ?>
                                                            <i class="cancel" style="cursor:pointer">&nbsp; ×</i>
                                                        </div>
                                                        <?php
                                                    endforeach;
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>
                                </div> -->

                            </div>
        
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="title" id="title" required="" maxlength="40" value="<?= @$prediction_data['title'] ?>" aria-required="true">                                            
                                            <label class="form-label">Title</label>
                                        </div>
                                    </div>
                                    <strong><small class="text-danger titleErr"></small></strong>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="price" id="price" required=""  value="<?= @$prediction_data['price'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" aria-required="true" >                                            
                                            <label class="form-label">Price</label>
                                        </div>
                                        <strong><small class="text-danger priceErr"></small></strong>
                                    </div>
                                </div>


                               <!--  <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="quantity" id="quantity" required=""  value="<?= @$prediction_data['quantity'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" aria-required="true" >                                            
                                            <label class="form-label">Total Quantity</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="per_qty_points" id="per_qty_points" required=""  value="<?= @$prediction_data['per_qty_points'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" aria-required="true" >                                            
                                            <label class="form-label">Per Quantity Points</label>
                                        </div>
                                    </div>
                                </div>
                                 -->

                               
                          <!--       <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <div class="form-line form-float">
                                            <textarea rows="4" class="form-control no-resize poll_detail_change" name="description" id="description"  placeholder="Rules & Updates"><?= @$prediction_data['description'] ?></textarea>
                                        </div>
                                    </div>
                                    <!- - <?= @htmlspecialchars_decode( $preview ) ?> -->
                               <!-- </div> -->
                            </div>

                            <div class="row">

                               <!--  <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="poll_title" id="poll_title" required="" maxlength="75" value="<?= @$poll ?>" aria-required="true">                                            
                                            <label class="form-label">Reward</label>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div id="start" class="form-line">
                                                <input type="text" class="form-control start_datetimepicker" name="start_date" id="start_date" required="required"    value="<?= @$start_date ?>" style="background-color: transparent;" aria-required="true">
                                                <label class="form-label">Start Date <strong><small class="text-danger start_dateErr"></small></strong></label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar" id="btnPicker"></span>
                                            </span>
                                        </div>
                                        
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control end_datetimepicker" name="end_date" id="end_date" required="required" value="<?= @$end_date; ?>" style="background-color: transparent;" aria-required="true">
                                                <label class="form-label">End Date</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar" id="end_btnPicker"></span>
                                            </span>
                                        </div>
                                        <strong><small class="text-danger end_dateErr"></small></strong>
                                    </div>
                                </div>
                                

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control start_time" name="start_time" id="start_time" required style="background-color: transparent;" value="<?= @$start_time;?>">
                                                <label class="form-label">Start Time</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <strong><small class="text-danger start_timeErr"></small></strong>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control end_time" name="end_time" id="end_time" required style="background-color: transparent;"  value="<?= @$end_time;?>">
                                                <label class="form-label">End Time</label>
                                            </div>
                                            <strong><small class="text-danger end_timeErr"></small></strong>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>

                                        </div>
                                      
                                    </div>
                                </div>


                               <!--  <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control fpt_start_date" name="fpt_start_date" id="fpt_start_date"  required="required" value="<?= $fpt_start_date ?>" style="background-color: transparent;" aria-required="true">
                                                <label class="form-label">FPT Start Date</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div> -->


                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div id="fpt" class="form-line">
                                                <input type="text" class="form-control fpt_end_date" name="fpt_end_date" id="fpt_end_date"  required="required" value="<?= $fpt_end_date ?>" style="background-color: transparent;" aria-required="true">
                                                <label class="form-label">FPT End Date <strong><small class="text-danger fpt_end_dateErr"></small></strong></label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                

                                <!-- <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control fpt_start_time" name="fpt_start_time" id="fpt_start_time" style="background-color: transparent;" value="<?= @$prediction_data['fpt_start_time'];?>">
                                                <label class="form-label">FPT Start Time</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control fpt_end_time" required name="fpt_end_time" id="fpt_end_time" style="background-color: transparent;"  value="<?= @$prediction_data['fpt_end_time'];?>">
                                                <label class="form-label"> FPT End Time</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time" id="btnttimePicker"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="meta_keywords" id="meta_keywords" required="" maxlength="300" value="<?= @$prediction_data['meta_keywords'] ?>" aria-required="true"> 
                                            <label class="form-label">Meta Keywords</label>
                                        </div>
                                        <strong><small class="text-danger meta_keywordsErr"></small></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="meta_description" id="meta_description" required="" maxlength="300" value="<?= @$prediction_data['meta_description'] ?>" aria-required="true">                                            
                                            <label class="form-label">Meta Description</label>
                                        </div>
                                        <strong><small class="text-danger meta_descriptionErr"></small></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="uploadFile" name="uploaded_filename" placeholder="Choose Image" readonly="readonly" value="<?= @$prediction_data['image'] ?>">
                                                    <?php
                                                    if ( @$prediction_data['image'] == "" ) {
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
                                                    <div class="" style="height:90px; background:url(<?= @$prediction_data['image'] ?>) center center no-repeat;background-size:contain;"></div>
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
                                        if ( @$prediction_data['is_published'] == 1 ) {
                                            $checked = 'checked=""';
                                        } else {
                                            $checked = '';
                                        }
                                        ?>
                                        <label><input type="checkbox" name="is_published" value="1" <?= $checked;?>><span class="lever switch-col-bluenew"></span></label>
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 align-center">
                                    <button id="addelection" type="submit" class="btn btn-primary waves-effect"><?php echo (!empty($prediction_id))?'SAVE CHANGES':'SUBMIT';?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/adapters/jquery.js"></script>


<script type="text/javascript">
    $(function () {

    /* $("#topic_id").change();*/
         $(".select2").select2({
              width: 'resolve',
              
          });


         var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;

            $('#search_games').on('keyup', function () {

            var topic = $(this).val();
            var topic_id = $('#topic_id').val();

            if (topic && topic.length >= 2 ) {
                $('.searched_topics').html('');
                    //alert(data);
                    $.ajax({
                        url: "<?php echo base_url();?>Predictions/fetchdata",
                        method: "POST",
                        data: {p_category: topic, game_id: JSON.stringify(selectedTopicId),topic_id:topic_id},
                        dataType: "text",
                        success: function (data)
                        {

                           //console.log(data);
                            $('.searched_topics').append('');
                            var data1 = JSON.parse(data);
                            console.log(data1);
                            var addDivData = "";
                            //addDivData += '<ul class="suggestions">';
                            $.each(data1, function (index, item) {
                                /*console.log(value.id);
                                console.log(value.text);*/
                                // addDivData += "<li data-sug-id='" + item.id + "' data-sug-name='"+ item.topic +"'>" + item.topic + "</li>";
                                //$('#result').append(option);
                                $('.searched_topics').append($("<div>", {class: "col-sm-12"})
                                    .append($("<a />", {class: "foundtopic nav-link", href: "#", "data-id": item.id, "data-name": item.title}).html(item.title)
                                ));

                            });
                            //addDivData += '</ul>';

                            //$('.searched_topics').html(addDivData);
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
            .append('<input type="hidden" name="game_id[]" value="' + $(this).attr('data-id') + '" data-id="' + $(this).attr('data-id') + '">' + $(this).attr('data-name'))
            .append($("<i>", {class: "cancel", style: "cursor:pointer"}).html('&nbsp; &times;')
                )

            $(this).closest('.searched_topics').parent();
            $('.selected_topics').show();
            $('.selected_topics .row').append(selected);
            $("#search_games").val('').trigger("keyup");
            $("#is_topic_change").val('1');
            selectedTopicId.push(addId);
            $(".error-topics").html('');
        });

          $(document).on('click', '.selected_topics .cancel', function (e) {
            $(this).closest('.selected-topic').remove();
            var index = selectedTopicId.indexOf($(this).prev().attr('data-id'));
            console.log(index);
            if (index > -1) {
                selectedTopicId.splice(index, 1);
                $("#is_topic_change").val('1');
            }
        });


        $('.start_time').datetimepicker({
            format: 'LT'
        });


        $('#fpt_start_time').datetimepicker({
            format: 'LT'
        });

        $('.end_time').datetimepicker({
            format: 'LT'
        });


        $('#fpt_end_time').datetimepicker({
             format: 'LT'
        });

       /* $('#btnttimePicker').click(function(){
            $('.fpt_end_time').datetimepicker({
                format: 'LT' 
            });
        })*/

        $('#btnttimePicker').click(function () {
                    $('.fpt_end_time').datetimepicker('show');
        });

        

        <?php
            if ( $prediction_id == 0 ) {
                ?>
                $('.start_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                    
                });

                 $('#btnPicker').click(function () {
                    $('.start_datetimepicker').datetimepicker('show');
                });

                $(".start_datetimepicker").on("dp.change", function (e) {
                    $('.end_datetimepicker').data("DateTimePicker").minDate(e.date);
                });

                $(".start_datetimepicker").on("dp.change", function (e) {
                    $('.fpt_end_date').data("DateTimePicker").minDate(e.date);
                });

                $('.fpt_start_date').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                   
                });

                
                $('.fpt_end_date').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                 
                });



                $('.end_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                    
                });


                $('#end_btnPicker').click(function () {
                    $('.end_datetimepicker').datetimepicker('show');
                });

                $(".end_datetimepicker").on("dp.change", function (e) {
                    $('.start_datetimepicker').data("DateTimePicker").maxDate(e.date);
                });

            <?php
            } else { ?>

                $('.start_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                   
                });

                $('#btnPicker').click(function () {
                    $('.start_datetimepicker').datetimepicker('show');
                });

                $(".start_datetimepicker").on("dp.change", function (e) {
                    $('.end_datetimepicker').data("DateTimePicker").minDate(e.date);
                });

                $('.fpt_start_date').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    
                });

                $('.fpt_end_date').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                   
                });

                $('.end_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    
                });


                $('#end_btnPicker').click(function () {
                    $('.end_datetimepicker').datetimepicker('show');
                });

                $(".end_datetimepicker").on("dp.change", function (e) {
                    $('.start_datetimepicker').data("DateTimePicker").maxDate(e.date);
                });


               
             <?php } ?>

            //when change end date or average
            $("#average").on("change", function (e) {
                $("#only_avg_change").val("1");
            });

            $("#poll_detail_change").on("change", function (e) {
                $("#only_poll_detail_change").val("1");
            });



            //image file change function 
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


           /* CKEDITOR.on('instanceReady', function (evt) {
                var editor = evt.editor;
                editor.on('focus', function (e) {
                    $('.error').html('');
                });
            });
            
            CKEDITOR.replace('description');*/


         });


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function decimalCheck() {
    var dec = document.getElementById('average').value;
    if (dec.includes(".")) {
        var res = dec.substring(dec.indexOf(".") + 1);
        var kl = res.split("");
        if (kl.length > 1) {
            document.getElementById('average').value = (parseInt(dec * 100) /
                100).toFixed(2);
        }
    }
}

function isNumberKey(evt)
{
    var flag = 0;
    var txtVal = $('#average').val();
    var decimalSeparator = ".";
    var val = "" + txtVal;
    if (val.indexOf(decimalSeparator) < val.length - 3)
    {
        return false;
                //alert("too much decimal");
            }

            if (txtVal > 99) {
                return false;
            }
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                if (charCode != 46) {
                    return false;
                }
                if (charCode == 46 && flag == 1) {
                    return false;
                }
                return true;
            }
//      




        $(document).ready(function () {
            $("form#addUpdatePrediction").on("submit", function (e) {

                e.preventDefault();
                var err = [];
                var start_date = $('#start_date').val();
                start_date_split = start_date.split("-");
                var newstartDate = start_date_split[1]+","+start_date_split[0]+","+start_date_split[2];
                start_stamp = new Date(newstartDate).getTime();


                var end_date = $('#end_date').val();
                end_date_split = end_date.split("-");
                var newendDate = end_date_split[1]+","+end_date_split[0]+","+end_date_split[2];
                end_stamp = new Date(newendDate).getTime();



                var start_time = $('#start_time').val();
                var end_time = $('#end_time').val();


                var fpt_end_date = $('#fpt_end_date').val();
                fptend_date_split = fpt_end_date.split("-");
                var newfptDate = fptend_date_split[1]+","+fptend_date_split[0]+","+fptend_date_split[2];
                fpt_end_stamp = new Date(newfptDate).getTime();




                if(start_stamp == end_stamp && start_time == end_time){

                    $('.end_timeErr').text('Invalid End Time').css("color","#f44336");
                        
                    }else if(start_stamp > end_stamp){
                        $('.start_dateErr').text('Invalid Start date').css("color","#f44336");
                        $('#start').addClass('error');
                        
                    }else if(fpt_end_stamp < start_stamp || fpt_end_stamp > end_stamp){
                        $('.fpt_end_dateErr').text('Invalid Fpt End Date').css("color","#f44336");
                        $('#fpt').addClass('error');


                    }else{  


                    var formdata = new FormData(this);
                    console.log(formdata);
                    showloader();
                    ajax_call_multipart("<?php echo base_url(); ?>Predictions/create_update", "POST", formdata, function (result) {
                    hideloader();
                    data = JSON.parse(result);
                    console.log(data);
                    if (data.status == 'failure') {

                                if (data.error.title != '') {
                                    err.push('titleErr');
                                    $('.titleErr').text(data.error.title).css("color","#f44336");
                                }else if (data.error.price != '') {
                                    err.push('priceErr');
                                    $('.priceErr').text(data.error.price).css("color","#f44336");
                                }else if (data.error.meta_keywords != ''){
                                     err.push('meta_keywordsErr');
                                    $('.meta_keywordsErr').text(data.error.meta_keywords).css("color","#f44336");
                                }else if (data.error.meta_description != ''){
                                     err.push('meta_descriptionErr');
                                    $('.meta_descriptionErr').text(data.error.meta_description).css("color","#f44336");
                                    
                                }else{}

                            }else{

                                showToast(data.toast_message, '1');
                                setTimeout(function () {
                                    window.location.assign("lists");
                                }, 2000);
                                
                            }
                    });

                }
            });
        });



    function showloader() {
                $('.loading').css({"display": 'flex'});
                $('body').css({'height': "100vh", 'overflow': "hidden"});
            }


    function hideloader() {
                $('.loading').fadeOut(800);
                $('body').css({'height': "100vh", 'overflow': "auto"});
            }







</script>
