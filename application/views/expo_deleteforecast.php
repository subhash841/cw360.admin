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
                            Delete Forecast
                        </h2>

                    </div>
                    <div class="body">
                        <form name="deleteForecastByMax" id="form_validation" action="<?= base_url() ?>Dashboard/deleteForecastByMax"method="POST">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="forecast_type" id="forecast_type" required>
                                                <option value="">--Select Forecast Type--</option>
                                                <option value="seat">Seat Forecast</option>
                                                <option value="vote">Vote Forecast</option>
                                            </select>
                                            <label class="form-label">Forecast Type</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="election_period_id" id="election_period_id" required>
                                                <option value="">--Select Election Period--</option>
                                                <?php
                                                foreach ($election_period as $key => $ep) {
                                                    echo '<option value=' . $ep['id'] .','.$ep['state_id'].' data-editjson=\'' . json_encode($ep) . '\'>From : ' . $ep['from_date'] . ' To : ' . $ep['to_date'] . ' ' . $ep['state_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <label class="form-label">Forecast Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="max_limit" id="max_limit" required="" aria-required="true">
                                            <label class="form-label">Enter max forecast value </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="party_id" id="party_list" required>
                                                <option value="">--Party list--</option>
                                                <option disabled>Select Election Period</option>
                                            </select>
                                            <label class="form-label">Forecast Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 align-center">
                                    <button id="addelection" type="submit" class="btn btn-primary waves-effect">SAVE CHANGES</button>
                                    <a id="expotoexcel" href="" class="btn btn-secondary waves-effect disabled pull-right" data-ourl="<?= base_url()?>Dashboard/getCurrentForecastingList">Export to Excel</a></div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
</section>

<div class="modal fade" id="deleteReasonModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Delete Reason</h4>
            </div>
            <form name="deleteforecastreason" id="form_validation" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="forecastreasonid" id="forecastreasonid">
                    <input type="hidden" name="forecasttype" id="forecasttype" value="Karnataka">
                    <h5>Are you sure want to delete ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">Yes</button>
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    <?php if($this->session->flashdata('toast')) { ?>
        $('#response_message').html('<div class="btn btn-danger"><?= $this->session->flashdata('toast') ?></div>').fadeIn(1000).delay(1000).fadeOut(1000);
    <?php } ?>
        
         
    $(document).on('change', '#election_period_id', function (e) {
        if ($(this).val() != "") {
            var electionandstate=$(this).val();
            var json = JSON.parse($('option:selected', this).attr('data-editjson'));
            var party_id = json.party_id.split(',');
            var party_names = json.party_names.split(',');
            var party_abbrivation = json.party_abbrivation.split(',');
            var html = '';

            html += '<option value="">Select Party</option>'
            for (var x in party_id, party_names, party_abbrivation) {
                html += '<option value=' + party_id[x] + '>' + party_names[x] + ' - ' + party_abbrivation[x] + '</option>';
            }
            $('#expotoexcel').removeClass('disabled');
            var linkurl=$('#expotoexcel').attr('data-ourl');
            var arr = electionandstate.split(',');
            $('#expotoexcel').attr('href',linkurl+'/'+arr[0]+'/'+arr[1]);
        } else {
            html += '<option value="">--Party list--</option>\
                    <option disabled>Select Election Period</option>';
            $('#expotoexcel').addClass('disabled');
            $('#expotoexcel').attr('href','');
        }
        $('#party_list').html(html);
        $('#party_list').selectpicker('refresh');
    });
</script>
