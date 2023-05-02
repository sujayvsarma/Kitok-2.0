<?php
    get_header();
?>
<div class="kitok2-page">
    <div class="content">
        <div class="kitok2-webpart header">
            <h1 class="heading">Catalog of things I have posted in <?php the_archive_title(); ?></h1>
        </div>
        <div class="kitok2-webpart content">
            <?php  if ( have_posts() ) { ?>
            <main>
                <div class="table w-100">
            <?php
                $dbg_loop = 0; 
                while ( have_posts() ) {                    
                    the_post();
                    get_template_part( 'template-parts/generic-post-excerpt', 'generic-post-excerpt' );
                }

                wp_reset_postdata();
            ?>
                </div>
            </main>
            <?php
            } else {
                ?>
                <div class="alert alert-secondary" role="alert">
                    <span class="glyphicon glyphicon-info-sign" style="font-size: larger;"></span>Looks like there is no content for this date.
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
    get_footer();
?>