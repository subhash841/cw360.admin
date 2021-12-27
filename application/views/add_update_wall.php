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
                            Add Update Survey
                        </h2>
                    </div>
                    <div class="body">
                        <form name="addUpdatewall" id="addUpdatewall" method="POST" autocomplete="off">
                            <input type="hidden" name="wall_id" id="wall_id" value="<?= @$data[ 0 ][ 'id' ] ?>">
                            <input type="hidden" name="is_topic_change" id="is_topic_change" value="0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="wall_title" id="wall_title" required="" maxlength="75" value="<?= @$data[ 0 ][ 'title' ] ?>" aria-required="true">
                                            <label class="form-label">Title</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="search_topics" id="search_topics" maxlength="75" aria-required="true">
                                            <label class="form-label">Add Topics</label>
                                            <p class="error-topics"></p>
                                        </div>
                                        <div class="form-group searched_topics position-absolute w-75 bg-light p-t-10" style="position: absolute; background: white; left: 0; z-index: 1;">

                                        </div>
                                        <div class="form-group selected_topics">
                                            <label class="m-t-10">Selected Topics:</label>
                                            <div class="row px-4 col-xs-12">
                                                <?php
                                                $selectedTopicIds = array ();

                                                if ( ! empty( @$data[ 0 ][ 'topic_associated' ] ) ) {
                                                        foreach ( @$data[ 0 ][ 'topic_associated' ] as $ta ):
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
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="uploadFile" name="uploaded_filename" placeholder="Choose Cover Image" readonly="readonly" value="<?= @$data[ 0 ][ 'image' ] ?>">
                                                    <?php
                                                    if ( @$data[ 0 ][ 'image' ] == "" ) {
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
//            var i = 3 +  //$other_fields ?>;
//            var i = 3 + ;
            var fields = '';

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
            $('#end_datetimepicker').datetimepicker({
                useCurrent: false,
                format: "DD-MM-YYYY",
                minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                ignoreReadonly: true
            });

            //submit add update survey form
            $("#addUpdateSurvey").on("submit", function (e) {
//            var end_date = $("#end_date").val();
//            if (end_date == "") {
//                e.preventDefault();
//                showToast("Please select end date", '0');
//            }
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


            $(document).ready(function () {

                var selectedTopicId = <?= json_encode( $selectedTopicIds ) ?>;

                $('#search_topics').on('keyup', function () {

                    var topic = $(this).val();
                    console.log(topic.length);

                    if (topic && topic.length >= 2) {
                        $('.searched_topics').html('');
                        //alert(data);
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

                // $('li').click(function(){
                //     var nameValue = $(this).attr("#data-sug-name");
                //     alert('Hi');
                //     $('#p_category').val(nameValue);
                // });
                $(document).on('click', 'a.foundtopic', function (e) {
                    console.log('foundtopic clicked');
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
                    if (index > -1) {
                        selectedTopicId.splice(index, 1);
                        $("#is_topic_change").val('1');
                    }
                });



                $("form#addUpdatewall").on("submit", function (e) {
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
                    ajax_call("/Wall/add_update_wall", "POST", data, function (result) {
//                        console.log(result);
                        //result = JSON.parse(result);
                        //alert(result);
                        //if (result.status) {
                        window.location.assign("<?php echo base_url(); ?>Wall/lists");
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

        });
</script>