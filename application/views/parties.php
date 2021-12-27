<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <!-- Exportable Table -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card p20">
                    <div class="row">
                        <form name="addeditparty" id="addeditparty" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="party_id" value="0">
                            <div class="col-md-2">
                                <div class="imgprev">
                                    <h5>Upload Image</h5>
                                    <label class="fw500">(.jpg or .png)</label>
                                    <input type="file" name="partyimg" id="partyimg" accept="image/*" style="display:none" onchange="readURL(this);"/>
                                    <label for="partyimg" class="btn bg-red">Browse</label>
                                    <img id="imgPrime" src="" name="drangndropimg">
                                    <div id="removethumb"><i class="fa fa-times"></i></div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="party_name" required>
                                        <label class="form-label">Party Name</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="party_abbr" required>
                                        <label class="form-label">Party abbreviation</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect">SAVE</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Parties List
                        </h2>
                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Abbreviation</th>
                                        <th>Party Icon</th>
                                        <th class="text-center" width="100">Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($parties as $key => $list):
                                        $num = $key + 1;
                                        echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list['name'] . '</td>
                                                <td>' . $list['abbreviation'] . '</td>
                                                <td><img class="partyimg" src=' . base_url() . '../webportal/images/party_logos/' . $list['icon'] . '></td>
                                                <td class="text-center">' . $list['created_date'] . '</td>
                                                <td class="text-center">
                                                    <a href="#" id="editparty" data-id="' . $list['id'] . '" data-editjson=\'' . json_encode($list) . '\'><i class="material-icons">&#xE254;</i></a>&nbsp;&nbsp;
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
                <h4 class="modal-title" id="defaultModalLabel">Category Modal</h4>
            </div>
            <form name="addUpdateBlogCategory" id="form_validation" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="categoryid" id="categoryid" value="0">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="category_name" required>
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
<script>
    function readURL(input) {
        console.log(input.files);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                //$('#falseinput').attr('src', e.target.result);
                //$('#base').val(e.target.result);
                $("#imgPrime").attr("src", e.target.result);
                $('#imgPrime').css('display', 'block');
                $('.dz-preview').remove();
                $('#removethumb').css('display', 'block');
                //$('#cwimg').val(e.target.result)
                document.getElementById('removethumb').addEventListener('click', function () {
                    //_this.removeAllFiles();
                    $("#imgPrime").attr("src", '');
                    $('#imgPrime').css('display', 'none');
                    $('#removethumb').css('display', 'none');
                    $('input[type=file]').val(null);
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


