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
                            Add Update Poll
                        </h2>
                    </div>
                    <div class="body">
                        <?php
                        $pollid = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                        $end_date = (@$end_date == "") ? "" : date( "d-m-Y", strtotime( @$end_date ) );
                        ?>
                        <form name="addUpdatePoll" id="addUpdatePoll" method="POST" autocomplete="off">
                            <!--action=create_update-->
                            <input type="hidden" name="poll_id" id="poll_id" value="<?= $pollid ?>">
                            <input type="hidden" name="is_topic_change" id="is_topic_change" value="0">
                            <input type="hidden" name="only_poll_detail_change" id="only_poll_detail_change" value="0">
                            <input type="hidden" name="only_end_date_change" id="only_end_date_change" value="0">
                            <input type="hidden" name="only_avg_change" id="only_avg_change" value="0">
                            <input type="hidden" name="previewdata" id="previewdata" value="<?= @$preview ?>">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="poll_title" id="poll_title" required="" maxlength="75" value="<?= @$poll ?>" aria-required="true">                                            
                                            <label class="form-label">Ask a Question</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change typehead" name="search_topics" id="search_topics" maxlength="75" value="" aria-required="true">                                            
                                            <label class="form-label">Add Topics</label>
                                            <p class="error-topics"></p>
                                        </div>
                                        <div class="form-group searched_topics position-absolute w-75 bg-light p-t-10" style="position: absolute; background: white; left: 0; z-index: 1;">

                                        </div>
                                        <div class="form-group selected_topics bg-dark">
                                            <label class="m-t-10">Selected Topics:</label>
                                            <div class="row px-4 col-xs-12">

                                                <?php
                                                $selectedTopicIds = array ();

                                                if ( ! empty( @$topic_associated ) ) {
                                                        foreach ( @$topic_associated as $ta ):
                                                                $selectedTopicIds[] = $ta[ 'topic_id' ];
                                                                ?>
                                                                <div class="btn bg-teal m-t-5 m-r-10 selected-topic">
                                                                    <input type="hidden" name="topics[]" value="<?= $ta[ 'topic_id' ] ?>" data-id="<?= $ta[ 'topic_id' ] ?>"><?= $ta[ 'topic' ] ?>
                                                                    <i class="cancel" style="cursor:pointer">&nbsp; ×</i>
                                                                </div>
                                                                <?php
                                                        endforeach;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line form-float">
                                            <textarea rows="4" class="form-control no-resize poll_detail_change" name="poll_desc" id="preview" required="required" maxlength="300" placeholder="Question Description"><?= @$description ?></textarea>
                                        </div>
                                    </div>
                                    <?= @htmlspecialchars_decode( $preview ) ?>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line form-float">
                                            <textarea rows="4" class="form-control no-resize" name="meta_keywords" required="required" placeholder="Meta Keywords"><?= @$meta_keywords ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line form-float">
                                            <textarea rows="4" class="form-control no-resize" name="meta_description" required="required" placeholder="Meta Description"><?= @$meta_description ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row add-more-choices">
                                <div class="col-sm-6">
                                    <div class="remove-poll-choices delete_choice display-delete">×</div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="choice[]" id="choice1" required="" maxlength="35" placeholder="Enter Choice" value="<?= @$choices[ 0 ][ 'choice' ] ?>" aria-required="true">
                                            <!--<label class="form-label">Choice 1</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="remove-poll-choices delete_choice display-delete">×</div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control poll_detail_change" name="choice[]" id="choice2" required="" maxlength="35" placeholder="Enter Choice" value="<?= @$choices[ 1 ][ 'choice' ] ?>" aria-required="true">
                                            <!--<label class="form-label">Choice 2</label>-->
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $other_fields = 0;
                                if ( count( @$choices ) > 4 ) {
                                        $other_fields = count( @$choices ) - 4;
                                        unset( $choices[ count( @$choices ) - 1 ] );
                                        unset( $choices[ count( @$choices ) - 1 ] );
                                        foreach ( @$choices as $key => $ch ) {
                                                if ( $key <= 1 ) {
                                                        continue;
                                                }
                                                $num = $key + 2;
                                                echo '<div class="col-sm-6">
                                                <div class="remove-poll-choices delete_choice poll_detail_change">×</div>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="choice[]" id="choice' . $num . '" required="" maxlength="35" placeholder="Enter Choice" value="' . $ch[ 'choice' ] . '" aria-required="true">
                                                        <!--<label class="form-label">Choice $num</label>-->
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                }
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35" readonly="readonly" value="See the Results" aria-required="true">
                                            <!--<label class="form-label">Choice 7</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice2" required="" maxlength="35" readonly="readonly" value="None of the above" aria-required="true">
                                            <!--<label class="form-label">Choice 8</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date" id="end_datetimepicker">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="end_date" id="end_date" readonly="readonly" required="required" value="<?= $end_date ?>" style="background-color: transparent;" aria-required="true">
                                                <label class="form-label">End Date</label>
                                            </div>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="input-group date">
                                            <div class="form-line">
                                                <input type="text" class="form-control"  name="average" id="average" value="<?= @$average ?>" onkeypress="return isNumber(event)" maxlength="50" style="background-color: transparent;" aria-required="true">
                                                <label class="form-label">Average</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="uploadFile" name="uploaded_filename" placeholder="Choose Cover Image" readonly="readonly" value="<?= @$image ?>">
                                                    <?php
                                                    if ( @$image == "" ) {
                                                            $required = 'required=""';
                                                    } else {
                                                            $required = '';
                                                    }
                                                    ?>
                                                    <div class="fileUpload btn btn-primary">
                                                        <span>Choose image</span>
                                                        <input id="uploadBtn" name="poll_img" type="file" class="upload" <?= $required ?> aria-required="true">
                                                    </div>
                                                    <br>
                                                    <i class="small">File size should be less than 1 MB and dimension should be minimum 200*200</i>
                                                </div>
                                                <div class="col-sm-3 uploaded-img-preview">
                                                    <div class="" style="height:90px; background:url(<?= @$image ?>) center center no-repeat;background-size:contain;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row" style="text-align: right;">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-approve waves-effect add-poll-choices">Add Choices</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 align-center">
                                    <button id="addelection" type="submit" class="btn btn-primary waves-effect">SAVE CHANGES</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
        $(function () {
            var i = 3 +<?= $other_fields ?>;
            var fields = '';

            //Condition to display remove polls
            if (i > 3) {
                $('.add-more-choices div:nth-child(1), .add-more-choices div:nth-child(2)').find('.remove-poll-choices').removeClass('display-delete');
            }
            //Add new Choices
            $(".add-poll-choices").on("click", function () {
                if (i < 11) {
                    fields = '<div class="col-sm-6">\
                <div class="remove-poll-choices delete_choice">×</div>\
                <div class="form-group form-float">\
                    <div class="form-line">\
                        <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35"  placeholder="Enter Choice" value="" aria-required="true">\
                    </div>\
                </div>\
            </div>';
                    $(".add-more-choices").append(fields);
                    i++;
                }
            });

            //Remove new Choices
            $(document).on("click", ".remove-poll-choices", function () {
                console.log(i);
                $("#only_poll_detail_change").val("1");
                $(this).closest("div.col-sm-6").remove();
                i--;
                if (i == 3) {
                    $('.add-more-choices div:nth-child(1), .add-more-choices div:nth-child(2)').find('.remove-poll-choices').addClass('display-delete');
                }
            });

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

            //End Date config
<?php
if ( $pollid == 0 ) {
        ?>
                    $('#end_datetimepicker').datetimepicker({
                        useCurrent: false,
                        format: "DD-MM-YYYY",
                        minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                        ignoreReadonly: true
                    });
        <?php
} else {
        ?>
                    $('#end_datetimepicker').datetimepicker({
                        useCurrent: false,
                        format: "DD-MM-YYYY",
                        ignoreReadonly: true
                    });
        <?php
}
?>
            //check end date change
            $("#end_datetimepicker").on("dp.change", function (e) {
                $("#only_end_date_change").val("1");
            });

            //submit add update poll form
            $("#addUpdatePoll").on("submit", function (e) {
                var end_date = $("#end_date").val();
                if (end_date == "") {
                    e.preventDefault();
                    showToast("Please select end date", '0');
                }
            });

            //when change end date or average
            $("#average").on("change", function (e) {
                $("#only_avg_change").val("1");
            });

            $("#poll_detail_change").on("change", function (e) {
                $("#only_poll_detail_change").val("1");
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
            console.log(txtVal);
            if (parseFloat(txtVal) > 100) {
                //$(this).val('');
            }

        });


        $(document).ready(function () {

            var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;

            $('#search_topics').on('keyup', function () {

                var topic = $(this).val();
                console.log(topic.length);

                if (topic && topic.length >= 2) {
                    $('.searched_topics').html('');
                    // alert('/Poll/fetchdata');
                    $.ajax({
                        url: "/Poll/fetchdata",
                        method: "POST",
                        data: {p_category: topic, topics: JSON.stringify(selectedTopicId)},
                        dataType: "text",
                        success: function (data)
                        {
                            $('.searched_topics').append('');
                            var data1 = JSON.parse(data);

                            var addDivData = "";
                            //addDivData += '<ul class="suggestions">';
                            $.each(data1, function (index, item) {
                                console.log(value.id);
                                 console.log(value.text);

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

            // $('li').click(function(){
            //     var nameValue = $(this).attr("#data-sug-name");
            //     alert('Hi');
            //     $('#p_category').val(nameValue);
            // });
            $(document).on('click', 'a.foundtopic', function (e) {
                e.preventDefault();
                var addId = $(this).attr('data-id');
                var selected = $("<div>", {class: "btn bg-teal m-t-5 m-r-10 selected-topic"})
                        .append('<input type="hidden" name="topics[]" value="' + $(this).attr('data-id') + '" data-id="' + $(this).attr('data-id') + '">' + $(this).attr('data-name'))
                        .append($("<i>", {class: "cancel", style: "cursor:pointer"}).html('&nbsp; &times;')
                                )


                $(this).closest('.searched_topics').parent();
                $('.selected_topics').show();
                $('.selected_topics .row').append(selected);
                $("#search_topics").val('').trigger("keyup");
                $("#is_topic_change").val('1');
                selectedTopicId.push(addId);
                $(".error-topics").html('');
            });

            $(document).on('click', '.selected_topics .cancel', function (e) {
                $(this).closest('.selected-topic').remove();
                var index = selectedTopicId.indexOf($(this).prev().attr('data-id'));
                console.log(index);
                if (index > -1) {
                    selectedTopicId.splice(index, 1);
                    $("#is_topic_change").val('1');
                }
            });



            $("form#addUpdatePoll").on("submit", function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var topics = $("input[name='topics[]']").length;
                if (topics == 0) {
                    $("#search_topics").focus();
                    $(".error-topics").html('*Add topics to this article');
                    $(".error-topics").css('color', 'red');
                    /*$(".show-error").html(
                     $("<div>", {class: "alert alert-warning alert-dismissible fade show", role: "alert"})
                     .append($("<strong>").html("Please select Topics"))
                     .append($("<button>", {type: "button", class: "close", "data-dismiss": "alert", "aria-label": "Close"})
                     .append($("<span>", {"aria-hidden": "true"}).html("&times;"))
                     )
                     );*/

                    return false;
                } else {
                    //$(".alert").alert('close');
                    $(".error-topics").html('');
                }
                ajax_call("/Poll/create_update", "POST", data, function (result) {
                    //result = JSON.parse(result);
                    //alert(result);
                    //if (result.status) {
                    window.location.assign("<?php echo base_url(); ?>Poll/lists");
                    //} else {
                    //result.data.title;
                    //result.data.description;
                    //result.data.choices;
                    //result.data.emails;
                    //result.data.uploaded_filename;
                    //}
                });
            });



        });




</script>