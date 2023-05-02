<?php

    wp_enqueue_style( 'KITOK2_CSS_COMMON_STYLE_BLOCKS', get_template_directory_uri() . '/assets/css/common-style-blocks.css' );
    get_header();
?>

<div class="kitok2-page">
    <div class="content">

        <div class="card w-100">
            <div class="card-header bg-secondary text-white">
                <h1 class="heading card-title"><span class="glyphicon glyphicon-alert" style="color: yellow;"></span>Content not found</h1>
            </div>
            <div class="card-body small">
                <p class="text-justify">
                    Did you reach here from a <a target="_blank" class="text-dark" href="https://www.google.com/?oq=site%3Asujayvsarma.com&q=site%3Asujayvsarma.com">Google search</a> or a saved bookmark? 
                    If so, I may have moved the page elsewhere. Use the menus and links here to find the content again. If you really must find it and you cannot locate it, use the 
                    Contact Form on the homepage to get in touch!
                </p>
            </div>
        </div>
        
    </div>
</div>
    
<?php
    get_footer();
    
?>