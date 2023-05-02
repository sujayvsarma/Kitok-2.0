<?php

    require_once get_template_directory() . '/functions/misc.php';
    require_once get_template_directory() . '/functions/bloginfo.php';
    require_once get_template_directory() . '/functions/featuredimage.php';
    require_once get_template_directory() . '/functions/oembedthumbnail.php';
    require_once get_template_directory() . '/functions/post-walker.php';
    require_once get_template_directory() . '/functions/pagination.php';
    
    require_once get_template_directory() . '/functions/startup/common-filters.php';
    require_once get_template_directory() . '/functions/startup/register-posttypes.php';

    require_once get_template_directory() . '/functions/admin/editor-metafields-audio.php';
    require_once get_template_directory() . '/functions/admin/editor-metafields-video.php';
    require_once get_template_directory() . '/functions/admin/editor-metafields-audio-transcript.php';
    require_once get_template_directory() . '/functions/admin/customizer.php';
    

    /**
     * The theme setup function.
     */
    function kitok_setup() {
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'gutenberg', array( 'wide-images' => true ));
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 
            'custom-logo', 
            array(
                'height'        => 64,
                'width'         => 64,
                'flex-height'   => true,
                'flex-width'    => true
            )
        );
        
        register_nav_menus( 
            array(
                'top_horizontal_menu'   => __( 'Top Horizontal Menu', 'KiTok' ),        // Rendered as a horizontal navbar, will auto-collapse with breadcrumbs
                'bottom_footer_menu'    => __( 'Bottom Footer Menu', 'KiTok' ),         // Each top level gets a horizontally spaced box, with its children within it. Just rearranges to vertical format.
                'left_menu'             => __( 'Left-side Menu', 'KiTok' ),             // Classic left-hand side menu. Rendered as UL/LI tags. Basic styling only. Has expand/collapse buttons.
                'right_menu'            => __( 'Right-side Menu', 'KiTok' ),            // Classic right-hand side menu. Rendered as UL/LI tags. Basic styling only. Has expand/collapse buttons.
                'floating_fixed_menu'   => __( 'Floating Menu', 'KiTok' )               // Same as "left_menu", only it floats at a fixed position, a few pixels under the site-banner header.
            )
        );

        // We do the feeds ourselves in header.php
        remove_action( 'wp_head', 'feed_links_extra', 3 );                      // Category Feeds
        remove_action( 'wp_head', 'feed_links', 2 );                            // Post and Comment Feeds
        remove_action( 'wp_head', 'rsd_link' );                                 // EditURI link

        // out of date software, removing support
        remove_action( 'wp_head', 'wlwmanifest_link' );                         // Windows Live Writer

        // Why are these even output!
        remove_action( 'wp_head', 'index_rel_link' );                           // index link
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );              // previous link
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );               // start link
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   // Links for Adjacent Posts
        remove_action( 'wp_head', 'rel_canonical' );
        remove_action( 'wp_head', 'rel_shortlink' );
        remove_action( 'wp_head', 'rel_alternate' );

        // This should not be on screen, for anyone. People want to admin, go to /wp-admin.
        show_admin_bar(false);                                                  // Remove WordPress admin bar

        if (!is_admin()) {
            wp_deregister_script('jquery');                                     // De-Register jQuery
            wp_register_script('jquery', '', '', '', true);                     // Register as 'empty', because we manually insert our script in header.php
        }
    }
    add_action( 'after_setup_theme', 'kitok_setup' );

?>

