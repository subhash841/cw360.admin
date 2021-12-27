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
                        $subscription_id = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                       
                        ?>
                    <div class="header">
                        <h2>
                            <?php echo (!empty($subscription_id))?'Edit':'Create';?>  Subscription 
                        </h2>
                    </div>
                    <div class="body">
                       
                        <form name="addUpdatesubscr" id="addUpdatesubscr" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <!--action=create_update-->
                            <input type="hidden" name="subscription_id" id="subscription_id" value="<?= $subscription_id ?>">
                            <div class="row">
                                
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control poll_detail_change" name="package_name" id="package_name"  maxlength="15" required="" value="<?= @$package_name ?>" aria-required="true">                                            
                                        <label class="form-label">Package Name</label>
                                    </div>
                                    <strong><small class="text-danger package_nameErr"></small></strong>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" required="" name="price" id="price"   value="<?= @$price ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                            <label class="form-label">Price</label>
                                        </div>
                                    </div>
                            </div> 

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" required="" name="points" id="points"   value="<?= @$coins ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                            <label class="form-label">Total Coins</label>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Rules & Updates</label>
                                        <div class="form-line form-float">
                                            <textarea rows="4" class="form-control no-resize poll_detail_change"  name="description" id="description"  placeholder="Rules & Updates"><?= @$description ?></textarea>
                                        </div>
                                        <small class="text-danger descriptionErr"></small>
                                    </div>
                                 </div>
                            </div>

                            
                          <div class="row">
                                <div class="col-sm-12 align-center">
                                    <button id="addelection" type="submit" class="btn btn-primary waves-effect"><?php echo (!empty($subscription_id))?'SAVE CHANGES':'SUBMIT';?> </button>
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
            $('input[name="package_name"]').on('change', function(){
                var pn_name = $('input[name="package_name"]').val().trim();
                $('input[name="package_name"]').val(pn_name);
            });

            $('input[name="price"]').on('change', function(){
                var pn_price = $('input[name="price"]').val().trim();
                if(pn_price == 0){
                    pn_price = '';
                }
                $('input[name="price"]').val(pn_price);
            });

            $('input[name="points"]').on('change', function(){
                var pn_points = $('input[name="points"]').val().trim();
                if(pn_points == 0){
                    pn_points = '';
                }
                $('input[name="points"]').val(pn_points);
            });

            $('textarea[name="description"]').on('change', function(){
                var pn_desc = $('textarea[name="description"]').val().trim();
                $('textarea[name="description"]').val(pn_desc);
            });
 
            $("form#addUpdatesubscr").on("submit", function (e) {
                e.preventDefault();
                var err = [];
                /*var data = $(this).serialize();*/
                var formdata = new FormData(this);
                console.log(formdata);
                showloader();
                ajax_call_multipart("<?php echo base_url(); ?>Subscription/create_update", "POST", formdata, function (result) {
                //result = JSON.parse(result);
                hideloader();
              
                data = JSON.parse(result);
                console.log(data);

             if (data.status == 'failure') {

                   /* if (data.error.title != '') {
                        err.push('titleErr');
                        $('.titleErr').text(data.error.title);
                    }else if (data.error.description != '') {
                        err.push('descriptionErr');
                        $('.descriptionErr').text(data.error.description);
                    }else if (data.error.meta_description != '') {
                        err.push('meta_descriptionErr');
                        $('.meta_descriptionErr').text(data.error.meta_description);
                    }else if (data.error.meta_keywords != '') {
                        err.push('meta_keywordsErr');
                        $('.meta_keywordsErr').text(data.error.meta_keywords);
                    }else{}*/

                }else{
                    
                    showToast(data.toast_message, '1');
                            setTimeout(function () {
                                window.location.assign("lists");
                            }, 2000);
                    
                }

                //alert(result);
                //if (result.status) {

                    //} else {
                    //result.data.title;
                    //result.data.description;
                    //result.data.choices;
                    //result.data.emails;
                    //result.data.uploaded_filename;
                    //}
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