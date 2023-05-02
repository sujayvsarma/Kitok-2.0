<?php
    // Template to render "Podcast" posts

    $author_info = get_user_by( 'login', get_the_author_login() );
    $author_photo_url = WP_CONTENT_DIR . '/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';

    if (! file_exists($author_photo_url)) {
        $author_photo_url = '//via.placeholder.com/180x120.png?text=' . substr($author_info->nickname, 0, 1);
    } else {
        $author_photo_url = '/wp-content/uploads/author_profiles/' . strtolower($author_info->first_name) . '_' . strtolower($author_info->last_name) . '.png';
    }
    
    $podcast_meta = get_post_meta( $post->ID );
    $fi = get_featured_image();
?>

<div class="container-fluid col-sm-12 col-md-8">
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
            </div>
        </div>
    </div>
    <hr />

    <p>&nbsp;</p>
    <?php the_content(); ?>
    <hr />

    <?php if (($podcast_meta) && (! empty($podcast_meta)) && (! empty($podcast_meta['_k2_transcript_text']) ) ) { ?>
    <div class="card w-100">
        <div class="card-header bg-secondary text-white" data-toggle="collapse" data-target="#transcriptContent"><span class="glyphicon glyphicon-chevron-down"></span>Transcript</div>
        <div class="card-body text-info small collapse hide" id="transcriptContent">
            <?php echo nl2br($podcast_meta['_k2_transcript_text'][0]); ?>
        </div>
    </div>
    <hr />
    <?php } ?>
    
    <div class="card w-100">
        <div class="card-header bg-secondary text-white"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?> attributes</div>
        <div class="card-body text-info small">

        <?php if (($podcast_meta ) && (! empty( $podcast_meta ) ) ) { ?>
            <table class="table w-100" id="post_attributes_table">
                <tbody>
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">Episode name<td>
                        <td><?php  echo $podcast_meta['_k2_podcast_episode_name'][0]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">Series name<td>
                        <td><?php  echo $podcast_meta['_k2_podcast_series_name'][0]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">Channel name<td>
                        <td><?php  echo $podcast_meta['_k2_podcast_channel_name'][0]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">Production ID<td>
                        <td><?php  echo $podcast_meta['_k2_podcast_production_number'][0]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">Recorded on<td>
                        <td><?php $dt = date_create($podcast_meta['_k2_podcast_recorded_on'][0]); echo date_format($dt, 'M d, Y'); ?></td>
                    </tr>                    
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">People in the recording<td>
                        <td><?php  echo implode( ', ', explode(',', $podcast_meta['_k2_podcast_guest_names'][0]) ); ?></td>
                    </tr>                    
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">Language(s)<td>
                        <td><?php  echo implode( ', ', explode(',', $podcast_meta['_k2_podcast_language'][0]) ); ?></td>
                    </tr>                                        
                    <tr>
                        <td class="font-weight-bold text-uppercase" style="width: 25%;">Also listen at<td>
                        <td>
                            <?php  
                                $url = $podcast_meta['_k2_podcast_alt_url'][0]; 
                                if ($url && ($url !== '')) {
                                    echo "<span class=\"glyphicon glyphicon-headphones\"></span><a href=\"$url\" target=\"_blank\">$url</a>";
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php }  ?>
        </div>
    </div>
    
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

</div>

<style type="text/css">
    #post_attributes_table td {
        text-align: left;
    }
</style>