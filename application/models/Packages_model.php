<?php

class Packages_model extends CI_Model {

        function __construct() {
                parent::__construct();
        }

        function get_list() {
                $this -> db -> select( "p.*" );
                $this -> db -> from( "package p" );
                $result = $this -> db -> get() -> result_array();
                return $result;
        }

        function get_subscription(){
            $this -> db -> select( "pt.user_email,pt.package_name,pt.transaction_amount,pt.transaction_date,u.name");
            $this -> db -> from( "package_transactions pt" );
            $this -> db -> join( "users u", "pt.user_id = u.id", "LEFT" );
            $result['sub']  = $this -> db -> get() -> result_array();
            
            $this -> db ->select( "sum(pt.transaction_amount) as total");
            $this -> db ->from("package_transactions pt");

            $result['total'] = $this -> db ->get() -> result_array();
            return $result;
        }
      

        function add_update_package( $inputs ) {

                //$uid = $inputs[ 'user_id' ];
                $package_id = $inputs[ 'package_id' ];
                $name = $inputs[ 'package_name' ];
                $type = $inputs[ 'package_type' ];
                $price = $inputs[ 'package_price' ];
                $image = $inputs[ 'uploaded_filename' ];
                $enddate = $inputs[ 'package_end_date' ];
                $is_premium = $inputs['package_feature'];
                $premium_price = $inputs['premium_price'];
                //$package_content = $inputs[ 'package_content' ];
                $end_date = date( "y-m-d", strtotime( $enddate ) );
                $package_contents = $inputs[ 'package_content' ];

                $prize_text = $inputs[ 'prize_text' ];
                $point_required_text = $inputs[ 'point_required_text' ];
                $reward_text = $inputs[ 'reward_text' ];
                if ( $package_id == 0 ) {
                        //insert Polls
                        $insert_package = array (
                            "name" => $name,
                            "type" => $type,
                            "price" => $price,
                            "premium_price" => $premium_price,
                            "is_active" => "1",
                            "is_premium" => $is_premium,
                            "image" => $image,
                            "end_date" => $end_date,
                            "prize_text" => $prize_text,
                            "point_required_text" => $point_required_text,
                            "reward_text" => $reward_text
                        );
                        /* if ( $inputs[ 'json_data' ] != "" ) {
                          $insert_article[ 'data' ] = $inputs[ 'json_data' ];
                          } */
                        $this -> db -> insert( 'package', $insert_package );
                        $packageid = $this -> db -> insert_id();

                        foreach ( $package_contents as $key => $p ) {
                                $package_content[] = array (
                                    "package_id" => $packageid,
                                    "module_id" => $p
                                );
                        }

                        if ( ! empty( $package_content ) ) {
                                $this -> db -> insert_batch( 'package_data', $package_content );
                        }
                } else {

                        $update_package = array (
                            "name" => $name,
                            "type" => $type,
                            "price" => $price,
                            "premium_price" => $premium_price,
                            "is_active" => "1",
                            "is_premium" =>$is_premium,
                            "image" => $image,
                            "end_date" => $end_date,
                            "prize_text" => $prize_text,
                            "point_required_text" => $point_required_text,
                            "reward_text" => $reward_text
                        );

                        $this -> db -> where( array ( "id" => $package_id ) );
                        $this -> db -> update( 'package', $update_package );

                        $this -> db -> where( "package_id = '$package_id'" );
                        $this -> db -> delete( 'package_data' );

                        foreach ( $package_contents as $key => $p ) {
                                $package_content[] = array (
                                    "package_id" => $package_id,
                                    "module_id" => $p
                                );
                        }

                        if ( ! empty( $package_content ) ) {
                                $this -> db -> insert_batch( 'package_data', $package_content );
                        }
                }
        }

        function get_package_details( $package_id ) {
                $this -> db -> select( "p.*" );
                $this -> db -> from( "package p" );
                //$this->db->join("article_category pc", "pc.id = p.category_id", "INNER");
                //$this -> db -> join( "users u", "u.id = p.user_id", "LEFT" );
                $this -> db -> where( "p.id = '$package_id'" );
                $package_data = $this -> db -> get() -> row_array();

                $this -> db -> select( "pd.*" );
                $this -> db -> from( "package_data pd" );
                $this -> db -> where( "package_id = '$package_id'" );
                $package_data[ 'package_contents' ] = $this -> db -> get() -> result_array();

                return $package_data;
        }

}
