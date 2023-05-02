<?php

    /**
     * Implements our own powerful, customizable and predictable pagination system
     * 
     */

    /**
     * Get the pagination numbers for ARCHIVE pages. This function returns an associative array. The pages() array within 
     * contains the list of paginated page links. Other properties are state indicators.
     * 
     * @param   string  $post_type  Type of posts we are dealing with.
     * @return  array               An associative array containing the pagination data
     * 
     * @example $data = get_archive_pagination('post');
     * 
     */
    function get_archive_pagination( $post_type ) {

        global $wp_query;

        $total_pages = ( isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1 );
        $current_page = ( get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1 );
        $base_url = get_post_type_archive_link( $post_type );

        $result = array(
            'has_pages'             => ( $total_pages > 1 ),
            'older_link_url'        => '',
            'newer_link_url'        => '',
            'latest_page_url'       => '',
            'oldest_page_url'       => '',
            'current_page_number'   => $current_page,
            'total_pages'           => $total_pages,
            'pages'                 => array()
        );

        if ( $total_pages > 1 ) {
            for( $n = 1; $n <= $total_pages; $n++ ) {
                array_push( 
                    $result['pages'],  
                    $base_url . 'page/' . strval( $n ) . '/'
                );
            }

            if ( $current_page > 1 ) {
                $result['newer_link_url'] = $base_url . 'page/' . strval( $current_page - 1 ) . '/';
                $result['latest_page_url'] = $base_url . 'page/1/';
            }

            if ( $current_page < $total_pages ) {
                $result['older_link_url'] = $base_url . 'page/' . strval( $current_page + 1 ) . '/';
                $result['oldest_page_url'] = $base_url . 'page/' . strval( $total_pages ) . '/';
            }
        }

        return $result;

    }

    /**
     * Get HTML-formatted pagination for ARCHIVE pages that can be displayed on the UI. This function makes use of the 
     * get_archive_pagination() function to do the actual pagination. Typically, the 'post_type' argument is 
     * all you will need to make this work :-)
     * 
     * @param   array   $args   Associative array of arguments, can be in any recognized WP format, we use wp_parse_args to make sense of it.
     * @return  string          Returns HTML output. You need to use ECHO to write it out.
     * 
     * @example $data = get_archive_pagination_html( array( 'post_type' => 'post' ));
     */
    function get_archive_pagination_html( $args ) {

        $usable_args = wp_parse_args( 
            $args, 
            array(
                'show_page_numbers'                                         => true,
                'post_type'                                                 => 'post', 
                'show_post_type_in_labels'                                  => true,

                'container_classes'                                         => 'nav w-100 mt-2 mb-4 p-3 text-center', 
                'page_menu_header_classes'                                  => 'bg-secondary text-white ml-2',
                'page_menu_toggle_classes'                                  => 'btn btn-secondary',
                'page_menu_toggle_icon'                                     => 'glyphicon glyphicon-menu-hamburger',
                'page_menu_toggle_label'                                    => 'Jump to Page',
                'page_menu_toggle_show_current_page_insteadof_label'        => false,
                'page_menu_list_classes'                                    => 'bg-secondary text-white',
                'page_menu_pagelink_classes'                                => '',
                'page_menu_page_label'                                      => 'Page',

                'link_distance'                                             => 'ml-2',
                'link_classes'                                              => 'btn btn-secondary text-white', 
                'allow_link_underline'                                      => false, 

                'latest_link_icon'                                          => 'glyphicon glyphicon-fast-backward', 
                'newer_link_icon'                                           => 'glyphicon glyphicon-backward',
                'older_link_icon'                                           => 'glyphicon glyphicon-forward', 
                'oldest_link_icon'                                          => 'glyphicon glyphicon-fast-forward', 

                'latest_link_label'                                         => 'Latest', 
                'newer_link_label'                                          => 'Newer', 
                'older_link_label'                                          => 'Older', 
                'oldest_link_label'                                         => 'Oldest'
            ) 
        );


        $pt = get_post_type_object( $usable_args['post_type'] );
        $pages = get_archive_pagination( $args['post_type'] );
        $html = '';

        if ( $pages['has_pages'] == true ) {
            $html = $html . '<div class="container w-100 text-center"><div class="' . $usable_args['container_classes'] . '">';

            if (( $usable_args['show_page_numbers'] == true ) && ( $pages['total_pages'] > 1 ) ) {

                $html = $html . sprintf( 
                        '<div class="nav-item mb-2 dropdown %s">', 
                            $usable_args['page_menu_header_classes'] 
                    );

                $html = $html . sprintf( 
                        '<button class="%s dropdown-toggle" type="button" id="tocPaginationPagesButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">', 
                            $usable_args['page_menu_toggle_classes'] 
                    );
                
                $html = $html . sprintf( 
                        '<span class="%s"></span>%s', 
                            $usable_args['page_menu_toggle_icon'], 
                            ( ( $usable_args['page_menu_toggle_show_current_page_insteadof_label'] == true ) ? strval($pages['current_page_number']) : $usable_args['page_menu_toggle_label']) 
                    );

                $html = $html . '</button>';
                $html = $html . sprintf(
                        '<div class="dropdown-menu %s" aria-labelledby="tocPaginationPagesButton">',
                            $usable_args['page_menu_list_classes']
                    );

                for ( $page = 1; $page <= $pages['total_pages']; $page++ ) {
                    if ( $page == $pages['current_page_number'] ) {
                        if ( $usable_args['page_menu_toggle_show_current_page_insteadof_label'] == false ) {

                            $html = $html . '<div class="dropdown-item">';
                            $html = $html . sprintf(
                                '<a class="%s w-100 disabled" %s href="%s" disabled>%s</a>',
                                    $usable_args['page_menu_pagelink_classes'],
                                    ( ( $usable_args['allow_link_underline'] == true ) ? ' style="text-decoration: none;" ' : '' ),
                                    $pages['pages'][$page - 1],
                                    trim((($usable_args['page_menu_page_label'] != '') ? $usable_args['page_menu_page_label'] . ' ' : '') . strval($page))
                            );
                            $html = $html . '</div>';
                        }
                    } else {
                        $html = $html . '<div class="dropdown-item">';
                        $html = $html . sprintf(
                            '<a class="%s w-100" %s href="%s">%s</a>',
                                $usable_args['page_menu_pagelink_classes'],
                                ( ( $usable_args['allow_link_underline'] == true ) ? ' style="text-decoration: none;" ' : '' ),
                                $pages['pages'][$page - 1],
                                trim((($usable_args['page_menu_page_label'] != '') ? $usable_args['page_menu_page_label'] . ' ' : '') . strval($page))
                        );
                        $html = $html . '</div>';
                    }
                }

                $html = $html . '</div>';
                $html = $html . '</div>';
            }
            
            if ( ( $pages['latest_page_url'] != '' ) && ( $pages['latest_page_url'] != $pages['newer_link_url'] ) ) {
                $html = $html . sprintf(
                    '<div class="nav-item mb-2"><a class="%s" %s href="%s">%s %s</a></div>',
                        trim( $usable_args['link_classes'] . ' ' . ( ( $usable_args['link_distance'] != '' ) ? $usable_args['link_distance'] : '' ) ),
                        ( ( $usable_args['allow_link_underline'] == true ) ? ' style="text-decoration: none;" ' : '' ),
                        $pages['latest_page_url'],
                        ( ( $usable_args['latest_link_icon'] != '' ) ? '<span class="' . $usable_args['latest_link_icon'] . '"></span>' : '' ),
                        trim( ( ( $usable_args['latest_link_label'] != '' ) ? $usable_args['latest_link_label'] : '' ) . ' ' . ( ( $usable_args['show_post_type_in_labels'] == true ) ? $pt->labels->name : '' ) )
                );
            }

            if ( $pages['newer_link_url'] != '' ) {
                $html = $html . sprintf(
                    '<div class="nav-item mb-2"><a class="%s" %s href="%s">%s %s</a></div>',
                        trim( $usable_args['link_classes'] . ' ' . ( ( $usable_args['link_distance'] != '' ) ? $usable_args['link_distance'] : '' ) ),
                        ( ( $usable_args['allow_link_underline'] == true ) ? ' style="text-decoration: none;" ' : '' ),
                        $pages['newer_link_url'],
                        ( ( $usable_args['newer_link_icon'] != '' ) ? '<span class="' . $usable_args['newer_link_icon'] . '"></span>' : '' ),
                        trim( ( ( $usable_args['newer_link_label'] != '' ) ? $usable_args['newer_link_label'] : '' ) . ' ' . ( ( $usable_args['show_post_type_in_labels'] == true ) ? $pt->labels->name : '' ) )
                );
            }

            if ( $pages['older_link_url'] != '' ) {
                $html = $html . sprintf(
                    '<div class="nav-item mb-2"><a class="%s" %s href="%s">%s %s</a></div>',
                        trim( $usable_args['link_classes'] . ' ' . ( ( $usable_args['link_distance'] != '' ) ? $usable_args['link_distance'] : '' ) ),
                        ( ( $usable_args['allow_link_underline'] == true ) ? ' style="text-decoration: none;" ' : '' ),
                        $pages['older_link_url'],
                        trim( ( ( $usable_args['older_link_label'] != '' ) ? $usable_args['older_link_label'] : '' ) . ' ' . ( ( $usable_args['show_post_type_in_labels'] == true ) ? $pt->labels->name : '' ) ),
                        ( ( $usable_args['older_link_icon'] != '' ) ? '<span class="' . $usable_args['older_link_icon'] . '"></span>' : '' )
                );
            }

            if ( ( $pages['oldest_page_url'] != '' ) && ( $pages['oldest_page_url'] != $pages['older_link_url'] ) ) {
                $html = $html . sprintf(
                    '<div class="nav-item mb-2"><a class="%s" %s href="%s">%s %s</a></div>',
                        trim( $usable_args['link_classes'] . ' ' . ( ( $usable_args['link_distance'] != '' ) ? $usable_args['link_distance'] : '' ) ),
                        ( ( $usable_args['allow_link_underline'] == true ) ? ' style="text-decoration: none;" ' : '' ),
                        $pages['oldest_page_url'],
                        trim( ( ( $usable_args['oldest_link_label'] != '' ) ? $usable_args['oldest_link_label'] : '' ) . ' ' . ( ( $usable_args['show_post_type_in_labels'] == true ) ? $pt->labels->name : '' ) ),
                        ( ( $usable_args['oldest_link_icon'] != '' ) ? '<span class="' . $usable_args['oldest_link_icon'] . '"></span>' : '' )
                );
            }

            $html = $html . '</div></div>';
        }

        return $html;

    }


    /**
     * Get the pagination numbers for a SINGLE post page.
     * 
     */
    function get_post_pagination() {

        $args = array(
            'before'                => '<div class="container w-100 mt-2 mb-4 p-3 text-center">',
            'after'                 => '</div>',
            'next_or_number'        => 'number',
            'nextpagelink'          => 'Next Page <span class="glyphicon glyphicon-backward"></span>',
            'previouspagelink'      => '<span class="glyphicon glyphicon-forward"></span>Previous Page',
            'pagelink'              => '<span class="btn btn-secondary text-white">Page %s</span>'
        );

        wp_link_pages( $args );

    }

?>