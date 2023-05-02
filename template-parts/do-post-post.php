<?php
    // Template to render "wordpress native 'post'" posts

    $author_info = get_user_by( 'login', get_the_author_login() );
    $author_photo_url = WP_CONTENT_DIR . '/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';

    if (! file_exists($author_photo_url)) {
        $author_photo_url = '//via.placeholder.com/180x120.png?text=' . substr($author_info->nickname, 0, 1);
    } else {
        $author_photo_url = '/wp-content/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';
    }

    $fi = get_featured_image();
?>

<div class="table w-100">
        <div class="row">
            <?php if ( $fi->is_present ) { ?>
            <div class="col-sm-12 col-md-2">
                <img class="<?php echo $fi->css_class; ?>" style="width: <?php echo $fi->width; ?>; height: <?php echo $fi->height; ?>" itemprop="image" src="<?php echo esc_url( $fi->url ); ?>" alt="<?php esc_attr( $fi->alt_text ); ?>" />
            </div>
            <?php } ?>
            <div class="col-sm-12 col-md">
                <h1><?php the_title(); ?> | <?php echo $h['title']; ?></h1>
                <p class="text-info small mt-2">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <?php echo '<a class="text-dark" target="_blank" href="/' . get_the_date('Y/m/d') .'">' . get_the_date() . '</a>'; ?>
                    <span class="ml-3 glyphicon glyphicon-user"></span>
                    <?php echo '<a class="text-dark" target="_blank" href="/author/' . get_the_author_login() .'">' . get_the_author() . '</a>'; ?>
                </p>
                <p class="mt-2">
                    <i class="text-info small"><?php the_excerpt(); ?></i>
                </p>
            </div>
        </div>
    </div>
<hr />

<?php the_content(); ?>

<?php 
    $tags = get_the_tags(); 

    if ($tags) {
?>

<hr />

<div class="card w-100">
    <div class="card-body text-info small">
        <?php
            foreach( $tags as $tag ) {
                echo '<i class="ml-2">#' . $tag->name . '</i>';
            }
        ?>
    </div>
</div>
<?php } ?>

<hr />
<div class="card w-100 small">
    <div class="card-body">
        <div class="table">
            <div class="row">
                <div class="col-sm-12 col-md-2">
                    <img src="<?php echo $author_photo_url; ?>" style="width: 160px !important; height: auto !important; border-radius: 50%;" />
                </div>
                <div class="col-sm-12 col-md-10">
                    <p class="heading font-weight-bold mb-3 border-bottom">About the author:</p>
                    <div class="kitok2-authorbio content"><?php echo nl2br($author_info->description); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>