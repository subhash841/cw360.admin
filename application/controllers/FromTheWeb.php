<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FromTheWeb extends Base_Controller {

        private $userdata = array ();

        function __construct() {
                parent::__construct();

                $this -> load -> model( 'FromTheWeb_model' );
                $this -> userdata = $this -> session -> userdata( 'loggedin' );
        }

        function lists() {
                $data = array ();
                $page_title[ 'page_title' ] = "From The Web";

                $data[ 'web' ] = $this -> FromTheWeb_model -> get_list();

//                $data[ 'topics' ] = $this -> FromTheWeb_model -> get_topic_list();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'fromtheweb_list', $data );
                $this -> load -> view( 'template/footer' );
        }

        function index() {
                $data = array ();
                $article_id = $this -> input -> get( 'id' );
                
                if ( $article_id != 0 ) {
                        $data[ 'data' ] = $this -> FromTheWeb_model -> get_web_details( $article_id );
                }
                $page_title[ 'page_title' ] = "From The Web";
                //$data['article_category'] = $this->Survey_model->get_article_category();

                $this -> load -> view( 'template/header', $page_title );
                $this -> load -> view( 'add_update_web', $data );
                $this -> load -> view( 'template/footer' );
        }

        function filteredList() {
                $offset = $this -> input -> post();
                $offset = $offset[ 'offSet' ];
                $web = $this -> FromTheWeb_model -> get_list( $offset );
                $num = $offset;
                foreach ( $web as $key => $p ):
                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                        $num = $num + 1;
                        echo '<tr>'
                        . '<td>' . $num . '</td>'
                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                        . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                        . '<td class="text-center">
                                            <a class="switch changefromtheweb" data-id="' . $p[ 'id' ] . '" data-type="fromtheweb" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                        . '<td class="text-center">
                                            <a href="' . base_url() . 'FromTheWeb/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="#" data-toggle="modal" data-target="#viewArticleDetails" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                                        </td>';
                endforeach;
        }

        function add_update_web() {
                $inputs = $this -> input -> post();

                return $this -> FromTheWeb_model -> add_update_web( $inputs );
        }

        function active_inactive_web() {
                $inputs = $this -> input -> post();

                $this -> FromTheWeb_model -> active_inactive_web_mod( $inputs );

                $message = ($inputs[ 'current' ] == "1") ? "WEb deactivated successfully" : "Web activated successfully";
                echo json_encode( array ( "status" => TRUE, "message" => $message ) );
        }

        function filter_result() {
                $inputs = $this -> input -> post();
                $web = $this -> FromTheWeb_model -> web_mod_filter( $inputs );
                $num = $inputs[ 'offSet' ];
                if ( ! empty( $web ) ) {
                        foreach ( $web as $key => $p ):
                                $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                $num = $key + 1;
                                echo '<tr>'
                                . '<td>' . $num . '</td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                                . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                . '<td class="text-center">
                                            <a class="switch changefromtheweb" data-id="' . $p[ 'id' ] . '" data-type="fromtheweb" data-status=' . $p[ 'is_active' ] . '>
                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
                                            </a>
                                        </td>'
                                . '<td class="text-center">
                                            <a href="' . base_url() . 'FromTheWeb/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                            <a href="#" data-toggle="modal" data-target="#viewArticleDetails" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
                                        </td>';
                        endforeach;
                }
        }

        function export_to_excel() {
                $web = $this -> FromTheWeb_model -> get_list( -1 );


                $data = '<tr>'
                        . '<td><strong>Sr. No.</strong></td>'
                        . '<td><strong>Title</strong></td>'
                        . '<td><strong>Description</strong></td>'
                        . '<td><strong>Created Date</strong></td>'
                        . '<td><strong>Is Active</strong></td>'
                        . '</tr>';

                foreach ( $web as $key => $p ):
                        $isactive = ($p[ 'is_active' ] == 1) ? "YES" : "NO";
                        $num = $key + 1;
                        $data .= '<tr>'
                                . '<td>' . $num . '</td>'
                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'title' ] . '</p></td>'
                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
                                . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                . '<td class="text-center">' . $isactive . '</td>';
                endforeach;
                $file = "From_the_web.xls";
                $test = "<table border='1'>" . $data . "</table>";
                header( "Content-type: application/vnd.ms-excel" );
                header( "Content-Disposition: attachment; filename=$file" );
                echo $test;
        }

//
//        function filteredList() {
//                $articles = array ();
//
//                $inputs = $this -> input -> post();
//
//                $articles = $this -> RatedArticle_model -> get_filtered_list( $inputs );
//
//                $output = '';
//                $num = $inputs[ 'offSet' ];
//                foreach ( $articles as $key => $p ):
//                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
//                        $isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
//                        $num = $num + 1;
//                        $p[ 'preview' ] = str_replace( "'", '', $p[ 'preview' ] );
//                        unset( $p[ 'choices' ] );
//                        //$p['choices']= htmlspecialchars($p['choices']);
//                        echo '<tr>'
//                        . '<td>' . $num . '</td>'
//                        . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'question' ] . '</p></td>'
//                        . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
//                        //. '<td class="text-center">' . $isapproved . '</td>'
//                        . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
//                        . '<td class="text-center">
//                                            <a class="switch changeactivearticle" data-id="' . $p[ 'id' ] . '" data-type="articles" data-status=' . $p[ 'is_active' ] . '>
//                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
//                                            </a>
//                                        </td>'
//                        . '<td class="text-center">
//                                            <a href="' . base_url() . 'RatedArticle/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
//                                            <a href="' . base_url() . 'RatedArticle/article_details?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
//                                        </td>';
//                endforeach;
//                echo $output;
//        }
//
//        function exportList_articles() {
//                $articles = array ();
//
//                $data = '';
//
//                $inputs = $this -> input -> get();
//
//                $articles = $this -> RatedArticle_model -> get_filtered_list_exported( $inputs );
//
//                $output = '';
//                //$num = $inputs['offSet'];
//                $data .= '<tr>
//                    <th># Sr. No</th>                                        
//                    <th>Article</th>
//                    <th>Description</th>
//                    <th class="text-center">Is Approved</th>
//                    <th class="text-center">Created Date</th>
//                    <th class="text-right">Active</th>
//                    <th class="text-center">Action</th>
//                </tr>';
//
//                foreach ( $articles as $key => $p ):
//                        $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
//                        $isapproved = ($p[ 'is_approved' ] == "1") ? "Yes" : "No";
//                        $num = $key + 1;
//                        $p[ 'preview' ] = str_replace( "'", '', $p[ 'preview' ] );
//                        unset( $p[ 'choices' ] );
//                        //$p['choices']= htmlspecialchars($p['choices']);
//                        $data .= '<tr>'
//                                . '<td>' . $num . '</td>'
//                                . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'question' ] . '</p></td>'
//                                . '<td><p class="multiline-ellipsis" data-lines="3">' . $p[ 'description' ] . '</p></td>'
//                                //. '<td class="text-center">' . $isapproved . '</td>'
//                                . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
//                                . '<td class="text-center">
//                                            <a class="switch changeactivearticle" data-id="' . $p[ 'id' ] . '" data-type="articles" data-status=' . $p[ 'is_active' ] . '>
//                                                <label><input type="checkbox" ' . $ischecked . '><span class="lever switch-col-bluenew"></span></label>
//                                            </a>
//                                        </td>'
//                                . '<td class="text-center">
//                                            <a href="' . base_url() . 'RatedArticle/index?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
//                                            <a href="' . base_url() . 'RatedArticle/article_details?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '"><i class="material-icons">remove_red_eye</i></a>
//                                        </td>';
//                endforeach;
//                $file = "articles.xls";
//                $test = "<table border='1'>" . $data . "</table>";
//                header( "Content-type: application/vnd.ms-excel" );
//                header( "Content-Disposition: attachment; filename=$file" );
//                echo $test;
//        }
//
//        function article_details() {
//                $article_data = array ();
//                $article_title[ 'page_title' ] = "Article Details";
//                $article_id = $this -> input -> get( 'id' );
//                $article_data = $this -> RatedArticle_model -> get_details_article( $article_id );
//
//                $article_data[ 'articles' ] = $this -> RatedArticle_model -> get_article_count( $article_id );
//
//                $article_data[ 'replies' ] = $this -> RatedArticle_model -> get_article_replies( $article_id );
//
//                $this -> load -> view( 'template/header', $article_title );
//                $this -> load -> view( 'article_details', $article_data );
//                $this -> load -> view( 'template/footer' );
//                echo $article_id;
//        }
//
//        function article_detail() {
//                $article_id = $this -> input -> post( 'articleid' );
//                $article_data = $this -> RatedArticle_model -> get_article_details( $article_id );
//                echo json_encode( $article_data );
//        }
//
//        function create_update( $id = 0 ) {
//
//                $data = array ();
//                $page_title[ 'page_title' ] = "Articles";
//                //$data['article_category'] = $this->Survey_model->get_article_category();
//
//                $inputs = $this -> input -> post();
//                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
//
//                $this -> RatedArticle_model -> add_update_article( $inputs );
//
//                $this -> load -> view( 'template/header', $page_title );
//                $this -> load -> view( 'add_update_article', $data );
//                $this -> load -> view( 'template/footer' );
//
//                redirect( 'RatedArticle/lists' );
//        }
//
//        function approve_article() {
//                $inputs = $this -> input -> post();
//
//                $inputs[ 'user_id' ] = $this -> userdata[ 'user_id' ];
//
//                $this -> RatedArticle_model -> approve_article( $inputs );
//
//                echo json_encode( array ( "status" => TRUE, "message" => "Article approved successfully" ) );
//        }
//
//
//        function export_articles() {
//                $data = "";
//                $articles = $this -> RatedArticle_model -> get_list();
//
//                $data = '<tr>'
//                        . '<td><strong>Sr. No.</strong></td>'
//                        //. '<td><strong>Category</strong></td>'
//                        . '<td><strong>Article</strong></td>'
//                        . '<td><strong>Description</strong></td>'
//                        . '<td><strong>Choices</strong></td>'
//                        //. '<td><strong>Approved</strong></td>'
//                        . '<td><strong>Created Date</strong></td>'
//                        . '<td><strong>Is Active</strong></td>'
//                        . '</tr>';
//
//                foreach ( $articles as $key => $article_data ) {
//                        $num = $key + 1;
//                        $is_approved = ($article_data[ 'is_approved' ] == 1) ? "Yes" : "No";
//                        $is_active = ($article_data[ 'is_active' ] == 1) ? "Yes" : "No";
//
//                        $data .= '<tr>'
//                                . '<td>' . $num . '</td>'
//                                //. '<td>' . $article_data['category'] . '</td>'
//                                . '<td>' . $article_data[ 'question' ] . '</td>'
//                                . '<td>' . $article_data[ 'description' ] . '</td>'
//                                . '<td>' . $article_data[ 'choices' ] . '</td>'
//                                //. '<td>' . $is_approved . '</td>'
//                                . '<td>' . date( "d-m-Y", strtotime( $article_data[ 'created_date' ] ) ) . '</td>'
//                                . '<td>' . $is_active . '</td>'
//                                . '</tr>';
//                }
//                $file = "articles.xls";
//                $test = "<table border='1'>" . $data . "</table>";
//                header( "Content-type: application/vnd.ms-excel" );
//                header( "Content-Disposition: attachment; filename=$file" );
//                echo $test;
//        }

}
