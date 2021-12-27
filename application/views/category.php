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
                            Category List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#categoryModal" data-id="0">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th class="text-center" width="100">Date</th>
                                        <th class="text-center notexport">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($category_list as $key => $list):
                                        $num = $key + 1;
                                        $list=str_replace(array( '\'' ), "&#8217;", $list);

                                        echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list['name'] . '</td>
                                                <td class="text-center">' . $list['created_date'] . '</td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal" data-target="#categoryModal" data-id="' . $list['id'] . '" data-editjson=\'' . json_encode($list) . '\'><i class="material-icons">&#xE254;</i></a>&nbsp;&nbsp;
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

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"></h4>
            </div>
            <form name="addUpdateBlogCategory" id="form_validation" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="categoryid" id="categoryid" value="0">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="category_name" maxlength="25"required>
                            <label class="form-label">Category Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect add-cat-btn"></button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
           $('input[name="category_name"]').on('change', function(){
            var tp_name = $('input[name="category_name"]').val().trim();
            $('input[name="category_name"]').val(tp_name);
        });


        /*$('input[name="category_name"]').keypress(function(event) {
            var character = String.fromCharCode(event.keyCode);
            return isValid(character);     
        });

        function isValid(str) {
            return !/[~`!@#$%\^&*()+_=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
        }*/

        
</script>

