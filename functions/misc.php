<?php

    /**
     * Add an entry to the debug log.
     * 
     * Adds the value of $message to a file named 'debug.log' in the theme's folder root.
     * Does not return anything.
     * 
     * @since 2.0
     * 
     * @param string $message The message to add.
     * 
     */
    function kitok2_write_debug_message( $message ) {
        error_log( "\n" . date('Y-m-d H:i:s') . ' - ' . $message . "\n", 3, get_template_directory() . '/debug.log' );
    }

    /**
     * Validate image type from URL.
     * 
     * Verify that the provided URL is in a valid format and is a PNG/JPG/JPEG type
     * 
     * @since 1.0
     * 
     * @param string $url The URL containing the proposed image file name.
     * @return bool Returns TRUE if is a valid image file, FALSE if not.
     * 
     */
    function kitok_isvalidimageurl($url) {
        $valid_extensions = array(
            '.png',
            '.jpg', '.jpeg',
        );

        if (strlen($url) < 4) {
            return false;
        }

        $lowered_url = strtolower($url);

        foreach ($valid_extensions as $ext) {
            if (substr_compare($lowered_url, $ext, -strlen($ext)) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Transform the result of wp_get_menu_items() into a hierarchical array.
     * 
     * The wp_get_menu_items() function returns results in a flat, but key-based associative array. This function 
     * transforms that flat-array into a hierarchical array. Child-level menus will be found within the "children" key 
     * of its parent.
     * 
     * @param   array   $wp_menu_array Array result obtained from wp_get_menu_items()
     * @return  array   Associative hierarchical array. Empty array if input was empty.
     * 
     */
    function kitok2_get_menu_hierarchically( $wp_menu_array ) {

        $result = array();

        $wp_menu_parent_0 = kitok2_filter_menu_for_parent( $wp_menu_array, '0' );

        foreach( $wp_menu_parent_0 as $top_item ) {

            $menu_parent = array(
                'id'            => $top_item->ID,                                               // ID of the backend wp_post, only to have an ID attribute in the array.
                'label'         => $top_item->title,                                            // The menu label -- what is to be displayed to the user.
                'description'   => $top_item->description,                                      // our native function will render this as a 'title' attribute on the link.
                'url'           => $top_item->url,                                              // URL
                'has_children'  => false,                                                       // flag indicating if child nodes are present, we will set this below.
                'num_children'  => 0,                                                           // number of child nodes present. Again, we will change this below.
                'children'      => array()                                                      // placeholder array to hold child nodes. We set this below.
            );

            $wp_menu_child = kitok2_filter_menu_for_parent( $wp_menu_array, (string)$top_item->ID );

            if ( $wp_menu_child && ( ! empty( $wp_menu_child ) ) ) {
                $menu_parent['has_children'] = true;
                $menu_parent['num_children'] = count( $wp_menu_child );

                foreach( $wp_menu_child as $child_item ) {
                    $menu_child = array(
                        'id'            => $child_item->ID,                                               // ID of the backend wp_post, only to have an ID attribute in the array.
                        'label'         => $child_item->title,                                            // The menu label -- what is to be displayed to the user.
                        'description'   => $child_item->description,                                      // our native function will render this as a 'title' attribute on the link.
                        'url'           => $child_item->url,                                              // URL
                        'has_children'  => false,                                                         // Will ALWAYS be false, we only support (A->B, not A->B->C...) menus.
                        'num_children'  => 0,                                                             // Will ALWAYS be zero.
                        'children'      => array()                                                        // Will ALWAYS be empty.
                    );

                    array_push( $menu_parent['children'], $menu_child );
                }
            }

            array_push( $result, $menu_parent );

        }

        return $result;
    }


    /**
     * PHP5's array_intersect_key seems buggy to do what we want to accomplish, so this is a ho-hum function 
     * to do the same, more efficiently :-)
     * 
     * @param   array   $menu_array     The array we want to filter from (master menu-list).
     * @param   string  $parent_id      Value of the parent ID we want to filter to.
     * @return  array                   The filtered list, no structural changes!
     */
    function kitok2_filter_menu_for_parent( $menu_array, $parent_id ) {
        $result = array();

        foreach( $menu_array as $menu_item ) {
            if ( isset( $menu_item->menu_item_parent ) && ( $menu_item->menu_item_parent == $parent_id ) ) {
                array_push( $result, $menu_item );
            }
        }

        return $result;
    }

?>