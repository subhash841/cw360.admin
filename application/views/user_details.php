<style>
    .delete_choice{
        cursor:pointer;
        position: absolute;
        top: 0;
        right: 4%;
        z-index: 1;
        font-size: large;
    }
    .display-delete{
        display: none;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            User Details
                        </h2>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Basic Details
                        </h2>
                    </div>
                    <div class="body">
                        <?php
                        $user_id = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                        //$end_date = (@$end_date == "") ? "" : date( "d-m-Y", strtotime( @$end_date ) );
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <span>Name:</span>
                                <h5><?= @$name ?></h5>
                            </div>
                            <div class="col-sm-4">
                                <span>Email:</span>
                                <h5><?= @$email ?></h5>
                            </div>
                            <div class="col-sm-4">
                                <span>Alise:</span>
                                <h5><?= @$alise ?></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <span>Login Type:</span>
                                <h5><?= @$login_type ?></h5>
                            </div>
                            <div class="col-sm-4">
                                <span>Location:</span>
                                <h5><?= @$location ?></h5>
                            </div>
                            <div class="col-sm-4">
                                <span>Party Affiliation:</span>
                                <h5><?= @$party ?></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <span>Gold Coins:</span>
                                <h5><?= @$earned_points ?></h5>
                            </div>
                            <div class="col-sm-4">
                                <span>Silver Coins:</span>
                                <h5><?= @$unearned_points ?></h5>
                            </div>
                            <div class="col-sm-4">
                                <span>Created On:</span>
                                <h5><?php echo date( "d F Y", strtotime( @$created_date ) );  ?></h5>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="card">
                    <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#home" data-toggle="tab">PREDICTIONS (<?= $counts['prediction']['total_polls']; ?>)</a></li>
                                <li role="presentation"><a href="#profile" data-toggle="tab">ASK QUESTIONS (<?= $counts['surveys']['total_surveys']; ?>)</a></li>
                                <li role="presentation"><a href="#messages" data-toggle="tab">YOUR VOICE (<?= $counts['blogs']['total_blogs']; ?>)</a></li>
                                <li role="presentation"><a href="#settings" data-toggle="tab">RATED ARTICLES (<?= $counts['articles']['total_articles']; ?>)</a></li>
                                <li role="presentation"><a href="#points" data-toggle="tab">Coins (<?= $counts['points']['total_points']; ?>)</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                    <div class="header">
                                    <b>PREDICTIONS</b>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown">
                                                <button type="submit" id="export-userpolls-excel" class="btn btn-danger waves-effect m-r-20">Export</button>
                                                <button type="submit" class="btn btn-danger waves-effect m-r-20">Filter</button>

                                            
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="body poll-filters">
                                        <form id="filterPolls" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="poll_type" id="poll_type">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="1">Raised</option>
                                                            <option value="2">Participated</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="poll_quest" id="poll_quest" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Question</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="poll_desc" id="poll_desc" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="poll_status" id="poll_status">
                                                            <option value="">-- Select Status --</option>
                                                            <option value="1">Public</option>
                                                            <option value="2">Private</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="pollend_from_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="pollend_start_date" id="pollend_start_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Poll Ending Start Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="pollend_to_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="pollend_end_date" id="pollend_end_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Poll Ending End Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="poll_from_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="poll_cstart_date" id="poll_cstart_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created Start Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="poll_to_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="poll_cend_date" id="poll_cend_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created End Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="user_id" id="user_id" readonly="readonly" value="<?php echo $_GET['id']; ?>" style="background-color: transparent;" aria-required="true">
                                            <input type="hidden" class="form-control" name="offset" id="offset" readonly="readonly" value="0" style="background-color: transparent;">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 align-center">
                                                <button id="addelection" type="submit" class="btn btn-danger waves-effect">APPLY FILTER</button>
                                                <button id="clearpollsfilter" type="submit" class="btn btn-danger waves-effect">CLEAR FILTER</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>

                                    <div class="body">
                                        <div class="">
                                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                                <thead>
                                                    <tr>
                                                        <th># Sr. No</th>
                                                        <th>Category</th>
                                                        <th>Poll</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Is Approved</th>
                                                        <th class="text-center">Created Date</th>
                                                        <th class="text-right">Active</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="pollsContainer">
                                                    <?php
                                                    foreach ( $predictions as $key => $p ):
                                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                                            $isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
                                                            $num = $key + 1;
                                                            
                                                            $update_right_answer = '';
                                                            
                                                            if ( strtotime( $p[ 'end_date' ] ) < strtotime( date( "Y-m-d" ) ) ) {
                                                                    $update_right_answer = ($p[ 'right_choice' ] == "") ? '<a href="' . base_url() . 'Poll/details/' . $p[ 'id' ] . '"><i class="material-icons">info_outline</i></a>' : '';
                                                            }
                                                            echo '<tr>'
                                                            . '<td>' . $num . '</td>'
                                                            . '<td>' . $p[ 'category' ] . '</td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'poll' ] . '</p></td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                                                            . '<td class="text-center">' . $isapproved . '</td>'
                                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                                            . '<td class="text-center">
                                                                <a class="switch changeactivepoll" data-id="' . $p[ 'id' ] . '" data-type="polls" data-status=' . $p[ 'is_active' ] . '>
                                                                    <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                                                </a>
                                                            </td>'
                                                            . '<td class="text-center">
                                                                <a href="' . base_url() . 'Poll/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                                                <a href="#" data-toggle="modal" data-target="#viewPollDetails" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                                                                ' . $update_right_answer . '
                                                                </td>';
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div style="padding-bottom: 25px;">
                                        <center>
                                            <button id="loadUserPolls" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                                        </center>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                    <b>Ask Questions</b>
                                    <button type="submit" id="export-usersurveys-excel" class="btn btn-danger waves-effect m-r-20">Export</button>

                                    <div class="body survey-filters">
                                        <form id="filterSurveys" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="survey_status" id="survey_status">
                                                            <option value="">-- Select Status --</option>
                                                            <option value="1">Raised</option>
                                                            <option value="2">Participated</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="survey_quest" id="survey_quest" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Question</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="survey_desc" id="survey_desc" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="survey_from_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="survey_cstart_date" id="survey_cstart_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created Start Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="survey_to_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="survey_cend_date" id="survey_cend_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created End Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="user_id" id="user_id" readonly="readonly" value="<?php echo $_GET['id']; ?>" style="background-color: transparent;" aria-required="true">
                                            <input type="hidden" class="form-control" name="offset" id="offset" readonly="readonly" value="0" style="background-color: transparent;">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 align-center">
                                                <button id="addelection" type="submit" class="btn btn-danger waves-effect">APPLY FILTER</button>
                                                <button id="clearsurveysfilter" type="submit" class="btn btn-danger waves-effect">CLEAR FILTER</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>

                                    <div class="body">
                                        <div class="">
                                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                                <thead>
                                                    <tr>
                                                        <th># Sr. No</th>
                                                        
                                                        <th>Survey</th>
                                                        <th>Description</th>
                <!--                                        <th class="text-center">Is Approved</th>-->
                                                        <th class="text-center">Created Date</th>
                                                        <th class="text-right">Active</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="surveysContainer">
                                                    <?php
                                                    foreach ($surveys as $key => $p):
                                                        $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                                        $num = $key + 1;
                                                        echo '<tr>'
                                                        . '<td>' . $num . '</td>'
                                                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p['question'] . '</p></td>'
                                                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p['description'] . '</p></td>'
                                                        //. '<td class="text-center">' . $isapproved . '</td>'
                                                        . '<td class="text-center">' . date("d-m-Y", strtotime($p['created_date'])) . '</td>'
                                                        . '<td class="text-center">
                                                            <a class="switch changeactivesurvey" data-id="' . $p['id'] . '" data-type="surveys" data-status=' . $p['is_active'] . '>
                                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                                            </a>
                                                        </td>'
                                                        . '<td class="text-center">
                                                            <a href="' . base_url() . 'Survey/index?id=' . $p['id'] . '" data-id="' . $p['id'] . '" data-editjson=\'' . json_encode($p) . '\'><i class="material-icons">&#xE254;</i></a>
                                                            <a href="#" data-toggle="modal" data-target="#viewSurveyDetails" data-id="' . $p['id'] . '"><i class="material-icons">remove_red_eye</i></a>
                                                        </td>';
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div style="padding-bottom: 25px;">
                                        <center>
                                            <button id="loadUserSurveys" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                                        </center>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages">
                                    <b>Blogs</b>
                                    <button type="submit" id="export-userblogs-excel" class="btn btn-danger waves-effect m-r-20">Export</button>

                                    <div class="body blog-filters">
                                        <form id="filterBlogs" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control poll_detail_change" name="blog_status" id="blog_status">
                                                            <option value="">-- Select Status --</option>
                                                            <option value="1">Approved</option>
                                                            <option value="0">Pending</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="blog_title" id="blog_title" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Title</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="blog_desc" id="blog_desc" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control poll_detail_change" name="blog_type" id="blog_type">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="1">Blog</option>
                                                            <option value="2">Article</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="blog_from_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="blog_cstart_date" id="blog_cstart_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created Start Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="blog_to_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="blog_cend_date" id="blog_cend_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created End Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="user_id" id="user_id" readonly="readonly" value="<?php echo $_GET['id']; ?>" style="background-color: transparent;" aria-required="true">
                                            <input type="hidden" class="form-control" name="offset" id="offset" readonly="readonly" value="0" style="background-color: transparent;">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 align-center">
                                                <button id="addelection" type="submit" class="btn btn-danger waves-effect">APPLY FILTER</button>
                                                <button id="clearblogsfilter" type="submit" class="btn btn-danger waves-effect">CLEAR FILTER</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover dataTable">
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
                                                <tbody class="blogContainer">
                                                    <?php
                                                    foreach ( $blogs as $key => $list ):
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

                                    <div style="padding-bottom: 25px;">
                                        <center>
                                            <button id="loadUserBlogs" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                                        </center>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="settings">
                                    <b>Rated Articles</b>
                                    <button type="submit" id="export-userarticles-excel" class="btn btn-danger waves-effect m-r-20">Export</button>

                                    <div class="body articles-filters">
                                        <form id="filterArticles" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control poll_detail_change" name="article_status" id="article_status">
                                                            <option value="">-- Select Status --</option>
                                                            <option value="1">Raised</option>
                                                            <option value="2">Participated</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="article_quest" id="article_quest" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Question</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control poll_detail_change" name="article_desc" id="article_desc" maxlength="75" value="" aria-required="true">
                                                        <label class="form-label">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="article_from_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="article_cstart_date" id="article_cstart_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created Start Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="article_to_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="article_cend_date" id="article_cend_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created End Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="user_id" id="user_id" readonly="readonly" value="<?php echo $_GET['id']; ?>" style="background-color: transparent;" aria-required="true">
                                            <input type="hidden" class="form-control" name="offset" id="offset" readonly="readonly" value="0" style="background-color: transparent;">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 align-center">
                                                <button id="addelection" type="submit" class="btn btn-danger waves-effect">APPLY FILTER</button>
                                                <button id="cleararticlesfilter" type="submit" class="btn btn-danger waves-effect">CLEAR FILTER</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>

                                    <div class="body">
                                        <div class="">
                                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                                <thead>
                                                    <tr>
                                                        <th># Sr. No</th>
                                                        
                                                        <th>Article</th>
                                                        <th>Description</th>
                <!--                                        <th class="text-center">Is Approved</th>-->
                                                        <th class="text-center">Created Date</th>
                                                        <th class="text-right">Active</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="articlesContainer">
                                                    <?php
                                                    foreach ($articles as $key => $p):
                                                        $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                                        $num = $key + 1;
                                                        $p['preview']=str_replace("'", '', $p['preview']);
                                                        unset($p['choices']);
                                                        //$p['choices']= htmlspecialchars($p['choices']);
                                                        echo '<tr>'
                                                        . '<td>' . $num . '</td>'
                                                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p['question'] . '</p></td>'
                                                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p['description'] . '</p></td>'
                                                        //. '<td class="text-center">' . $isapproved . '</td>'
                                                        . '<td class="text-center">' . date("d-m-Y", strtotime($p['created_date'])) . '</td>'
                                                        . '<td class="text-center">
                                                            <a class="switch changeactivearticle" data-id="' . $p['id'] . '" data-type="articles" data-status=' . $p['is_active'] . '>
                                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                                            </a>
                                                        </td>'
                                                        . '<td class="text-center">
                                                            <!--<a href="' . base_url() . 'RatedArticle/index?id=' . $p['id'] . '" data-id="' . $p['id'] . '" data-editjson=\'' . json_encode($p) . '\'><i class="material-icons">&#xE254;</i></a>-->
                                                            <a href="#" data-toggle="modal" data-target="#viewArticleDetails" data-id="' . $p['id'] . '"><i class="material-icons">remove_red_eye</i></a>
                                                        </td>';
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div style="padding-bottom: 25px;">
                                        <center>
                                            <button id="loadUserArticles" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                                        </center>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="points">
                                    <b>Coins</b>
                                    <button type="submit" id="export-userpoints-excel" class="btn btn-danger waves-effect m-r-20">Export</button>
                                    <div class="body points-filters">
                                        <form id="filterPoints" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="points_type" id="points_type">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="poll">Poll</option>
                                                            <option value="survey">Survey</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="points_pointType" id="points_pointType">
                                                            <option value="">-- Select Coins Type --</option>
                                                            <option value="gold">Gold</option>
                                                            <option value="silver">Silver</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="points_from_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="points_cstart_date" id="points_cstart_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created Start Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="input-group date" id="points_to_datetimepicker">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="points_cend_date" id="points_cend_date" readonly="readonly" value="" style="background-color: transparent;" aria-required="true">
                                                            <label class="form-label">Created End Date</label>
                                                        </div>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="user_id" id="user_id" readonly="readonly" value="<?php echo $_GET['id']; ?>" style="background-color: transparent;" aria-required="true">
                                            <input type="hidden" class="form-control" name="offset" id="offset" readonly="readonly" value="0" style="background-color: transparent;">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 align-center">
                                                <button id="addelection" type="submit" class="btn btn-danger waves-effect">APPLY FILTER</button>
                                                <button id="clearpointsfilter" type="submit" class="btn btn-danger waves-effect">CLEAR FILTER</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>


                                    <div class="body">
                                        <div class="">
                                            <!-- js-basic-example -->
                                            <table class="table table-responsive table-bordered table-striped table-hover dataTable">
                                                <thead>
                                                    <tr>
                                                        <th># Sr. No</th>
                                                        <th>Type</th>
                                                        <th>Coins</th>
                                                        <th>Coins Type</th>
                                                        <!--<th class="text-center">Is Approved</th>
                                                        <th class="text-right">Active</th>-->
                                                        <th class="text-center">Action</th>
                                                        <th class="text-center">Created Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="pointsContainer">
                                                    <?php
                                                    foreach ( $points as $key => $p ):
                                                            //$ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                                            //$isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
                                                            $num = $key + 1;
                                                            
                                                            $update_right_answer = '';
                                                            
                                                            /*if ( strtotime( $p[ 'end_date' ] ) < strtotime( date( "Y-m-d" ) ) ) {
                                                                    $update_right_answer = ($p[ 'right_choice' ] == "") ? '<a href="' . base_url() . 'Poll/details/' . $p[ 'id' ] . '"><i class="material-icons">info_outline</i></a>' : '';
                                                            }*/
                                                            echo '<tr>'
                                                            . '<td>' . $num . '</td>'
                                                            . '<td>' . $p[ 'type' ] . '</td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'points' ] . '</p></td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'point_type' ] . '</p></td>'
                                                            . '<td class="text-center">' . $p[ 'action' ] . '</td>'
                                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>';
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div style="padding-bottom: 25px;">
                                        <center>
                                            <button id="loadUserPoints" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                                        </center>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade in" id="viewArticleDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> Article Details</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
<!--                <button type="button" class="btn btn-link btn-success waves-effect btn-approve">Approve</button>-->
                <!--<button type="button" class="btn btn-link btn-danger waves-effect btn-reject" data-dismiss="modal" data-toggle="modal" data-target="#reject_article">Reject</button>-->
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        $(function () {
            var i = 3;
            var fields = '';

            //Condition to display remove polls
            if (i > 3) {
                $('.add-more-choices div:nth-child(1), .add-more-choices div:nth-child(2)').find('.remove-poll-choices').removeClass('display-delete');
            }
            //Add new Choices
            $(".add-poll-choices").on("click", function () {
                if (i < 11) {
                    fields = '<div class="col-sm-6">\
                <div class="remove-poll-choices delete_choice">×</div>\
                <div class="form-group form-float">\
                    <div class="form-line">\
                        <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35"  placeholder="Enter Choice" value="" aria-required="true">\
                    </div>\
                </div>\
            </div>';
                    $(".add-more-choices").append(fields);
                    i++;
                }
            });

            //Remove new Choices
            $(document).on("click", ".remove-poll-choices", function () {
                console.log(i);
                $("#only_poll_detail_change").val("1");
                $(this).closest("div.col-sm-6").remove();
                i--;
                if (i == 3) {
                    $('.add-more-choices div:nth-child(1), .add-more-choices div:nth-child(2)').find('.remove-poll-choices').addClass('display-delete');
                }
            });

            $('#weekly_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                ignoreReadonly: true
            });
            $('#from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });
            $('#to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });


            $('#pollend_to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $('#pollend_from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#pollend_to_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#pollend_from_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });


            $('#poll_to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $('#poll_from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#poll_from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#poll_to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });


            $('#survey_to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $('#survey_from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#survey_from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#survey_to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });

            $('#blog_to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $('#blog_from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#blog_from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#blog_to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });


            $('#article_to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $('#article_from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#article_from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#article_to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });


            $('#points_to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $('#points_from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#points_from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#points_to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });

            //End Date config
<?php
//if ( $pollid == 0 ) {
        ?>
                    $('#end_datetimepicker').datetimepicker({
                        useCurrent: false,
                        format: "DD-MM-YYYY",
                        minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                        ignoreReadonly: true
                    });
        <?php
//} else {
        ?>
                    $('#end_datetimepicker').datetimepicker({
                        useCurrent: false,
                        format: "DD-MM-YYYY",
                        ignoreReadonly: true
                    });
        <?php
//}
?>
            //check end date change
            $("#end_datetimepicker").on("dp.change", function (e) {
                $("#only_end_date_change").val("1");
            });

            //submit add update poll form
            $("#addUpdatePoll").on("submit", function (e) {
                var end_date = $("#end_date").val();
                if (end_date == "") {
                    e.preventDefault();
                    showToast("Please select end date", '0');
                }
            });

            //when change end date or average
            $("#average").on("change", function (e) {
                $("#only_avg_change").val("1");
            });

            $("#poll_detail_change").on("change", function (e) {
                $("#only_poll_detail_change").val("1");
            });

            //image file change function 
            $("#uploadBtn").on("change", function () {
                var file = $(this)[0].files[0];

                var imageData = new FormData();
                imageData.append('file', file);

                ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                    $("#uploadBtn").closest(".form-group").find("#uploadFile").val(result);
                    $(".uploaded-img-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
                });
                //var filename = $(this).val();
                //filename = filename.replace(/\\/g, '/').replace(/.*\//, '');
            });
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function decimalCheck() {
            var dec = document.getElementById('average').value;
            if (dec.includes(".")) {
                var res = dec.substring(dec.indexOf(".") + 1);
                var kl = res.split("");
                if (kl.length > 1) {
                    document.getElementById('average').value = (parseInt(dec * 100) /
                            100).toFixed(2);
                }
            }
        }
        function isNumberKey(evt)
        {
            var flag = 0;
            var txtVal = $('#average').val();
            var decimalSeparator = ".";
            var val = "" + txtVal;
            if (val.indexOf(decimalSeparator) < val.length - 3)
            {
                return false;
                //alert("too much decimal");
            }

            if (txtVal > 99) {
                return false;
            }
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                if (charCode != 46) {
                    return false;
                }
            if (charCode == 46 && flag == 1) {
                return false;
            }
            return true;
        }
//      
        $(document).on('keyup', '#average', function (evt) {
            var txtVal = $(this).val();
            console.log(txtVal);
            if (parseFloat(txtVal) > 100) {
                //$(this).val('');
            }

        });

        $('#filterPolls').submit(function(e){
                e.preventDefault();
                var data = $( '#filterPolls' ).serialize();
                //data += '&paging=20';
                alert(data);
                var output = function(cb){
                    $('.pollsContainer').html(cb);
                    
                };
                ajax_call('/User/filter_user_polls', 'POST', data, output);
                $('#loadUserPolls').attr('disabled', false);
                $('#loadUserPolls').attr('data-offset', 10);
            });


        $('#loadUserPolls').click(function(){
                var offSet = $(this).attr('data-offset');
                
                alert('Loading... '+offSet);

                
                var data = $( '#filterPolls' ).serialize();
                data += '&offset='+offSet;
                alert(data);
                var output = function(cb){
                    if (cb != "") {
                        $('.pollContainer').append(cb);
                    } else {
                         $('#loadUserPolls').attr('disabled', true);
                    }
                        
                };
                ajax_call('/User/filter_user_polls', 'POST', data, output);

                    
                offSet =  parseInt(offSet, 10);
                offSet =offSet+10;
                $(this).attr('data-offset', offSet);
            });

            $('#clearpollsfilter').click(function(){
                //alert('Clear... ');
                $("#filterPolls").trigger('reset');
            });


        $('#export-userpolls-excel').click(function(){
                //alert('Export Data');

                var query = '';
                var req_url = '/User/export_filter_user_polls';

                //var data = $( '#filterForm' ).serialize();
                //alert(data);

                if($('#user_id').val() != ""){ query += 'user_id='+$('#user_id').val()+'&'; }

                if($('#poll_type').val() != ""){ query += 'poll_type='+$('#poll_type').val()+'&'; }

                if($('#poll_status').val() != ""){ query += 'poll_status='+$('#poll_status').val()+'&'; }

                if($('#poll_quest').val() != ""){ query += 'poll_quest='+$('#poll_quest').val()+'&'; }

                if($('#poll_desc').val() != ""){ query += 'poll_desc='+$('#poll_desc').val()+'&'; }

                if($('#pollend_start_date').val() != ""){ query += 'pollend_start_date='+$('#pollend_start_date').val()+'&'; }

                if($('#pollend_end_date').val() != ""){ query += 'pollend_end_date='+$('#pollend_end_date').val(); }

                if($('#poll_cstart_date').val() != ""){ query += 'poll_cstart_date='+$('#poll_cstart_date').val()+'&'; }

                if($('#poll_cend_date').val() != ""){ query += 'poll_cend_date='+$('#poll_cend_date').val(); }

                //alert(query);

                if(query.charAt(query.length-1) == '&'){ query = query.slice(0, -1); }

                if(query != ""){ req_url = req_url + '?' + query; }

                window.location.assign(req_url);
                
            });



        $('#filterSurveys').submit(function(e){
                e.preventDefault();
                var data = $( '#filterSurveys' ).serialize();
                //data += '&paging=20';
                alert(data);
                var output = function(cb){
                    $('.surveysContainer').html(cb);
                    
                };
                ajax_call('/User/filter_user_surveys', 'POST', data, output);
                $('#loadUserSurveys').attr('disabled', false);
                $('#loadUserSurveys').attr('data-offset', 10);
            });


        $('#loadUserSurveys').click(function(){
                var offSet = $(this).attr('data-offset');
                
                alert('Loading... '+offSet);

                
                var data = $( '#filterSurveys' ).serialize();
                data += '&offset='+offSet;
                alert(data);
                var output = function(cb){
                    if (cb != "") {
                        $('.surveyContainer').append(cb);
                    } else {
                         $('#loadUserSurveys').attr('disabled', true);
                    }
                        
                };
                ajax_call('/User/filter_user_surveys', 'POST', data, output);

                    
                offSet =  parseInt(offSet, 10);
                offSet =offSet+10;
                $(this).attr('data-offset', offSet);
            });

            $('#clearsurveysfilter').click(function(){
                //alert('Clear... ');
                $("#filterSurveys").trigger('reset');
            });


        $('#export-usersurveys-excel').click(function(){
                //alert('Export Data');

                var query = '';
                var req_url = '/User/export_filter_user_surveys';

                //var data = $( '#filterForm' ).serialize();
                //alert(data);

                if($('#user_id').val() != ""){ query += 'user_id='+$('#user_id').val()+'&'; }

                if($('#survey_status').val() != ""){ query += 'survey_status='+$('#survey_status').val()+'&'; }

                if($('#survey_quest').val() != ""){ query += 'survey_quest='+$('#survey_quest').val()+'&'; }

                if($('#survey_desc').val() != ""){ query += 'survey_desc='+$('#survey_desc').val()+'&'; }

                if($('#survey_cstart_date').val() != ""){ query += 'survey_cstart_date='+$('#survey_cstart_date').val()+'&'; }

                if($('#survey_cend_date').val() != ""){ query += 'survey_cend_date='+$('#survey_cend_date').val(); }

                //alert(query);

                if(query.charAt(query.length-1) == '&'){ query = query.slice(0, -1); }

                if(query != ""){ req_url = req_url + '?' + query; }

                window.location.assign(req_url);
                
            });



        $('#filterBlogs').submit(function(e){
                e.preventDefault();
                var data = $( '#filterBlogs' ).serialize();
                //data += '&paging=20';
                alert(data);
                var output = function(cb){
                    $('.blogContainer').html(cb);
                    
                };
                ajax_call('/User/filter_user_blogs', 'POST', data, output);
                // $('#loadUsers').attr('disabled', false);
                //$('#loadUsers').attr('data-offset', 10);
            });


        $('#loadUserBlogs').click(function(){
                var offSet = $(this).attr('data-offset');
                
                alert('Loading... '+offSet);

                
                var data = $( '#filterBlogs' ).serialize();
                data += '&offset='+offSet;
                alert(data);
                var output = function(cb){
                    if (cb != "") {
                        $('.blogContainer').append(cb);
                    } else {
                         $('#loadUserBlogs').attr('disabled', true);
                    }
                        
                };
                ajax_call('/User/filter_user_blogs', 'POST', data, output);

                    
                offSet =  parseInt(offSet, 10);
                offSet =offSet+10;
                $(this).attr('data-offset', offSet);
            });

            $('#clearblogsfilter').click(function(){
                //alert('Clear... ');
                $("#filterBlogs").trigger('reset');
            });


        $('#export-userblogs-excel').click(function(){
                //alert('Export Data');

                var query = '';
                var req_url = '/User/export_filter_user_blogs';

                //var data = $( '#filterForm' ).serialize();
                //alert(data);

                if($('#user_id').val() != ""){ query += 'user_id='+$('#user_id').val()+'&'; }

                if($('#blog_type').val() != ""){ query += 'blog_type='+$('#blog_type').val()+'&'; }

                if($('#blog_status').val() != ""){ query += 'blog_status='+$('#blog_status').val()+'&'; }

                if($('#blog_title').val() != ""){ query += 'blog_title='+$('#blog_title').val()+'&'; }

                if($('#blog_desc').val() != ""){ query += 'blog_desc='+$('#blog_desc').val()+'&'; }

                if($('#blog_cstart_date').val() != ""){ query += 'blog_cstart_date='+$('#blog_cstart_date').val()+'&'; }

                if($('#blog_cend_date').val() != ""){ query += 'blog_cend_date='+$('#blog_cend_date').val(); }

                //alert(query);

                if(query.charAt(query.length-1) == '&'){ query = query.slice(0, -1); }

                if(query != ""){ req_url = req_url + '?' + query; }

                window.location.assign(req_url);
                
            });



        $('#filterArticles').submit(function(e){
                e.preventDefault();
                var data = $( '#filterArticles' ).serialize();
                //data += '&paging=20';
                alert(data);
                var output = function(cb){
                    $('.articlesContainer').html(cb);
                    
                };
                ajax_call('/User/filter_user_articles', 'POST', data, output);
                $('#loadUserArticles').attr('disabled', false);
                $('#loadUserArticles').attr('data-offset', 10);
            });


        $('#loadUserArticles').click(function(){
                var offSet = $(this).attr('data-offset');
                
                alert('Loading... '+offSet);

                
                var data = $( '#filterArticles' ).serialize();
                data += '&offset='+offSet;
                alert(data);
                var output = function(cb){
                    if (cb != "") {
                        $('.articleContainer').append(cb);
                    } else {
                         $('#loadUserArticles').attr('disabled', true);
                    }
                        
                };
                ajax_call('/User/filter_user_articles', 'POST', data, output);

                    
                offSet =  parseInt(offSet, 10);
                offSet =offSet+10;
                $(this).attr('data-offset', offSet);
            });

            $('#cleararticlesfilter').click(function(){
                //alert('Clear... ');
                $("#filterArticles").trigger('reset');
            });


        $('#export-userarticles-excel').click(function(){
                //alert('Export Data');

                var query = '';
                var req_url = '/User/export_filter_user_articles';

                //var data = $( '#filterForm' ).serialize();
                //alert(data);

                if($('#user_id').val() != ""){ query += 'user_id='+$('#user_id').val()+'&'; }

                if($('#article_status').val() != ""){ query += 'article_status='+$('#article_status').val()+'&'; }

                if($('#article_quest').val() != ""){ query += 'article_quest='+$('#article_quest').val()+'&'; }

                if($('#article_desc').val() != ""){ query += 'article_desc='+$('#article_desc').val()+'&'; }

                if($('#article_cstart_date').val() != ""){ query += 'article_cstart_date='+$('#article_cstart_date').val()+'&'; }

                if($('#article_cend_date').val() != ""){ query += 'article_cend_date='+$('#article_cend_date').val(); }

                //alert(query);

                if(query.charAt(query.length-1) == '&'){ query = query.slice(0, -1); }

                if(query != ""){ req_url = req_url + '?' + query; }

                window.location.assign(req_url);
                
            });



        $('#filterPoints').submit(function(e){
                e.preventDefault();
                var data = $( '#filterPoints' ).serialize();
                //data += '&paging=20';
                alert(data);
                var output = function(cb){
                    $('.pointsContainer').html(cb);
                    
                };
                ajax_call('/User/filter_user_points', 'POST', data, output);
                $('#loadUserPoints').attr('disabled', false);
                $('#loadUserPoints').attr('data-offset', 10);
            });

        $('#loadUserPoints').click(function(){
                var offSet = $(this).attr('data-offset');
                
                alert('Loading... '+offSet);

                
                var data = $( '#filterPoints' ).serialize();
                data += '&offset='+offSet;
                alert(data);
                var output = function(cb){
                    if (cb != "") {
                        $('.pointsContainer').append(cb);
                    } else {
                         $('#loadUserPoints').attr('disabled', true);
                    }
                        
                };
                ajax_call('/User/filter_user_points', 'POST', data, output);

                    
                offSet =  parseInt(offSet, 10);
                offSet =offSet+10;
                $(this).attr('data-offset', offSet);
            });

            $('#clearpointsfilter').click(function(){
                //alert('Clear... ');
                $("#filterPoints").trigger('reset');
            });


        $('#export-userpoints-excel').click(function(){
                //alert('Export Data');

                var query = '';
                var req_url = '/User/export_filter_user_points';

                //var data = $( '#filterForm' ).serialize();
                //alert(data);

                if($('#user_id').val() != ""){ query += 'user_id='+$('#user_id').val()+'&'; }

                if($('#points_type').val() != ""){ query += 'points_type='+$('#points_type').val()+'&'; }

                if($('#points_pointType').val() != ""){ query += 'points_pointType='+$('#points_pointType').val()+'&'; }

                if($('#points_cstart_date').val() != ""){ query += 'points_cstart_date='+$('#points_cstart_date').val()+'&'; }

                if($('#points_cend_date').val() != ""){ query += 'points_cend_date='+$('#points_cend_date').val(); }

                //alert(query);

                if(query.charAt(query.length-1) == '&'){ query = query.slice(0, -1); }

                if(query != ""){ req_url = req_url + '?' + query; }

                window.location.assign(req_url);
                
            });

        

</script>
