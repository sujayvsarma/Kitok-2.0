<?php

    if ( post_password_required() ) {
        return;
    }

    if ( comments_open() ) {
        comment_form();
    } 

    if ( have_comments() ) {
        ?>
        <h3><?php printf(get_the_title() . ' has ' . get_comments_number() . ' comments:'); ?></h3>
        <ol class="list-unstyled">
            <?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 74 ) ); ?>
        </ol>
        <?php
    }
    else {
        ?>
    <div class="alert alert-secondary">
        <span class="glyphicon glyphicon-alert" style="color: yellow;"></span>Either there are no approved comments for this post, or comments have been disabled for this content.
    </div>
        <?php
    }  
?>
