<?php

    get_header();

?>

<div class="kitok2-page">
    <div class="content">
        <div class="kitok2-webpart content">
            <?php if (have_posts()) {
                the_post();

                $post_type_template = 'template-parts/do-post-' . $post->post_type;
                $post_type_name = 'do-post-' . $post->post_type;

                $template_file_path = get_template_directory() . '/' . $post_type_template . '.php';
                if ( file_exists($template_file_path) ) {
                    get_template_part( $post_type_template, $post_type_name );

                    get_post_pagination();
                }
                else {

                    if ( get_option( 'kitok2_enable_handle_native_post_type', 1 ) ) {
                        // satisfy with the default POST template
                        get_template_part( 'template-parts/do-post-post', 'do-post-post' );

                        get_post_pagination();
                    }
                    else {
                        global $wp_query;
                        $wp_query->set_404();
                        status_header( 404, 'No valid handler configured for content.' );
                    }

                }
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>