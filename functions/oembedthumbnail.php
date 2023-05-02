<?php

    /**
     * These functions help in fetching, caching and refreshing thumbnails for oEmbed objects. 
     * An example of this is: Thumbnails of YouTube videos embedded.
     * 
     */

    require_once(ABSPATH . '/wp-includes/class-oembed.php'); 

    function fetch_oembed_thumbnail( $post_id, $video_url ) {
        $thumbnail = get_post_meta( $post_id, '_k2_attachment_thumbnail', true );

        if ( empty( $thumbnail ) ) {
            $oe = new WP_oembed;
            $oe_provider = $oe->discover( $video_url );
            $video = $oe->fetch($oe_provider, $video_url, array('width' => 1920, 'height' => 1080));
            $thumbnail = $video->thumbnail_url;
    
            update_post_meta( $post_id, '_k2_attachment_thumbnail', $thumbnail );
        }

        return $thumbnail;
    }


?>