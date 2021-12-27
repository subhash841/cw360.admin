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
                 $game_id = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                 $start_time  =  (@$start_time == "") ? "" : date("H:i:s", strtotime(@$start_date));
                 $end_time = (@$end_time == "") ? "" : date("H:i:s", strtotime(@$end_date));
                 $end_date = (@$end_date == "") ? "" : date( "d-m-Y", strtotime( @$end_date ) );
                 $start_date = (@$start_date == "") ? "" : date( "d-m-Y", strtotime( @$start_date ) );

                 ?>
                 <div class="header">
                    <h2>
                        <?php echo (!empty($game_id))?'Edit':'Create';?>  Game
                    </h2>
                </div>
                <div class="body">
                    <form name="addUpdateGame" id="addUpdateGame" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <!--action=create_update-->
                        <input type="hidden" name="game_id" id="game_id" value="<?= $game_id ?>">
                        <input type="hidden" name="is_reward_change" id="is_reward_change" value="0">
                        <div class="row">

                           <!-- <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control select2" name="topics[]" id="topics" required select2 multiple="multiple"> 
                                           <?php 
                                           foreach ($topics as $key => $t):
                                            if(in_array($t['id'], explode(',', $topic_id))) {$selected='selected'; }else{ $selected=''; }
                                            echo '<option value="' . $t['id'] . '" '.$selected.'>' . $t['topic'] . '</option>';
                                        endforeach;
                                        ?> 
                                    </select>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control select2" name="topics[]" id="topics" required select2> 
                                           <?php 
                                           foreach ($topics as $key => $t):
                                            if(in_array($t['id'], explode(',', $topic_id))) {$selected='selected'; }else{ $selected=''; }
                                            echo '<option value="' . $t['id'] . '" '.$selected.'>' . $t['topic'] . '</option>';
                                        endforeach;
                                        ?> 
                                    </select>
                                </div>
                            </div>
                        </div>



                         
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" name="max_players" id="max_players"  maxlength="50" required="" value="<?= @$max_players ?>" aria-required="true">                                            
                                    <label class="form-label">Max Players</label>
                                </div>
                                <strong><small class="text-danger max_playersErr"></small></strong>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" name="title" id="title"  maxlength="40" required="" value="<?=
                                    htmlspecialchars(@$title); ?>" aria-required="true">                                            
                                    <label class="form-label">Title</label>
                                </div>
                                <strong><small class="text-danger titleErr"></small></strong>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" required="" name="req_game_points" id="req_game_points"   value="<?= @$req_game_points ?>" oninput="this.value = this.value.replace(/[^0-9.]|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Required Game Coins</label>
                                    <strong><small class="text-danger req_game_pointsErr"></small></strong>
                                </div>
                            </div>
                        </div>

                       <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" required="" name="change_prediction_time" id="change_prediction_time" value="<?= @$change_prediction_time ?>" oninput="this.value = this.value.replace(/[^0-9.]|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">
                                    <label class="form-label">Change Prediction Time Minutes</label>
                                </div>
                                    <strong><small class="text-danger change_prediction_timekErr"></small></strong>
                            </div>
                        </div>

<!--Below game points are initial portfolio points of user,display after User entered in prediction  -->
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" required="" name="initial_game_points" id="initial_game_points"   value="<?= @$initial_game_points ?>" oninput="this.value = this.value.replace(/[^0-9.]|^0+|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Initial Game Coins</label>
                                    <strong><small class="text-danger initial_game_pointsErr"></small></strong>
                                </div>
                            </div>
                        </div>
                        <?php if($game_id > 100 || $game_id==0){  ?>       
                       <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" required="" name="coin_transfer_limit" id="coin_transfer_limit"   value="<?= @$coin_transfer_limit ?>" oninput="this.value = this.value.replace(/[^0-9.]|^0+|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Coin Transfer Limit</label>
                                    <strong><small class="text-danger"></small></strong>
                                </div>
                            </div>
                        </div>
                     
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" required="" name="point_value_per_coin" id="point_value_per_coin"   value="<?= @$point_value_per_coin ?>" oninput="this.value = this.value.replace(/[^0-9.]|\s/g, '').replace(/(\*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Point Value Per Coin</label>
                                </div>
                                    <strong><small class="text-danger point_value_per_coinErr"></small></strong>
                            </div>
                        </div> 
                                    <?php } ?>

                    </div>
                    <?php if($game_id > 268 || $game_id==0){  ?>       
                        <div class="row">
                        <label class="form-label m-l-15">Game Bonus & Deduct Coins</label><br><br>
                        <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" required="" name="bonus_point_yes_right" id="bonus_point_yes_right"   value="<?= !empty(@$bonus_point_yes_right)? @$bonus_point_yes_right : '50'; ?>" oninput="this.value = this.value.replace(/[^0-9.]|^0+|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Bonus Coins Yes Right</label>
                                    <strong><small class="text-danger"></small></strong>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" required="" name="deduct_point_yes_wrong" id="deduct_point_yes_wrong"   value="<?= @$deduct_point_yes_wrong ?>" oninput="this.value = this.value.replace(/[^0-9.]|^0+|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Deduct Point Yes Wrong</label>
                                    <strong><small class="text-danger"></small></strong>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" required="" name="bonus_point_no_wrong" id="bonus_point_no_wrong"   value="<?= !empty(@$bonus_point_no_wrong) ? @$bonus_point_no_wrong :'50' ?>" oninput="this.value = this.value.replace(/[^0-9.]|^0+|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Bonus Coins No Wrong</label>
                                    <strong><small class="text-danger"></small></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" required="" name="deduct_point_no_right" id="deduct_point_no_right"   value="<?= !empty(@$deduct_point_no_right) ? @$deduct_point_no_right : '50' ?>" oninput="this.value = this.value.replace(/[^0-9.]|^0+|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Deduct Coins No Right</label>
                                    <strong><small class="text-danger"></small></strong>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <label class="form-label m-l-15">Game Rewards</label><br><br>
                        <div class="col-sm-12">


                           <div class="row add-more-choices">
                                <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="reward_description[]" id="choice1" required="" maxlength="35" placeholder="Enter Description" value="<?= @htmlspecialchars($reward[ 0 ][ 'description' ]) ?>" aria-required="true">
                                            <!--<label class="form-label">Choice 1</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="remove-survey-choices delete_choice display-delete">×</div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control " name="price[]" id="choice2" required="" maxlength="35" placeholder="Enter Prize" value="<?= @htmlspecialchars($reward[0][ 'price' ]) ?>" aria-required="true">
                                            <!--<label class="form-label">Choice 2</label>-->
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <?php
                                $other_fields = 0;
                                if ( count( @$reward ) > 1 ) {
                                        /*$other_fields = count( @$reward ) - 4;
                                        unset( $reward[ count( @$reward ) - 1 ] );
                                        unset( $reward[ count( @$reward ) - 1 ] );*/
                                        foreach ( @$reward as $key => $ch ) {
                                                /*if ( $key <= 1 ) {
                                                        continue;
                                                }*/
                                                if($key>0){
                                                     echo '<div class="col-sm-12">
                                                    <div class="col-sm-6">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="reward_description[]" id="choice1" required="" maxlength="35" placeholder="Enter Description" value="' . $ch[ 'description' ] . '" aria-required="true">
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="remove-survey-choices delete_choice">×</div>
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="price[]" id="choice2" required="" maxlength="35" placeholder="Enter Prize" value="' . $ch[ 'price' ] . '" aria-required="true">
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>';

                                                }
                                               
                                        }
                                }
                                ?>
                            </div>
                            <button type="button" class="btn btn-primary waves-effect add-survey-choices">Add Reward</button>
                        </div>


                        
                        <div class="col-sm-12 mt-2">
                            <div class="form-group">
                                <label class="form-label">Rules & Updates</label>
                                <div class="form-line form-float">
                                    <textarea rows="4" class="form-control no-resize poll_detail_change"  name="description" id="description"  placeholder="Rules & Updates"><?= @$description ?></textarea>
                                </div>
                                <small class="text-danger descriptionErr"></small>
                            </div>

                            <!--          <?= @htmlspecialchars_decode( $preview ) ?> -->
                        </div>
                        

                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="input-group date">
                                    <div class="form-line">
                                        <input type="text" class="form-control start_datetimepicker" required="" name="start_date" id="start_date"   value="<?= $start_date ?>" style="background-color: transparent;" aria-required="true">
                                        <label class="form-label">Start Date<strong><small class="text-danger start_dateErr"></small></strong></label>
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
                                        <input type="text" class="form-control end_datetimepicker" name="end_date" id="end_date"   required="" value="<?= $end_date ?>" style="background-color: transparent;" aria-required="true">
                                        <label class="form-label">End Date<strong><small class="text-danger end_dateErr"></small></strong></label>
                                    </div>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar" id="end_btnPicker"></span>
                                    </span>
                                </div>
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
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date" >
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

                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" required="" name="meta_keywords" id="meta_keywords"  maxlength="300" value="<?= @$meta_keywords ?>" aria-required="true">                                            
                                    <label class="form-label">Meta Keywords</label>
                                </div>
                                <small class="text-danger meta_keywordsErr"></small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" required="" name="meta_description" id="meta_description"  maxlength="300" value="<?= @$meta_description ?>" aria-required="true">                                            
                                    <label class="form-label">Meta Description</label>
                                </div>
                                <small class="text-danger meta_descriptionErr"></small>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input type="text" id="uploadFile" name="uploaded_filename"  placeholder="Choose Game Image" readonly="readonly" value="<?= @$image ?>">
                                        <?php
                                        if ( @$image == "" ) {
                                            $required = 'required=""';
                                        } else {
                                            $required = '';
                                        }
                                        ?>
                                        <div class="fileUpload btn btn-primary">
                                            <span>Choose image</span>
                                            <input id="uploadBtn" name="poll_img"  type="file" class="upload" <?= $required ?> aria-required="true">
                                        </div>
                                        <br>
                                        <i class="small">File size should be less than 1 MB and dimension should be minimum 200*200</i>
                                    </div>
                                    
                                    <div class="col-sm-3 uploaded-img-preview">
                                    <div class="" style="height:90px; background:url(<?= @$image ?>) center center no-repeat;background-size:contain;"></div>
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
                            if ( @$is_published == 1 ) {
                                $checked = 'checked=""';
                            } else {
                                $checked = '';
                            }
                            ?>
                            <label><input type="checkbox" name="is_published" id="is_published" value="1" <?= $checked;?>><span class="lever switch-col-bluenew"></span></label>
                        </a>
                    </div>


                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <button id="addelection" type="submit" class="btn btn-primary waves-effect"><?php echo (!empty($game_id))?'SAVE CHANGES':'SUBMIT';?> </button>
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
        var placeholder = "Select Topics";
        $(".select2").select2({
         placeholder: placeholder,
        });

        var i = 3 +<?= $other_fields ?>;
        var fields = '';

        //Condition to display remove polls
        if (i > 3) {
                $('.add-more-choices div:nth-child(1), .add-more-choices div:nth-child(2)').find('.remove-poll-choices').removeClass('display-delete');
        }

            //Add new Choices
            $(".add-survey-choices").on("click", function () {
                if(i == 11){
                    $('.add-survey-choices').attr("disabled",true);
                }
                if (i < 11) {
                    fields = '<div class="col-sm-12">\
                    <div class="col-sm-6">\
                <div class="form-group form-float">\
                    <div class="form-line">\
                        <input type="text" class="form-control" name="reward_description[]" id="choice1" required="" maxlength="35"  placeholder="Enter Description" value="" aria-required="true">\
                    </div>\
                </div>\
            </div>\
            <div class="col-sm-6">\
            <div class="remove-survey-choices delete_choice">×</div>\
                                    <div class="form-group form-float">\
                                        <div class="form-line">\
                                            <input type="text" class="form-control" name="price[]" id="choice2" required="" maxlength="35" placeholder="Enter Prize" aria-required="true">\
                                        </div>\
                                    </div>\
            </div></div>';


                    $(".add-more-choices").append(fields);
                    $("#is_reward_change").val('1');
                    i++;
                }
            });





            //Remove new Choices
            $(document).on("click", ".remove-survey-choices", function () {
                console.log(i);
                $(this).closest("div.col-sm-12").remove();
                $("#is_reward_change").val('1');
                i--;
                /*if (i == 3) {
                    $('.add-more-choices div:nth-child(1), .add-more-choices div:nth-child(2)').find('.remove-survey-choices').addClass('display-delete');
                }*/
            });


            //Remove new Choices
            $(document).on("click", ".remove-poll-choices", function () {
                console.log(i);
                $("#only_poll_detail_change").val("1");
                $(this).closest("div.col-sm-6").remove();
                i--;
                if (i == 3) {
                    $('.add-more-choices div:nth-child(1), .add-more-choices div:nth-child(2)').find('.remove-poll-choices').addClass('display-delete');
                }
            });

            $('#weekly_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                ignoreReadonly: true
            });
            
            $('#from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });
            $('#to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });

            $('.start_time').datetimepicker({
                format: 'LT'
            });

            $('.end_time').datetimepicker({
                format: 'LT'
            });



            <?php
            if ( $game_id == 0 ) {
                ?>
                $('.start_datetimepicker').datetimepicker({

                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                    ignoreReadonly: true
                });

                $('#btnPicker').click(function () {
                    $('.start_datetimepicker').datetimepicker('show');
                });

                $(".start_datetimepicker").on("dp.change", function (e) {
                    $('.end_datetimepicker').data("DateTimePicker").minDate(e.date);
                });

                $('.end_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                    ignoreReadonly: true
                });
                
                $('#end_btnPicker').click(function () {
                    $('.end_datetimepicker').datetimepicker('show');
                });

                $(".end_datetimepicker").on("dp.change", function (e) {
                    $('.start_datetimepicker').data("DateTimePicker").maxDate(e.date);
                });


                <?php
            } else {
                ?>
                $('.start_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    ignoreReadonly: true
                });

                $('#btnPicker').click(function () {
                    $('.start_datetimepicker').datetimepicker('show');
                });

                $(".start_datetimepicker").on("dp.change", function (e) {
                    $('.end_datetimepicker').data("DateTimePicker").minDate(e.date);
                });

                $('.end_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    ignoreReadonly: true
                });
                
                $('#end_btnPicker').click(function () {
                    $('.end_datetimepicker').datetimepicker('show');
                });

                $(".end_datetimepicker").on("dp.change", function (e) {
                    $('.start_datetimepicker').data("DateTimePicker").maxDate(e.date);
                });


                $(".add-more-choices input").focus(function() { 
                        $("#is_reward_change").val('1');
                }); 

             <?php } ?>


            //check end date change
            /*$("#end_datetimepicker").on("dp.change", function (e) {
                $("#only_end_date_change").val("1");
            });
            */
            //submit add update poll form
            /*$("#addUpdatePoll").on("submit", function (e) {
                var end_date = $("#end_date").val();
                if (end_date == "") {
                    e.preventDefault();
                    showToast("Please select end date", '0');
                }
            });*/

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
                //console.log(img_valid);
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
                
                //var filename = $(this).val();
                //filename = filename.replace(/\\/g, '/').replace(/.*\//, '');
            });



            CKEDITOR.tools.callFunction(1, this);
            CKEDITOR.plugins.addExternal('simpleImageUpload', '<?php echo base_url();?>assets/ckeditor/plugins/simpleImageUpload/', 'plugin.js');

            CKEDITOR.on('instanceReady', function (evt) {
                var editor = evt.editor;
                editor.on('focus', function (e) {
                    $('.error').html('');
                });
            });

            
            CKEDITOR.replace('description',{
                uploadUrl: "https://imgupload.crowdwisdom.co.in",
                removeButtons: "EasyImageUpload",
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


            /*CKEDITOR.replace('reward',{
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
            });*/




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

$(document).on('keyup', '#average', function (evt) {
    var txtVal = $(this).val();
    //console.log(txtVal);
    if (parseFloat(txtVal) > 100) {
                //$(this).val('');
            }

        });



$(document).ready(function () {

    var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;
    //console.log(selectedTopicId);
    $('#search_topics').on('keyup', function () {

        var topic = $(this).val();
        console.log(topic.length);

        if (topic && topic.length >= 2) {
            $('.searched_topics').html('');
                    //alert(data);
                    $.ajax({
                        url: "<?php echo base_url();?>/Games/fetchdata",
                        method: "POST",
                        data: {p_category: topic, topic_id: JSON.stringify(selectedTopicId)},
                        dataType: "text",
                        success: function (data)
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
                                $('.searched_topics').append($("<div>", {class: "col-sm-12"})
                                    .append($("<a />", {class: "foundtopic nav-link", href: "#", "data-id": item.id, "data-name": item.topic}).html(item.topic)

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
                    $("#is_reward_change").val('1');
                }
            });



            $("form#addUpdateGame").on("submit", function (e) {
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
                /*var data = $(this).serialize();*/

                if(start_stamp == end_stamp && start_time == end_time){

                    $('.end_timeErr').text('Invalid End Time').css("color","#f44336");
                        
                }else if(start_stamp > end_stamp){

                    $('.start_dateErr').text('Invalid Start Date').css("color","#f44336");

                }else{

                        var formdata = new FormData(this);
                        showloader();
                        var description = CKEDITOR.instances['description'].getData();
                        /*var reward = CKEDITOR.instances['reward'].getData();*/
                        formdata.append('description', description);
                       /* formdata.append('reward', reward);*/
                        ajax_call_multipart("<?php echo base_url(); ?>Games/create_update", "POST", formdata, function (result) {
                        //result = JSON.parse(result);
                        hideloader();
                        data = JSON.parse(result);
                        //console.log(data);

                        if (data.status == 'failure') {

                            if (data.error.title != '') {
                                err.push('titleErr');
                                $('.titleErr').text(data.error.title).css("color","#f44336");
                            }else if (data.error.description != '') {
                                err.push('descriptionErr');
                                $('.descriptionErr').text(data.error.description).css("color","#f44336");
                            }else if (data.error.meta_description != '') {
                                err.push('meta_descriptionErr');
                                $('.meta_descriptionErr').text(data.error.meta_description).css("color","#f44336");
                            }else if (data.error.meta_keywords != '') {
                                err.push('meta_keywordsErr');
                                $('.meta_keywordsErr').text(data.error.meta_keywords).css("color","#f44336");
                            }else if (data.error.max_players != ''){
                                err.push('max_players');
                                $('.max_playersErr').text(data.error.max_players).css("color","#f44336");
                            }else if (data.error.change_prediction_time != ''){
                                err.push('change_prediction_time');
                                $('.change_prediction_timekErr').text(data.error.change_prediction_time).css("color","#f44336");
                            }else if (data.error.point_value_per_coin != ''){
                                err.push('point_value_per_coin');
                                $('.point_value_per_coinErr').text(data.error.point_value_per_coin).css("color","#f44336");
                            }

                        }else{

                            showToast(data.toast_message, '1');
                            setTimeout(function () {
                                window.location.assign("lists");
                            }, 2000);
                            
                        }

                        
                        });

                }

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

            $(document).on('change', 'input[name="reward_description[]"]', function(){
                $('input[name^="reward_description[]"]').each( function() {
                    var currentrdescriptionValue = this.value.trim();
                    if(currentrdescriptionValue == ""){
                        $(this).val('');
                    }
                });        
            });
            $(document).on('change', 'input[name="price[]"]', function(){
            //$('input[name="price[]"]').change(function(){
                $('input[name^="price[]"]').each( function() {
                    var currentrprizeValue = this.value.trim();
                    if(currentrprizeValue == ""){
                        $(this).val('');
                    }
                });        
            });
        });
    </script>   
