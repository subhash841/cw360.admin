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
                            Predictions List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                            </li>
                            <li class="dropdown">
                                <!-- <form name="export" id="export" method="POST" action="export_polls">
                                    <button type="submit" class="btn btn-danger waves-effect m-r-20">Export</button>
                                </form> -->
                                <button type="submit" id="export_prediction_excel" class="btn btn-danger waves-effect m-r-20">Export to Excel</button>
                            </li>
                        </ul>
                    </div>

                    <!-- Filter -->
                    <div style="border: none; padding: 20px 30px">
                        <div class="collapse" id="collapseFilter" aria-expanded="false">
                            <form id="filterForm" method="POST">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control select2" name="game_id" id="game_id" select2>
                                                    <option value="">--Select Games--</option>
                                                    <?php
                                                    foreach ($games as $key => $s):
                                                        echo '<option value="' . $s['id'] . '">' . $s['title'] . '</option>';
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="title" id="title" maxlength="30" value="">
                                                <label class="form-label">Predictions</label>
                                            </div>
                                        </div>
                                    </div>
                        <!--             <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="poll_desc" id="poll_desc" maxlength="75" value="">
                                                <label class="form-label">Description</label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="poll_cat" id="poll_cat" maxlength="75" value="">
                                                <label class="form-label">Category</label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="input-group date" id="from_datetimepicker">
                                                <div class="form-line">
                                                    <input type="text" class="form-control start_date" name="start_date" id="start_date" readonly="readonly" value="" style="background-color: transparent;">
                                                    <label class="form-label">Start Date</label>
                                                </div>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar" id="btnPicker"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="input-group date" id="to_datetimepicker">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="end_date" id="end_date" readonly="readonly" value="" style="background-color: transparent;">
                                                    <label class="form-label">End Date</label>
                                                </div>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar" id="end_btnPicker"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="offSet" id="offSet" readonly="readonly" value="0" style="background-color: transparent;">
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 align-center">
                                        <button type="submit" class="btn btn-danger waves-effect" id="filterapply">APPLY FILTER</button>
                                        <button type="submit" class="btn btn-danger waves-effect" id="filterclear">CLEAR FILTER</button>
                                    </div>
                                </div>
                            </form>
                        </div>    
                    </div>
                    <!-- End Filter -->
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th># Id</th>
                                        <!--<th>Category</th>-->
                                        <th class="text-center">Game</th>
                                        <th>Prediction</th>
                                        <th>Start Date</th>
                                        <th class="text-center">End Date</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Prediction Status</th>
                                        <th class="text-center">Agreed Count</th>
                                        <th class="text-center">Disagreed Count</th>
                                        <th class="text-center">Is Published</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="records">

                                    <?php
                                    if(!empty($predictions)){
                                        foreach ($predictions as $key => $value) {
                                        $value = str_replace(array( '\''), "&#8217;", $value);
                                    


                                        $ispublished = ($value[ 'is_published' ] == 1) ? "checked" : "";
                                          if($value[ 'wrong_prediction' ] == "1" && $value['prediction_executed']=='1'){ 

                                            $status="Wrong"; 

                                        }else if($value[ 'wrong_prediction' ] == "0" && $value['prediction_executed']=='1'){

                                            $status="Right" ;

                                        }else{
                                            $status="Pending";
                                        } 

                                        $prediction_id_exist = check_data_in_used('prediction_id',$value['id'],'executed_predictions');
                                        if($prediction_id_exist > 0){

                                            $disabled = "disabled =''";
                                            $class = "invalid";

                                        }else{

                                            $class = "changeactivepred";
                                            $disabled = "";
                                        }


                                        ?>
                                        <tr>
                                            <td><?php echo $value['id'] ?></td>
                                            <td><?php echo $value['games'] ?></td>
                                            <td><p class="multiline-ellipsis" data-lines="1"><?php echo $value['title']; ?></p></td>
                                            <td><p class="multiline-ellipsis" data-lines="3"><?php echo  date( "d-m-Y", strtotime( $value[ 'start_date' ] ) ) ?></p></td>
                                            <td class="text-center"><?php echo  date( "d-m-Y", strtotime( $value[ 'end_date' ] ) ) ?></td>
                                            <td class="text-center"><?php echo $value['price']; ?></td>
                                            <td class="text-center"><?php echo $status; ?></td>                                            
                                            <td class="text-center"><?php echo $value['agreed']; ?></td>                                            
                                            <td class="text-center"><?php echo $value['disagreed']; ?></td> 
                                            <td class="text-center">
                                                <a class="switch changepublishprediction" data-id="<?= @$value[ 'id' ];?>" data-type=games data-status="<?= @$value[ 'is_published' ];?>" >
                                                    <label><input type="checkbox" <?= @$ispublished;?>><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                            </td> 
                                            <td class="text-center">
                                                <a href="<?php echo base_url(); ?>Predictions/index?id=<?php echo $value['id'] ?>" title="edit" data-id="<?php echo $value['id'] ?>">
                                                    <i class="material-icons">&#xE254;</i>
                                                </a>&nbsp;&nbsp;&nbsp;


                                                <a href="#" <?= @$disabled;?> data-id="<?=$value['id']?>" data-type="prediction" class="<?= @$class; ?>">
                                                    <i class="material-icons" aria-hidden="true" title="Delete">delete_forever</i></a>


                                                    &nbsp;&nbsp;
                                                    <?php if($value['end_date'] < date('Y-m-d H:i:s') && $value['prediction_executed']=='0'): ?>
                                                        <a href="#"  id="hide_prediction<?= $value['id']; ?>" data-id="<?= $value['id']; ?>" data-togle="tooltip" title="Prediction YES/NO">
                                                            <i class="material-icons" aria-hidden="true" onclick="openmodal_prediction('<?php echo $value['id'] ?>','<?php echo $value['game_id'] ?>','<?php echo htmlspecialchars($value['games']) ?>')">style</i></a>
                                                        <?php endif; ?>                                       
                                            </td>   
                                                </tr>
                                            <?php } } else { 
                                                echo '<tr style="text-align:center;"><td colspan=11>No Predictions are Available</td></tr>';

                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="padding-bottom: 25px;">
                                <center>
                                    <button id="loadlist" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Exportable Table -->
            </div>
        </section>

<!-- <div class="modal fade in" id="viewPollDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> Poll Details</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-success waves-effect btn-approve">Approve</button>
                <button type="button" class="btn btn-link btn-danger waves-effect btn-reject" data-dismiss="modal" data-toggle="modal" data-target="#reject_poll">Reject</button>-->
                <!--<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="modal fade in" id="reject_poll" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> Forecasting</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-success waves-effect btn-approve">Approve</button>
                <button type="button" class="btn btn-link btn-danger waves-effect btn-reject">Reject</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div> -->



<!-- Modal starts-->

<div class="modal fade" id="bonus_points" tabindex="-1" role="dialog" aria-labelledby="bonus_pointsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title header" id="bonus_pointsLabel">Select whether prediction is Right or Wrong</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">

    <form id="prediction_result_form">
        <div class="row  align-items-center justify-content-center mx-auto">
            <div class="col text-center border-right d-flex justify-content-center"> 
                <input type="radio" name="radAnswer" value="yes" id="radio_1">
                <label for="radio_1">Right</label>             
            </div>
            <div class="col text-center d-flex justify-content-center">
                <input type="radio" name="radAnswer" value="no" id="radio_2">
                <label for="radio_2">Wrong</label>

            </div>
            <input type="hidden" name="game_id" id="input_game_id">
            <input type="hidden" name="prediction_id" id="input_prediction_id">
            <input type="hidden" name="game_name" id="input_game_name">

        </div>
    </form>
</div>
<span class="text-danger text-center" id="err_radio"></span>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="prediction_submit">Submit</button>
</div>
</div>
</div>
</div>
<!-- Modal ends-->

<script type="text/javascript">

    function openmodal_prediction(prediction_id, game_id, game_name) {
        $('#input_game_id').val(game_id);
        $('#input_prediction_id').val(prediction_id);
        $('#input_game_name').val(game_name);
        $('#bonus_points').modal('show');

    }

    $("#prediction_submit").on("click", function () {
        is_selected = $("input[name='radAnswer']:checked").val();


        if (typeof is_selected=='undefined') {
            $('#err_radio').text('Please select Right or Wrong');
        }else{
            _this = $(this);
            confirm_msg = confirm("Are you sure you want to submit?");
            if (confirm_msg) {

                var formData = $('#prediction_result_form').serializeArray();
                formData.push({name: 'prediction_result', value: is_selected});

                $.ajax({
                    url: base_url + 'predictions/prediction_result',
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON', 
                    success: function(result){
                        if (result.status==true) {
                            $('#bonus_points').modal('hide');
                            id = $('#input_prediction_id').val();
                            $("#hide_prediction" + id).hide();
                        //location.reload();
                        // console.log(result)
                    }else{
                        alert('Something went wrong!');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });    
            }
        }

    });


</script>>

<script type="text/javascript">
    $(function () {
        var placeholder = "select Game";
        $(".select2").select2({
         placeholder: placeholder,
         width: '100%',
     });



        $('#start_timepicker').datetimepicker({
            format: 'LT'
        });

        $('#btnPicker').click(function () {
            $('#start_date').datetimepicker('show');
        });



        $('#end_timepicker').datetimepicker({
            format: 'LT'
        });

        $('#end_btnPicker').click(function () {
            $('#end_date').datetimepicker('show');
        });


        $('#start_date').datetimepicker({
            useCurrent: false,
            format: "DD-MM-YYYY",
            ignoreReadonly: true
        });

        $('#end_date').datetimepicker({
            useCurrent: false,
            format: "DD-MM-YYYY",
            ignoreReadonly: true
        });

        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });

        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
        });




        $(document).on('click', '.invalid', function (e) {
            showToast('Action Disabled as Prediction is Live','0');
        });



             //Active - Inactive Prediction
            $(document).on('click', '.changeactivepred', function (e) {
                var result = confirm("Want to delete?");
                if(result){
                    showloader();
                    var prediction_id = $(this).attr('data-id');
                    var type = $(this).attr('data-type');
                    var status = $(this).attr('data-status');
                    if (type != "") {

                        var param = {prediction_id: prediction_id, type: type, current: status};
                        console.log(param);
                        ajax_call('Predictions/active_inactive_prediction', "POST", param, function (result) {
                            console.log(result);
                            result = JSON.parse(result);
                            if (result['status']) {
                                hideloader();
                                $("#response_message").html('<div class="btn-lg bg-green">Prediction Successfully Deleted</div>').fadeIn(2000).delay(1000).fadeOut(2000);
                                setTimeout(function () {
                                    window.location.assign("lists");
                                }, 2000);
                            } else {
                                hideloader();
                                showToast(result['message'], '0');
                                setTimeout(function () {
                                    window.location.assign("lists");
                                }, 2000);
                            }
                        });
                    }    
                }
                
            });






             $(".edit-election").on("click", function (event) {
                event.preventDefault();
                var json = JSON.parse($(this).attr("data-editjson"));
                var base = "form[name='addUpdateElectionPeriod'] ";
                $(base + "#election_period_id").val(json.id);
                $(base + "#from_date").val(convertDate(json.from_date)).focus();
                $(base + "#to_date").val(convertDate(json.to_date)).focus();
                $(base + '#state_id').find("option[value='" + json.state_id + "']").prop("selected", "selected");
                $(base + '#total_seats').val(json.total_seats).focus();
                var selected = json.party_id.split(',');
                for (var x in selected) {
                    $(base + "select#optgroup").find("option[value='" + selected[x] + "']").prop("selected", "selected");
                }
                $('#optgroup').multiSelect();

                $('#state_id').selectpicker('refresh');
            });


             $('#filterForm').submit(function(e){
                e.preventDefault();
                var data = $( '#filterForm' ).serialize();
                //data += '&paging=20';
                // alert(data);
                var output = function(cb){
                    $('.records').html(cb);
                    
                };
                ajax_call('Predictions/filteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 10);
            });

             $('#loadlist').click(function(){
                var offSet = $(this).attr('data-offSet');
                // alert('Loading... '+offSet);

                var data = $('#filterForm').serialize();
                data += '&offSet=' +offSet;
                 // alert(data);
                 var output = function(cb){
                    if (cb != "") {
                        $('.records').append(cb);
                    } else {
                        $('#loadlist').attr('disabled', true);
                    }
                };
                ajax_call('Predictions/filteredList', 'POST', data, output);
                offSet = parseInt(offSet, 10);
                offSet = offSet+10;
                $(this).attr('data-offSet', offSet);

            });

             $('#filterclear').click(function(){
                // alert('Clear... ');
                $('#game_id').val(null).trigger('change');
                $("#filterForm").trigger('reset');
            });


             $('#export_prediction_excel').click(function(){
                var query = '';
                var req_url = 'exportList_prediction';

                if ($('#game_id').val() != "") {
                    query += 'game_id=' + $('#game_id').val() + '&';
                }
                
                if ($('#title').val() != "") {
                    query += 'title=' + $('#title').val() + '&';
                }
                if ($('#start_date').val() != "") {
                    query += 'start_date=' + $('#start_date').val() + '&';
                }
                if ($('#end_date').val() != "") {
                    query += 'end_date=' + $('#end_date').val();
                }

                if (query.charAt(query.length-1) == '&') {
                    query = query.slice(0, -1);
                }
                if (query != "") {
                    req_url = req_url + '?' + query;
                }
                //alert(req_url);
                window.location.assign(req_url);

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
