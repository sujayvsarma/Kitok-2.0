<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<?php

    $template = str_replace( '%2F', '/', rawurlencode( get_template() ) );
    $theme_root_uri = get_theme_root_uri( $template );
    $theme_uri = "$theme_root_uri/$template";
    $bloginfo = get_blog_info();
?>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="<?php echo $bloginfo->charset; ?>" />
    <meta name="referrer" content="origin-when-crossorigin" id="meta_referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="resource-type" content="document" />
    <meta http-equiv="content-type" content="text/html; charset=US-ASCII" />
    <meta http-equiv="content-language" content="<?php echo $bloginfo->language; ?>" />

    <?php 

        $site_name = $bloginfo->name;
        
        $page_title = $site_name;
        $page_description = $bloginfo->description;
        $page_hero_image = $bloginfo->siteicon;
        $page_permalink_url = $bloginfo->siteurl;

        $feed_atom = $bloginfo->atom_url;
        $feed_rss2 = $bloginfo->rss2_url;

        $slug = $wp->request;
        if ( strpos($slug, '/', 0) > 0 ) {
            $slug = end( explode( "/", $slug ) );
        }

        if ( is_category() ) {
            $cat = get_term_by( 'slug', $slug, 'category' );

            $page_title = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", str_ireplace( 'category', '', $cat->name )))) . ' category';
            $page_description = $cat->description;
            $page_permalink_url = get_permalink( '', false );

            $feed_atom = get_category_feed_link( $cat->term_id, 'atom' );
            $feed_rss2 = get_category_feed_link( $cat->term_id, 'rss2' );
        }
        else if ( is_tag() ) {
            $tag = get_term_by( 'slug', $slug, 'post_tag' );

            $page_title = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", str_ireplace( 'tag', '', $tag->name )))) . ' tag';
            $page_description = $tag->description;
            $page_permalink_url = get_permalink( '', false );

            $feed_atom = get_tag_feed_link( $tag->term_id, 'atom' );
            $feed_rss2 = get_tag_feed_link( $tag->term_id, 'rss2' );
        }
        else if ( is_author() ) {
            $fn_author_info = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));          

            $page_title = $fn_author_info->display_name;
            $page_description = $fn_author_info->description;
            $page_hero_image = get_avatar_url( $fn_author_info->ID, array( 'size' => 1280 ) );
            $page_permalink_url = get_author_link( false, $fn_author_info->ID, '' );

            $feed_atom = get_author_feed_link( $fn_author_info->ID, 'atom' );
            $feed_rss2 = get_author_feed_link( $fn_author_info->ID, 'rss2' );
        }
        else if ( is_archive() ) {
            $page_title = post_type_archive_title( '', false );

            $page_permalink_url = get_permalink( '', false );
            $feed_atom = get_feed_link( 'atom' );
            $feed_rss2 = get_feed_link( 'rss2' );
        } else if ( is_single() ) {
            global $post;

            $page_title = get_the_title( $post );
            $page_description = get_the_excerpt( $post );
            $page_hero_image = get_the_post_thumbnail_url( $post, 1024 );
            $page_permalink_url = get_permalink( $post, '' );

            $feed_atom = $bloginfo->atom_url;
            $feed_rss2 = $bloginfo->rss2_url;
        }
    ?>

    <?php if ( ( get_option( 'kitok2_enable_render_ogtags', 1 ) ) && ( ! is_404() )) { ?>
        <meta property="og:site_name" content="<?php echo $site_name; ?>">
        <meta property="og:title" content="Home | <?php echo $page_title; ?>" />
        <meta property="og:description" content="<?php echo esc_attr( $page_description ); ?>">   
        <meta property="og:url" content="<?php echo $page_permalink_url; ?>">
        
        <?php if ( $page_hero_image != '' ) { ?>
            <meta property="og:image" content="<?php echo esc_url($page_hero_image); ?>">
            <meta name="twitter:card" content="<?php echo esc_url($page_hero_image); ?>">               
            <meta name="twitter:image:alt" content="Home | <?php echo $page_title; ?>">
        <?php } ?>

        <?php if ( ! empty( $bloginfo->siteicon ) ) { ?>
            <link rel="icon" type="image/png" href="<?php echo esc_url($bloginfo->siteicon); ?>" sizes="32x32" />
        <?php } ?>
    <?php } ?>

    <link rel="stylesheet" type="text/css" href="<?php echo $theme_uri; ?>/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_uri; ?>/assets/css/glyphicons.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_uri; ?>/style.css" />

    <link rel="alternate" type="application/atom+xml" title="Atom Feed" href="<?php echo esc_url($feed_atom); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php echo esc_url($feed_rss2); ?>" />

    <script type="text/javascript" src="<?php echo $theme_uri; ?>/assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $theme_uri; ?>/assets/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo $theme_uri; ?>/assets/js/bootstrap.min.js"></script>

    <title><?php echo esc_html($page_title); ?> | <?php echo $bloginfo->name; ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <a name="verytop" id="verytop"></a>
    <div class="navbar-brand bg-dark text-white w-100 p-3 mt-0">
        <div class="align-top">
            <a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_attr( $bloginfo->name ); ?>">
            <?php if ( ! empty( $bloginfo->siteicon ) ) { ?>
                <img src="<?php echo esc_url($bloginfo->siteicon); ?>" class="logo align-middle" alt="<?php echo esc_attr( $bloginfo->description ); ?>" />
            <?php } 
                echo '<span class="blog-name text-white">' . esc_html(get_bloginfo( 'name' )) . '</span>';
                echo '<span class="blog-description text-white hide-below-md show-above-md" style="margin-left: 50px;">' . esc_html(get_bloginfo( 'description' )) . '</span>';
            ?>
            </a>
        </div>
    </div>
    <?php 

        $used_locations = get_nav_menu_locations();
        if ( $used_locations && ( isset( $used_locations['top_horizontal_menu'] ) )) {
            $th_menu = wp_get_nav_menu_object( $used_locations['top_horizontal_menu'] );
            if ( $th_menu ) {
                $items = wp_get_nav_menu_items( $th_menu->term_id );

                $th_menu = kitok2_get_menu_hierarchically( $items );
                if ( $th_menu && ( count($th_menu) > 0 ) ) {

                    $th_added_permalinks = array();

    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTopbarMenu" aria-controls="navbarTopbarMenu" aria-expanded="false" aria-label="Toggle top navigation menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarTopbarMenu">
            <ul class="navbar-nav w-100">
                <?php
                    foreach( $th_menu as $th_menu_item ) {
                        if ( $th_menu_item['has_children'] ) {
                            // render dropdown menus
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle btn btn-dark text-white text-left pl-2" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" title="<?php echo esc_attr( isset($th_menu_item['description']) ? $th_menu_item['description'] : $th_menu_item['label'] ); ?>">
                        <?php echo $th_menu_item['label']; ?>
                    </a>
                    <div class="dropdown-menu bg-dark text-white">
                    <?php
                            foreach( $th_menu_item['children'] as $child_item ) {
                        ?>
                            <div class="dropdown-item">
                                <a class="w-100 pl-2" href="<?php echo esc_url( $child_item['url'] ); ?>" title="<?php echo esc_attr( isset($child_item['description']) ? $child_item['description'] : $child_item['label'] ); ?>">
                                    <?php echo $child_item['label']; ?>
                                </a>    
                            </div>                        
                        <?php

                                array_push( $th_added_permalinks, $child_item['url']);
                            }
                    ?>
                    </div>
                </li>
                <?php
                        }
                        else {
                            // render normal links
                ?>
                <li class="nav-item">
                    <a class="nav-link text-white pl-2" style="text-decoration: none;" href="<?php echo esc_url( $th_menu_item['url'] ); ?>" title="<?php echo esc_attr( isset($th_menu_item['description']) ? $th_menu_item['description'] : $th_menu_item['label'] ); ?>">
                        <?php echo $th_menu_item['label']; ?>
                    </a>
                </li>
                <?php
                        }
                    }

                    if ( get_option( 'kitok2_enable_auto_menus', 1 ) ) 
                    {
                        /*
                            Construct auto-menus.

                            Customizations:

                            1. Add KiTok post-types that need to appear automatically in the $visible_post_types array below. 

                            2. Do NOT add non-KiTok types here! Add them manually from wp-admin > Appearance > Menus
                                or... write a plug-in :-)

                        */                    

                        $visible_post_types = array( 'book', 'podcast', 'video' );
                        foreach( $visible_post_types as $vpt_pt ) {
                            $data = wp_count_posts( $vpt_pt, 'readable' );
                            if ( $data->publish > 0 ) {
                                $post_type = get_post_type_object( $vpt_pt );
                                $post_type_slug = $post_type->name;

                                if ( isset($post_type->rewrite) && isset($post_type->rewrite['slug']) ) {
                                    $post_type_slug = $post_type->rewrite['slug'];
                                }
                ?>
                <li class="nav-item small">
                    <a class="nav-link text-white pl-2" style="text-decoration: none;" href="<?php echo "$bloginfo->siteurl/$post_type_slug" ?>" title="<?php echo $post_type->description; ?>">
                        <?php echo $post_type->label; ?>
                    </a>
                </li>
                <?php
                            }
                        }
                    }
                ?>             
            </ul>
            <div class="nav-item">
                <div class="navbar-form ml-auto">
                    <?php get_search_form(); ?>
                </div>
            </div>
    </nav>
        </div>
    </nav>
    <?php
                }
            }
        }
    ?>
    </div>
    

    <section style="flex: 1;" style="height: 100vh !important;">
        <div class="container-fluid mt-3" style="clear: both;">