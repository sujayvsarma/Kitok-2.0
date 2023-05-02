<?php

    /**
     * Filter function to clear the RSS version output in the META headers.
     * 
     * @return string Returns an empty string.
     */
    function kitok_rss_version() { 
        return ''; 
    }
    add_filter('the_generator', 'kitok_rss_version');


    /**
     * Filter function to remove the 'Read more' string from the continuation ellipse text.
     * 
     * @return string Returns just the '...' characters.
     */
    function kitok_remove_read_more() {
        return '&hellip;';
    }
    add_filter( 'excerpt_more', 'kitok_remove_read_more' );


    function kitok_increase_upload_size( $size ) {
        if (! current_user_can( 'manage_options' )) {
            $size = 512 * 1024 * 1024;                          // 512 MB
        }

        return $size;
    }
    add_filter( 'upload_size_limit', 'kitok_increase_upload_size', 20 );

?>