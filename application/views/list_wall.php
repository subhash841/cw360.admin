
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
                            Wall List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                            </li>
                            <li class="dropdown">
                                <button type="submit" id="export_walls_excel" class="btn btn-danger waves-effect m-r-20">Export</button>
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
                                                <input type="text" class="form-control" name="wall_title" id="wall_title" maxlength="75" value="">
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
                                        <input type="hidden" class="form-control" name="offSet" id="offSet" readonly="readonly" value="1" style="background-color: transparent;">
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 align-center">
                                        <button type="submit" class="btn btn-danger waves-effect" id="filterapply">APPLY FILTER</button>
                                        <button type="reset" class="btn btn-danger waves-effect" id="filterclear">CLEAR FILTER</button>
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
                                        <th>Title </th>
                                        <th class="text-center" width='100'>Created Date</th>
                                        <th class="text-right">Active</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    foreach ( $wall_details as $key => $p ):
                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                            $num = $key + 1;
                                            echo '<tr>'
                                            . '<td>' . $num . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                            . '<td class="text-center">
                                            <a class="switch changeactivewall" data-id="' . $p[ 'id' ] . '" data-type="surveys" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                                            . '<td class="text-center">
                                            <a href="' . base_url() . 'Wall/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="' . base_url() . 'Wall/wall_details?id=' . $p[ 'id' ] . '"  data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
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

<script>
        $(function () {
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
            $('#loadlist').click(function (e) {
                var offSet = $(this).attr('data-offset');
                var data = '&offSet=' + offSet;
                $.ajax({
                    url: '/Wall/filteredList',
                    method: 'POST',
                    data: data
                }).done(function (e) {
                    if (e !== '')
                        $('.records').append(e);
                    else
                        $('#loadlist').attr('disabled', true);
                });
                offSet = parseInt(offSet, 10);
                offSet = offSet + 10;
                $(this).attr('data-offSet', offSet);
            });
            $('#export_walls_excel').click(function () {
                window.location.assign(base_url + 'Wall/export_wall');
            });

            $(document).on('submit', '#filterForm', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    url: base_url + 'Wall/wall_filter',
                    method: 'POST',
                    data: data
                }).done(function (e) {
                    $('.records').html('');

                    if (e !== '') {
                        $('.records').append(e);
                    }
                });

            })
        })
</script>
