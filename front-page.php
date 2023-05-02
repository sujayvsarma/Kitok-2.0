<?php

    get_header();

    // Add support to a WP "Page" set as a front-page:
    $wp_page_frontpage = get_option( 'page_on_front', 0 );
    if ( $wp_page_frontpage != 0 ) {
        // There is a WP "Page" that has been set as a front-page. Render that content!
        $page = get_post( $wp_page_frontpage );

        global $post;
        $post = $page;
?>
        <?php get_template_part( '/template-parts/featured-image' ); ?>
        <!-- <h1><?php /* the_title(); */ ?></h1>
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-info-sign"></span>We are showing the page set as the Frontpage in WP.
        </div> -->
        <?php the_content(); ?>
<?php
    }
    else {

        $blog = get_blog_info();

?>
<h1>Welcome to <?php echo $blog->name; ?></h1>
<hr />
<p>
    <?php echo $blog->description; ?>
</p>

<?php
    }
   
    // footer is rendered regardless of which front-page we are using...
    get_footer(); 
?>

