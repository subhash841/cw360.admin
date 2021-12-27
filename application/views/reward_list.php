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
                            Reward List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                               <!--  <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button> -->
                            </li>
                            <li class="dropdown">
                                <!-- <form name="export" id="export" method="POST" action="export_polls">
                                    <button type="submit" class="btn btn-danger waves-effect m-r-20">Export</button>
                                </form> -->
                                <!-- <button type="submit" id="export_polls_excel" class="btn btn-danger waves-effect m-r-20">Export</button> -->
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
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th style="width:10%;" class="text-center"># Reward ID</th>
                                        <!--<th>Category</th>-->
                                        <th class="text-center">Reward Title</th>
                                        <th style="width:15%" class="text-center">Coins Required</th>
                                        <th style="width:15%" class="text-center notexport">Image</th>
                                        <th style="width:10%" class="text-center notexport">Is Published</th>
                                        <th style="width:10%" class="text-center notexport">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    foreach ( $reward as $key => $r ):
                                       /*  echo'<pre>'; print_r($p);*/
                                       $ischecked = ($r[ 'is_active' ] == 1) ? "checked" : "";
                                       $ispublished = ($r[ 'is_published' ] == 1) ? "checked" : "";

                                       echo '<tr>'
                                       . '<td>' . $r['id'] . '</td>'
                                        //. '<td>' . $p[ 'category' ] . '</td>'
                                       .'<td><p class="multiline-ellipsis" data-lines="1">' . $r[ 'title' ] . '</p></td>'
                                       .'<td class="text-center">' . $r[ 'req_coins' ] . '</td>'
                                       .'<td class="text-center"><div class="" style="height:68px; background:url(' . $r[ 'image' ] . ') center center no-repeat;background-size:contain;"></div></td>'
                                       .'<td class="text-center">
                                                <a class="switch changepublishreward" data-id="' . $r[ 'id' ] . '" data-type="rewards" data-status=' . $r[ 'is_published' ] . '>

                                                    <label><input type="checkbox"  ' . $ispublished . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>' 

                                            /*. '<td class="text-center">
                                                <a class="switch changeactivegame" data-id="' . $p[ 'id' ] . '" data-type="games" data-status=' . $p[ 'is_active' ] . '>

                                                    <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>'*/
                                                . '<td class="text-center">
                                                <a href="' . base_url() . 'Reward/index?id=' . $r[ 'id' ] . '" data-id="' . $r[ 'id' ] . '" ><i class="material-icons">&#xE254;</i></a>
                                                <a href="#" data-id="' . $r[ 'id' ] . '" data-type="reward" class="changeactivereward"><i class="material-icons">delete_forever</i></a>
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



        <script type="text/javascript">
            $(function () {


            //Active - Inactive Games


            $(document).on('click', '.changeactivereward', function (e) {
                var result = confirm("Want to delete?");
                if(result){
                    
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
                showloader();
                console.log(data);


                //data += '&paging=20';
                // alert(data);
                var output = function(cb){
                    hideloader();
                    $('.records').html(cb);
                };

                ajax_call('Games/filteredList', 'POST', data, output);
                $('#loadlist').attr('disabled', false);
                $('#loadlist').attr('data-offset', 10);
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

                ajax_call('Reward/filteredList', 'POST', data, output);
                offSet = parseInt(offSet, 10);
                offSet = offSet+10;
                $(this).attr('data-offSet', offSet);

            });



            $('#filterclear').click(function(){
                // alert('Clear... ');
                $("#filterForm").trigger('reset');
            });

            $('#export_polls_excel').click(function(){
                var query = '';
                var req_url = '/Poll/exportList_polls';

                if ($('#topic_id').val() != "") {
                    query += 'topic_id=' + $('#topic_id').val() + '&';
                }
                if ($('#poll_quest').val() != "") {
                    query += 'poll_quest=' + $('#poll_quest').val() + '&';
                }
                if ($('#poll_desc').val() != "") {
                    query += 'poll_desc=' + $('#poll_desc').val() + '&';
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