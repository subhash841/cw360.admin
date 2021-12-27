<!DOCTYPE html>
<html>
    <head>
        <title>Blogs</title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->

        <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="google" content="notranslate">
        <style>
            .container{
                width: 86%;
            }
            h5,h6{
                letter-spacing: 1px;
            }
            .load_feeds{
                padding: 0;
                width: 40px;
                height: 40px;
                margin: 0 12px;
            }
            .page{
                background-color: white !important;
                color: #232b3c;
            }
            .page.current{
                background-color: #232b3c !important;
                color: white !important;
            }
            .pagination-container{
                padding:5% 0;
                padding-bottom: 10%;
            }
            .bottomborder{
                border-bottom:  1px solid #e0e7ea;
            }
            .blogsubject{
                font-size: 15px;
                text-transform: uppercase;
                color:#c3cad8;
                font-weight: 600;
            }
            .blogtitle{
                margin: 25px 0;
                font-size: 28px;
                font-weight: 600;
            }
            .blogdate{
                font-size: 15px;
                color:#c3cad8;
                font-weight: 500;
                margin: 15px 0;
            }
            .bloglinks{
                font-size: 18px;
                color:#c3cad8;
                font-weight: 500;
            }
            .bloglinks a{
                color: #45bce7;
            }
            .blogtext{
                font-size: 19px;

            }
            .blogimg{
                width:100%;
                height:440px;
            }
            .mtb3{

            }
            blockquote {

                font-style: italic;
                margin: 0.25em 0;
                padding: 0.35em 40px;
                line-height: 1.45;
                position: relative;
                color: #383838;
                border-left: none;
            }

            blockquote:before {
                font-family: poppins,sans-serif;
                display: block;
                padding-left: 10px;
                content: open-quote;
                font-size: 180px;
                position: absolute;
                left: -20px;
                top: -20px;
                color: #eff2f8;
            }
            blockquote:after {
                font-family: poppins,sans-serif;
                display: block;
                padding-left: 10px;
                content:close-quote;
                font-size: 180px;
                position: absolute;
                right: 50px;
                bottom: -20%;
                color: #eff2f8;
            }
            blockquote cite {
                color: #999999;
                font-size: 14px;
                display: block;
                margin-top: 5px;
            }

            blockquote cite:before {
                content: "\2014 \2009";
            }
            .blogtext ul li {
                list-style-type: disc;
                font-size:20px;
            }
            ul:not(.browser-default){
                padding-left: 25px;
            }
            blockquote div{
                margin: 8% 4%;
            }
            .blogcover{
                box-shadow: 0px 5px 25px #c3cad8;
                width:100%;
                height:100vh;
            }
            .link {
                position: fixed;
                top: 30vh;
                left: 0;
                z-index: 9999;
                /* background: #27334b; */
                background: #e70000;
                font-size: 12px;
            }
            .link a {
                color:#FFF;
                text-decoration: none;
            }
            .link:hover {
                background: #e70000;
            }
            .blogtext img{
                max-width: 500px;
            }

            .blogtext{

                word-break: break-word;
                color: rgb(46, 46, 46);
                font-family: "Open Sans", sans-serif !important;
            }
            p.MsoNormal {
                font-family: 'Poppins', sans-serif !important;
                mso-style-name: Normal;
                mso-style-parent: "";
                margin-bottom: inherit; 
                line-height: inherit !important; 
                font-size: inherit !important; 
            }
            .MsoNormal span{
                font-family: 'Poppins', sans-serif !important;
                font-size: 19px !important;
            }
            .blogtext div span{
                font-family: 'Poppins', sans-serif !important;
            }
        </style>
    </head>

    <body>
        <div id="toast-container"></div>


        <!--<div class="banner1" style="min-height:90vh;">
            <img src="/CrowdWisdom/Code/webportal/images/blogs/coverblog.jpg" class="blogcover">
        </div>-->
        <div class="white bottomborder">
            <div class="content container" >
                <?php if ( ! empty( $Blog_detail ) ) { ?>
                        <?php
                        if ( $Blog_detail[ 'sub_category' ] == "Karnataka" ) {
                                $linkurl = base_url() . "Karnataka/Home";
                        } else if ( $Blog_detail[ 'sub_category' ] == "Gujrat" ) {
                                $linkurl = base_url() . "Gujrat/Home";
                        } else {
                                $linkurl = "#";
                        }
                        ?>
                        <div class="row" style="padding: 20px 0;">
                          <!--   <h5 class="blogsubject" style=""><?php echo $Blog_detail[ 'category' ] ?></h5>  -->
                            <h4 class="blogtitle" style=""><?php echo $Blog_detail[ 'title' ] ?></h4>

                            <div class="bloglinks" style=""><!--By <a>Subhash Chabra</a> & <a>Amitabh Tiwari</a>--></div>
                            <?php if ( $Blog_detail[ 'image' ] != "default_blog.png" ) { ?>
                                    <div style="text-align: center;"><img style="max-width: 100%;width:550px;" src="<?php echo $Blog_detail[ 'image' ]; ?>" alt="Crowd Forecast"></div>
                            <?php } ?>
                            <div class="blogtext">
                                <h5 class="blogdate" style=""><?php echo date( 'j-M-Y', strtotime( $Blog_detail[ 'blog_date' ] ) ); ?></h5>
                                <?php $description = str_replace( "&#34;", '\'', $Blog_detail[ 'description' ] ); ?>
                                <?= $description; ?>
                            </div>
                        </div>
                <?php } else { ?>
                        <div class="row" style="padding: 20px 0;">
                            <h4>No data found</h4>
                        </div>

                <?php } ?>

            </div>
        </div>

    </body>
</html>
