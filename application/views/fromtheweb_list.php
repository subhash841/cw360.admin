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
                            From The Web List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                            </li>
                            <li class="dropdown">
                                <button type="submit" id="export_articles_excel" class="btn btn-danger waves-effect m-r-20">Export</button>
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
                                                <input type="text" class="form-control" name="web_title" id="web_title" maxlength="75" value="">
                                                <label class="form-label">Title</label>
                                            </div>
                                        </div>
                                    </div>
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
                                    foreach ( $web as $key => $p ):
                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
//                                            $isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
                                            $num = $key + 1;
                                            echo '<tr>'
                                            . '<td>' . $num . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                            . '<td class="text-center">
                                            <a class="switch changefromtheweb" data-id="' . $p[ 'id' ] . '" data-type="fromtheweb" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                                            . '<td class="text-center">
                                            <a href="' . base_url() . 'FromTheWeb/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="#" data-toggle="modal" data-target="#viewArticleDetails" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
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

            $('#filterForm').submit(function (e) {
                e.preventDefault();
                var data = $('#filterForm').serialize();
                var output = function (cb) {
                    $('.records').html(cb);
                };
                $.ajax({
                    url: base_url + 'FromTheWeb/filter_result',
                    data: data,
                    method: 'POST',
                }).done(function (e) {
                    if (e !== '') {
                        $('.records').html('');
                        $('.records').html(e);
                    }
                });

            });

            $('#loadlist').click(function (e) {
                var offSet = $(this).attr('data-offset');
                var data = '&offSet=' + offSet;
                $.ajax({
                    url: '/FromTheWeb/filteredList',
                    method: 'POST',
                    data: data
                }).done(function (e) {
                    console.log(e);
                    if (e !== '')
                        $('.records').append(e);
                    else
                        $('#loadlist').attr('disabled', true);
                });
                offSet = parseInt(offSet);
                offSet = offSet + 10;
                $(this).attr('data-offSet', offSet);
            });

            $('#filterclear').click(function () {
                $('#loadlist').removeAttr('disabled');
            });

            $('#export_articles_excel').click(function () {
                window.location.assign(base_url + 'FromTheWeb/export_to_excel');

            });
        });
</script>