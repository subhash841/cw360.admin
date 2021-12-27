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
                            Subscription List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                             <!--    <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button> -->
                            </li>
                            <li class="dropdown">
                                <!-- <form name="export" id="export" method="POST" action="export_polls">
                                    <button type="submit" class="btn btn-danger waves-effect m-r-20">Export</button>
                                </form> -->
                                <!-- <button type="submit" id="export_subscription_excel" class="btn btn-danger waves-effect m-r-20">Export to Excel</button> -->
                            </li>
                        </ul>
                    </div>
                    <!-- Filter -->
                    <div style="border: none; padding: 20px 30px">
                        <div class="collapse" id="collapseFilter" aria-expanded="false">

                            <form id="filterForm" method="POST">
                                <div class="row">
                                   <!--  <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="topic_id" id="topic_id">
                                                    <option value="">--Select Topics--</option>
                                                    <?php
                                                        foreach ($topics as $key => $s):
                                                            echo '<option value="' . $s['id'] . '">' . $s['topic'] . '</option>';
                                                        endforeach;
                                                    ?>
                                                </select>
                                                <label class="form-label">Topics</label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="package_name" id="package_name" maxlength="75" value="">
                                                <label class="form-label">Package Name</label>
                                            </div>
                                        </div>
                                    </div>
                                   <!-- <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="input-group date" >
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="start_date" id="start_date" readonly="readonly" value="" style="background-color: transparent;">
                                                    <label class="form-label">Start Date</label>
                                                </div>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
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
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="offSet" id="offSet" readonly="readonly" value="0" style="background-color: transparent;">
                                    </div> -->  
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
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#Package ID</th>
                                        <th class="text-center">Package Name</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Created Date</th>
                                        <th style="width:10%" class="text-center notexport">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    foreach ( $subscription as $key => $s ):
                                    /*  echo'<pre>'; print_r($p);*/
                                    $ischecked = ($s[ 'is_active' ] == 1) ? "checked" : "";
                                    /* $num = $key + 1;*/
                                            echo '<tr>'
                                            . '<td>' . $s['id'] . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'package_name' ] . '</p></td>'      
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $s[ 'price' ] . '</p></td>'       
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . date( "d-m-Y", strtotime( $s[ 'created_date' ] ) ) . '</p></td>'
                                            . '<td class="text-center">
                                                <a href="' . base_url() . 'Subscription/index?id=' . $s[ 'id' ] . '" data-id="' . $s[ 'id' ] . '" ><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" data-id="' . $s[ 'id' ] . '" data-type="subscription" class="changeactivesubscription"><i class="material-icons">delete_forever</i></a>
                                                </td>
                                            </tr>';
                                    endforeach;
                                    ?>
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

            
            $('#end_date').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
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



            //Active - Inactive Games
            $(document).on('click', '.changeactivesubscription', function (e) {


                    var result = confirm("Want to delete?");

                    if(result){
                            var subscription_id = $(this).attr('data-id');
                            var type = $(this).attr('data-type');
                            console.log(type);
                            /*var status = $(this).attr('data-status');*/
                            if (type != "") {
                            var param = {subscription_id: subscription_id, type: type};
                            console.log(param);
                            ajax_call('Subscription/active_inactive_subscription', "POST", param, function (result) {
                                console.log(result);
                                result = JSON.parse(result);
                                if (result['status']) {
                                    $("#response_message").html('<div class="btn-lg bg-green">Subscription Successfully Deleted</div>').fadeIn(2000).delay(1000).fadeOut(2000);
                                    setTimeout(function () {
                                        window.location.assign("lists");
                                    }, 2000);
                                } else {
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
                    $('.records').html(cb);
                };

                ajax_call('Subscription/filteredList', 'POST', data, output);
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

                ajax_call('Subscription/filteredList', 'POST', data, output);
                offSet = parseInt(offSet, 10);
                offSet = offSet+10;
                $(this).attr('data-offSet', offSet);
               
            });



            $('#filterclear').click(function(){
                // alert('Clear... ');
                $("#filterForm").trigger('reset');
            });

           /* $('#export_subscription_excel').click(function(){
                var query = '';
                var req_url = 'exportList_subscription';
                if ($('#package_name').val() != "") {
                    query += 'package_name=' + $('#package_name').val() + '&';
                }
                if (query.charAt(query.length-1) == '&') {
                    query = query.slice(0, -1);
                }
                if (query != "") {
                    req_url = req_url + '?' + query;
                }
                //alert(req_url);
                window.location.assign(req_url);
            });*/


        });
</script>