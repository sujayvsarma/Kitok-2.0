<?php

    /**
     * Filter function to add textboxes to capture audio transcripts for audio posts.
     * 
     * This function adds the fields to the Gutenberg editor's bottom view (document) to capture lyrics or subtitles for audio content.
     * 
     * NOTE: This is called only from wp-admin as it hooks the admin_init filter.
     * 
     */
    function kitok2_audio_posts_admin_add_transcript_boxes() {
        
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );

        add_meta_box( 
            'kitok2-audio-transcript',                              // ID
            'Audio Transcript',                                     // UI Title of section
            'kitok2_audio_posts_admin_add_transcript_boxes_render', // Callback function, below in this file!
            array ( 'podcast', 'video' ),                           // post type "podcast" and "video"
            'normal',                                               // where the box appears, on the main document area of the Gutenberg editor
            'low'                                                   // location in the placement, this should appear at the bottom of the window
        );
    }
    add_action( 'admin_init', 'kitok2_audio_posts_admin_add_transcript_boxes' );


    function kitok2_audio_posts_admin_save_transcript_boxes() {
        global $post;

        // Don't save anything if we are simply doing an autosave or the post is an auto-draft.
        if (( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( get_post_status( $post->ID ) === 'auto-draft' )) {
            return;
        }

        // DO NOT SANITIZE THIS FIELD!
        update_post_meta( $post->ID, '_k2_transcript_text', $_POST[ "_k2_transcript_text" ] );
    }
    add_action( 'save_post', 'kitok2_audio_posts_admin_save_transcript_boxes' );

    /**
     * Callback function to render the metadata boxes.
     * 
     * This function is called as a callback from the add_meta_box() call in kitok2_audio_posts_admin_add_metadata_boxes().
     * To comply with the rules, we must ECHO our output!
     * 
     */
    function kitok2_audio_posts_admin_add_transcript_boxes_render() {
        global $post;
        $saved = get_post_custom( $post->ID );

        $transcript_text = $saved['_k2_transcript_text'][0];

        echo "<label for=\"_k2_transcript_text\">Paste the audio transcript text here:</label><br /><i class=\"small\"></i>This can be in time-stamped notation, or as normal text. We do not parse this content.";
        echo "<textarea id=\"_k2_transcript_text\" name=\"_k2_transcript_text\" class=\"form-control\" rows=\"25\" placeholder=\"Type or paste the transcript or lyrics or other text here.\">$transcript_text</textarea>";
    }

?>