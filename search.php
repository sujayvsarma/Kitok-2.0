<?php
    get_header();
?>
<div class="kitok2-page">
    <div class="content">
        <div class="kitok2-webpart header">
            <h1 class="heading">Search results</h1>
            <p class="small">
                <strong>Query:</strong> <?php echo get_search_query(); ?>
            </p>
        </div>
        <div class="kitok2-webpart content">
            <?php  if ( have_posts() ) { ?>
            <main>
                <div class="table w-100">
            <?php
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
                    <span class="glyphicon glyphicon-info-sign" style="font-size: larger;"></span>There were no results for your search. Please check back later!
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