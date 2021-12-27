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
                            Sub Category List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#subCategoryModal" data-id="0">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th class="text-center" width="100">Date</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($sub_category_list as $key => $list):
                                        $num = $key + 1;
                                        $newvalue=$list['is_active'] == 1 ? "checked" : "";
                                        echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list['category'] . '</td>
                                                <td>' . $list['name'] . '</td>
                                                <td class="text-center">' . $list['created_date'] . '</td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#subCategoryModal" data-id="' . $list['id'] . '" data-editjson=\'' . json_encode($list) . '\'><i class="material-icons">&#xE254;</i></a>&nbsp;&nbsp;
                                                </td>';
                                            echo '<td>
                                                    <a class="switch changeactive" data-id="' . $list['id'] . '" data-type="subcategory" data-status='.$list['is_active'].'>
                                                        <label><input type="checkbox" '.$newvalue.'><span class="lever switch-col-bluenew"></span></label>
                                                    </a>
                                                </td>
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

<div class="modal fade" id="subCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Sub Category Modal</h4>
            </div>
            <form name="addUpdateBlogSubCategory" id="form_validation" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="subcategoryid" id="subcategoryid" value="0">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control" name="category_id" required>
                                <option value="">--Select Category--</option>
                                <?php
                                foreach ($category_list as $key => $list):
                                    echo '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';


                                endforeach;
                                ?>

                            </select>
                            <label class="form-label">Category Name</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="sub_category_name" required>
                            <label class="form-label">Category Name</label>
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