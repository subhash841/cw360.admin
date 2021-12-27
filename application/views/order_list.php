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
                           Order List
                        </h2>
                        <ul class="header-dropdown m-r-5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                            </li>
                            <li class="dropdown">
                                <!-- <form name="export" id="export" method="POST" action="export_polls">
                                    <button type="submit" class="btn btn-danger waves-effect m-r-20">Export</button>
                                </form> -->
                                <!-- <button type="submit" id="export_polls_excel" class="btn btn-danger waves-effect m-r-20">Export</button> -->
                               <!--  <form name="addUpdateReward" id="addUpdateReward" method="POST" action="<?php echo base_url();?>Order/exportList_order">
                                <button  type="submit" class="btn btn-danger waves-effect m-r-20">Export</button>
                                </form> -->

                                 <button type="submit" id="export_order_excel" class="btn btn-danger waves-effect m-r-20">Export to Excel</button>
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
                                                <select class="form-control select_game select2" name="game_id" id="game_id" select2>
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
                                                <select class="form-control select_pred" name="prediction_id" id="prediction_id" select2>
                                                    <option value="">--Select Predictions--</option>
                                                    <?php
                                                        foreach ($predictions as $key => $p):
                                                            echo '<option value="' . $p['id'] . '">' . $p['title'] . '</option>';
                                                        endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control select3" name="name" id="name" select2>

                                                    <option value="">--Select User Name--</option>
                                                    <?php
                                                        foreach ($u_name as $key => $u):
                                                            echo '<option value="' . $u['id'] . '">' . $u['name'] . '</option>';
                                                        endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control select4" name="email" id="email" select2>
                                                    <option value="">--Select User Email--</option>
                                                    <?php
                                                        foreach ($users as $key => $u):
                                                            echo '<option value="' . $u['id'] . '">' . $u['email'] . '</option>';
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
                                                    <input type="text" class="form-control start_datetimepicker" name="start_date" id="start_date" readonly="readonly" value="" style="background-color: transparent;">
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
                                        <input type="hidden" class="form-control" name="offSet" id="offSet" readonly="readonly" value="0" style="background-color: transparent;">
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


                    <!-- End Filter -->
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>    
                                        <th style="width:5%;" class="text-center"># Order ID</th>
                                        <th style="width:10%" class="text-center">Game Name</th>
                                        <th style="width:8%;" class="text-center">Prediction Name</th>
                                        <!--<th>Category</th>-->
                                        <!-- <th style="width:10%" class="text-center">User Email</th> -->
                                        <th style="width:10%" class="text-center">Buyers Name</th>
                                        <th style="width:10%" class="text-center">Email</th>
                                        <!--  <th style="width:15%" class="text-center">Prediction Name</th> -->
                                        <th style="width:10%" class="text-center">Trade Date and Time</th>
                                        <th style="width:8%" class="text-center">(Buy/Sell) value</th>
                                        <th style="width:10%" class="text-center">Type of Trade(Yes/No)</th>
                                      <!--   <th style="width:10%" class="text-center">Profit Value </th>
                                        <th style="width:10%" class="text-center">Current Value</th> -->
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    foreach ( $orders as $key => $o ):
                                        $swipe_status =  $o[ 'swipe_status' ] == 'agreed' ?'YES':'NO';
                                        echo '<tr>'
                                        . '<td>' . $o['orderid'] . '</td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'game_title' ] . '</p></td>'
                                        . '<td>' . $o['prediction_title'] . '</td>'
                                  
                                        //. '<td>' . $p[ 'category' ] . '</td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'name' ] . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'email' ] . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'created_date' ] . '</p></td>'
                                        /*.'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'email' ] . '</p></td>'*/
                                        .'<td class="text-center">' . $o[ 'points' ] . '</td>'
                                        .'<td class="text-center">' . $swipe_status . '</td>'
                                        /*.'<td><p class="multiline-ellipsis" data-lines="1">' .($o[ 'points' ] - $o[ 'current_price' ]) . '</p></td>'
                                        .'<td><p class="multiline-ellipsis" data-lines="1">' . $o[ 'current_price' ] . '</p></td>'*/
                                        .'</tr>';
                                        endforeach;?>
                                </tbody>
                                </table>
                                </div>
                            </div>
                            <?php if ((count($orders) == 500)):?>
                            <div style="padding-bottom: 25px;">
                                <center>
                                    <button id="loadlist" class="btn btn-danger waves-effect m-r-20" data-offset="500">Load More</button>
                                </center>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- #END# Exportable Table -->
            </div>
        </section>



        <script type="text/javascript">
            $(function () {


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
                   url: '<?= base_url() ?>Order/fetchPrediction',
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




                var placeholder1 = "Select User Name";
                $(".select3").select2({
                placeholder: placeholder1,
                width: '100%',
                });



                var placeholder1 = "Select User Email";

                $(".select4").select2({
                placeholder: placeholder1,
                width: '100%',
                });





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




                
             //Active - Inactive Games
            $(document).on('click', '.changeactivegame', function (e) {
                showloader();
                var reward_id = $(this).attr('data-id');
                var type = $(this).attr('data-type');
                console.log(type);
                console.log(reward_id);
                /*var status = $(this).attr('data-status');*/
                if (type != "") {
                    var param = {reward_id: reward_id, type: type};
                    console.log(param);
                    ajax_call('Reward/active_inactive_reward', "POST", param, function (result) {
                        console.log(result);
                        result = JSON.parse(result);

                        if (result['status']) {
                            hideloader();
                            $("#response_message").html('<div class="btn-lg bg-green">Reward Successfully Deleted</div>').fadeIn(2000).delay(1000).fadeOut(2000);

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
            });


           /* $(".edit-election").on("click", function (event) {
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
            });*/



            $('#filterForm').submit(function(e){
                e.preventDefault();
                var data = $( '#filterForm' ).serialize();
                
                console.log(data);
                //data += '&paging=20';
                // alert(data);
                var output = function(cb){
                    hideloader();
                    $('.records').html(cb);
                };

                /*showloader();
                ajax_call('Order/filteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 500);*/

                if($("#game_id").val() == "" && $("#prediction_id").val() == "" && $("#name").val() == "" && $("#email").val() == "" && $(".start_datetimepicker").val() == "" && $(".end_datetimepicker").val() == ""){
                    $('.filter_error').text('*Please select at least one field');
                    $('.filter_error').addClass('text-danger');
                } else {
                    showloader();
                    ajax_call('Order/filteredList', 'POST', data, output);
                    $('#loadlist').attr('disabled', false);
                    $('#loadlist').attr('data-offset', 500);

                    $('.filter_error').text('');
                    $('.filter_error').removeClass('text-danger');
                }
            });

            $('.clear-filter').click(function(){
                //window.location.assign(window.location.href);
                $('#filterForm').get(0).reset();
                var output = function(cb){
                    hideloader();
                    $('.records').html(cb);
                };
                showloader();
                ajax_call('Order/filteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 500);
            });



            $('#loadlist').click(function(){
                var offSet = $(this).attr('data-offSet');
                showloader();
                var data = $('#filterForm').serialize();
                 data += '&offSet=' +offSet;
                 // alert(data);
                 var output = function(cb){
                 hideloader();
                    if (cb != "") {
                        $('.records').append(cb);
                    } else {
                        $('#loadlist').attr('disabled', true);
                    }
                };

                ajax_call('Order/filteredList', 'POST', data, output);
                offSet = parseInt(offSet);
                offSet = offSet+500;
                //alert(offSet);
                $(this).attr('data-offSet', offSet);

            });



            $('#filterclear').click(function(){
                // alert('Clear... ');
                $("#filterForm").trigger('reset');
                $('#game_id').val(null).trigger('change');
                $('#prediction_id').val(null).trigger('change');
                $('#name').val(null).trigger('change');
                $('#email').val(null).trigger('change');
                $('.filter_error').text('');
                $('.filter_error').removeClass('text-danger');
                    
            });

            $('#export_order_excel').click(function(){
                var query = '';
                var req_url = base_url + 'Order/exportList_order';

                if ($('#game_id').val() != "") {
                    query += 'game_id=' + $('#game_id').val() + '&';
                }
                if ($('#prediction_id').val() != "") {
                    query += 'prediction_id=' + $('#prediction_id').val() + '&';
                }
                if ($('#name').val() != "") {
                    query += 'name=' + $('#name').val() + '&';
                } 
                if ($('#email').val() != "") {
                    query += 'email=' + $('#email').val() + '&';
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