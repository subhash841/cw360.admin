<style>
    .delete_choice{
        cursor:pointer;
        position: absolute;
        top: 0;
        right: 4%;
        z-index: 9999;
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
                            Add Update Article
                        </h2>
                    </div>
                    <div class="body">
                        <?php
                        $articleid = $this -> input -> get( 'id' ) != "0" ? $this -> input -> get( 'id' ) : "0";
                        $end_date = (@$end_date == "") ? "" : date( "d-m-Y", strtotime( @$end_date ) );

                        if ( @$data != "" ) {
                                $json_data = json_decode( @$data );
                                $json_data -> description = str_replace( "'", "`", $json_data -> description );
                                @$data = json_encode( $json_data );
                        }
                        ?>
                        <form name="addUpdateArticle" id="addUpdateArticle" method="POST" autocomplete="off">
                            <!-- action="base_url() RatedArticle/create_update"-->
                            <input type="hidden" name="article_id" id="article_id" value="<?= $articleid ?>">
                            <input type="hidden" name="previewdata" id="previewdata" value="<?= @$preview ?>">
                            <input type="hidden" id="json_data" name="json_data" value='<?= @$data ?>' />
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="article_title" id="article_title" required="" maxlength="75" value="<?= @$question ?>" aria-required="true">
                                            <label class="form-label">Ask a Question</label>
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <select class="form-control" name="article_category" id="article_category" required>
                                                                                    <option value="">-- Select Category --</option>
                                    <?php
                                    foreach ( $article_category as $key => $pc ):
                                            $selected = ($category_id == $pc[ 'id' ]) ? 'selected="selected"' : '';

                                            echo '<option value="' . $pc[ 'id' ] . '" ' . $selected . '>' . $pc[ 'name' ] . '</option>';
                                    endforeach;
                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>-->
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" name="article_desc" id="preview" required="required" maxlength="300" placeholder="Question Description"><?= @$description ?></textarea>
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
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Must Read" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice2" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Must Read but Partisan" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Read but Incomplete Picture" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice2" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Read but Biased" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Don't Read, Partisan" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice2" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Don't Read, Incomplete Picture" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Don't Read, Biased" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice2" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Mostly Fake" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Fully Fake" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice2" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Others (Add in Comment Section)" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice1" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="Click to see Rating" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="choice[]" id="choice2" required="" maxlength="35" readonly="readonly" placeholder="Enter Choice" value="None of the Above" aria-required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="row" style="text-align: right;">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-approve waves-effect add-article-choices">Add Choices</button>
                                </div>
                            </div>-->
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
        $('input[readonly]').each(function () {
            $(this).parent().removeClass('focused');
        });
</script>

<script>
        $(document).ready(function () {

            var selectedTopicId = [];

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


                // var data = $('#p_category').val().toLowerCase();

                // if (data == '') 
                // {

                // }
                // else
                // {
                //     $('#result').html('');
                //     //alert(data);
                //     $.ajax({
                //         url: "/Poll/fetchdata",
                //         method: "GET",
                //         data:{p_category:data},
                //         dataType: "text",
                //         success: function(data)
                //         {
                //             var data1 = JSON.parse(data);
                //              $.each(data1, function (index, item) {
                //                  /*console.log(value.id);
                //                  console.log(value.text);*/

                //                  var option = $("<option value='" + item.id + "'>" + item.name + "</option>");
                //                  $('#result').append(option);

                //              });

                //             //$('#result').html(data);
                //         }
                //     });
                // }
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
                //$("#is_topic_change").val('1');
                selectedTopicId.push(addId);
                $(".error-topics").html('');
            });

            $(document).on('click', '.selected_topics .cancel', function (e) {
                $(this).closest('.selected-topic').remove();
                var index = selectedTopicId.indexOf($(this).prev().attr('data-id'));
                if (index > -1) {
                    selectedTopicId.splice(index, 1);
                    //$("#is_topic_change").val('1');
                }
            });



            $("form#addUpdateArticle").on("submit", function (e) {
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
                ajax_call("/RatedArticle/create_update", "POST", data, function (result) {
                    //result = JSON.parse(result);
                    //alert(result);
                    //if (result.status) {
                    window.location.assign("<?php echo base_url(); ?>RatedArticle/lists");
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