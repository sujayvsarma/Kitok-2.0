<?php

    // Functions that walk a collection of posts of given type

    /**
     * Walk through post hierarchy, returns associative array of posts.
     * 
     * Starts at the $post_id and walk through all children of the tree. Returns an associative array 
     * 
     * @param   string  $post_type     The type of post in the collection
     * @param   int     $post_id       ID of the post in the data set
     * @param   bool    $start_at_root Optional. If TRUE, starts at $post_id and walks UP the tree to the top-most parent and then starts the walking. TRUE.
     * @return  array   Returns a recursive associative array
     * 
     */
    function kitok2_walk_post_hierarchy( $post_type, $post_id, $start_at_root = true ) {
        $walk_post = get_post($post_id);

        if ( $start_at_root == true ) {
            // Find the root-level post by walking UP the tree

            while ( ($walk_post) && ($walk_post->post_parent) && ($walk_post->post_parent > 0) ) {
                $walk_post = get_post($walk_post->post_parent);
            }
        }

        if ( $walk_post ) {
            
            $result = array(
                'id'        => $walk_post->ID,
                'title'     => $walk_post->post_title,
                'permalink' => get_post_permalink( $walk_post, false, null ),
                'children'  => array()
            );

            foreach( get_posts( array( 'post_parent' => $walk_post->ID, 'post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) ) as $top_level_post ) {
                array_push( $result['children'], postwalker_recurse_children( $top_level_post, $post_type ) );
            }

            return $result;
        }

        // return empty array
        return array();
    }

    // recurse children
    function postwalker_recurse_children( $parent_post, $post_type ) {
        $child_result = array(
            'id'        => $parent_post->ID,
            'title'     => $parent_post->post_title,
            'permalink' => get_post_permalink( $parent_post, false, null ),
            'children'  => array()
        );

        foreach( get_posts( array( 'post_parent' => $parent_post->ID, 'post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => -1, 'order_by' => 'menu_order', 'order' => 'ASC' ) ) as $child_post ) {
            $child_result['children'] += postwalker_recurse_children( $child_post, $post_type ); 
        }

        // return empty array
        return $child_result;
    }

?>