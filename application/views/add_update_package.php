
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Add Package
                        </h2>
                    </div>
                    <div class="body">
                        <?php
                        $packageid = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                        $end_date = (@$end_date == "") ? "" : date( "d-m-Y", strtotime( @$end_date ) );
                        ?>
                        <form name="addUpdatePackage" id="addUpdatePackage" method="POST" action="<?= base_url() ?>Packages/create_update">
                            <input type="hidden" name="package_id" id="package_id" value="<?= $packageid ?>">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-label">Package Name</label>
                                    <div class="form-group form-float">                                        
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="package_name" id="package_name" required="" maxlength="75" aria-required="true" placeholder="Name" value="<?= @$name ?>">
                                            <!--<label class="form-label">Name</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">Winning Reward</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="prize_text" id="prize_text" required=""  aria-required="true" placeholder="Winning Reward Text " value="<?= @$prize_text ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">Winning Rules</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="point_required_text" id="point_required_text" required=""  aria-required="true" placeholder="Winning Rules Text " value="<?= @$point_required_text ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">Reward text</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="reward_text" id="reward_text" required=""  aria-required="true" placeholder="reward text" value="<?= @$reward_text ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">Type: </label>

                                    <input name="package_type" type="radio" id="radio_type_forecast" class="with-gap radio-col-red" required="" disabled="disabled" <?php //if(@$type == "forecast"){ echo 'checked=""'; }       ?>>
                                    <label for="radio_type_forecast">Forecast</label>

                                    <input name="package_type" type="radio" id="radio_type_prediction" class="with-gap radio-col-red" required="" value="prediction" disabled="disabled" checked="checked" <?php //if(@$type != "forecast"){ echo 'checked=""'; }       ?> >
                                    <label for="radio_type_prediction">Prediction</label>

                                    <input name="package_type" type="hidden" value="prediction">

                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">Select Predictions: </label>
                                    <select name="package_content[]" id="Prediction_group" class="ms" multiple="multiple">
                                        <?php
                                        $module_id = 0;
                                        foreach ( $polls as $key => $p ):
                                                foreach ( $package_contents as $key => $pc ):
                                                        if ( $p[ 'id' ] == $pc[ 'module_id' ] ) {
                                                                $module_id = $pc[ 'module_id' ];
                                                                break;
                                                        } else {
                                                                $module_id = 0;
                                                        }
                                                endforeach;
                                                if ( $p[ 'id' ] == $module_id ) {
                                                        echo '<option value="' . $p[ 'id' ] . '" selected>' . $p[ 'poll' ] . '</option>';
                                                } else {
                                                        echo '<option value="' . $p[ 'id' ] . '">' . $p[ 'poll' ] . '</option>';
                                                }
                                        endforeach;
                                        ?>
                                    </select>
                                </div>


                                <div class="col-sm-12">
                                    <label class="form-label">Type: </label>

                                    <input name="package_feature" type="radio" id="radio_type_free" class="with-gap radio-col-red" required="" value="1" <?php
                                    if ( @$price == "0.00" ) {
                                            echo 'checked=""';
                                    }
                                    ?>>
                                    <label for="radio_type_free">Free</label>
                                    <input name="package_feature" type="radio" id="radio_type_premium" class="with-gap radio-col-red" required="" value="2" <?php
                                    if ( @$price != "0.00" ) {
                                            echo 'checked=""';
                                    }
                                    ?>>
                                    
                                    <label for="radio_type_premium">Coins</label>
                                    
                                    <!-- EDITED -->
                                    <input name="package_feature" type="radio" id="radio_type_points" class="with-gap radio-col-red" required="" value="3" <?php if($is_premium == 3){ echo 'checked=""';}?>>
                                    <label for="radio_type_points">Premium</label>
                                </div>


                                <div class="col-sm-6 price-set" <?php
                                if ( @$price == "0.00" ) {
                                        echo 'style="display: none;"';
                                }
                                ?>>
                                    <label class="form-label">Coins: </label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="package_price" id="package_price"  maxlength="10" value="<?= @$price ?>"  placeholder="Coins">
                                            <!--<label class="form-label">Price</label>-->
                                        </div>
                                    </div>
                                </div>


                                <!-- EDITED -->
                                
                                <div class="col-sm-6 points-set" style="display:none;">
                                    <label class="form-label">Price: </label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="premium_price" id="package_points"  maxlength="10" value="<?=@$premium_price ?>"  placeholder="Price in INR">
                                            <!--<label class="form-label">Price</label>-->
                                        </div>
                                    </div>
                                </div>
                            
                                 

                            



                                <div class="col-sm-6">
                                    <label class="form-label">End Date: </label>
                                    <div class="form-group form-float">
                                        <div class="input-group date" id="to_datetimepicker">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="package_end_date" id="package_end_date" readonly="readonly"  required="" value="<?= $end_date ?>" style="background-color: transparent;"/>
                                                <!--<label class="form-label">To Date</label>-->
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="uploadFile" name="uploaded_filename" placeholder="Choose Cover Image" readonly="readonly" value="<?= @$image ?>">
                                                    <?php
                                                    if ( @$image == "" ) {
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
                                                    <div class="" style="height:90px; background:url(<?= @$image ?>) center center no-repeat;background-size:contain;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 align-center">
                                    <button id="addpackage" type="submit" class="btn btn-primary waves-effect">SAVE CHANGES</button>
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
            $('#to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });


            $('#radio_type_forecast').click(function () {
                if ($('#radio_type_forecast').is(':checked')) {
                    var data = $('#radio_type_forecast').val();
                    if (data != "") {
                        $('#Prediction_group').html('');
                        $('#Prediction_group').multiSelect('refresh');
                    }

                } else {
                    $('.price-set').css('display', 'none');
                    

                }
            });

            $("#uploadBtn").on("change", function () {
                var file = $(this)[0].files[0];

                var imageData = new FormData();
                imageData.append('file', file);

                ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                    $("#uploadBtn").closest(".form-group").find("#uploadFile").val(result);
                    $(".uploaded-img-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
                });
                //var filename = $(this).val();
                //filename = filename.replace(/\\/g, '/').replace(/.*\//, '');
            });

            $('#radio_type_prediction').click(function () {
                if ($('#radio_type_prediction').is(':checked')) {
                    var data = $('#radio_type_prediction').val();

                    if (data != "") {
                        $('#Prediction_group').html('');
                        $('#Prediction_group').multiSelect('refresh');
                    }

                    var output = function (cb) {
                        var newData = "";
                        console.log(cb);

                        $.each(JSON.parse(cb), function (i, item) {
                            newData += "<option value=" + item.id + ">" + item.poll + "</option>";
                        })

                        $('#Prediction_group').html(newData);
                        $('#Prediction_group').multiSelect('refresh');

                    };
                    ajax_call('/Packages/get_polls_list', 'POST', data, output);
                } else {

                }
            });
                
            
            $('#radio_type_premium').click(function () {
                if ($('#radio_type_premium').is(':checked')) {
                    $('.price-set').css('display', 'block');
                    $('.points-set').css('display', 'none');
                } else {
                    $('.price-set').css('display', 'none');
                    $('#package_price').val('0.00');
                }
            });


             $('#radio_type_points').click(function () {
                if ($('#radio_type_points').is(':checked')) {
                    $('.points-set').css('display', 'block');
                    $('.price-set').css('display', 'none');
                } else {
                    $('.points-set').css('display', 'none');
                }
            });


            $('#radio_type_free').click(function () {
                if ($('#radio_type_free').is(':checked')) {
                    $('.price-set').css('display', 'none');
                    $('.points-set').css('display', 'none');
                    $('#package_price').val('0.00');
                } else {
                    $('.points-set').css('display', 'block');
                    $('.price-set').css('display', 'block');
                }
            });

            $('#Prediction_group').multiSelect();

        });
</script>
