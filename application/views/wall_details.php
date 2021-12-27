

<section class="content">
    <div class="container-fluid">
        <div class="block-header"></div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Survey Details</h2><br>
                        <div id="viewPollDetails">
                            <div class="pbody">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <span>Image</span>
                                            <img src=" <?= @$wall_detail[ 0 ][ 'image' ] ; ?> " style="max-width:100%;height: auto;">
                                    </div>
                                    <div class="col-sm-4">
                                        <span>Created at: </span><h5>
                                            <?= date( "d-m-Y", strtotime( @$wall_detail[ 0 ][ 'created_date' ] ) ); ?>
                                        </h5>                                 
                                    </div>
                                    <div class="col-sm-4">
                                        <span>Title</span><h5><?= @$wall_detail[ 0 ][ 'title' ] ?></h5>
                                    </div>
                                    <div class="col-sm-4">
                                        <span>Total Likes</span><h5><?= @$wall_detail[ 0 ][ 'total_like' ] ?></h5>
                                    </div>
                                    <div class="col-sm-4">
                                        <span>Total neutral: </span><h5><?= @$wall_detail[ 0 ][ 'total_neutral' ] ?></h5>
                                    </div>
                                    <div class="col-sm-4">
                                        <span>Total Dislike: </span><h5><?= @$wall_detail[ 0 ][ 'total_dislike' ] ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>