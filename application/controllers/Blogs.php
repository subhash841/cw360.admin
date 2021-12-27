<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Blogs extends Base_Controller {

    function __construct() {
        parent::__construct();
        $this->load->config('validation_rules', TRUE);
        $this->load->model('Blog_model');
        $this->load->model('Games_model');
        $this->load->model('Topics_model');
    }

    function index() {
        $data = array();
        $page_title['page_title'] = "Blogs";
        $data['category_list'] = $this->Blog_model->get_blog_category_detail_mod();
        $data['sub_category_list'] = $this->Blog_model->get_blog_sub_category_detail_mod();
        $data['blog_list'] = $this->Blog_model->get_blog_detail_mod();
        $data['pending_blog_list'] = $this->Blog_model->get_pending_blog_detail_mod();
        $this->load->view('template/header', $page_title);
        $this->load->view('blogs', $data);
        $this->load->view('template/footer');
    }


    function lists(){
        $data = array();
        $page_title['page_title'] = "Blogs";
        $data['blogs'] = $this->Blog_model->get_blog_list();
        $data['topics'] = $this->Topics_model->get_topics_list();
        $this->load->view('template/header', $page_title);
        $this->load->view('blog_list', $data);
        $this->load->view('template/footer');
    }


    function addeditblogview($id = Null) {

        $data = array();
        $page_title['page_title'] = "Blogs";
        if (empty($id)) {
            $data['Page_type'] = "Add Blog";
            $data['blog_id'] = 0;
        } else {
            $data['blog_id'] = $id;
            $data['Page_type'] = "Edit Blog";
            $data['Blogs'] = $this->Blog_model->get_blog_detail_byid_mod($id);
           /* echo'<pre>';print_r($data['Blogs']);
            exit();*/
        }
        //var_dump($data);exit;
        $data['category_list'] = $this->Blog_model->get_blog_category_detail_mod();
        $data['sub_category_list'] = $this->Blog_model->get_blog_sub_category_detail_mod();
        $data['topics'] = $this->Games_model->get_topic_list();
        /* echo'<pre>';print_r($data);exit();*/
        $this->load->view('template/header', $page_title);
        $this->load->view('addeditblogview', $data);
        $this->load->view('template/footer');
    }

    function previewblog($id = Null) {
        //$data=array();
        $data['Blog_detail'] = $this->Blog_model->get_blog_detail_byid_mod($id);
        //var_dump($data);exit;
        $this->load->view('previewblog', $data);    
    }

    function add_update_blog() {
        $inputs = $this->input->post();
        $blogid = $inputs['blogid'];
        $validationResult = $this->Blog_model->validate_blog();
            if(empty($validationResult)){
            $data['status']= 'failure';
            $data['error'] = array(
                'blog_title' =>strip_tags(form_error('blog_title')),            
                'blog_date' =>strip_tags(form_error('blog_date')),          
                'meta_keywords' =>strip_tags(form_error('meta_keywords')),            
                'meta_description' =>strip_tags(form_error('meta_description')),
                'description' =>strip_tags(form_error('description'))       
            );
            
            }else{
                $result = $this->Blog_model->add_update_blog_mod($inputs);
                $data['status'] = $result['status'];
                $data['message'] = $result['message'];
            }
            
            echo json_encode($data);
    }

    /*function category() {
        $data = array();
        $page_title['page_title'] = "Blogs";
        $data['category_list'] = $this->Blog_model->get_blog_category_detail_mod();

        $this->load->view('template/header', $page_title);
        $this->load->view('category', $data);
        $this->load->view('template/footer');
    }*/

    function addUpdateBlogCategory() {
        $inputs = $this->input->post();

        if ($inputs['categoryid'] == "0") {
            $this->Blog_model->addCategory($inputs);
        } else {
            $this->Blog_model->updateCategory($inputs);
        }
        
        $msg = ($inputs['categoryid'] == "0") ? "Category added successfully" : "Category updated successfully";
        echo json_encode(array("status" => TRUE, "message" => $msg));
    }

    /*function subcategory() {
        $data = array();
        $page_title['page_title'] = "Blogs";
        $this->load->view('template/header', $page_title);
        $data['category_list'] = $this->Blog_model->get_blog_category_detail_mod();
        $data['sub_category_list'] = $this->Blog_model->get_blog_sub_category_detail_mod();
        $this->load->view('subcategory', $data);
        $this->load->view('template/footer');
    }*/

    function addUpdateBlogSubCategory() {
        $inputs = $this->input->post();

        if ($inputs['sub_category_name'] == "") {
            echo json_encode(array("status" => FALSE, "message" => "Please enter Sub category name."));
        }
        if ($inputs['category_id'] == "") {
            echo json_encode(array("status" => FALSE, "message" => "Please select category name."));
        }
        if ($inputs['subcategoryid'] == "0") {
            $this->Blog_model->addSubCategory($inputs);
        } else {
            $this->Blog_model->updateSubCategory($inputs);
        }

        $msg = ($inputs['subcategoryid'] == "0") ? "Category added successfully" : "Category updated successfully";
        echo json_encode(array("status" => TRUE, "message" => $msg));
    }

    function changeActive() {
        $id = $this->input->post('id');
        $type = $this->input->post('type'); //use this for reusability for category,sub-category
        $current = $this->input->post('current');
        $newstatus = $current == "1" ? 0 : 1;

        $status = $this->Blog_model->changeActiveStatus($id, $newstatus, $type);
        $msg = "Action performed successfully";
        //$msg = ($newstatus == "0") ? "Sub category deactive successfully" : "Sub category active successfully";
        echo json_encode(array("status" => $status, "message" => $msg));
    }

    function rejectblog() {
        $id = $this->input->post('id');
        
        $status = $this->Blog_model->blogstatus($id, 2);
        $msg = "Action performed successfully";
        //$msg = ($newstatus == "0") ? "Sub category deactive successfully" : "Sub category active successfully";
        echo json_encode(array("status" => $status, "message" => $msg));
    }

    function approveblog() {
        $id = $this->input->post('id');
        $status = $this->Blog_model->blogstatus($id, 1);
        $msg = "Action performed successfully";
        //$msg = ($newstatus == "0") ? "Sub category deactive successfully" : "Sub category active successfully";
        echo json_encode(array("status" => $status, "message" => $msg));
    }

    function changeOrder() {
        $id = $this->input->post('id');
        $order = $this->input->post('order');

        if (!empty($id) && !empty($order)) {
            $status = $this->Blog_model->changeBlogOrder($id, $order);
            if ($status) {
                echo json_encode(array("status" => $status, "message" => "Order change successfully"));
            }
        }
    }

    function checkBlogOrderExist() {
        $order = $this->input->post('order');

        if (!empty($order)) {
            $status = $this->Blog_model->checkBlogOrderExist_mod($order);
            if ($status) {
                echo json_encode(array("status" => $status, "message" => "Do you want to replace existing"));
            } else {
                echo json_encode(array("status" => $status, "message" => "Can't assign this order id"));
            }
        }
    }



    function filteredList() {
            $blogs = array();


            //Filter Form Data
            $inputs = $this->input->post();


            $blogs = $this -> Blog_model -> get_filtered_list($inputs);

            $output = '';
            $num = $inputs[ 'offset' ];

            foreach ( $blogs as $key => $list ):
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
                                                            ';
                                                    endforeach;

            echo $output;


        }




    function export_blogs(){
        $data = "";

        //Filter Form Data
        $inputs = $this->input->get();

        $blogs = $this->Blog_model->export_filter_user_blogs($inputs);

        $data .= ' <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th width="400">Description</th>
                                                        <th class="text-center">Type</th>
                                                        <th class="text-center" width="100">Date</th>
                                                        <th class="text-center">Action</th>
                                                        <th class="text-center">Active</th>
                                                        <!--<th class="text-center">Order</th>-->
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
                                                                <td class="text-center">
                                                                    <a href="' . base_url() . 'Blogs/addeditblogview/' . $list[ 'id' ] . '" target="_Blank"><i class="material-icons">&#xE254;</i></a>
                                                                    <a href="' . base_url() . 'Blogs/previewblog/' . $list[ 'id' ] . '" target="_Blank"><i class="material-icons">remove_red_eye</i></a>
                                                                </td>';
                                                            $data .= '<td>
                                                                    <a class="switch changeactive" data-id="' . $list[ 'id' ] . '" data-type="blogs" data-status=' . $list[ 'is_active' ] . '>
                                                                        <label><input type="checkbox" ' . $newvalue . '><span class="lever switch-col-bluenew"></span></label>
                                                                    </a>
                                                                </td>';
                                                    endforeach;


        $file = "blogs.xls";
        $test = "<table border='1'>" . $data . "</table>";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

}
