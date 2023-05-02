<?php

    get_header();

    if ( have_posts() ) {
        the_post();
?>
<div class="kitok2-page">
    <div class="content">
        <div class="card w-100">
            <div class="card-body small">
                <h1 class="heading"><?php the_title(); ?></h2>
                <hr />
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>
<?php
        wp_reset_postdata();
    }

    get_footer();

?>