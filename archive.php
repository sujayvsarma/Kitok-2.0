<?php

    if ( ! get_option( 'kitok2_enable_handle_native_post_type', 1 ) ) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404, 'No valid handler configured for content.' );
    }

    get_header();   

    $bi = get_blog_info();

    if (have_posts()) {

        // since this is a generic fallback page, we need to determine what we are looking at.
        // unfortunately, WP (atleast till 5.5) does not provide a way to get at the first post 
        // without doing the following jiggery-pokery!

        the_post();
        global $post;

        $pt = get_post_type_object(get_post_type());

        $archive_name = '';
        $archive_description = '';

        // what are we after?
        if (is_category()) {
            global $wp;

            $slug = $wp->request;
            if ( strpos($slug, '/', 0) > 0 ) {
                $slug = end( explode( "/", $slug ) );
            }

            $cat = get_term_by( 'slug', $slug, 'category' );

            $archive_name = ' in \'' . $cat->name . '\' category';
            $archive_description = $cat->description;
        }
        else if (is_tag()) {
            global $wp;

            $slug = $wp->request;
            if ( strpos($slug, '/', 0) > 0 ) {
                $slug = end( explode( "/", $slug ) );
            }

            $tag = get_term_by( 'slug', $slug, 'post_tag' );

            $archive_name = ' with \'' . $tag->name . '\' tag';
            $archive_description = $tag->description;
        }
        else {
            // final fallback
            $archive_name = ' of type \'' . $pt->name . '\'';
            $archive_description = $pt->description;
        }

        rewind_posts();
?>
<div class="kitok2-page mt-2">
    <div class="content">
        <div class="kitok2-webpart content">
            <h1>Available posts <?php echo $archive_name; ?></h1>
            <p><?php echo $archive_description; ?></p>
            <hr />

            <div class="table w-100">
                <div class="row" style="padding: 15px;">
            <?php
                    while (have_posts()) {
                        the_post();

                        $h = kitok2_walk_post_hierarchy( $pt->labels->name, $post->ID, true );

                        $head_post = get_post($h['id']);
                        $featured_image = get_post_thumbnail_id( $head_post );

                        if ($featured_image) {
                            $featured_image = wp_get_attachment_image_src( $featured_image, 'full', false );
                            $fi_url = $featured_image[0];

                            $featured_image = "<img class=\"kitok-featured-image\" style=\"width: 100% !important; height: 240px !important;\" itemprop=\"image\" src=\"$fi_url\" />";
                        }
                        else {
                            $featured_image = '';
                        }
            ?>
                    <div class="card-deck">
                        <div class="card" style="width: 320px !important; margin-right: 30px !important; margin-top: 30px !important;">
                            <div class="card-body small">
                                <?php echo $featured_image; ?>
                                <p class="small">
                                    <?php the_excerpt(); ?>
                                </p>
                            </div>
                            <div class="card-footer text-center">
                                <?php if ( ! empty( $h['children'] ) ) { ?>
                                <div class="dropdown bg-secondary p-2 mb-1">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="tocButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="glyphicon glyphicon-menu-hamburger"></span>Jump to Chapter
                                    </button>
                                    <div class="dropdown-menu bg-secondary text-white" aria-labelledby="tocButton">
                                        <?php foreach( $h['children'] as $index => $values ) { ?>
                                            <?php if ( $values['id'] == $post->ID ) { ?>
                                                <div class="dropdown-item"><span class="font-weight-bold w-100"><?php echo $values['title']; ?></span></div>
                                            <?php } else { ?>
                                                <div class="dropdown-item"><a class="w-100" href="<?php echo $values['permalink']; ?>"><?php echo $values['title']; ?></a></div>
                                        <?php } } ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <a class="text-dark font-weight-bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="_blank">
                                    <?php the_title(); ?>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                    }
            ?>
                </div>
            </div>

            <?php echo get_archive_pagination_html(array('post_type' => $pt->name)); ?>
        </div>
    </div>
</div>
<?php
    }
    else {
        ?>
        <div class="alert alert-secondary" role="alert">
            <span class="glyphicon glyphicon-info-sign" style="font-size: larger;"></span>Looks like there is no content for this path.
        </div>
        <?php
    }   

    get_footer();
?>