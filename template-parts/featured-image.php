<?php

    $fi = get_featured_image();
    
    if ( $fi->is_present ) {
?>
<img class="<?php echo $fi->css_class; ?>" style="width: <?php echo $fi->width; ?>; height: <?php echo $fi->height; ?>" itemprop="image" src="<?php echo esc_url( $fi->url ); ?>" alt="<?php esc_attr( $fi->alt_text ); ?>" />
<?php
    } else {
?>
<div style="width: <?php echo $fi->width; ?>; height: <?php echo $fi->height; ?>">&nbsp;</div>
<?php
    }
?>
