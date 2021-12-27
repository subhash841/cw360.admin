<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                           Forecast
                        </h2>
                    </div>


                    <div class="body">
                        <div class="">
                            <div class="row">
                               <form id="form1" method="post" action="<?php echo base_url();?>Export/exportCSV">
                                 <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="id" id="id" required>
                                                <option>Select State</option>
                                                <?php foreach ($state as $states) {?>
                                                        <option value="<?php echo $states->id;?>"><?php echo $states->name;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" >
                                    <button style="display: none;" type="submit" id="submit" class="btn btn-danger waves-effect m-r-20">Export Forecast</button>
                                </div>
                            </form>
                        </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                           Prediction 
                        </h2>
                    </div>
                    <div class="body">
                        <div class="">
                        <div class="row">
                            <form id="form2">
                               <div class="col-sm-12">
                                    <button  type="submit" id="submit2" class="btn btn-danger waves-effect m-r-20">Export Prediction</button>
                                    <img id="loader" style="display:none;height:50px;width:50px;" src = '<?php echo base_url();?>images/loader.gif'>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                           Silver and Gold point
                        </h2>
                    </div>
                    <div class="body">
                        <div class="">
                        <div class="row">
                            <form id="form3" method="post">
                               <div class="col-sm-12">
                                    <button  type="submit" id="submit3" class="btn btn-danger waves-effect m-r-20">Export Points</button>
                                    <img id="load" style="display:none;height:50px;width:50px;" src = '<?php echo base_url();?>images/loader.gif'>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        
        
        <!-- #END# Exportable Table -->
    </div>
</section>

<div class="modal fade in" id="viewPollDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> Poll Details</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-success waves-effect btn-approve">Approve</button>
                <!--<button type="button" class="btn btn-link btn-danger waves-effect btn-reject" data-dismiss="modal" data-toggle="modal" data-target="#reject_poll">Reject</button>-->
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="reject_poll" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"><span class="username"></span> Forecasting</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link btn-success waves-effect btn-approve">Approve</button>
                <button type="button" class="btn btn-link btn-danger waves-effect btn-reject">Reject</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script type="text/javascript">
        $(document).ready(function(){
                $('#form3').submit(function(event) {
                $('#load').show();  
                $.ajax({
                            url: '<?php echo base_url();?>Export/exportCSV_points',
                            success: function(result)
                            {
                                    console.log(result);
                                    $('#load').hide();
                                    window.location = '<?php echo base_url();?>Export/exportCSV_points';
                            }

                        });
                    event.preventDefault();
                });

                $('#form2').submit(function(event) {
                $('#loader').show();  
                $.ajax({
                            url: '<?php echo base_url();?>Export/exportCSV_prediction',
                            success: function(result)
                            {
                                    console.log(result);
                                    $('#loader').hide();
                                    window.location = '<?php echo base_url();?>Export/exportCSV_prediction';
                            }

                        });
                event.preventDefault();
                });

        });
</script>


<script type="text/javascript">
    $(document).ready(function(){
    $('#id').on('change', function() {
      if ( this.value != null)
      //.....................^.......
      {
        $("#submit").show();
      }
      else
      {
        $("#submit").hide();
      }
    });
});
</script>
<script type="text/javascript">
        $(function () {
            $('#weekly_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                ignoreReadonly: true
            });


            $('#from_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });
            $('#to_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                ignoreReadonly: true
            });

            $("#from_datetimepicker").on("dp.change", function (e) {
                $('#to_datetimepicker').data("DateTimePicker").minDate(e.date);
            });
            $("#to_datetimepicker").on("dp.change", function (e) {
                $('#from_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });

            $(".edit-election").on("click", function (event) {
                event.preventDefault();
                var json = JSON.parse($(this).attr("data-editjson"));
                var base = "form[name='addUpdateElectionPeriod'] ";
                $(base + "#election_period_id").val(json.id);
                $(base + "#from_date").val(convertDate(json.from_date)).focus();
                $(base + "#to_date").val(convertDate(json.to_date)).focus();
                $(base + '#state_id').find("option[value='" + json.state_id + "']").prop("selected", "selected");
                $(base + '#total_seats').val(json.total_seats).focus();
                var selected = json.party_id.split(',');
                for (var x in selected) {
                    $(base + "select#optgroup").find("option[value='" + selected[x] + "']").prop("selected", "selected");
                }
                $('#optgroup').multiSelect();

                $('#state_id').selectpicker('refresh');
            });
        });
</script>