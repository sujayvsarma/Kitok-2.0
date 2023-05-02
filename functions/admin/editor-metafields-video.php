<?php

    /**
     * Filter function to add metadata boxes for VIDEO type posts.
     * 
     * This function adds the data-capture fields to the Gutenberg editor's sidepanel (document settings) to capture metadata 
     * for the video.
     * 
     * NOTE: This is called only from wp-admin as it hooks the admin_init filter.
     * 
     */
    function kitok2_video_posts_admin_add_metadata_boxes() {
        
        wp_enqueue_style( 'bootstrap', get_template_directory() . '/assets/css/bootstrap.min.css' );

        add_meta_box( 
            'kitok2-video-metadata',                                // ID
            'Video Metadata',                                       // UI Title of section
            'kitok2_video_posts_admin_add_metadata_boxes_render',   // Callback function, below in this file!
            'video',                                                // post type "video"
            'side',                                                 // where the box appears, on the sidebar ("Settings") of the Gutenberg editor
            'high'                                                  // location in the placement, so this should appear higher up the order of boxes there!
        );
    }
    add_action( 'admin_init', 'kitok2_video_posts_admin_add_metadata_boxes' );


    function kitok2_video_posts_admin_save_metadata_boxes() {
        global $post;

        // Don't save anything if we are simply doing an autosave or the post is an auto-draft.
        if (( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( get_post_status( $post->ID ) === 'auto-draft' )) {
            return;
        }

        update_post_meta( $post->ID, '_k2_video_channel_name', sanitize_text_field( $_POST[ "_k2_video_channel_name" ] ) );
        update_post_meta( $post->ID, '_k2_video_recorded_on', sanitize_text_field( $_POST[ "_k2_video_recorded_on" ] ) );
        update_post_meta( $post->ID, '_k2_video_guest_names', sanitize_text_field( $_POST[ "_k2_video_guest_names" ] ) );
        update_post_meta( $post->ID, '_k2_video_series_name', sanitize_text_field( $_POST[ "_k2_video_series_name" ] ) );
        update_post_meta( $post->ID, '_k2_video_episode_name', sanitize_text_field( $_POST[ "_k2_video_episode_name" ] ) );
        update_post_meta( $post->ID, '_k2_video_language', sanitize_text_field( $_POST[ "_k2_video_language" ] ) );
        update_post_meta( $post->ID, '_k2_video_alt_url', sanitize_text_field( $_POST[ "_k2_video_alt_url" ] ) );
        update_post_meta( $post->ID, '_k2_video_production_number', sanitize_text_field( $_POST[ "_k2_video_production_number" ] ) );
        update_post_meta( $post->ID, '_k2_video_channel_id', sanitize_text_field( $_POST[ "_k2_video_channel_id" ] ) );
    }
    add_action( 'save_post', 'kitok2_video_posts_admin_save_metadata_boxes' );

    /**
     * Callback function to render the metadata boxes.
     * 
     * This function is called as a callback from the add_meta_box() call in kitok2_video_posts_admin_add_metadata_boxes().
     * To comply with the rules, we must ECHO our output!
     * 
     */
    function kitok2_video_posts_admin_add_metadata_boxes_render() {
        global $post;
        $saved = get_post_custom( $post->ID );

        $channel_name = $saved['_k2_video_channel_name'][0];
        $recorded_on = $saved['_k2_video_recorded_on'][0];
        $guest_names = $saved['_k2_video_guest_names'][0];
        $series_name = $saved['_k2_video_series_name'][0];
        $episode_name = $saved['_k2_video_episode_name'][0];
        $language = $saved['_k2_video_language'][0];
        $alt_url = $saved['_k2_video_alt_url'][0];
        $production_number = $saved['_k2_video_production_number'][0];
        $video_channel_id = $saved['_k2_video_channel_id'][0];

        echo "<label for=\"_k2_video_recorded_on\">Recorded on:</label><input id=\"_k2_video_recorded_on\" name=\"_k2_video_recorded_on\" maxlength=\"16\" type=\"date\" required class=\"form-control\" value=\"$recorded_on\">";
        echo "<br /><label for=\"_k2_video_guest_names\">Recognizable people(s):</label><textarea id=\"_k2_video_guest_names\" name=\"_k2_video_guest_names\" maxlength=\"4096\" class=\"form-control\" rows=\"4\" placeholder=\"John Doe, Jane Doe, Oliver Smith,...\">$guest_names</textarea>";
        echo "<br /><label for=\"_k2_video_series_name\">Album or series name:</label><input id=\"_k2_video_series_name\" name=\"_k2_video_series_name\" maxlength=\"255\" type=\"text\" required placeholder=\"Getting Started: Tutorial\" class=\"form-control\" value=\"$series_name\">";
        echo "<br /><label for=\"_k2_video_episode_name\">Performance or episode name:</label><input id=\"_k2_video_episode_name\" name=\"_k2_video_episode_name\" maxlength=\"255\" type=\"text\" required placeholder=\"Signing up on YouTube\" class=\"form-control\" value=\"$episode_name\">";
        echo "<br /><label for=\"_k2_video_language\">Language(s):</label><input id=\"_k2_video_language\" name=\"_k2_video_language\" maxlength=\"255\" type=\"text\" required placeholder=\"English, Klingon, French, ...\" class=\"form-control\" value=\"$language\">";
        echo "<br /><label for=\"_k2_video_channel_name\">YouTube channel name:</label><input id=\"_k2_video_channel_name\" name=\"_k2_video_channel_name\" maxlength=\"255\" type=\"text\" required placeholder=\"Nursery Rhymes at 60\" class=\"form-control\" value=\"$channel_name\">";
        echo "<br /><label for=\"_k2_video_channel_id\">YouTube channel ID:</label><input id=\"_k2_video_channel_id\" name=\"_k2_video_channel_id\" maxlength=\"255\" type=\"text\" required placeholder=\"Channel ID\" class=\"form-control\" value=\"$video_channel_id\">";
        echo "<br /><label for=\"_k2_video_alt_url\">YouTube Watch URL or ID:</label><input id=\"_k2_video_alt_url\" name=\"_k2_video_alt_url\" maxlength=\"255\" type=\"url\" placeholder=\"https://youtube.com/watch?v=...\" class=\"form-control\" value=\"$alt_url\">";
        echo "<br /><label for=\"_k2_video_production_number\">Internal production ID:</label><input id=\"_k2_video_production_number\" name=\"_k2_video_production_number\" maxlength=\"6\" type=\"number\" min==\"1\" max=\"999999\" step=\"1\" required placeholder=\"1\" class=\"form-control text-right\" value=\"$production_number\">";
        echo "<p class=\"mt-2 text-info\"><strong>NOTE:</strong> Please fill out the 'Excerpt' field above with a synopsis of this show or episode.</p>";
    }

?>