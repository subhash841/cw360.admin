<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends Base_Controller {

		function __construct() {
                parent::__construct();

                $this -> load -> model( 'User_model' );
                $this -> load -> model( 'Blog_model' );
                $this -> load -> model( 'RatedArticle_model' );
                $this -> load -> model( 'Poll_model' );
                $this -> load -> model( 'Survey_model' );
        }


        function lists() {
                $data = array ();
                $page_title[ 'page_title' ] = "Users";
                $data[ 'users' ] = $this -> User_model -> get_list();
                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'user_list', $data );
                $this -> load -> view( 'template/footer' );

        }

        function filteredList() {
            $data = array();


            //Filter Form Data
            $inputs = $this->input->post();


            $data = $this -> User_model -> get_filtered_list($inputs);

            $output = '';
            $num = $inputs[ 'offset' ];

            foreach ( $data as $key => $p ):
                if($p[ 'id' ] != 2 ){
                    $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                    $isapproved = 1;//$isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
                    $num = $num + 1;
                                            
                    $update_right_answer = '';
                                            
                    /*if ( strtotime( $p[ 'end_date' ] ) < strtotime( date( "Y-m-d" ) ) ) {
                        $update_right_answer = ($p[ 'right_choice' ] == "") ? '<a href="' . base_url() . 'Poll/details/' . $p[ 'id' ] . '"><i class="material-icons">info_outline</i></a>' : '';
                        }*/
                    echo '<tr>'
                    . '<td>' . $num . '</td>'
                    . '<td>' . $p[ 'name' ] . '</td>'
                    . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'email' ] . '</p></td>'
                    . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'alise' ] . '</p></td>'
                    . '<td class="text-center">' . $p[ 'location' ] . '</td>'
                    . '<td class="text-center">' . $p[ 'party' ] . '</td>'
                    . '<td class="text-center">' . $isapproved . '</td>'
                    . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                    . '<td class="text-center">
                        <a class="switch changeactivepoll" data-id="' . $p[ 'id' ] . '" data-type="polls" data-status=' . $p[ 'is_active' ] . '>
                        <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                        </a>
                    </td>'
                    . '<td class="text-center">
                        <!--<a href="' . base_url() . 'User/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>-->
                            <a href="' . base_url() . 'User/details?id=' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                    ' . $update_right_answer . '
                    </td></tr>';
                                                }
            endforeach;

            echo $output;


        }


        function details() {
                $data = array ();
                $page_title[ 'page_title' ] = "Users";

                $user_id = $this -> input -> get( 'id' );
                if ( $user_id != 0 ) {
                    $data = $this -> User_model -> get_user_details( $user_id );
                    $data['counts'] = $this -> User_model -> get_user_counts( $user_id );
                    $data['predictions'] = $this -> User_model -> get_user_predictions( $user_id );
                    $data['surveys'] = $this -> User_model -> get_user_surveys( $user_id );
                    $data['blogs'] = $this -> User_model -> get_user_blogs( $user_id );
                    $data['articles'] = $this -> User_model -> get_user_ratedArticles( $user_id );
                    $data['points'] = $this -> User_model -> get_user_points( $user_id );
                }


                //$data[ 'users' ] = $this -> User_model -> get_user_details();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'user_details', $data );
                $this -> load -> view( 'template/footer' );

        }


        function export_users() {
            $data = "";

            //Filter Form Data
            $inputs = $this->input->get();

            $users = $this->User_model->get_filtered_list_exported($inputs);
            
            $data = '<tr>'
                    . '<td><strong>Sr. No.</strong></td>'
                    . '<td><strong>Name</strong></td>'
                    //. '<td><strong>Social ID</strong></td>'
                    . '<td><strong>Twitter ID</strong></td>'
                    . '<td><strong>Email</strong></td>'
                    . '<td><strong>Login Type</strong></td>'
                    . '<td><strong>Alise</strong></td>'
                    . '<td><strong>Location</strong></td>'
                    . '<td><strong>Party</strong></td>'
                    . '<td><strong>Is Active</strong></td>'
                    //. '<td><strong>TNC Agreed</strong></td>'
                    //. '<td><strong>Game Played</strong></td>'
                    //. '<td><strong>Rank</strong></td>'
                    //. '<td><strong>Points</strong></td>'
                    . '<td><strong>Gold Coins</strong></td>'
                    . '<td><strong>Silver Coins</strong></td>'
                    //. '<td><strong>Certificate</strong></td>'
                    . '<td><strong>Created Date</strong></td>'
                    . '</tr>';

            foreach ($users as $key => $user_data) {
                $num = $key + 1;
                //$is_approved = ($user_data['is_approved'] == 1) ? "Yes" : "No";
                $is_active = ($user_data['is_active'] == 1) ? "Yes" : "No";

                $data .= '<tr>'
                        . '<td>' . $num . '</td>'
                        . '<td>' . $user_data['name'] . '</td>'
                        //. '<td>' . $user_data['social_id'] . '</td>'
                        . '<td>' . $user_data['twitter_id'] . '</td>'
                        . '<td>' . $user_data['email'] . '</td>'
                        . '<td>' . $user_data['login_type'] . '</td>'
                        . '<td>' . $user_data['alise'] . '</td>'
                        . '<td>' . $user_data['location'] . '</td>'
                        . '<td>' . $user_data['party'] . '</td>'
                        . '<td>' . $is_active . '</td>'
                        //. '<td>' . $user_data['tnc_agree'] . '</td>'
                        //. '<td>' . $user_data['is_game_played'] . '</td>'
                        //. '<td>' . $user_data['rank'] . '</td>'
                        //. '<td>' . $user_data['points'] . '</td>'
                        . '<td>' . $user_data['earned_points'] . '</td>'
                        . '<td>' . $user_data['unearned_points'] . '</td>'
                        //. '<td>' . $user_data['certificate_path'] . '</td>'
                        . '<td>' . date("d-m-Y", strtotime($user_data['created_date'])) . '</td>'
                        . '</tr>';
            }
            $file = "users.xls";
            $test = "<table border='1'>" . $data . "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $test;
        }


        function filter_user_blogs() {

            $data = array();


            //Filter Form Data
            $inputs = $this->input->post();


            $data = $this -> Blog_model -> get_user_blogs_filtered($inputs);

            $output = '';
            $num = $inputs[ 'offset' ];

            foreach ( $data as $key => $list ):
                                            $num = $num + 1;
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

                                    echo $output;

        }


        function filter_user_articles() {

            $data = array();


            //Filter Form Data
            $inputs = $this->input->post();


            $data = $this -> RatedArticle_model -> get_user_articles_filtered($inputs);

            foreach ($data as $key => $p):
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

        }


        function filter_user_points() {

            $data = array();


            //Filter Form Data
            $inputs = $this->input->post();

            $num = $inputs[ 'offset' ];


            $data = $this -> User_model -> get_user_points_filtered($inputs);

            
            foreach ( $data as $key => $p ):
                                                            
                                                            $num = $num + 1;
                                                            
                                                            $update_right_answer = '';
                                                            
                                                            
                                                            echo '<tr>'
                                                            . '<td>' . $num . '</td>'
                                                            . '<td>' . $p[ 'type' ] . '</td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'points' ] . '</p></td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'point_type' ] . '</p></td>'
                                                            . '<td class="text-center">' . $p[ 'action' ] . '</td>'
                                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>';
                
            endforeach;

        }


        function filter_user_surveys() {

            $data = array();


            //Filter Form Data
            $inputs = $this->input->post();

            $num = $inputs[ 'offset' ];


            $data = $this -> Survey_model -> get_user_surveys_filtered($inputs);

            foreach ($data as $key => $p):
                                                        $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                                        $num = $num + 1;
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
        }



        function filter_user_polls() {

            $data = array();


            //Filter Form Data
            $inputs = $this->input->post();


            $data = $this -> Poll_model -> get_user_polls_filtered($inputs);

            foreach ( $data as $key => $p ):
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

        }



        function export_filter_user_polls() {

            $data = "";


            //Filter Form Data
            $inputs = $this->input->get();


            $polls = $this -> Poll_model -> export_filter_user_polls($inputs);

            $data .= '<tr>
                                                        <th># Sr. No</th>
                                                        <th>Category</th>
                                                        <th>Poll</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Is Approved</th>
                                                        <th class="text-center">Created Date</th>
                                                    </tr>';

            foreach ( $polls as $key => $p ):
                                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                                            $isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
                                                            $num = $key + 1;
                                                            
                                                            $update_right_answer = '';
                                                            
                                                            if ( strtotime( $p[ 'end_date' ] ) < strtotime( date( "Y-m-d" ) ) ) {
                                                                    $update_right_answer = ($p[ 'right_choice' ] == "") ? '<a href="' . base_url() . 'Poll/details/' . $p[ 'id' ] . '"><i class="material-icons">info_outline</i></a>' : '';
                                                            }
                                                            $data .= '<tr>'
                                                            . '<td>' . $num . '</td>'
                                                            . '<td>' . $p[ 'category' ] . '</td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'poll' ] . '</p></td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                                                            . '<td class="text-center">' . $isapproved . '</td>'
                                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                                            . '</tr>';
                                                    endforeach;

            $file = "user_polls.xls";
            $test = "<table border='1'>" . $data . "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $test;

        }



        function export_filter_user_surveys() {

            $data = "";


            //Filter Form Data
            $inputs = $this->input->get();


            $surveys = $this -> Survey_model -> export_filter_user_surveys($inputs);

            $data .= '<tr>
                                                        <th># Sr. No</th>
                                                        
                                                        <th>Survey</th>
                                                        <th>Description</th>
                                                        <!--<th class="text-center">Is Approved</th>-->
                                                        <th class="text-center">Created Date</th>
                                                        <th class="text-right">Active</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>;';

            foreach ($surveys as $key => $p):
                                                        $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                                        $num = $key + 1;
                                                        $data .= '<tr>'
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
                                                        </td>'
                                                        .'</tr>';
            endforeach;

            $file = "user_surveys.xls";
            $test = "<table border='1'>" . $data . "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $test;
        }



        function export_filter_user_blogs() {

            $data = "";


            //Filter Form Data
            $inputs = $this->input->get();


            $blogs = $this -> Blog_model -> export_filter_user_blogs($inputs);

            $output = '';

            $data .= '<tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th width="400">Description</th>
                                                        <th class="text-center">Type</th>
                                                        <th class="text-center" width="100">Date</th>
                                                    </tr>';

            foreach ( $blogs as $key => $list ):
                                            $num = $key + 1;
                                            $newvalue = $list[ 'is_active' ] == 1 ? "checked" : "";
                                            $description = str_replace( '\\', '/', $list[ 'description' ] );
                                            $description = preg_replace( "/<style(.*)<\/style>/iUs", "", $description );
                                            $description = str_replace( "&nbsp;", " ", $description );
                                            $type = ($list[ 'type' ] == "1") ? "Blog" : "Article";
                                            $data .= '<tr>
                                                <td>' . $num . '</td>
                                                <td>' . $list[ 'title' ] . '</td>
                                                <td><p class="ellipsis">' . strip_tags( $description ) . '</p></td>
                                                <td>' . $type . '</td>
                                                <td class="text-center">' . $list[ 'created_date' ] . '</td>
                                                </tr>';
                                    endforeach;

            $file = "user_blogs.xls";
            $test = "<table border='1'>" . $data . "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $test;

        }



        function export_filter_user_articles() {

            $data = "";


            //Filter Form Data
            $inputs = $this->input->get();


            $articles = $this -> RatedArticle_model -> export_filter_user_articles($inputs);

            $data .= '<tr>
                                                        <th># Sr. No</th>
                                                        <th>Article</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Created Date</th>
                                                    </tr>';

            foreach ($articles as $key => $p):
                                                        $ischecked = ($p['is_active'] == 1) ? "checked" : "";
                                                        $isapproved = ($p['is_approved'] == "1") ? "Yes" : "No";
                                                        $num = $key + 1;
                                                        $p['preview']=str_replace("'", '', $p['preview']);
                                                        unset($p['choices']);
                                                        //$p['choices']= htmlspecialchars($p['choices']);
                                                        $data .= '<tr>'
                                                        . '<td>' . $num . '</td>'
                                                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p['question'] . '</p></td>'
                                                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p['description'] . '</p></td>'
                                                        //. '<td class="text-center">' . $isapproved . '</td>'
                                                        . '<td class="text-center">' . date("d-m-Y", strtotime($p['created_date'])) . '</td>'
                                                        . '</tr>';
                                                    endforeach;

            $file = "user_articles.xls";
            $test = "<table border='1'>" . $data . "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $test;

        }



        function export_filter_user_points() {

            $data = "";


            //Filter Form Data
            $inputs = $this->input->get();


            $points = $this -> User_model -> get_user_points_filtered_exported($inputs);

            $data .= '<tr>
                                                        <th># Sr. No</th>
                                                        <th>Type</th>
                                                        <th>Coins</th>
                                                        <th>Coins Type</th>
                                                        <!--<th class="text-center">Is Approved</th>
                                                        <th class="text-right">Active</th>-->
                                                        <th class="text-center">Action</th>
                                                        <th class="text-center">Created Date</th>
                                                    </tr>';

            
            foreach ( $points as $key => $p ):
                                                            
                                                            $num = $key + 1;
                                                            
                                                            $update_right_answer = '';
                                                            
                                                            
                                                            $data .= '<tr>'
                                                            . '<td>' . $num . '</td>'
                                                            . '<td>' . $p[ 'type' ] . '</td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'points' ] . '</p></td>'
                                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'point_type' ] . '</p></td>'
                                                            . '<td class="text-center">' . $p[ 'action' ] . '</td>'
                                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>';
                
            endforeach;
            $file = "user_coins.xls";
            $test = "<table border='1'>" . $data . "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $test;

        }


        

}
