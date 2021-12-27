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
    .dataTables_filter, .dataTables_info,.buttons-excele,.buttons-html5 { display: none; }

</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                <?php

                ?>
                
                <div class="header">
                    <h2>
                        Add/Deduct Coins
                    </h2>
                    <ul class="header-dropdown m-r-5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" id="addbtn">Add/Deduct</button>
                            </li>
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" id="filterbtn">Filter</button>
                            </li>
                            <?php if(!empty($orders)){ ?>
                            <li class="dropdown">                                
                                <button type="submit" id="export_points_excel" class="btn btn-danger waves-effect m-r-20">Export to Excel</button>
                            </li>
                            <?php } ?>
                    </ul>
                </div>

               


                <div class="body">
                    <div class="collapse" id="collapseFilter" aria-expanded="false">
                    <form name="addUpdatePoint" id="addUpdatePoint" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <!--action=create_update-->
                        <div class="row">

                        <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control select_game select2" name="game_id" id="game_id" select2 required>
                                                    <option value="">--Select Games--</option>
                                                    <?php
                                                        foreach ($games as $key => $s):
                                                            echo '<option value="' . $s['id'] . '">' . $s['title'] . '</option>';
                                                        endforeach;
                                                    ?>
                                                </select>
                                            <strong><small class="text-danger gamesErr error_val"></small></strong>
                                            </div>
                                            
                                        </div>
                        </div>

                        <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control select_pred" name="prediction_id" id="prediction_id" select2 required>
                                                    <option value="">--Select Predictions--</option>
                                                    <?php
                                                        foreach ($predictions as $key => $p):
                                                            echo '<option value="' . $p['id'] . '">' . $p['title'] . '</option>';
                                                        endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                            <strong><small class="text-danger predictionErr error_val"></small></strong>
                                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group form-float">
                                        <div class="form-line">
                                        <select class="form-control" name="action" id="action" required> 
                                        <option value="">Select Action</option> 
                                        <option value="add">Add</option> 
                                        <option value="deduct">Deduct</option> 
                                        </select>
                                        </div>
                                        <strong><small class="text-danger actionErr error_val"></small></strong>
                        </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" name="points" id="points" oninput="this.value = this.value.replace(/[^0-9.]|\.|\s/g, '').replace(/(\..*)\./g, '$1');" required>           
                                    <label class="form-label">Coins</label>
                                    
                                </div>
                                <strong><small class="text-danger pointsErr error_val"></small></strong>
                            </div>
                        </div>

                    </div>

                    

                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <button id="addelection" type="submit" class="btn btn-danger waves-effect">SUBMIT</button>
                        </div>
                    </div>
                </form>
                </div>



                <div style="border: none; padding: 20px 30px">
                        <div class="collapse" id="FilterPoints" aria-expanded="false">
                            <form id="filterForm" method="POST" autocomplete="off">
                            
                                   
                                <div class="row">
                                  
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control select_game select2" name="fgame_id" id="fgame_id" select2>
                                                    <option value="">--Select Games--</option>
                                                    <?php
                                                        foreach ($filter_games as $key => $s):
                                                            echo '<option value="' . $s['title'] . '">' . $s['title'] . '</option>';
                                                        endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control select_pred2" name="fprediction_id" id="fprediction_id" select2>
                                                    <option value="">--Select Predictions--</option>
                                                    <?php
                                                        foreach ($filter_pred as $key => $p):
                                                            echo '<option value="' . $p['title'] . '">' . $p['title'] . '</option>';
                                                        endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                   
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="input-group date">
                                                <div class="form-line">
                                                    <input type="text" class="form-control start_datetimepicker" name="start_date" id="start_date" readonly="readonly" value="" style="background-color: transparent;"  autocomplete="off">
                                                    <label class="form-label">From Date</label>
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
                                                    <input type="text" class="form-control end_datetimepicker" name="end_date" id="end_date" readonly="readonly" value="" style="background-color: transparent;">
                                                    <label class="form-label">To Date</label>
                                                </div>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar" id="end_btnPicker"></span>
                                                </span>
                                            </div>
                                        </div>
                                      <!--   <input type="hidden" class="form-control" name="offSet" id="offSet"   style="background-color: transparent;"> -->
                                    </div>  
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 align-center">
                                        <button type="submit" class="btn btn-danger waves-effect" id="filterapply">APPLY FILTER</button>
                                        <button type="button" class="btn btn-danger waves-effect clear-filter" id="filterclear">CLEAR FILTER</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="filter_error text-center p-t-10 p-b-10"></div>
                                </div>
                            </form>

                        </div>    
                    </div>

                <div class="body">        
                    <div>
                        <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                       
                                <thead>
                                    <tr>
                                        <th class="text-center">Game</th>  
                                        <th class="text-center">Prediction</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Updated Coins</th>
                                        <th class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    if(!empty($orders)){
                                       foreach( $orders as $key => $o):
                                        
                                    // $type = ($o[ 'update_type' ] == '6') ? "Add" : "Deduct";
                                    echo '<tr>'
                                       . '<td class="text-center">' . $o['game_name'] . '</td>'
                                       . '<td class="text-center">' . $o['prediction_name'] . '</td>'
                                       . '<td class="text-center">' . $o['type']. '</td>'
                                       . '<td class="text-center">' . $o['points'] . '</td>'
                                       . '<td class="text-center">' . date( "d-m-Y", strtotime( $o[ 'created_date' ] ) ) . '</td></tr>';
                                        endforeach;
                                    } else { 
                                        echo '<tr style="text-align:center;"><td colspan=6>No records found</td></tr>';
                                    
                                       }
                                    ?>
                                </tbody>
                        </table>
                    </div>
                    <?php if(!empty($orders) && count($orders)>=20) { ?>
                    <div style="padding-bottom: 25px;">
                                <center>
                                    <button id="loadlist" class="btn btn-danger waves-effect m-r-20" data-offset="20" <?php echo count($orders);?>>Load More</button>
                                </center>
                            </div>
                    <?php }?>
                </div>
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
    $("#addbtn").click(function(){
        var output = function(cb){
                    // hideloader();
                    $('.records').html(cb);
                };

         ajax_call('Games/PointsfilteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 20);
                // $('#offSet').val(20);
               
     
        $('#game_id').val(null).trigger('change');
        $('#prediction_id').val(null).trigger('change');
        $('#fgame_id').val(null).trigger('change');
        $('#fprediction_id').val(null).trigger('change');
        $('#points').val(null).trigger('change');
        $('#action').val(null).trigger('change');
        $('#start_date').val(null).trigger('change');
        $('#end_date').val(null).trigger('change');
        $("#addUpdatePoint").trigger('reset');
        $("#collapseFilter").collapse('toggle');
        $("#FilterPoints").collapse('hide');
        $('.error_val').text('');
        $('.error_val').removeClass('text-danger');
            });
        


        $("#filterbtn").click(function(){
        $('.error_val').text('');
        $('.error_val').removeClass('text-danger');
        
        $('#game_id').val(null).trigger('change');
        $('#prediction_id').val(null).trigger('change');
        $('#fgame_id').val(null).trigger('change');
        $('#fprediction_id').val(null).trigger('change');
        $('#points').val(null).trigger('change');
        $('#action').val(null).trigger('change');
        $('#start_date').val(null).trigger('change');
        $('#end_date').val(null).trigger('change');
        $("#addUpdatePoint").trigger('reset');
            $("#collapseFilter").collapse('hide');
            $("#filterForm").trigger('reset');            
            $("#FilterPoints").collapse('toggle');
            
        });
        // $("#filterForm").trigger('reset');
  
        // $('#start_date').val(null).trigger('change');
      var placeholder = "Select Game";

                $(".select2").select2({
                placeholder: placeholder,
                width: '100%',
                });


                var placeholder1 = "Select Predictions";
                $(".select_pred").select2({
                   
                   placeholder: placeholder1,
                   width: '100%',
                   ajax: { 
                   url: '<?= base_url() ?>Games/fetchPrediction',
                   type: "post",
                   dataType: 'json',
                   delay: 250,
                   data: function (params) {
                      return {
                         searchTerm: params.term, // search term
                        game_id: $("#game_id").val() // Category ID
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


                $(".select_pred2").select2({                    
                   placeholder: placeholder1,
                   width: '100%',
                   ajax: { 
                   url: '<?= base_url() ?>Games/fetchPrediction2',
                   type: "post",
                   dataType: 'json',
                   delay: 250,
                   data: function (params) {
                      return {
                        searchTerm: params.term, // search term
                        game_name: $("#fgame_id").val() // game name.
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


                $('.start_datetimepicker').datetimepicker({
                    useCurrent: false,
                    // defaultDate:false,
                    // maxDate:'-1d',
                    // maxDate: new Date() ,
                    format: "DD-MM-YYYY",
                    ignoreReadonly: true,
                });


                $('#btnPicker').click(function () {
                    $('.start_datetimepicker').datetimepicker('show');
                });
                // $("#start_date").attr("autocomplete", "off"); 
                // $("#end_date").attr("autocomplete", "off"); 
                 $(".start_datetimepicker").on("dp.change", function (e) {
                    $('.end_datetimepicker').data("DateTimePicker").minDate(e.date);
                });


                 $('.end_datetimepicker').datetimepicker({
                    useCurrent: false,
                    // defaultDate:false,
                    // maxDate:'-1d',
                    // maxDate: new Date() ,
                    format: "DD-MM-YYYY",
                    ignoreReadonly: true,
                });


                $('#end_btnPicker').click(function () {
                    $('.end_datetimepicker').datetimepicker('show');
                });

                $(".end_datetimepicker").on("dp.change", function (e) {
                    $('.start_datetimepicker').data("DateTimePicker").maxDate(e.date);
                });




  /* $('#custom_tab').DataTable( {
        "order": [[ 1, "desc" ]]
    } );*/




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
});



$(document).ready(function () {

    var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;
    //console.log(selectedTopicId);
    $('#search_topics').on('keyup', function () {

        var topic = $(this).val();
        // console.log(topic.length);

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

            /*$("#user_id").select2({
               placeholder: 'Please Select User',
               ajax: { 
               url: '<?= base_url() ?> /fetchUser',
               type: "post",
               dataType: 'json',
               delay: 250,
               data: function (params) {
                  return {
                    searchTerm: params.term, // search term
                    game_id: $("#game_id").val() // Category ID
                  };
               },
               processResults: function (response) {
                    return {
                     results: response
                  };
               },
               cache: true
               }
            });*/



        $("form#addUpdatePoint").on("submit", function (e) {
                e.preventDefault();
                var err = [];
                /*var data = $(this).serialize();*/
                var formdata = new FormData(this);
                // console.log(formdata);
                showloader();
                ajax_call_multipart("<?php echo base_url(); ?>Games/update_points", "POST", formdata, function (result) {
                //result = JSON.parse(result);
                hideloader();
                data = JSON.parse(result);
                // console.log(data);
                if (data.status == 'failure') {
                    //    console.log(data.error.coins);
                        if(data.error.game_id !=''){
                            $('.gamesErr').text(data.error.game_id).css("color","#f44336");
                        }else if(data.error.prediction_id !=''){
                            $('.predictionErr').text(data.error.prediction_id).css("color","#f44336");
                        }else if(data.error.action !=''){
                            $('.actionErr').text(data.error.action).css("color","#f44336");
                        }else if(data.error.points !=''){
                            $('.pointsErr').text(data.error.points).css("color","#f44336");
                        }else{
                            // showToast_coins('error');    
                        }
                        setTimeout(function () {
                            $('.error_val').text('');
                            $('.error_val').removeClass('text-danger');
                         }, 2000);
                }else{
                    $('#game_id').val(null).trigger('change');
                    $('#prediction_id').val(null).trigger('change');
                    $('#fgame_id').val(null).trigger('change');
                    $('#fprediction_id').val(null).trigger('change');
                    $('#points').val(null).trigger('change');
                    $('#action').val(null).trigger('change');
                    $('#start_date').val(null).trigger('change');
                    $('#end_date').val(null).trigger('change');
                    $("#addUpdatePoint").trigger('reset');
                    $('.filter_error').text('');
                    $('.filter_error').removeClass('text-danger');
                     if(data.toast_message == 'add'){
                        showToast_coins('add');
                     }else{
                        showToast_coins('deduct');
                     }
                    setTimeout(function () {
                        window.location.assign("Add_deduct_points");
                    }, 2000);
                                        
                    
                }

            });
        });



        $('#filterForm').submit(function(e){
                e.preventDefault();
                var data = $( '#filterForm' ).serialize();
                
                // console.log(data);
                //data += '&paging=20';
                // alert(data);
                var output = function(cb){
                    hideloader();
                    if (cb != "") {
                        $('.records').html(cb);
                        var rowCount = $(".dataTable td").closest("tr").length;
    
                        // console.log(rowCount);
                        if(rowCount >=20){
                            $('#loadlist').show();
                        }else{
                            $('#loadlist').hide();
                        }
                    } else {
                        $('.records').html("'<tr style='text-align:center;'><td colspan='6'><b>No records found</b></td></tr>'");
                        $('#loadlist').attr('disabled', true);
                        $('#loadlist').hide();
                    }
                };

                /*showloader();
                ajax_call('Order/filteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 500);*/

                if($("#fgame_id").val() == "" && $("#fprediction_id").val() == "" && $("#start_date").val() == "" && $("#end_date").val() == ""){
                    $('.filter_error').text('*Please select at least one field');
                    $('.filter_error').addClass('text-danger');
                } else {
                    showloader();
                    ajax_call('Games/PointsfilteredList', 'POST', data, output);
                    // console.log(output);
                    $('#loadlist').attr('disabled', false);
                    $('#loadlist').attr('data-offset', 20);
                    /* $('#game_id').val(null).trigger('change');
                    $('#prediction_id').val(null).trigger('change');
                    $('#fgame_id').val(null).trigger('change');
                    $('#fprediction_id').val(null).trigger('change');
                    $('#points').val(null).trigger('change');
                    $('#action').val(null).trigger('change');
                    $('#start_date').val(null).trigger('change');
                    $('#end_date').val(null).trigger('change');
                    $("#addUpdatePoint").trigger('reset'); */
                    $('.filter_error').text('');
                    $('.filter_error').removeClass('text-danger');
                }


                
            });


            $('#loadlist').click(function(){
                var data = $('#filterForm').serialize();
                var offSet = $(this).attr('data-offSet');
                $('#loadlist').show();
                showloader();
                 data += '&offSet=' +offSet;
                //  $('#offSet').val(offSet);
                //  alert(offSet);
                 var output = function(cb){
                 hideloader();
                    if (cb != "") {
                        $('.records').append(cb);
                        var rowCount = $(".dataTable td").closest("tr").length;
    
                        // console.log(rowCount);
                        if(rowCount >=20){
                            $('#loadlist').show();
                        }else{
                            $('#loadlist').hide();
                        }
                    } else {
                        $('.records').append("'<tr style='text-align:center;'><td colspan='6'><b>No records found</b></td></tr>'");
                        $('#loadlist').attr('disabled', true);
                    }
                };

                ajax_call('Games/PointsfilteredList', 'POST', data, output);
                // offSet = parseInt(offSet, 20);
                offSet = parseInt(offSet)+parseInt(20);
                // alert(offSet);
                // alert(offSet);
                // $('#offSet').val(offSet);
                $(this).attr('data-offSet', offSet);

            });


            
            $('#filterclear').click(function(){
                // alert('Clear... ');
                // $('#loadlist').show();
                var data = '';
                var output = function(cb){
                    hideloader();
                    $('.records').html(cb);
                    var rowCount = $(".dataTable td").closest("tr").length;
    
    // console.log(rowCount);
    if(rowCount >=20){
        $('#loadlist').show();
    }else{
        $('#loadlist').hide();
    }
                };
                showloader();
                $('#loadlist').show();
                ajax_call('Games/PointsfilteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 20);
                // $('#offSet').val(20);
                
                $('.filter_error').text('');
                $('#points').val(null).trigger('change');
                $('#action').val(null).trigger('change');
                $('#start_date').val(null).trigger('change');
                $('#end_date').val(null).trigger('change');
                $('#fgame_id').val(null).trigger('change');
                $('#fprediction_id').val(null).trigger('change');
                $('.filter_error').removeClass('text-danger');
                $("#filterForm").trigger('reset');

                
            });

      


          $('#export_points_excel').click(function(){
            // $('#start_date').val(null).trigger('change');
            //$('#loadlist').show();
                var query = '';
                var req_url = 'export_Pointsfiltered';
                

                if ($('#fgame_id').val() != "") {
                    query += 'fgame_id=' + $('#fgame_id').val() + '&';
                }
                if ($('#fprediction_id').val() != "") {
                    query += 'fprediction_id=' + $('#fprediction_id').val() + '&';
                }
                if ($('#start_date').val() != "") {
                    query += 'start_date=' + $('#start_date').val() + '&';
                }
                if ($('#end_date').val() != "") {
                    query += 'end_date=' + $('#end_date').val() + '&';
                }
                if ($('#offset').val() != "") {
                    query += 'offset=' + $('#offset').val();
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
