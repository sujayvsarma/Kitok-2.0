<?php

    /**
     * Get information about the featured image.
     * 
     * Returns information about the featured image for any post.
     * 
     * @return  stdClass    Returns rich information about the attachment.
     * 
     */
    function get_featured_image() {

        $postitem_thumbnail_id = get_post_thumbnail_id();
        $postitem_img_info = wp_get_attachment_image_src( $postitem_thumbnail_id, 'full', false );

        $featured_image = new stdClass();
        $featured_image->is_present             = ( ( ! empty($postitem_img_info) ) ? true : false );
        if ( is_single() || is_front_page() ) {

            $featured_image->width          = '100%';
            $featured_image->height         = 'auto !important';
        }
        else {
            $featured_image->width          = '240px !important';
            $featured_image->height         = '180px !important';
        }

        if ( $featured_image->is_present ) {
            $featured_image->url                = $postitem_img_info[0];
            $featured_image->alt_text           = get_post_meta( $postitem_thumbnail_id, '_wp_attachment_image_alt', true );

            $featured_image->css_class          = 'kitok-featured-image';
        }

        return $featured_image;
    }

?>