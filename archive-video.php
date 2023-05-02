<?php

    require_once(ABSPATH . '/wp-includes/class-oembed.php');

    get_header();   

    if (have_posts()) {

        $pt = get_post_type_object( 'video' );
?>
<div class="kitok2-page mt-2">
    <div class="content">
        <div class="kitok2-webpart content">
            <h1>Available <?php echo $pt->labels->name; ?></h1>
            <p><?php echo $pt->description; ?></p>
            <hr />

            <div class="table w-100">
                <div class="row" style="padding: 15px;">
            <?php
                    while (have_posts()) {
                        the_post();

                        $h = kitok2_walk_post_hierarchy( 'video', $post->ID, true );

                        $head_post = get_post($h['id']);
            ?>
                    <div class="card-deck">
                        <div class="card" style="width: 320px !important; margin-right: 30px !important; margin-top: 30px !important;">
                            <div class="card-body small">
                                <?php 
                                    $podcast_meta = get_post_meta( $post->ID );
                                    $url = $podcast_meta['_k2_video_alt_url'][0]; 
                                    if ($url && ($url !== '')) {
                                        $thumbnail = fetch_oembed_thumbnail( $post->ID, $url );
                                    }
                                ?>
                                <img src="<?php echo $thumbnail; ?>" width="100%" />
                            </div>
                            <div class="card-footer text-center">
                                <?php if ( ! empty( $h['children'] ) ) { ?>
                                <div class="dropdown bg-secondary p-2 mb-1">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="tocButton_<?php echo $post->ID; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="glyphicon glyphicon-menu-hamburger"></span>Jump to Chapter
                                    </button>
                                    <div class="dropdown-menu bg-secondary text-white" aria-labelledby="tocButton_<?php echo $post->ID; ?>">
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
            <span class="glyphicon glyphicon-info-sign" style="font-size: larger;"></span>Looks like there are no videos at this time. Do check back later!
        </div>
        <?php
    }   

    get_footer();
?>