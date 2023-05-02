<?php

    // This page renders the author-bio page.

    $author_info = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $author_photo_url = WP_CONTENT_DIR . '/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';

    if (! file_exists($author_photo_url)) {
        $author_photo_url = '//via.placeholder.com/180x120.png?text=' . substr($author_info->nickname, 0, 1);
    } else {
        $author_photo_url = WP_CONTENT_URL . '/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';
    }

    get_header();
?>

<div class="kitok2-page">
    <div class="content">
        <div class="card w-100">
            <div class="card-header bg-secondary text-white">
                <h1 class="heading text-left card-title font-weight-bold text-uppercase">
                    <span class="glyphicon glyphicon-user"></span>
                    <?php echo $author_info->first_name . ' ' . $author_info->last_name; ?>
                </h1>
            </div>
            <div class="card-body">
                <div class="table">
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <img src="<?php echo $author_photo_url; ?>" style="width: 160px !important; height: auto !important; border-radius: 50%;" />
                        </div>
                        <div class="col-sm-12 col-md-10">
                            <div class="kitok2-authorbio content"><?php echo nl2br($author_info->description); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="kitok2-webpart header">
            <h1 class="heading">The last ten articles written by <?php echo $author_info->nickname; ?></h1>
        </div>
        <div class="kitok2-webpart content">
            <?php if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    get_template_part( 'template-parts/generic-post-excerpt', 'generic-post-excerpt' );
                }

                wp_reset_postdata();
            } else {
                ?>
                <div class="alert alert-secondary" role="alert">
                    <span class="glyphicon glyphicon-info-sign" style="font-size: larger;"></span>Looks like <?php echo $author_info->nickname; ?> has not written any articles yet. Please check back later!
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
