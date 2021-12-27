<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <!--<h2>
                JQUERY DATATABLES
                <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
            </h2>-->
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Define Experts
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <form name="export" id="export" method="POST" action="export_stock_forecast">
                                    <button type="submit" class="btn btn-danger waves-effect m-r-20">Export User's Forecast</button>
                                </form>
                            </li>
                        </ul>
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
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th># Sr. No</th>
                                        <th>Name</th>
                                        <th>Stock</th>
                                        <th>Weekly Forecast</th>
                                        <th>Monthly Forecast</th>
                                        <th>Yearly Forecast</th>
                                        <th>Expert</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $num = 0;
                                    $name = "";
                                    foreach ($users_forecasting as $key => $uf):
                                        //echo "<pre>";
                                        //print_r($uf);
                                        if ($uf['name'] == $name) {
                                            
                                        } else {
                                            $num = $num + 1;
                                            $isexpert_checked = ($uf['is_expert'] == "1") ? 'checked="checked"' : '';

                                            //"demo-checkbox" this class was applied to div
                                            $checkbox_define = '<div class="">
                                                <input type="checkbox" id="' . $uf['user_id'] . '" class="filled-in make-expert check' . $uf['user_id'] . '" data-isexpert="' . $uf['is_expert'] . '" ' . $isexpert_checked . ' value="' . $uf['user_id'] . '">
                                                <label for="' . $uf['user_id'] . '"></label>
                                            </div>';

                                            echo '<tr>'
                                            . '<td>' . $num . '</td>'
                                            . '<td>' . $uf['name'] . '</td>'
                                            . '<td>' . $uf['stock_name'] . '</td>'
                                            . '<td>' . $uf['weekly_forecast'] . '</td>'
                                            . '<td>' . $uf['monthly_forecast'] . '</td>'
                                            . '<td>' . $uf['yearly_forecast'] . '</td>'
                                            . '<td class="text-center">' . $checkbox_define . '</td>'
                                            . '<td class="text-center"><a href="#" data-toggle="modal" data-target="#userStockForecastDetail" data-userid="' . $uf['user_id'] . '"><i class="material-icons">remove_red_eye</i></a></td>'
                                            . '</tr>';
                                        }


//                                        if ($uf['name'] == $name) {
//                                            $displayname = "";
//                                            $checkbox_define = "";
//                                            $srno = "";
//                                        } else {
//                                            $num = $num + 1;
//                                            $srno = $num;
//                                            $displayname = $uf['name'];
//                                            $isexpert = ($uf['is_expert'] == "1") ? 'checked="checked"' : '';
//
//                                            //"demo-checkbox" this class was applied to div
//                                            $checkbox_define = '<div class="">
//                                                <input type="checkbox" id="' . $uf['user_id'] . '" class="filled-in make-expert" data-isexpert="' . $uf['is_expert'] . '" ' . $isexpert . ' value="' . $uf['user_id'] . '">
//                                                <label for="' . $uf['user_id'] . '"></label>
//                                            </div>';
//                                        }
//                                        echo '<tr>'
//                                        . '<td>' . $srno . '</td>'
//                                        . '<td>' . $displayname . '</td>'
//                                        . '<td>' . $uf['stock_name'] . '</td>'
//                                        . '<td>' . $uf['weekly_forecast'] . '</td>'
//                                        . '<td>' . $uf['monthly_forecast'] . '</td>'
//                                        . '<td>' . $uf['yearly_forecast'] . '</td>'
//                                        . '<td class="text-center">' . $checkbox_define . '</td>'
//                                        . '<td class="text-center"><a href=""><i class="material-icons">remove_red_eye</i></a></td>'
//                                        . '</tr>';

                                        $name = $uf['name'];
                                    endforeach;
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
<div class="modal fade in" id="userStockForecastDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> Forecasting</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>