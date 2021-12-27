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
                            Article List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                            </li>
                            <li class="dropdown">
                                <!-- <form name="export" id="export" method="POST" action="export_articles">
                                    <button type="submit" id="export_articles_excel" class="btn btn-danger waves-effect m-r-20">Export</button>
                                </form> -->
                                <button type="submit" id="export_articles_excel" class="btn btn-danger waves-effect m-r-20">Export</button>
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
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="article_quest" id="article_quest" maxlength="75" value="">
                                                <label class="form-label">Question</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="article_desc" id="article_desc" maxlength="75" value="">
                                                <label class="form-label">Description</label>
                                            </div>
                                        </div>
                                    </div>
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
                                                    <input type="text" class="form-control" name="start_date" id="start_date" readonly="readonly" value="" style="background-color: transparent;">
                                                    <label class="form-label">Created Start Date</label>
                                                </div>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="input-group date" id="to_datetimepicker">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="end_date" id="end_date" readonly="readonly" value="" style="background-color: transparent;">
                                                    <label class="form-label">Created End Date</label>
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
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th># Sr. No</th>
                                        
                                        <th>Article</th>
                                        <th>Description</th>
<!--                                        <th class="text-center">Is Approved</th>-->
                                        <th class="text-center">Created Date</th>
                                        <th class="text-right">Active</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    foreach ($articles as $key => $p):
                                        $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                        $num = $key + 1;
                                        $p['preview']=str_replace("'", '', $p['preview']);
                                        unset($p['choices']);
                                        //$p['choices']= htmlspecialchars($p['choices']);
                                        echo '<tr>'
                                        . '<td>' . $num . '</td>'
                                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p['question'] . '</p></td>'
                                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p['description'] . '</p></td>'
                                        //. '<td class="text-center">' . $isapproved . '</td>'
                                        . '<td class="text-center">' . date("d-m-Y", strtotime($p['created_date'])) . '</td>'
                                        . '<td class="text-center">
                                            <a class="switch changeactivearticle" data-id="' . $p['id'] . '" data-type="articles" data-status=' . $p['is_active'] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                                        . '<td class="text-center">
                                            <a href="' . base_url() . 'RatedArticle/index?id=' . $p['id'] . '" data-id="' . $p['id'] . '" data-editjson=\'' . json_encode($p) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="#" data-toggle="modal" data-target="#viewArticleDetails" data-id="' . $p['id'] . '"><i class="material-icons">remove_red_eye</i></a>
                                        </td>';
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

<!-- <div class="modal fade in" id="viewArticleDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> Article Details</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-success waves-effect btn-approve">Approve</button>
                <button type="button" class="btn btn-link btn-danger waves-effect btn-reject" data-dismiss="modal" data-toggle="modal" data-target="#reject_article">Reject</button>-->
                <!--<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="modal fade in" id="reject_article" tabindex="-1" role="dialog">
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
        $('#end_datetimepicker').datetimepicker({
            useCurrent: false,
            format: "DD-MM-YYYY",
            minDate: moment().millisecond(0).second(0).minute(0).hour(0),
            ignoreReadonly: true
        });

        $("#from_datetimepicker").on("dp.change", function (e) {
            $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
        });
        $("#to_datetimepicker").on("dp.change", function (e) {
            $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
        });
        $("#end_datetimepicker").on("dp.change", function (e) {
            $("#only_end_date_change").val("1");
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
                ajax_call('/RatedArticle/filteredList', 'POST', data, output);
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
                ajax_call('/RatedArticle/filteredList', 'POST', data, output);
                 offSet = parseInt(offSet, 10);
                offSet = offSet+10;
                $(this).attr('data-offSet', offSet);
               
        });

        $('#filterclear').click(function(){
                // alert('Clear... ');
                $("#filterForm").trigger('reset');
        });

        $('#export_articles_excel').click(function(){
                var query = '';
                var req_url = '/RatedArticle/exportList_articles';

                if ($('#topic_id').val() != "") {
                    query += 'topic_id=' + $('#topic_id').val() + '&';
                }
                if ($('#article_quest').val() != "") {
                    query += 'article_quest=' + $('#article_quest').val() + '&';
                }
                if ($('#article_desc').val() != "") {
                    query += 'article_desc=' + $('#article_desc').val() + '&';
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
    });
</script>