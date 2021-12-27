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
                            Subscription List
                        </h2>
                        <!-- <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="<?php echo base_url() . 'Packages/index'; ?>">
                                <button type="button" class="btn btn-danger waves-effect m-r-20">Add</button>
                                </a>
                            </li>
                        </ul> -->

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
                            <h6 class="pull-right">Total Transaction amount:- <?php echo $total[0]['total'];?></h6>
                            <table class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th># Sr. No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th class="text-center">Package Name</th>
                                        <th class="text-center">Amount Paid</th>
                                        <th class="text-center">Transaction Date</th>
                                        <!-- <th class="text-center">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($sub as $key => $list):
                                        $num = $key + 1;
                                        echo '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list['name'] . '</td>
                                                <td>' . $list['user_email'] . '</td>
                                                <td>' . $list['package_name'] . '</td>
                                                <td class="text-center">' . $list['transaction_amount'] . '</td>
                                                <td class="text-center">' . date( "d-m-Y", strtotime( $list['transaction_date'] ) ) . '</td>
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