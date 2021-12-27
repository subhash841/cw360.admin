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
                            Game List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                            </li>
                            <li class="dropdown">
                                <!-- <form name="export" id="export" method="POST" action="export_polls">
                                    <button type="submit" class="btn btn-danger waves-effect m-r-20">Export</button>
                                </form> -->
                                <button type="submit" id="export_games_excel" class="btn btn-danger waves-effect m-r-20">Export to Excel</button>
                            </li>
                        </ul>
                    </div>
                    <!-- Filter -->
                    <div style="border: none; padding: 20px 30px">
                        <div class="collapse" id="collapseFilter" aria-expanded="false">

                            <form id="filterForm" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="title" id="title" maxlength="75" value="">
                                                <label class="form-label">Game Name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="input-group date" >
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="start_date" id="start_date" readonly="readonly" value="" style="background-color: transparent;">
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
                                            <div class="input-group date" >
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
                                        <button type="button" class="btn btn-danger waves-effect" id="filterclear">CLEAR FILTER</button>
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
                                        <th style="width:10%;" class="text-center"># Game ID</th>
                                        <!--<th>Category</th>-->
                                        <th class="text-center">Game Title</th>
                                        <th style="width:15%" class="text-center">Start Date</th>
                                        <th style="width:15%" class="text-center">End Date</th>
                                        <th style="width:10%" class="text-center">Is Published</th>
                                        <!-- <th class="text-right">Active</th> -->
                                        <th style="width:10%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    if(!empty($games)){

                                    foreach ( $games as $key => $p ):   
                                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                       $ispublished = ($p[ 'is_published' ] == 1) ? "checked" : "";
                                       $p = str_replace(array( '\''), "&#8217;", $p);
                                       $game_id_exist=check_data_in_used('game_id',$p['id'],'points');
                                       if($game_id_exist > 0){
                                        $disabled = "disabled =''";
                                        $class = "invalid";
                                        }else{
                                        $class = "changeactivegame";
                                        $disabled = "";

                                       }
                                        /* $ispublished = ($p[ 'is_published' ] == "1") ? "Yes" : "No";*/
                                       echo '<tr>'
                                       . '<td>' . $p['id'] . '</td>'
                                            //. '<td>' . $p[ 'category' ] . '</td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                       . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y H:i:s", strtotime( $p[ 'start_date' ] ) ) . '</p></td>'
                                       . '<td class="text-center">' . date( "d-m-Y  H:i:s", strtotime( $p[ 'end_date' ] ) ) . '</td>'

                                       /*. '<td class="text-center">' . $ispublished . '</td>'*/
                                        . '<td class="text-center">
                                                <a class="switch changepublishgame" data-id="' . $p[ 'id' ] . '" data-type="games" data-status=' . $p[ 'is_published' ] . '>

                                                    <label><input type="checkbox" ' . $ispublished . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>'
                                        . '<td class="text-center">
                                                <a href="' . base_url() . 'Games/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" ><i class="material-icons">&#xE254;</i></a>
                                                <a  '.$disabled .' href="#" data-id="' . $p[ 'id' ] . '" data-type="games"  class="'.$class.'"><i class="material-icons" >delete_forever</i></a>
                                                </td>
                                                </tr>';
                                            endforeach; 
                                            } else { 
                                                echo '<tr style="text-align:center;"><td colspan=6>No Games are Available</td></tr>';
                                            
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



        <script type="text/javascript">
            $(function () {
                $('#weekly_datetimepicker').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                    ignoreReadonly: true
                });


                $('#start_date').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    ignoreReadonly: true
                });


                $('#btnPicker').click(function () {
                    $('#start_date').datetimepicker('show');
                });


                $('#end_date').datetimepicker({
                    useCurrent: false,
                    format: "DD-MM-YYYY",
                    ignoreReadonly: true
                });


                $('#end_btnPicker').click(function () {
                    $('#end_date').datetimepicker('show');
                });




        $('#end_datetimepicker').datetimepicker({
            useCurrent: false,
            format: "DD-MM-YYYY",
            minDate: moment().millisecond(0).second(0).minute(0).hour(0),
            ignoreReadonly: true
        });

        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
        });
        $("#end_datetimepicker").on("dp.change", function (e) {
            $("#only_end_date_change").val("1");
        });




            $(document).on('click', '.invalid', function (e) {
                    showToast('Action Disabled as Game is Live','0');
            });




            //Active - Inactive Games
            $(document).on('click', '.changeactivegame', function (e) {
                var result = confirm("Want to delete?");

                if(result){
                    showloader();
                var game_id = $(this).attr('data-id');
                var type = $(this).attr('data-type');
                console.log(type);
                console.log(game_id);

                /*var status = $(this).attr('data-status');*/
                if (type != "") {
                    var param = {game_id: game_id, type: type};
                    console.log(param);
                    ajax_call('Games/active_inactive_game', "POST", param, function (result) {
                        console.log(result);
                        result = JSON.parse(result);

                        if (result['status']) {
                            hideloader();
                            $("#response_message").html('<div class="btn-lg bg-green">Game Successfully Deleted</div>').fadeIn(2000).delay(1000).fadeOut(2000);

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
               
                console.log(data);
                //data += '&paging=20';
                // alert(data);
                var output = function(cb){
                    hideloader();
                    $('.records').html(cb);
                };
                 if($("#title").val() == "" && $("#start_date").val() == "" && $("#end_date").val() == ""){
                    $('.filter_error').text('*Please select at least one field');
                    $('.filter_error').addClass('text-danger');
                } else {
                    showloader();
                    ajax_call('Games/filteredList', 'POST', data, output);
                    $('#loadlist').attr('disabled', false);
                    $('#loadlist').attr('data-offset', 10);

                    $('.filter_error').text('');
                    $('.filter_error').removeClass('text-danger');
                }

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

                ajax_call('Games/filteredList', 'POST', data, output);
                offSet = parseInt(offSet, 10);
                offSet = offSet+10;
                $(this).attr('data-offSet', offSet);

            });



            $('#filterclear').click(function(){
                // alert('Clear... ');
                var data = '';
                var output = function(cb){
                    hideloader();
                    $('.records').html(cb);
                };
                showloader();
                ajax_call('Games/filteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 10);
                $('.filter_error').text('');
                $('.filter_error').removeClass('text-danger');
                $("#filterForm").trigger('reset');
            });
            

            $('#export_games_excel').click(function(){
                var query = '';
                var req_url = 'exportList_games';

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
