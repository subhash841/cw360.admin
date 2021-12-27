<section class="content">
	<div class="container-fluid">
		<div class="block-header">
        </div>
        <div class="row clearfix">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<div class="card">
        			<div class="header">
        				<h2>
                        	Questions List
                    	</h2>
                    <?php if(!empty($question_list)){?>
                    	<ul class="header-dropdown m-r--5">
                        	<li class="dropdown">
                            	<button type="submit" class="btn btn-danger waves-effect m-r-20" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter</button>
                        	</li>
                        	<li class="dropdown">                                
                            	<button type="submit" id="export_quizquestion_excel" class="btn btn-danger waves-effect m-r-20">Export to Excel</button>
                        	</li>
                    	</ul>
                    <?php } ?>    
        			</div>
        			<!-- Filter -->
        			<div style="border: none; padding: 20px 30px">
        				<div class="collapse" id="collapseFilter" aria-expanded="false">
        					<form id="filterForm" method="POST">
        						<div class="row">
        							<div class="col-sm-6">
        								<div class="form-group form-float">
        									<div class="form-line">
        										<input type="text" class="form-control" name="question_name" id="question_name" maxlength="75" value="">
                                            	<label class="form-label">Question Name</label>
        									</div>
        								</div>
        							</div>
        							<div class="col-sm-6">
        								<div class="form-group form-float">
                                        	<div class="form-line">
                                            	<input type="text" class="form-control" name="question_desc" id="question_desc" maxlength="75" value="">
                                            	<label class="form-label">Question Description</label>
                                        	</div>
                                    	</div>
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-sm-6">
        								<div class="form-group form-float">
                                        	<div class="input-group date" id="from_datetimepicker">
                                            	<div class="form-line">
                                                	<input type="text" class="form-control" name="start_date" id="start_date" readonly="readonly" value="" style="background-color: transparent;">
                                                	<label class="form-label">Created Date</label>
                                            	</div>
                                            	<span class="input-group-addon">
                                                	<span class="glyphicon glyphicon-calendar"></span>
                                          		</span>
                                        	</div>
                                    	</div>
        							</div>
        						</div>
                                <input type="hidden" class="form-control" name="offSet" id="offSet" readonly="readonly" value="0" style="background-color: transparent;">
        						<div class="row">
                                    <div class="col-sm-12 align-center">
                                        <button type="submit" class="btn btn-danger waves-effect" id="filterapply">APPLY FILTER</button>
                                        <button type="submit" class="btn btn-danger waves-effect" id="filterclear">CLEAR FILTER</button>
                                    </div>
                                </div>
        					</form>
        				</div>
        			</div>
        			<div class="body">
        				<div class="">
        					<table class="table table-responsive table-bordered table-striped table-hover dataTable">
        						<thead>
        							<tr>
                    					<th># Sr. No</th>
                                        <th>Question</th>
                                        <th style="width:20%">Description</th>
<!--                                    <th class="text-center">Is Approved</th>-->
                                        <th class="text-center">Created Date</th>
                                        <!--<th class="text-right">Active</th>-->
                                        <th class="text-center">Is Published</th>
                                        <th class="text-center">Action</th>
                    				</tr>
        						</thead>
        						<tbody class="records">
        							<?php 
                                     if(!empty($question_list)){
        								foreach ( $question_list as $key => $p ):        			

                                            $ischecked = ($p[ 'is_active' ] == 1) ? "checked" : "";
                                            $ispublished = ($p[ 'is_published' ] == 1) ? "checked" : "";
                                            $p=str_replace(array( '\'' ), "&#8217;", $p);
                                            $num = $key + 1;

                                            $question_id_exist = check_data_in_used('question_id',$p['id'],'quiz_action');
                                            if($question_id_exist > 0){
                                                $disabled = "disabled =''";
                                                $class = "invalid";
                                            }else{
                                                $class = "changeactivequestion";
                                                $disabled = "";

                                            }

                                            
                                        echo '<tr>'
                                            . '<td>' . $num . '</td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="1">' . $p[ 'question' ] . '</p></td>'
                                            . '<td><p class="multiline-ellipsis" data-lines="3">' . blank_value($p[ 'description' ]) . '</p></td>'
                                            . '<td class="text-center">' . date( "d-m-Y", strtotime( $p[ 'created_date' ] ) ) . '</td>'
                                            . '<td class="text-center">
                                                <a class="switch changepublishquestion" data-id="' . $p[ 'id' ] . '" data-type="question" data-status=' . $p[ 'is_published' ] . '>

                                                    <label><input type="checkbox" ' . $ispublished . '><span class="lever switch-col-bluenew"></span></label>
                                                </a>
                                                </td>'
                                            .'<td class="text-center">
                                            	<a href="' . base_url() . 'Quiz/question?id=' . $p[ 'id' ] . '" data-id="' . $p[ 'id' ] . '" data-editjson=\'' . json_encode( $p ) . '\'><i class="material-icons">&#xE254;</i></a>
                                            	<a href="#" '.$disabled.' data-id="' . $p[ 'id' ] . '" data-type="question" class="'.$class.'"><i class="material-icons">delete_forever</i></a>
                                        	  </td>';

                                        endforeach;} else{
                                                echo '<tr>'
                                            . '<td colspan="6" class="text-center"> No records found</td>';
                                        }
        							?>
        						</tbody>
        					</table>
        				</div>
        			</div>
                      <?php if(!empty($question_list)){?>
        			<div style="padding-bottom: 25px;">
                        <center>
                            <button id="loadlist" class="btn btn-danger waves-effect m-r-20" data-offset="10">Load More</button>
                        </center>
                    </div>
                    <?php } ?>  
        		</div>
        	</div>
        </div>
	</div>
</section>
<script type="text/javascript">
	$(function () { 
		$('#from_datetimepicker').datetimepicker({
        	useCurrent: false,
        	format: "DD-MM-YYYY",
        	ignoreReadonly: true
    	});


        $('#start_date').click(function () {
                    $('#from_datetimepicker').datetimepicker('show');
        });

        $('#filterForm').submit(function (e) {
        	e.preventDefault();
        	var data = $('#filterForm').serialize();        
        	var output = function (cb) {
        		$('.records').html(cb);
        	};
        	ajax_call('/Quiz/filteredQuestionList', 'POST', data, output);
        	$('#loadlist').attr('disabled', false);
        	$('#loadlist').attr('data-offset', 10);
    	});


        $('#loadlist').click(function(){
            var offSet = $(this).attr('data-offSet');
            showloader();
            var data = $('#filterForm').serialize();
             data += '&offSet=' +offSet;
             //alert(data);
             var output = function(cb){
             hideloader();
                if (cb != "") {
                    $('.records').append(cb);
                } else {
                    $('#loadlist').attr('disabled', true);
                }
            };

            ajax_call('Quiz/filteredQuestionList', 'POST', data, output);
            offSet = parseInt(offSet, 10);
            offSet = offSet+10;
            $(this).attr('data-offSet', offSet);

        });


    	$('#filterclear').click(function () {
        	// alert('Clear... ');
        	$("#filterForm").trigger('reset');
    	});


        


        //Active - Inactive Question List
            $(document).on('click', '.changeactivequestion', function (e) {
                var result = confirm("Are You Sure?");

                        if(result){
                        console.log();
                        var question_id = $(this).attr('data-id');
                        var type = $(this).attr('data-type');
                       /*var status = $(this).attr('data-status');*/
                        if (type != "") {
                            var param = {question_id: question_id, type: type};
                            console.log(param);
                            ajax_call('Quiz/active_inactive_question', "POST", param, function (result) {
                                console.log(result);
                                result = JSON.parse(result);
                                if (result['status']) {
                                    $("#response_message").html('<div class="btn-lg bg-green">Question Successfully Deleted</div>').fadeIn(2000).delay(1000).fadeOut(2000);
                                    setTimeout(function () {
                                        window.location.assign("quest_list");
                                    }, 2000);
                                } else {
                                    showToast(result['message'], '0');
                                    setTimeout(function () {
                                        window.location.assign("quest_list");
                                    }, 2000);
                                }

                            });
                        }
                    }
                });



            $(document).on('click', '.invalid', function (e) {
                    showToast('Action Disabled as Quiz Question is Live','0');
            });



            $('#export_quizquestion_excel').click(function(){
                var query = '';
                var req_url = 'exportList_quizquestion';

                if ($('#question_name').val() != "") {
                    query += 'question_name=' + $('#question_name').val() + '&';
                }

                if ($('#question_desc').val() != "") {
                    query += 'question_desc=' + $('#question_desc').val() + '&';
                }

                if ($('#start_date').val() != "") {
                    query += 'start_date=' + $('#start_date').val() + '&';
                }

               

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