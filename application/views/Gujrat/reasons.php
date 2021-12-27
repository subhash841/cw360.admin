<?php // var_dump($reasons);exit; ?>
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
                            Reason List
                        </h2>

                    </div>
                    <div class="body">
                        <div class="">
                            <table class="table table-responsive table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Forecast type</th>
                                        <th class="text-center">Reason</th>
                                        <th class="text-center">Created Date</th>
                                        <th class="text-center">Modified Date</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($reasons)) { ?>
                                        <?php
                                        foreach ($reasons as $key => $list):
                                            $num = $key + 1;
                                            echo '<tr>
                                                    <td>' . $num . '</td>
                                                    <td>' . $list['forecast_type'] . '</td>
                                                    <td>' . $list['reason'] . '</td>
                                                    <td class="text-center">' . $list['created_date'] . '</td>
                                                    <td class="text-center">' . $list['modified_date'] . '</td>   
                                                    <td class="text-center">
                                                        <a href="#" data-toggle="modal" data-target="#deleteReasonModal" data-id="' . $list['id'] . '"><i class="material-icons">delete</i></a>&nbsp;&nbsp;
                                                    </td>
                                                </tr>';
                                        endforeach;
                                        ?>
                                    <?php } else { ?>
                                    <?php } ?>
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

<div class="modal fade" id="deleteReasonModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Delete Reason</h4>
            </div>
            <form name="deleteforecastreason" id="form_validation" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="forecastreasonid" id="forecastreasonid">
                    <input type="hidden" name="forecasttype" id="forecasttype" value="Gujrat">
                    <h5>Are you sure want to delete ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">Yes</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

