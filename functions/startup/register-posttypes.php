<?php

    /**
     * Registers the KiTok post types
     */
    function kitok2_register_post_types() {

        $common_post_properties = array(
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
            'show_in_admin_bar'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'show_in_rest'          => true,
            'query_var'             => true,
            'rewrite'               => array( 'with_front' => false, 'feeds' => true, 'pages' => true ),
            'supports'              => array(
                'author',
                'comments',
                'custom-fields',
                'editor',
                'excerpt',
                'thumbnail',
                'title',
                'revisions',
                'page-attributes'
            )
        );

        // Enable revisions only if it is enabled in WordPress!
        if ( constant('WP_POST_REVISIONS') == true ) {
            array_push( $common_post_properties['supports'], 'revisions' );
        }

        $book_name      = get_option( 'kitok2_enable_post_type_book_name', 'Chaptered Post' );
        $book_slug      = get_option( 'kitok2_enable_post_type_book_slug', 'book' );

        $podcast_name   = get_option( 'kitok2_enable_post_type_podcast_name', 'Audio Post' );
        $podcast_slug   = get_option( 'kitok2_enable_post_type_podcast_slug', 'podcast' );

        $video_name     = get_option( 'kitok2_enable_post_type_video_name', 'Video Post' );
        $video_slug     = get_option( 'kitok2_enable_post_type_video_slug', 'video' );

        $kitok2_post_types = array(
            'story'                                      => array(
                'post_type'                             => 'book',
                'label'                                 => __( $book_name, 'KiTok' ),
                'description'                           => __( 'A post that can have chapters to it. Like a publication, book, story, etc.', 'KiTok'),
                'label_names'                           => array(
                    'at_start'                          => array( $book_name . 's', $book_name ),
                    'in_text'                           => array( strtolower($book_name) . 's', strtolower($book_name) )
                ),
                'menu_icon'                             => 'dashicons-welcome-write-blog',
                // 'has_taxonomy_builtin_tag'              => true,
                // 'has_taxonomy_builtin_category'         => true,
                'is_hierarchical'                       => true,
                'custom_rewrite_slug'                   => ( ($book_slug == 'book') ? null : $book_slug )
            ),
            'audio'                                     => array(
                'post_type'                             => 'podcast',
                'label'                                 => __( $podcast_name, 'KiTok' ),
                'description'                           => __( 'Audio post. Suitable for podcasts.', 'KiTok'),
                'label_names'                           => array(
                    'at_start'                          => array( $podcast_name . 's', $podcast_name ),
                    'in_text'                           => array( strtolower($podcast_name) . 's', strtolower($podcast_name) )
                ),
                'menu_icon'                             => 'dashicons-media-audio',
                // 'has_taxonomy_builtin_tag'              => true,
                // 'has_taxonomy_builtin_category'         => true,
                'is_hierarchical'                       => true,
                'custom_rewrite_slug'                   => ( ($podcast_slug == 'podcast') ? null : $podcast_slug )
            ),
            'video'                                     => array(
                'post_type'                             => 'video',
                'label'                                 => __( $video_name, 'KiTok' ),
                'description'                           => __( 'Video post. Suitable for YouTube videos.', 'KiTok'),
                'label_names'                           => array(
                    'at_start'                          => array( $video_name . 's', $video_name ),
                    'in_text'                           => array( strtolower($video_name) . 's', strtolower($video_name) )
                ),
                'menu_icon'                             => 'dashicons-media-video',
            //     'has_taxonomy_builtin_tag'              => true,
            //     'has_taxonomy_builtin_category'         => true,
                'is_hierarchical'                       => true,
                'custom_rewrite_slug'                   => ( ($video_slug == 'video') ? null : $video_slug )
            )
        );

        $menu_position = 26;
        foreach( $kitok2_post_types as $array_key => $post_parameters ) {

            // copy common properties
            $pt_creation_args = $common_post_properties;

            $pt_creation_args['label'] = $post_parameters['label'];
            $pt_creation_args['labels'] = register_post_types_create_labels_array( $post_parameters['label_names'] );
            $pt_creation_args['description'] = $post_parameters['description'];

            // set sequential menu position
            $pt_creation_args['menu_position'] = $menu_position;
            $menu_position += 1;

            // set menu icon
            if (array_key_exists( 'menu_icon', $post_parameters )) {
                $pt_creation_args['menu_icon'] = $post_parameters['menu_icon'];
            }

            // if the individual post def's parameter overrides the global setting, pick it up.
            // but only if the key exists!
            if ( array_key_exists( 'is_hierarchical', $post_parameters ) ) {
                $pt_creation_args['hierarchical'] = ( ( $post_parameters['is_hierarchical'] == true ) ? true : false );
            }

            // if the individual post def's parameter overrides the global setting, pick it up.
            // but only if the key exists!
            if ( array_key_exists( 'custom_rewrite_slug', $post_parameters ) && ( $post_parameters['custom_rewrite_slug'] ) ) {
                $pt_creation_args['rewrite'] += array( 'slug' => $post_parameters['custom_rewrite_slug'] );
            }

            //kitok2_write_debug_message( 'Registering post type: ' . $post_parameters['post_type'] . "\n" . 'With parameters: ' . "\n" . print_r( $pt_creation_args, true ) );

            // register the post type
            register_post_type( $post_parameters['post_type'], $pt_creation_args );
        }

        if ( ( $book_slug != 'book' ) || ( $podcast_slug != 'podcast' ) || ( $video_slug != 'video' )) {

            $last_slugs = get_option( 'kitok2_post_slugs', array() );

            if ( ( ! in_array( $book_slug, $last_slugs ) ) || ( ! in_array( $podcast_slug, $last_slugs ) ) || ( ! in_array( $video_slug, $last_slugs ) ) ) {
                // Ensure permalink structure is refreshed.
                flush_rewrite_rules( true );

                update_option( 'kitok2_post_slugs', array( $book_slug, $podcast_slug, $video_slug ), false );
            }            
        }
    }
    add_action('init', 'kitok2_register_post_types');


    /**
     * Filter function to return only the top-level posts for Archive-type pages.
     * 
     * Archive pages will only display the top-most page in a hierarchical dataset. They will 
     * however show dropdown menus to help the user navigate to a sub-post. This filter function 
     * modifies the main-query to return only the top-most post.
     * 
     * @param WP_Query $query The main-query that is being modified.
     * 
     */
    function kitok2_filter_get_only_toplevel_posts_for_archive( $query ) {
        
        if ( $query->is_main_query() && (! is_admin()) && is_archive() ) {
            $query->set( 'post_parent', 0 );
            $query->set( 'posts_per_page', 10 );
        }

        return $query;
    }
    add_action('pre_get_posts', 'kitok2_filter_get_only_toplevel_posts_for_archive');

    
    // Create the 'labels' array for post types. This is a tedious job to maintain individually. 
    // So we have a function to generate the names automatically on every run!
    function register_post_types_create_labels_array( array $names ) {

        //kitok2_write_debug_message( 'Creating labels: ' . print_r( $names, true) );

        return array(
            'name'                  => _x( $names['at_start'][0]           , 'Post Type General Name'   , 'KiTok' ),
            'singular_name'         => _x( $names['at_start'][1]           , 'Post Type Singular Name'  , 'KiTok' ),
            'menu_name'             => __( $names['at_start'][0]                                        , 'KiTok' ),
            'parent_item_colon'     => __( $names['at_start'][1] . ':'                                  , 'KiTok' ),
            'all_items'             => __( 'All ' . $names['in_text'][0]                                , 'KiTok' ),
            'view_item'             => __( 'View ' . $names['in_text'][1]                               , 'KiTok' ),
            'add_new_item'          => __( 'Add new ' . $names['in_text'][1]                            , 'KiTok' ),
            'add_new'               => __( 'Add new'                                                    , 'KiTok' ),
            'new_item'              => __( 'New ' . $names['in_text'][1]                                , 'KiTok' ),
            'edit_item'             => __( 'Edit ' . $names['in_text'][1]                               , 'KiTok' ),
            'update_item'           => __( 'Update ' . $names['in_text'][1]                             , 'KiTok' ),
            'search_items'          => __( 'Search ' . $names['in_text'][0]                             , 'KiTok' ),
            'not_found'             => __( $names['at_start'][1] . ' not found'                         , 'KiTok' ),
            'not_found_in_trash'    => __( $names['at_start'][1] . ' not found in trash'                , 'KiTok' )
        );
    }

?>
