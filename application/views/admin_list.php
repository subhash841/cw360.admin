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
                            Admin List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#adminModal" data-id="0">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <!--<th class="text-center">Image</th>
                                        <th class="text-center">Icon</th>-->
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ( $admins as $key => $list ):
                                            $num = $key + 1;
                                            $newvalue = $list[ 'is_active' ] == 1 ? "checked" : "";

                                            echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list[ 'email' ] . '</td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#adminModal" data-id="' . $list[ 'id' ] . '" data-editjson=\'' . json_encode( $list ) . '\'><i class="material-icons">&#xE254;</i></a>&nbsp;&nbsp;
                                                </td>
                                                <td>
                                                    <a class="switch changeActiveAdmin" data-id="' . $list[ 'id' ] . '" data-type="admins" data-status=' . $list[ 'is_active' ] . '>
                                                        <label><input type="checkbox" ' . $newvalue . '><span class="lever switch-col-bluenew"></span></label>
                                                    </a>
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

<div class="modal fade" id="adminModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="addUpdateAdmin" id="form_validation" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">EDIT</h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="adminid" id="adminid">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="email" class="form-control" name="admin_email" required>
                            <label class="form-label">Admin Email Address</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" class="form-control" name="admin_password" required>
                            <label class="form-label">Admin Password</label>
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


<script type="text/javascript"></script>