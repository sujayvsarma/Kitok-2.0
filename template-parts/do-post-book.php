<?php
    // Template to render "Book" posts

    $author_info = get_user_by( 'login', get_the_author_login() );
    $author_photo_url = WP_CONTENT_DIR . '/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';

    if (! file_exists($author_photo_url)) {
        $author_photo_url = '//via.placeholder.com/180x120.png?text=' . substr($author_info->nickname, 0, 1);
    } else {
        $author_photo_url = '/wp-content/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';
    }

    // Create the book "contents":
    global $post;
    $h = kitok2_walk_post_hierarchy( 'book', $post->ID, true );

    $head_post = get_post($h['id']);
    $featured_image = get_post_thumbnail_id( $head_post );

    if ($featured_image) {
        $featured_image = wp_get_attachment_image_src( $featured_image, 'full', false );
        $fi_url = $featured_image[0];

        $featured_image = "<img class=\"kitok-featured-image\" style=\"width: 100% !important; height: auto !important;\" itemprop=\"image\" src=\"$fi_url\" />";
    }
    else {
        $featured_image = '';
    }

    if ($post->ID == $head_post->ID) {
        $post = get_post( $h['children'][0]['id'] );
        setup_postdata( $post );
    }

    // These are used for the bottom Prev/Next Chapter links
    $prev_link = NULL;
    $prev_title = NULL;
    $next_link = NULL;
    $next_title = NULL;

?>

<div class="container">
    <div class="table w-100">
        <div class="row">
            <div class="col-sm-12 col-md-2">
                <?php echo $featured_image; ?>
            </div>
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

    <?php if ( ! empty( $h['children'] ) ) { ?>
    <div class="dropdown bg-secondary p-2 mb-3">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="tocButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger"></span>Table of Contents
        </button>
        <div class="dropdown-menu bg-secondary text-white" aria-labelledby="tocButton">
            <?php 
                $max_children = max( array_keys($h['children']) );

                foreach( $h['children'] as $index => $values ) {
                    if ( $values['id'] == $post->ID ) {

                        if ($index > 0) {
                            $prev_link = $h['children'][$index - 1]['permalink'];
                            $prev_title = $h['children'][$index - 1]['title'];
                        }

                        if ($index < $max_children) {        
                            $next_link = $h['children'][$index + 1]['permalink'];
                            $next_title = $h['children'][$index + 1]['title'];
                        }
            ?>
                    <div class="dropdown-item"><span class="font-weight-bold w-100"><?php echo $values['title']; ?></span></div>
                <?php } else { ?>
                    <div class="dropdown-item"><a class="w-100" href="<?php echo $values['permalink']; ?>"><?php echo $values['title']; ?></a></div>
            <?php } } ?>
        </div>
    </div>
    <?php } ?>

    <?php the_content(); ?>

    <?php 
        if ( ! empty( $h['children'] ) ) { 
    ?>
    <div class="table w-100">
        <div class="row">
            <?php if ( $next_link != NULL ) { ?>
            <div class="col-sm-6 mt-2">
                <a class="btn btn-primary text-white" href="<?php echo $next_link; ?>">
                    <?php echo $next_title; ?>                    
                    <i class="fa fa-arrow-circle-right pl-1"></i>
                </a>
            </div>
            <?php } ?>
            <?php if ( $prev_link != NULL ) { ?>
            <div class="col-sm-6 mt-2">
                <a class="btn btn-secondary text-light" href="<?php echo $prev_link; ?>">
                    <i class="fa fa-arrow-circle-left pr-1"></i>
                    <?php echo $prev_title; ?>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</div>

<hr />
<div class="card w-100 small">
    <div class="card-body">
        <div class="table">
            <div class="row">
                <div class="col-sm-12 col-md-2" style="vertical-align: top;">
                    <img src="<?php echo $author_photo_url; ?>" style="width: 140px !important; height: auto !important; border-radius: 50%;" />
                </div>
                <div class="col-sm-12 col-md ml-1 mt-2" style="vertical-align: top;">
                    <p class="heading font-weight-bold mb-3 border-bottom">About the author:</p>
                    <div class="kitok2-authorbio content"><?php echo nl2br($author_info->description); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

