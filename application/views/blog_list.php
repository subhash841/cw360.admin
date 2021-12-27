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
                            Blog List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                                
                                    <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                                                
                                </li>
                                <li class="dropdown">
                                <!--<form name="export" id="export" method="POST" action="export_users">-->
                                    <button type="submit" id="export-blogs-excel" class="btn btn-danger waves-effect m-r-20">Export</button>
                                <!--</form>-->
                            </li>
                        </ul>
                    </div>
                    <!--<div class="header">
                                    <b>Filter</b>
                                    <ul class="header-dropdown m-r-/-5">
                                        <li class="dropdown">
                                            
                                                <button type="submit" class="btn btn-danger waves-effect m-r-20">Filter</button>
                                            
                                        </li>
                                    </ul>
                                    </div>-->
                                    <div style="border: none; padding: 20px 30px;">
                                    <div class=" collapse" id="collapseFilter" aria-expanded="false">
                                        <form id="filterForm" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control poll_detail_change" name="blog_topic" id="blog_topic">
                                                            <option value="">-- Select Topic --</option>
                                                            <?php
                                                            foreach ( $topics as $key => $list ):
                                                                    echo '<option value="' . $list[ 'id' ] . '">' . $list[ 'topic' ] . '</option>';
                                                            endforeach;
                                                            ?>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control poll_detail_change" name="blog_status" id="blog_status">
                                                            <option value="">-- Select Status --</option>
                                                            <option value="1">Approved</option>
                                                            <option value="0">Pending</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="blog_title" id="blog_title" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Title</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="blog_desc" id="blog_desc" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control poll_detail_change" name="blog_type" id="blog_type">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="1">Blog</option>
                                                            <option value="2">Article</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="from_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="blog_cstart_date" id="blog_cstart_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created Start Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="to_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="blog_cend_date" id="blog_cend_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created End Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="offset" id="offset" readonly="readonly" value="0" style="background-color: transparent;">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 align-center">
                                                <button id="filterdata" type="submit" class="btn btn-danger waves-effect">APPLY FILTER</button>
                                                <button id="clearfilter" type="submit" class="btn btn-danger waves-effect">CLEAR FILTER</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                    <div class="body">
                        <div class="">
                            <!-- js-basic-example -->
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                                        <th>#Sr.</th>
                                                        <th>Title</th>
                                                        <th width="400">Description</th>
                                                        <th class="text-center">Type</th>
                                                        <th class="text-center" width="100">Date</th>
                                                        <th class="text-center">Action</th>
                                                        <th class="text-center">Active</th>
                                                        <!--<th class="text-center">Order</th>-->
                                    </tr>
                                </thead>
                                <tbody class="recordsContainer">
                                    <?php
                                    foreach ( $blogs as $key => $list ):
                                                            $num = $key + 1;
                                                            $newvalue = $list[ 'is_active' ] == 1 ? "checked" : "";
                                                            $description = str_replace( '\\', '/', $list[ 'description' ] );
                                                            $description = preg_replace( "/<style(.*)<\/style>/iUs", "", $description );
                                                            $description = str_replace( "&nbsp;", " ", $description );
                                                            $type = ($list[ 'type' ] == "1") ? "Blog" : "Article";
                                                            echo '<tr>
                                                                <td>' . $num . '</td>
                                                                <td>' . $list[ 'title' ] . '</td>
                                                                <td><p class="ellipsis">' . strip_tags( $description ) . '</p></td>
                                                                <td>' . $type . '</td>
                                                                <td class="text-center">' . $list[ 'created_date' ] . '</td>
                                                                <td class="text-center">
                                                                    <a href="' . base_url() . 'Blogs/addeditblogview/' . $list[ 'id' ] . '" target="_Blank"><i class="material-icons">&#xE254;</i></a>
                                                                    <a href="' . base_url() . 'Blogs/previewblog/' . $list[ 'id' ] . '" target="_Blank"><i class="material-icons">remove_red_eye</i></a>
                                                                </td>';
                                                            echo '<td>
                                                                    <a class="switch changeactive" data-id="' . $list[ 'id' ] . '" data-type="blogs" data-status=' . $list[ 'is_active' ] . '>
                                                                        <label><input type="checkbox" ' . $newvalue . '><span class="lever switch-col-bluenew"></span></label>
                                                                    </a>
                                                                </td>';
                                                             '<td class="text-center">
                                                                <input type="text" class="text-center blog_order" style="width:100%" data-id="' . $list[ 'id' ] . '" name="blog_order" value="' . $list[ 'blog_order' ] . '">
                                                                </td>
                                                               </tr>
                                                            ';
                                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="padding-bottom: 25px;">
                        <center>
                            <button id="loadBlogs" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
</section>

<div class="modal fade in" id="viewPollDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> User Details</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-success waves-effect btn-approve">Approve</button>
                <!--<button type="button" class="btn btn-link btn-danger waves-effect btn-reject" data-dismiss="modal" data-toggle="modal" data-target="#reject_poll">Reject</button>-->
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="reject_poll" tabindex="-1" role="dialog">
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
</div>

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

            /*$('#filterdata').click(function(){
                //$('.recordsContainer').empty();
                var alias = $('#user_alias').val();
                var mail = $('#user_mail').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();

                var data = '';



                alert('Values as follows: '+alias+' - '+mail+' - '+start_date+' - '+end_date);

                /*var table = $('.dataTable').DataTable();
                table.clear().draw();*\/
            });*/

            $('#filterForm').submit(function(e){
                e.preventDefault();
                var data = $( '#filterForm' ).serialize();
                //data += '&paging=20';
                alert(data);
                var output = function(cb){
                    $('.recordsContainer').html(cb);
                    
                };
                ajax_call('/Blogs/filteredList', 'POST', data, output);
                 $('#loadBlogs').attr('disabled', false);
                $('#loadBlogs').attr('data-offset', 10);
            });



            $('#loadBlogs').click(function(){
                var offSet = $(this).attr('data-offset');
                
                alert('Loading... '+offSet);

                
                var data = $( '#filterForm' ).serialize();
                data += '&offset='+offSet;
                alert(data);
                var output = function(cb){
                    if (cb != "") {
                        $('.recordsContainer').append(cb);
                    } else {
                         $('#loadBlogs').attr('disabled', true);
                    }
                        
                };
                ajax_call('/Blogs/filteredList', 'POST', data, output);

                    
                offSet =  parseInt(offSet, 10);
                offSet =offSet+10;
                $(this).attr('data-offset', offSet);
            });

            $('#clearfilter').click(function(){
                //alert('Clear... ');
                $("#filterForm").trigger('reset');
                $('#blog_topic').val('');
            });

            $('#export-blogs-excel').click(function(){
                //alert('Export Data');

                var query = '';
                var req_url = '/Blogs/export_blogs';

                //var data = $( '#filterForm' ).serialize();
                //alert(data);

                if($('#blog_topic').val() != ""){ query += 'blog_topic='+$('#blog_topic').val()+'&'; }

                if($('#blog_status').val() != ""){ query += 'blog_status='+$('#blog_status').val()+'&'; }

                if($('#blog_title').val() != ""){ query += 'blog_title='+$('#blog_title').val()+'&'; }

                if($('#blog_desc').val() != ""){ query += 'blog_desc='+$('#blog_desc').val()+'&'; }

                if($('#blog_type').val() != ""){ query += 'blog_type='+$('#blog_type').val()+'&'; }

                if($('#blog_cstart_date').val() != ""){ query += 'blog_cstart_date='+$('#blog_cstart_date').val()+'&'; }

                if($('#blog_cend_date').val() != ""){ query += 'blog_cend_date='+$('#blog_cend_date').val(); }

                //alert(query);

                if(query.charAt(query.length-1) == '&'){ query = query.slice(0, -1); }

                if(query != ""){ req_url = req_url + '?' + query; }

                window.location.assign(req_url);
                
            });

            
        });
</script>