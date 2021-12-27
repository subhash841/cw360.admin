
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>
                            <?= $poll_detail[ 'poll' ] ?>
                        </h3>
                        <h4><?= $poll_detail[ 'description' ] ?></h4>
                        <br>
                        <h4>Select Correct Options</h4>
                        <form id="pollform" name="pollform" method="post" action="../../Poll/update_answer">
                            <div class="form-group">
                                <input type="hidden" name="poll_id" id="poll_id" value="<?= $poll_detail[ 'id' ] ?>" />
                                <?php
                                foreach ( $poll_detail[ 'choices' ] as $key => $value ) {
                                        if ( $poll_detail[ 'right_choice' ] == $value[ 'id' ] ) {
                                                $checked = 'checked="checked"';
                                        } else {
                                                $checked = '';
                                        }

                                        echo '<input type="radio" class="with-gap" ' . $checked . ' name="choice" id="' . $key . '" value="' . $value[ 'id' ] . '">'
                                        . '<label for=' . $key . '>' . $value[ 'choice' ] . '</label><br>';
                                }
                                ?>
                            </div>
                            <?php
                            if ( $poll_detail[ 'right_choice' ] == "" ) {
                                    ?>
                                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                                    <?php
                            }
                            ?>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

</section>
