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
                   <?php
                   $reward_id = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                   ?>
                   <div class="header">
                    <h2>
                        <?php echo (!empty($reward_id))?'Edit':'Create';?>  Reward
                    </h2>
                </div>
                <div class="body">
                  <!--   <?php echo "<pre>";print_r($_SERVER);?> -->
                    <form name="addUpdateReward" id="addUpdateReward" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <!--action=create_update-->
                        <input type="hidden" name="reward_id" id="reward_id" value="<?= $reward_id ?>">
                        <div class="row m-t-50">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="title" id="title"  maxlength="50" required="" value="<?= @$title ?>" aria-required="true">                                            
                                        <label class="form-label">Title</label>
                                    </div>
                                    <strong><small class="text-danger titleErr"></small></strong>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" required="" name="req_coins" id="req_coins"   value="<?= @$req_coins ?>" oninput="this.value = this.value.replace(/[^0-9.]|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                        <label class="form-label">Required Coins</label>
                                    </div>
                                    <strong><small class="text-danger req_coinsErr"></small></strong>
                                </div>
                            </div>
                        </div>



                        <div class="row m-t-50">
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input type="text" id="uploadFile" name="uploaded_filename" placeholder="Choose Game Image" readonly="readonly" value="<?= @$image ?>">
                                            <?php
                                            if ( @$image == "" ) {
                                                $required = 'required=""';
                                            } else {
                                                $required = '';
                                            }
                                            ?>
                                            <div class="fileUpload btn btn-primary">
                                                <span>Choose image</span>
                                                <input id="uploadBtn" name="poll_img"  type="file" class="upload" <?= $required ?> aria-required="true">
                                            </div>
                                            <br>
                                            <i class="small">File size should be less than 1 MB and dimension should be minimum 200*200</i>
                                        </div>
                                        <div class="col-sm-3 uploaded-img-preview">
                                            <div class="" style="height:90px; background:url(<?= @$image ?>) center center no-repeat;background-size:contain;"></div>
                                        </div>

                                    </div>
                                </div>
                                 <p id="img_err" style="display:none;">* Please select valid Format(jpeg,jpg,png)</p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Published</label>
                            <a class="switch" data-id="1" data-type="topics" data-status="1">
                                <?php
                                if ( @$is_published == 1 ) {
                                    $checked = 'checked=""';
                                } else {
                                    $checked = '';
                                }
                                ?>
                                <label><input type="checkbox" name="is_published" id="is_published" value="1" <?= $checked;?>><span class="lever switch-col-bluenew"></span></label>
                            </a>
                        </div>
                    </div>


                        <div class="row">
                            <div class="col-sm-12 align-center">
                                <button id="addelection" type="submit" class="btn btn-primary waves-effect"><?php echo (!empty($reward_id))?'SAVE CHANGES':'SUBMIT';?> </button>
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

            $("#uploadBtn").on("change", function () {
                var file = $(this)[0].files[0];
                const fileType = file['type'];
                var img_valid = image_ext(fileType);

                if(img_valid == 1){

                var imageData = new FormData();
                imageData.append('file', file);
                $('#img_err').html('');


                ajax_call_multipart(uploadUrl, "POST", imageData, function (result) {
                    $("#uploadBtn").closest(".form-group").find("#uploadFile").val(result);
                    $(".uploaded-img-preview").html('<div class="" style="height:90px; background:url(' + result + ') center center no-repeat;background-size:contain;"></div>');
                });

                }else{
                      $('#img_err').show().css("color","#f44336");
                      $('#uploadBtn').val('');
                }
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
    //console.log(txtVal);
    if (parseFloat(txtVal) > 100) {
                //$(this).val('');
            }

        });



$(document).ready(function () {

        $("form#addUpdateReward").on("submit", function (e) {
        e.preventDefault();
        var err = [];
        /*var data = $(this).serialize();*/
        var formdata = new FormData(this);
        console.log(formdata);
        showloader();
        ajax_call_multipart("<?php echo base_url(); ?>Reward/create_update", "POST", formdata, function (result) {
                //result = JSON.parse(result);
                hideloader();
                data = JSON.parse(result);
                console.log(data);

                if (data.status == 'failure') {

                    if (data.error.title != '') {
                        err.push('titleErr');
                        $('.titleErr').text(data.error.title).css("color","#f44336");
                    }else if (data.error.req_coins != '') {
                        err.push('req_coinsErr');
                        $('.req_coinsErr').text(data.error.req_coins).css("color","#f44336");
                    }

                }else{

                    showToast(data.toast_message, '1');
                    setTimeout(function () {
                        window.location.assign("lists");
                    }, 2000);
                    
                }

            });
    });

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