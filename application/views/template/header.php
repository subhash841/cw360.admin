<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= $page_title ?></title>
    <!-- Favicon-->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Core Css -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= base_url() ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= base_url() ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="<?= base_url() ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="<?= base_url() ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Date time picker Css -->
    <!--<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <!-- Morris Chart Css-->
    <!--<link href="<?= base_url() ?>assets/plugins/morrisjs/morris.css" rel="stylesheet" />-->

    <!-- Colorpicker Css -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="<?= base_url() ?>assets/plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="<?= base_url() ?>assets/plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="<?= base_url() ?>assets/plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- noUISlider Css -->
    <link href="<?= base_url() ?>assets/plugins/nouislider/nouislider.min.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?= base_url() ?>assets/css/themes/all-themes.css" rel="stylesheet" />

    <!-- Jquery Core Js --> 
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/config.js?v=0.00"></script>

    <!-- MULTI SELECT -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    

        <!-- Wysiwyg-text-editor 
        <link href="<?= base_url() ?>assets/plugins/Wysiwyg-text-editor/editor.css" rel="stylesheet" />
        <script src="<?= base_url() ?>assets/plugins/Wysiwyg-text-editor/editor.js"></script>
        
    -->
    <style type="text/css">
        .loading{
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            background: rgba(0,0,0,0.8);
            z-index: 999;
            /*display: flex;*/
            align-items: center;
            justify-content: center;
            display: none;
        }

        .spinner{
            border: 5px solid #f3f3f3;
            -webkit-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
            border-top: 5px solid #555;
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body class="theme-red" data-base_url="<?= base_url() ?>">

    <div class="loading">
        <div class="spinner"></div>
    </div>

    <!-- Page Loader -->
       <!--  <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div> -->
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Search Bar -->
        <div class="search-bar">
            <div class="search-icon">
                <i class="material-icons">search</i>
            </div>
            <input type="text" placeholder="START TYPING...">
            <div class="close-search">
                <i class="material-icons">close</i>
            </div>
        </div>
        <!-- #END# Search Bar -->
        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="">Crowd Wisdom</a>
                </div>
                <div class="navbar-header pull-right">
                    <span class="navbar-brand" id="header_clock"></span>
                </div>
                <!-- <div class="pull-right">
                    <span id="header_clock"></span>
                </div> -->
                <!--<div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                         Call Search 
                        <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                         #END# Call Search 
                         Notifications 
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                                <i class="material-icons">notifications</i>
                                <span class="label-count">7</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">NOTIFICATIONS</li>
                                <li class="body">
                                    <ul class="menu">
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">person_add</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>12 new members joined</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 14 mins ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-cyan">
                                                    <i class="material-icons">add_shopping_cart</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>4 sales made</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 22 mins ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-red">
                                                    <i class="material-icons">delete_forever</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>Nancy Doe</b> deleted account</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 3 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-orange">
                                                    <i class="material-icons">mode_edit</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>Nancy</b> changed name</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 2 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-blue-grey">
                                                    <i class="material-icons">comment</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>John</b> commented your post</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 4 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">cached</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>John</b> updated status</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 3 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-purple">
                                                    <i class="material-icons">settings</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>Settings updated</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> Yesterday
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="javascript:void(0);">View All Notifications</a>
                                </li>
                            </ul>
                        </li>
                         #END# Notifications 
                         Tasks 
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                                <i class="material-icons">flag</i>
                                <span class="label-count">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">TASKS</li>
                                <li class="body">
                                    <ul class="menu tasks">
                                        <li>
                                            <a href="javascript:void(0);">
                                                <h4>
                                                    Footer display issue
                                                    <small>32%</small>
                                                </h4>
                                                <div class="progress">
                                                    <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <h4>
                                                    Make new buttons
                                                    <small>45%</small>
                                                </h4>
                                                <div class="progress">
                                                    <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <h4>
                                                    Create new dashboard
                                                    <small>54%</small>
                                                </h4>
                                                <div class="progress">
                                                    <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <h4>
                                                    Solve transition issue
                                                    <small>65%</small>
                                                </h4>
                                                <div class="progress">
                                                    <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <h4>
                                                    Answer GitHub questions
                                                    <small>92%</small>
                                                </h4>
                                                <div class="progress">
                                                    <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="javascript:void(0);">View All Tasks</a>
                                </li>
                            </ul>
                        </li>
                         #END# Tasks 
                        <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                    </ul>
                </div>-->
            </div>
        </nav>
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    <div class="image">
                        <img src="<?= base_url() ?>assets/images/user.png" width="48" height="48" alt="User" />
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</div>
                        <div class="email"><?php
                        $userdata = $this -> session -> userdata( 'loggedin' );
                        echo $userdata[ 'user_email' ];
                        ?>
                    </div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                                <!--<li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                                <li role="seperator" class="divider"></li>
                                <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                                <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                                <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                                <li role="seperator" class="divider"></li>-->
                                <li><a href="<?= base_url() ?>Login/logout"><i class="material-icons">input</i>Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #User Info -->
                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <li class="header">MAIN NAVIGATION</li>

                        <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master' )) ? "active" : "" ?>"
                        style="display:<?= (in_array('Master', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                            <a href="javascript:void(0);" class="menu-toggle <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                                <i class="material-icons">wb_cloudy</i>
                                <span>Master</span>
                            </a>
                            <ul class="ml-menu">
                                <!-- comment topic for cw phase 3 -->
                                 <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/user_list' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Master/user_list" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/user_list' )) ? "active" : "" ?>">
                                        User List
                                    </a>
                                </li>
                                <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/category' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Master/category">Category</a>
                                </li> 
                                <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/topics' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Master/topics" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/topics' )) ? "active" : "" ?>">
                                        Topics List
                                    </a>
                                </li> 
                               
                                <!-- <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/states' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Master/states" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/states' )) ? "active" : "" ?>">
                                        States List
                                    </a>
                                </li>
                                <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/parties' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Master/parties" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Master/parties' )) ? "active" : "" ?>">
                                        Parties List
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                        <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Games' )) ? "active" : "" ?>"   style="display:<?= (in_array('Games', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                            <a href="javascript:void(0);" class="menu-toggle <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                                <i class="material-icons">games</i>
                                <span>Games</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Games/index' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Games/index" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Games/index' )) ? "active" : "" ?>">
                                        Create
                                    </a>
                                </li>
                                <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Games/lists' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Games/lists" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Games/lists' )) ? "active" : "" ?>">
                                       List
                                   </a>
                               </li>
                               <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Games/Add_deduct_points' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Games/Add_deduct_points" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Games/Add_deduct_points' )) ? "active" : "" ?>">
                                    Add/Deduct Coins
                                   </a>
                               </li>
                           </ul>
                       </li>

                       <?php
                       if ( strpos( $_SERVER[ 'REQUEST_URI' ], 'Karnataka/Forecast/reasons' ) ) {
                        $isforecastpage = "active";
                    } else if ( strpos( $_SERVER[ 'REQUEST_URI' ], 'Gujrat/Forecast/reasons' ) ) {
                        $isforecastpage = "active";
                    } else if ( strpos( $_SERVER[ 'REQUEST_URI' ], 'Karnataka/Forecast/forecastlist' ) ) {
                        $isforecastpage = "active";
                    } else if ( strpos( $_SERVER[ 'REQUEST_URI' ], 'Karnataka/Forecast/forecastlist' ) ) {
                        $isforecastpage = "active";
                    } else if ( strpos( $_SERVER[ 'REQUEST_URI' ], 'Dashboard' ) ) {
                        $isforecastpage = "active";
                    } else {
                        $isforecastpage = "";
                    }
                    ?>

                    

                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Predictions' )) ? "active" : "" ?>" style="display:<?=(in_array('Predictions', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                        <a href="javascript:void(0);" class="menu-toggle <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">multiline_chart</i>
                            <span>Predictions</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Predictions/index' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Predictions/index" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Predictions/index' )) ? "active" : "" ?>">
                                    Create
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Predictions/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Predictions/lists" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Predictions/lists' )) ? "active" : "" ?>">
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Survey' )) ? "active" : "" ?>">
                        <a href="javascript:void(0);" class="menu-toggle <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">note_add</i>
                            <span>Survey</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Survey/index' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Survey/index" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Survey/index' )) ? "active" : "" ?>">
                                    Create
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Survey/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Survey/lists" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Survey/lists' )) ? "active" : "" ?>">
                                    List
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'RatedArticle' )) ? "active" : "" ?>">
                        <a href="javascript:void(0);" class="menu-toggle <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">message</i>
                            <span>Article</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'RatedArticle/index' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>RatedArticle/index" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'RatedArticle/index' )) ? "active" : "" ?>">
                                    Create
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'RatedArticle/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>RatedArticle/lists" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'RatedArticle/lists' )) ? "active" : "" ?>">
                                    List
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'FromTheWeb' )) ? "active" : "" ?>">
                        <a href="javascript:void(0);" class="menu-toggle <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">message</i>
                            <span>FromTheWeb</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'FromTheWeb/index' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>FromTheWeb/index" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'FromTheWeb/index' )) ? "active" : "" ?>">
                                    Create
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'comments/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>FromTheWeb/lists" class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'FromTheWeb/lists' )) ? "active" : "" ?>">
                                    List
                                </a>
                            </li>
                        </ul>
                    </li> -->


                    
                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Quiz' )) ? "active" : "" ?>" style="display:<?=(in_array('Quiz', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                    <a href="javascript:void(0);" class="menu-toggle  <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                        <i class="material-icons">contact_support</i>
                        <span>Quiz</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Quiz/index' )) ? "active" : "" ?>">
                            <a href="<?= base_url() ?>Quiz/index">
                                Create
                            </a>
                        </li>
                        <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Quiz/lists' )) ? "active" : "" ?>">
                            <a href="<?= base_url() ?>Quiz/lists" >
                                List 
                            </a>
                        </li>
                        <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Quiz/question' )) ? "active" : "" ?>">
                            <a href="<?= base_url() ?>Quiz/question">
                                Question
                            </a>
                        </li>
                        <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Quiz/quest_list' )) ? "active" : "" ?>">
                            <a href="<?= base_url() ?>Quiz/quest_list">
                              Question List 
                            </a>
                        </li>
                    </ul>                            
                    </li>



                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Subscription' )) ? "active" : "" ?>" style="display:<?=(in_array('Subscription', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                        <a href="javascript:void(0);" class="menu-toggle  <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">subscriptions</i>
                            <span>Subscription</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Subscription/index' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Subscription/index">
                                    Create
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Subscription/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Subscription/lists" >
                                    List 
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Subscription/Subscription_trans_history' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Subscription/Subscription_trans_history" >
                                    Transaction History
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Reward' )) ? "active" : "" ?>" style="display:<?=(in_array('Reward', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                        <a href="javascript:void(0);" class="menu-toggle  <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">emoji_events</i>
                            <span>Rewards</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Reward/index' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Reward/index">
                                    Create
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Reward/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Reward/lists" >
                                    List 
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Order' )) ? "active" : "" ?>" style="display:<?=(in_array('Order History', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                        <a href="javascript:void(0);" class="menu-toggle  <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">history</i>
                            <span>Order History</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Order/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Order/lists" >
                                    List 
                                </a>
                            </li>
                        </ul>
                    </li>





                    <!-- <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Wall' )) ? "active" : "" ?>">
                        <a href="javascript:void(0);" class="menu-toggle  <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">note_add</i>
                            <span>Wall</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Wall/index' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Wall/index">
                                    Create
                                </a>
                            </li>
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Wall/lists' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Wall/lists" >
                                    List 
                                </a>
                            </li>
                        </ul>
                    </li> -->

                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Blogs' )) ? "active" : "" ?>" style="display:<?=(in_array('Blogs', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                        <a href="javascript:void(0)" class="menu-toggle <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                            <i class="material-icons">list</i>
                            <span>Blogs</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Blogs' )) ? "active" : "" ?>">
                                <a href="<?= base_url() ?>Blogs">List</a>
                            </li>
                        </ul>
                    </li>


                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Export' )) ? "active" : "" ?>" style="display:<?=(in_array('Export', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                            <a href="javascript:void(0)" class="menu-toggle  <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                                <i class="material-icons">import_export</i>
                                <span>Export</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Export/User_history' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Export/User_history">
                                        Export User History
                                    </a>
                                </li>
                           </ul>
                    </li> 

                    <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Add_wallet_coins' )) ? "active" : "" ?>" style="display:<?= (in_array('Update Wallet Coins', $userdata[ 'user_menu_list' ])) ? "block" : "none"?> ">
                            <a href="javascript:void(0);" class="menu-toggle  <?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'toggled' )) ? "active" : "" ?>">
                                <i class="material-icons">monetization_on</i>
                                <span>Update Wallet Coins</span>
                              
                            </a>
                            <ul class="ml-menu">
                                <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Add_wallet_coins/index' )) ? "active" : "" ?>">
                                    <a href="<?= base_url() ?>Add_wallet_coins/index">
                                        Update Wallet Coins
                                    </a>
                                </li>
                                
                            </ul>
                    </li>








            <!-- <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'BannedWords' )) ? "active" : "" ?>">
                <a href="<?= base_url() ?>BannedWords">
                    <i class="material-icons">volume_off</i>
                    <span>Banned Words</span>
                </a>
            </li> -->

            <!-- <li class="<?php echo (strpos( $_SERVER[ 'REQUEST_URI' ], 'Export_game' )) ? "active" : "" ?>">
                <a href="<?= base_url() ?>Export/index">
                    <i class="material-icons">cloud_download</i>
                    <span>Downloads</span>
                </a>
            </li> -->
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2017 - <?= date('Y')?> <a href="javascript:void(0);">Crowd Wisdom</a>.
        </div>
                    <!--<div class="version">
                        <b>Version: </b> 1.0.5
                    </div>-->
    </div>
                <!-- #Footer -->
    </aside>
            <!-- #END# Left Sidebar -->
        </section>
        <div id="response_message" style="position: fixed;bottom: 30px;right: 25px;z-index: 9999;padding: 10px;border-radius: 3px;"></div>

<!-- Display clock in header-->
<script>
    $(document).ready(function(){
        show_dateTime();        //on page load, immidiately show dateTime

        setInterval(function() {
            show_dateTime(); 
        }, 1000);               //to show dateTime on 1 second of interval
    })

    function show_dateTime(){
        $.ajax({
            url: base_url + 'Dashboard/get_date_time',
            type: 'POST',
            dataType: 'JSON',
            success: function (res, textStatus, jqXHR) {
               $('#header_clock').html(res.dateTime);
            },
            error: function (jqXHR, textStatus, errorThrown) { }
        })
    }
</script>
