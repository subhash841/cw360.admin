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

                ?>
                
                <div class="header">
                    <h2>
                        Update Wallet Coins
                    </h2>
                    <ul class="header-dropdown m-r-5">
                            <li class="dropdown">
                                <button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Add</button>
                            </li>
                           <!--  <li class="dropdown">                                
                                <button type="submit" id="export_wallet_excel" class="btn btn-danger waves-effect m-r-20">Export</button>
                            </li> -->
                    </ul>
                </div>

               


                <div class="body">
                    <div class="collapse" id="collapseFilter" aria-expanded="false">
                    <form name="addUpdateCoin" id="addUpdateCoin" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <!--action=create_update-->
                        <div class="row">


                           <!--  <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                        <select class="form-control select2" name="game_id" id="game_id" required select2> 
                                              <option value="">Please select game</option> 
                                                <?php
                                                foreach ($games as $key => $g):
                                                echo '<option value="' . $g['id'] . '">' . $g['title'] . '</option>';
                                                endforeach;
                                                ?> 
                                        </select>
                                     </div>
                                 </div>
                             </div>  -->


                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                        <div class="form-line">
                                        <select class="form-control select2" name="user_id" id="user_id" required select2>  
                                        <option value="">Please select User</option> 
                                        <?php 
                                        foreach ($user as $key => $u):
                                        echo '<option value="'. $u['id'] .'">'. $u['email'] .'&nbsp;&nbsp;'.'('.blank_value($u['name']).')'. '</option>';    
                                        endforeach;
                                        ?> 
                                        </select>
                                        </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control poll_detail_change" required="" name="coins" id="coins"   value="<?= @$coins ?>" oninput="this.value = this.value.replace(/[^0-9.]|\.|\s/g, '').replace(/(\..*)\./g, '$1');" aria-required="true">           
                                    <label class="form-label">Wallet Coins</label>
                                    
                                </div>
                                <strong><small class="text-danger coinsErr"></small></strong>
                            </div>
                        </div>


                        <div class="col-sm-6">
                        <div class="form-group form-float">
                                        <div class="form-line">
                                        <select class="form-control" name="action" id="action" required> 
                                        <option value="">Select Action</option> 
                                        <option value="add">Add</option> 
                                        <option value="deduct">Deduct</option> 
                                        </select>
                                        </div>
                        </div>
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col-sm-12 align-center">
                            <button id="addelection" type="submit" class="btn btn-primary waves-effect">SUBMIT</button>
                        </div>
                    </div>
                </form>
                </div>

                <div class="body">        
                    <div>
                        <table class="table table-responsive table-bordered table-striped js-basic-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">User Name</th>  
                                        <th class="text-center">User Email</th>
                                        <th class="text-center">Updated Coins</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Previous Coins</th>
                                        <th class="text-center">New Coins</th>
                                        <th class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="records">
                                    <?php
                                    if(!empty($orders)){
                                       foreach( $orders as $key => $o):
                                        
                                    $type = ($o[ 'type' ] == 'add') ? "Add" : "Deduct";
                                    echo '<tr>'
                                       . '<td class="text-center">' . blank_value($o['name']) . '</td>'
                                       . '<td class="text-center">' . $o['email'] . '</td>'
                                       . '<td class="text-center">' . $o['coins'] . '</td>'
                                       . '<td class="text-center">' . $type . '</td>'
                                       . '<td class="text-center">' . $o['previous_coins'] . '</td>'
                                       . '<td class="text-center">' . $o['new_game_coins'] . '</td>'
                                       . '<td class="text-center">' . date( "d-m-Y H:i a", strtotime( $o[ 'created_date' ] ) ) . '</td></tr>';
                                        endforeach;
                                    }?>
                                </tbody>
                        </table>
                    </div>
                </div>
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
        var placeholder = "Please select User";
        $(".select2").select2({
         width:'100%',
         placeholder: placeholder,
        });

     });



  /* $('#custom_tab').DataTable( {
        "order": [[ 1, "desc" ]]
    } );*/




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

    var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;
    //console.log(selectedTopicId);
    $('#search_topics').on('keyup', function () {

        var topic = $(this).val();
        console.log(topic.length);

        if (topic && topic.length >= 2) {
            $('.searched_topics').html('');
                    //alert(data);
                    $.ajax({
                        url: "<?php echo base_url();?>/Games/fetchdata",
                        method: "POST",
                        data: {p_category: topic, topic_id: JSON.stringify(selectedTopicId)},
                        dataType: "text",
                        success: function (data)
                        {
                            $('.searched_topics').append('');
                            var data1 = JSON.parse(data);

                            var addDivData = "";
                            //addDivData += '<ul class="suggestions">';
                            $.each(data1, function (index, item) {
                            /*console.log(value.id);
                                console.log(value.text);*/
                            // addDivData += "<li data-sug-id='" + item.id + "' data-sug-name='"+ item.topic +"'>" + item.topic + "</li>";
                                //$('#result').append(option);
                                $('.searched_topics').append($("<div>", {class: "col-sm-12"})
                                    .append($("<a />", {class: "foundtopic nav-link", href: "#", "data-id": item.id, "data-name": item.topic}).html(item.topic)

                                        ));

                            });
                            //addDivData += '</ul>';
                            //$('.searched_topics').html(addDivData);
                        }
                    });
                } else {
                    $('.searched_topics').html("");
                }


            });

            /*$("#user_id").select2({
               placeholder: 'Please Select User',
               ajax: { 
               url: '<?= base_url() ?> /fetchUser',
               type: "post",
               dataType: 'json',
               delay: 250,
               data: function (params) {
                  return {
                    searchTerm: params.term, // search term
                    game_id: $("#game_id").val() // Category ID
                  };
               },
               processResults: function (response) {
                    return {
                     results: response
                  };
               },
               cache: true
               }
            });*/



        $("form#addUpdateCoin").on("submit", function (e) {
                e.preventDefault();
                var err = [];
                /*var data = $(this).serialize();*/
                var formdata = new FormData(this);
                console.log(formdata);
                showloader();
                ajax_call_multipart("<?php echo base_url(); ?>Add_wallet_coins/update_coins", "POST", formdata, function (result) {
                //result = JSON.parse(result);
                hideloader();
                data = JSON.parse(result);
                console.log(data);
                if (data.status == 'failure') {
                       console.log(data.error.coins);
                        if(data.error.coins !=''){
                            $('.coinsErr').text(data.error.coins).css("color","#f44336");
                        }else{
                            showToast_coins('error');    
                        }
                }else{
                     if(data.toast_message == 'add'){
                        showToast_coins('add');
                     }else{
                        showToast_coins('deduct');
                     }
                    setTimeout(function () {
                        window.location.assign("index");
                    }, 2000);
                    
                }

            });
        });


        $('#export_wallet_excel').click(function(){
                var query = '';
                var req_url = 'exportList_wallet';
                if (query.charAt(query.length-1) == '&') {
                    query = query.slice(0, -1);
                }
                if (query != "") {
                       req_url = req_url + '?' + query;
                }      
                //alert(req_url);
                window.location.assign(req_url);
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