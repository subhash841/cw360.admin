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
                            <?= @$page_title ;?>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                            <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#userModal" data-id="0">Add</button>
                            <!-- <button type="submit" id="export_userlist_excel" class="btn btn-danger waves-effect m-r-20">Export</button> -->
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                       
                                        <th>User ID</th>
                                        <th>Email</th>
                                        <th>Created Date</th>
                                        <th class="text-center notexport">Action</th>
                                        <th class="text-center notexport">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // print_r($users);
                                    foreach ($users as $key => $list ):
                                            $num = $key + 1;
                                            $newvalue = $list[ 'is_active' ] == 1 ? "checked" : "";
                                            $list=str_replace(array( '\'' ), "&#8217;", $list);

                                            echo '<tr>
                                              
                                                <td>' . $list[ 'id' ] . '</td>
                                                <td>' . $list[ 'email' ] . '</td>
                                                <td class="text-center">' . $list[ 'created_date' ] . '</td>
                                                
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#userModal" data-id="' . $list[ 'id' ] . '" data-editjson=\'' . json_encode($list) . '\' ><i class="material-icons">&#xE254;</i></a>&nbsp;&nbsp;
                                                </td>
                                               
                                                <td>
                                                    <a class="switch changeActiveUser" data-id="' . $list[ 'id' ] . '" data-type="topics" data-status=' . $list[ 'is_active' ] . '>
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

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">  
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">EDIT</h4>
            </div>  
            <form name="addUpdateUser"  method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input autocomplete="off" type="email" class="form-control" name="admin_email" id="admin_email" required>
                            <label class="form-label">Email Address</label>
                        </div>
                        <strong><small class="text-danger admin_emailErr"></small></strong>
                    </div>
                    <div class="form-group form-float passwor">
                        <div class="form-line">
                            <input autocomplete="off" type="text" class="form-control" name="admin_password" id="admin_password" required>
                            <label class="form-label">Password</label>
                        </div>
                         <strong><small class="text-danger admin_passwordErr"></small></strong>
                    </div>
                    <div class="form-group form-float">


                        <!-- <label class="form-label">Role</label>
                            <select class="form-group form-float select2" name="admin_role" id="admin_role" required select2> 
                                <option value="">Select</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select> -->

                        <label class="form-label">Status</label>
                        <a class="switch" data-id="1" data-type="status" data-status="1">
                            <?php
                            if ( @$is_active == 1 ) {
                                $checked = 'checked=""';
                            } else {
                                $checked = '';
                            }
                            ?>
                            <label><input type="checkbox" name="is_active" id="is_active" value="1" <?= $checked;?>><span class="lever switch-col-bluenew"></span></label>
                        </a>
                    </div>
                    <div class="form-group form-float m-t-10 menu-lists">
                        <h4 for="role" class="text-center">Menu list</h4><br>
                        <?php foreach($menu_list as $key => $value){ ?>
                            <div class="col-md-6">
                            <input type="checkbox" id="basic_checkbox_<?=$value['name']?>" class="filled-in chk-col-light-blue" name="menu_list[]" value="<?=$value['id']?>">
                            <label for="basic_checkbox_<?=$value['name']?>"><?=$value['name']?></label>
                            </div>
                         <?php  } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect new-user-btn">SAVE CHANGES</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#userModal').on('hidden.bs.modal', function () {
 $('#userModal form')[0].reset();
})
</script>
