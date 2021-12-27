<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <!--<h2>
                JQUERY DATATABLES
                <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
            </h2>-->
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Add Stocks & Period
                        </h2>

                        <!--<ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>-->
                    </div>
                    <div class="body">
                        <form name="addUpdateStockPeriod" id="form_validation" method="POST">
                            <input type="hidden" name="stock_period_id" id="stock_period_id" value="0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date" id="from_datetimepicker">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="from_date" id="from_date" readonly="readonly" required style="background-color: transparent;"/>
                                                <label class="form-label">From Date</label>
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
                                                <input type="text" class="form-control" name="to_date" id="to_date" readonly="readonly" required style="background-color: transparent;"/>
                                                <label class="form-label">To Date</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select name="stocks[]" id="optgroup" class="ms" multiple="multiple">
                                        <?php
                                        foreach ($stock_list as $key => $lists):
                                            echo '<option value="' . $lists['id'] . '">' . $lists['name'] . '</option>';
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 align-center">
                                    <button id="addstock" type="submit" class="btn btn-primary waves-effect">SAVE CHANGES</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Stocks & Period
                        </h2>
                        <!--<ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#stockPeriodModal">Add</button>
                            </li>
                        </ul>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>-->
                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th># Sr. No</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <!--<th>From Date</th>
                                        <th>To Date</th>-->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $num = 0;
                                    foreach ($stock_period_list as $key => $spl):

                                        if ($spl['is_result_out'] == "0") {
                                            $icon = "thumb_down";
                                            $title = "Stop Forecasting";
                                        } else {
                                            $icon = "thumb_up";
                                            $title = "Start Forecasting";
                                        }

                                        //Weekly forecast stop
                                        if ($spl['is_weekly_stop'] == "0") {
                                            $weekly_icon = "thumb_down";
                                            $weekly_title = "Stop Weekly Forecasting";
                                        } else {
                                            $weekly_icon = "thumb_up";
                                            $weekly_title = "Start Weekly Forecasting";
                                        }

                                        //Monthly forecast stop
                                        if ($spl['is_monthly_stop'] == "0") {
                                            $monthly_icon = "thumb_down";
                                            $monthly_title = "Stop monthly Forecasting";
                                        } else {
                                            $monthly_icon = "thumb_up";
                                            $monthly_title = "Start monthly Forecasting";
                                        }

                                        //Yealy forecast stop
                                        if ($spl['is_yearly_stop'] == "0") {
                                            $yearly_icon = "thumb_down";
                                            $yearly_title = "Stop yearly Forecasting";
                                        } else {
                                            $yearly_icon = "thumb_up";
                                            $yearly_title = "Start yearly Forecasting";
                                        }

                                        $start_stop_weekly = '<a href="#" data-toggle="modal" data-target="#start_stop_stock_forecasting" data-stock_period_id="' . $spl['stock_period_id'] . '" data-result="' . $spl['is_weekly_stop'] . '" data-result_type="stopweekly"><i class="material-icons" title="' . $weekly_title . '">' . $weekly_icon . '</i></a>';
                                        $start_stop_monthly = '<a href="#" data-toggle="modal" data-target="#start_stop_stock_forecasting" data-stock_period_id="' . $spl['stock_period_id'] . '" data-result="' . $spl['is_monthly_stop'] . '" data-result_type="stopmonthly"><i class="material-icons" title="' . $monthly_title . '">' . $monthly_icon . '</i></a>';
                                        $start_stop_yearly = '<a href="#" data-toggle="modal" data-target="#start_stop_stock_forecasting" data-stock_period_id="' . $spl['stock_period_id'] . '" data-result="' . $spl['is_yearly_stop'] . '" data-result_type="stopyearly"><i class="material-icons" title="' . $yearly_title . '">' . $yearly_icon . '</i></a>';

                                        $start_stop_forecast = '<a href="#" data-toggle="modal" data-target="#start_stop_stock_forecasting" data-stock_period_id="' . $spl['stock_period_id'] . '" data-result="' . $spl['is_result_out'] . '" data-result_type="stopfull"><i class="material-icons" title="' . $title . '">' . $icon . '</i></a>';

                                        $weekly_endon_date = ($spl['weekly_endon_date'] == "") ? "" : date("d-m-Y", strtotime($spl['weekly_endon_date']));
                                        $monthly_endon_date = ($spl['monthly_endon_date'] == "") ? "" : date("d-m-Y", strtotime($spl['monthly_endon_date']));
                                        $yearly_endon_date = ($spl['yearly_endon_date'] == "") ? "" : date("d-m-Y", strtotime($spl['yearly_endon_date']));

                                        $num = $key + 1;
                                        echo '<tr>'
                                        . '<td>' . $num . '</td>'
                                        . '<td>' . str_replace(",", "<br />", $spl['name']) . '</td>'
                                        . '<td>' . str_replace(",", "<br />", $spl['code']) . '</td>'
                                        . '<!--<td>' . date("d-m-Y", strtotime($spl['from_date'])) . '</td>'
                                        . '<td>' . date("d-m-Y", strtotime($spl['to_date'])) . '</td>-->'
                                        . '<td>'
                                        . '<!--<a href="#"><i class="material-icons edit-stock" data-editjson=\'' . json_encode($spl) . '\'>create</i></a>-->'
                                        . $start_stop_weekly . '&nbsp;&nbsp;&nbsp;&nbsp;'
                                        . $start_stop_monthly . '&nbsp;&nbsp;&nbsp;&nbsp;'
                                        . $start_stop_yearly . '&nbsp;&nbsp;&nbsp;&nbsp;'
                                        . '<a href="#" data-toggle="modal" data-target="#update_stock_endon_date" data-stock_period_id="' . $spl['stock_period_id'] . '" data-weekly_end_date="' . $weekly_endon_date . '" data-monthly_end_date="' . $monthly_endon_date . '" data-yearly_end_date="' . $yearly_endon_date . '"><i class="glyphicon glyphicon-calendar" title="End on Date" style="top: -4px;font-size:19px;"></i></a>'
                                        . '</td>'
                                        . '</tr>';
                                    endforeach;

//                                    foreach ($stock_period_list as $key => $spl):
//                                        $num = $num + 1;
//                                        //echo '<option value="' . $lists['id'] . '">' . $lists['name'] . '</option>';
//                                        $s_id = explode(',', $spl['stock_id']);
//                                        $s_name = explode(',', $spl['stock_name']);
//                                        $s_code = explode(',', $spl['stock_code']);
//                                        //var_dump(sizeof($s_code));exit;
//
//                                        foreach ($s_id as $index => $sid) {
//                                            echo '<tr>'
//                                            . '<td>' . $num . '</td>';
//                                            //echo '<td>' . $sid . '</td>';
//                                            echo '<td>' . $s_name[$index] . '</td>'
//                                            . '<td>' . $s_code[$index] . '</td>';
//                                            echo '<td>' . $spl['from_date'] . '</td>'
//                                            . '<td>' . $spl['to_date'] . '</td>';
//                                            if ($index == 0) {
//                                                echo '<td rowspan="' . sizeof($s_id) . '"><a href="#" data_id=' . $spl['id'] . '><i class="material-icons">create</i></a></td>';
//                                                echo '</tr>';
//                                            } else {
//                                                echo '<td></td>';
//                                            }
//                                            echo '</tr>';
//                                        }
//
////                                        echo '<td>' . $spl['name'] . '</td>'
////                                        . '<td>' . $spl['code'] . '</td>'
////                                        echo '<td><a href="#" data_id=' . $spl['id'] . '><i class="material-icons">create</i></a></td>'
////                                        . '</tr>';
//                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
</section>

<div class="modal fade in" id="start_stop_stock_forecasting" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="frm_start_stop_stock_forecast" id="frm_start_stop_stock_forecast" method="POST" action="updateStockResultOut">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">End Date</h4>
                </div>
                <div class="modal-body">
                    <span class="message">Are you sure you want to stop forecasting?</span>
                    <input type="hidden" name="stock_period_id" id="stock_period_id" value="" />
                    <input type="hidden" name="is_result_out" id="is_result_out" value="" />
                    <input type="hidden" name="result_type" id="result_type" value="" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">Yes</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade in" id="update_stock_endon_date" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="frm_update_stock_endon_date" id="frm_update_stock_endon_date" method="POST" action="updateEndOnDate">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="endon_date_stock_period_id" id="endon_date_stock_period_id" value="" />
                            <div class="form-group form-float">
                                <div class="input-group date" id="weekly_datetimepicker">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="weekly_end_date" id="weekly_end_date" readonly="readonly" required="" style="background-color: transparent;" aria-required="true">
                                        <label class="form-label">Weekly End Date</label>
                                    </div>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="input-group date" id="monthly_datetimepicker">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="monthly_end_date" id="monthly_end_date" readonly="readonly" required="" style="background-color: transparent;" aria-required="true">
                                        <label class="form-label">Monthly End Date</label>
                                    </div>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="input-group date" id="yearly_datetimepicker">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="yearly_end_date" id="yearly_end_date" readonly="readonly" required="" style="background-color: transparent;" aria-required="true">
                                        <label class="form-label">Yearly End Date</label>
                                    </div>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">Yes</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">No</button>
                </div>
            </form>
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
        $('#monthly_datetimepicker').datetimepicker({
            useCurrent: false,
            format: "DD-MM-YYYY",
            minDate: moment().millisecond(0).second(0).minute(0).hour(0),
            ignoreReadonly: true
        });
        $('#yearly_datetimepicker').datetimepicker({
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

        $("#from_datetimepicker").on("dp.change", function (e) {
            $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
        });
        $("#to_datetimepicker").on("dp.change", function (e) {
            $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
        });

        $(".edit-stock").on("click", function (event) {
            event.preventDefault();
            var json = JSON.parse($(this).attr("data-editjson"));
            var base = "form[name='addUpdateStockPeriod'] ";
            $(base + "#stock_period_id").val(json.stock_period_id);
            $(base + "#from_date").val(convertDate(json.from_date)).focus();
            $(base + "#to_date").val(convertDate(json.to_date)).focus();

            var selected = json.stock_id.split(',');
            for (var x in selected) {
                $(base + "select#optgroup").find("option[value='" + selected[x] + "']").prop("selected", "selected");
            }
            $('#optgroup').multiSelect();
        });
    });
</script>