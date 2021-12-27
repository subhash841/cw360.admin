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
                            State List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#stateModal" data-id="0">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="text-center" width="100">Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($states as $key => $list):
                                        $num = $key + 1;
                                        echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list['name'] . '</td>
                                                <td class="text-center">' . $list['created_date'] . '</td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#stateModal" data-id="' . $list['id'] . '" data-editjson=\'' . json_encode($list) . '\'><i class="material-icons">&#xE254;</i></a>&nbsp;&nbsp;
                                                </td>
                                            </tr>';
                                    endforeach;
                                    ?>
                                    <!--<a href="#" data-toggle="modal" data-target="#delcategoryModal" data-id="' . $list['id'] . '"><i class="material-icons">&#xE872;</i></a>-->
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

<div class="modal fade" id="stateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">EDIT</h4>
            </div>
            <form name="addUpdateState" id="form_validation" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="stateid" id="stateid" value="0">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="state_name" required>
                            <label class="form-label">State Name</label>
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


