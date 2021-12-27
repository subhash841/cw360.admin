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
                            Stock List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#stockModal" data-id="0">Add</button>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th># Sr. No</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($stock_list as $key => $list):
                                        $num = $key + 1;
                                        echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list['name'] . '</td>
                                                <td>' . $list['code'] . '</td>
                                                <td class="text-center">' . $list['created_date'] . '</td>
                                                <td class="text-center"><a href="#" data-toggle="modal" data-target="#stockModal" data-id="' . $list['id'] . '" data-editjson=\'' . json_encode($list) . '\'><i class="material-icons">&#xE254;</i></a></td>
                                            </tr>';
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
<!-- Default Size -->
<div class="modal fade" id="stockModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Stock Modal</h4>
            </div>
            <form name="addUpdateStock" id="form_validation" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="stockid" id="stockid" value="0">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="stock_name" required>
                            <label class="form-label">Name</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="stock_code" required>
                            <label class="form-label">Code</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">SAVE CHANGES</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
