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
                            Blogs
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="<?= base_url() ?>Blogs/addeditblogview/0" target="_Blank"><button type="button" class="btn btn-danger waves-effect m-r-20" data-id="0">Add</button></a>
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
                        <h2>Pending</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th width="400">Description</th>
                                        <th class="text-center" width="100">Date</th>
                                        <th class="text-center" width="50">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ( $pending_blog_list as $key => $list ):
                                            $num = $key + 1;
                                            $newvalue = $list[ 'is_active' ] == 1 ? "checked" : "";
                                            $description = str_replace( '\\', '/', $list[ 'description' ] );
                                            $description = preg_replace( "/<style(.*)<\/style>/iUs", "", $description );
                                            $description = str_replace( "&nbsp;", " ", $description );
                                            echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list[ 'title' ] . '</td>
                                                <td><p class="ellipsis">' . strip_tags( $description ) . '</p></td>
                                                <td class="text-center">' . $list[ 'created_date' ] . '</td>
                                                <td class="text-center">
                                                    <a class="btn btn-default" href="' . base_url() . 'Blogs/addeditblogview/' . $list[ 'id' ] . '" style="max-width:45px"><i class="material-icons">remove_red_eye</i></a>
                                                </td>
                                                
                                            </tr>';
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <h2>Approved</h2>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th width="400">Description</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center" width="100">Date</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Active</th>
                                        <!--<th class="text-center">Order</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ( $blog_list as $key => $list ):
                                            $num = $key + 1;
                                            $newvalue = $list[ 'is_active' ] == 1 ? "checked" : "";
                                            $description = str_replace( '\\', '/', $list[ 'description' ] );
                                            $description = preg_replace( "/<style(.*)<\/style>/iUs", "", $description );
                                            $description = str_replace( "&nbsp;", " ", $description );
                                            $type = ($list[ 'type' ] == "1") ? "Blog" : "Article";
                                            echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list[ 'title' ] . '</td>
                                                <td><p class="ellipsis">' . strip_tags( $description ) . '</p></td>
                                                <td>' . $type . '</td>
                                                <td class="text-center">' . $list[ 'created_date' ] . '</td>
                                                <td class="text-center">
                                                    <a href="' . base_url() . 'Blogs/addeditblogview/' . $list[ 'id' ] . '" target="_Blank"><i class="material-icons">&#xE254;</i></a>
                                                    <a href="' . base_url() . 'Blogs/previewblog/' . $list[ 'id' ] . '" target="_Blank"><i class="material-icons">remove_red_eye</i></a>
                                                </td>';
                                            echo '<td>
                                                    <a class="switch changeactive" data-id="' . $list[ 'id' ] . '" data-type="blogs" data-status=' . $list[ 'is_active' ] . '>
                                                        <label><input type="checkbox" ' . $newvalue . '><span class="lever switch-col-bluenew"></span></label>
                                                    </a>
                                                </td>';
                                             '<td class="text-center">
                                                <input type="text" class="text-center blog_order" style="width:100%" data-id="' . $list[ 'id' ] . '" name="blog_order" value="' . $list[ 'blog_order' ] . '">
                                                </td>
                                               </tr>
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
<div class="modal fade" id="userBlogDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Blog Detail</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3"><strong>Title <span class="pull-right">:</span></strong></div>
                    <div class="col-sm-9 mb10 blogtitle"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><strong>Description <span class="pull-right">:</span></strong></div>
                    <div class="col-sm-9 mb10 blogdesc"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><strong>Blog Date <span class="pull-right">:</span></strong></div>
                    <div class="col-sm-9 mb10 blogdate"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><strong>Created Date <span class="pull-right">:</span></strong></div>
                    <div class="col-sm-9 mb10 blogcreated"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="blogModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Blog Modal</h4>
            </div>
            <form name="addUpdateBlog" id="form_validation" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="blogid" id="blogid" value="0">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control" name="blog_category" required>
                                <option value="">--Select Category--</option>
                                <?php
                                foreach ( $category_list as $key => $list ):
                                        echo '<option value="' . $list[ 'id' ] . '">' . $list[ 'name' ] . '</option>';
                                endforeach;
                                ?>

                            </select>
                            <label class="form-label">Category</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control" name="blog_subcategory" required>
                                <option value="">--Select Sub Category--</option>
                                <?php
                                foreach ( $sub_category_list as $key => $list ):
                                        echo '<option data-catid="' . $list[ 'category_id' ] . '" value="' . $list[ 'id' ] . '">' . $list[ 'name' ] . '</option>';
                                endforeach;
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="blog_title" required aria-required="true">
                            <label class="form-label">Title</label>
                        </div>
                    </div>
                    <label class="form-label">Description</label>
                    <!--                    <div class="form-group form-float">
                                            <textarea class="form-control" id="blog_description" name="blog_description" rows="2" style="display: none;" required aria-required="true"></textarea>
                                        </div>-->
                    <div class="form-group form-float">
                        <div id="blog_desc_editor"></div>
                        <label id="blog_description-error" class="editorerror" >This field is required.</label>
                    </div>

                    <div class="form-group form-float">
                        <div class="input-group date" id="blog_datetimepicker">
                            <div class="form-line">
                                <input type="text" class="form-control" name="blog_date" id="blog_date" readonly="readonly" required="" style="background-color: transparent;" aria-required="true">
                                <label class="form-label">Blog Date</label>
                            </div>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input id="uploadFile" placeholder="Choose Cover Image" disabled="disabled" />
                            <div class="fileUpload btn btn-primary">
                                <span>Upload</span>
                                <input id="uploadBtn" name="blog_img" type="file" class="upload"/>
                            </div>
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

<script>
        $(function () {
            $('#blog_date').datetimepicker({
                useCurrent: true,
                format: "DD-MM-YYYY",
                minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                ignoreReadonly: true
            });

            //image file change function 
            $("#uploadBtn").on("change", function () {
                var filename = $(this).val();
                filename = filename.replace(/\\/g, '/').replace(/.*\//, '');
                $("#uploadBtn").closest(".form-group").find("#uploadFile").val(filename);
            });
        });
</script>