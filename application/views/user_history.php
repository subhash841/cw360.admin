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
                        Export User History
                    </h2>
                </div>
                <div class="body">
                    <form name="addUpdateReward" id="addUpdateReward" method="POST" action="<?php echo base_url();?>Export/exportcsv_userhistory">
                        <div class="row">
                            <div class="col-sm-12">
                                <button  type="submit" class="btn btn-danger waves-effect"> Export To Excel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                <div class="header">
                    <h2>
                     Export User Quiz Coins History
                    </h2>
                </div>
                <div class="body">
                    <form  method="POST" id="export_coinhistory">
                        <div class="row">
                            <div class="col-sm-12">
                                <button  type="submit" class="btn btn-danger waves-effect"> Export To Excel</button>
                                <img style="display:none" class="load" src="<?php echo base_url();?>images/loader.gif" width=60>
                            </div>
                           

                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                    <h2>
                        Export Portfolio Data
                    </h2>
                    </div>
                <div class="body">
                    <form name="exportportfolio" id="exportportfolio" method="POST" autocomplete="off" action="<?php echo base_url();?>Export/portfolio_data">
                            <div class="row">
                            <div class="col-sm-12">
                            <div class="col-sm-10">
                            <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control select2" name="game_id" id="game_id" required select2> 
                                        <option value="">Please select game</option> 
                                                <?php
                                                foreach ($games as $key => $g):
                                                 echo '<option value="' . $g['id'] . '" >' . $g['title'] . '</option>';
                                                endforeach;
                                        ?> 
                                        </select>
                                    </div>
                            </div>
                            </div>
                            <div class="col-sm-2">
                            <button id="addelection" type="submit" class="btn btn-danger waves-effect"> Export To Excel</button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                    <h2>
                       Quiz Answers Data
                    </h2>
                    </div>
                <div class="body">
                    <form name="exportquizans" id="exportquizans" method="POST" autocomplete="off" action="<?php echo base_url();?>Export/export_quizans">
                            <div class="row">
                            <div class="col-sm-12">
                            <div class="col-sm-10">
                            <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control quizselect" name="quiz_id" id="quiz_id" required select2> 
                                        <option value="">Please select Quiz</option> 
                                                <?php
                                                foreach ($quiz as $key => $q):
                                                 echo '<option value="' . $q['quiz_id'] . '" >' . $q['name'] . '</option>';
                                                endforeach;
                                        ?> 
                                        </select>
                                    </div>
                            </div>
                            </div>
                            <div class="col-sm-2">
                            <button id="exportquiz" type="submit" class="btn btn-danger waves-effect"> Export To Excel</button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

</section>
<!--<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.11.4/adapters/jquery.js"></script>



<script type="text/javascript">
    $(function () {


              $('#export_coinhistory').submit(function(event) {
                
                  $('.load').show();
                  $.ajax({
                      type: "POST",
                      url: "<?php echo base_url();?>" + 'Export/exportcsv_usercoinhistory',
                      success: function(result)
                      {
                       
                       window.location.href = "<?php echo base_url();?>" + 'Export/exportcsv_usercoinhistory' ;
                        $('.load').hide(); 
                   },
                   error: function(jqXHR, textStatus, errorThrown)  {
                }
            });
             event.preventDefault();
          });


            $(".select2").select2({
              width: '100%',
            });

            $(".quizselect").select2({
              width: '100%',
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
    //console.log(txtVal);
    if (parseFloat(txtVal) > 100) {
                //$(this).val('');
            }

        });



$(document).ready(function () {

       

    var base_url = "<?= base_url(); ?>";
    function showloader() {
        $('.loading').css({"display": 'flex'});
        $('body').css({'height': "100vh", 'overflow': "hidden"});
    }

    function hideloader() {
        $('.loading').fadeOut(800);
        $('body').css({'height': "100vh", 'overflow': "auto"});
    }
});
</script>   
