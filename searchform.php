<?php

    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );

?>

<div class="mr-3 mt-2" style="width: 260px !important;">
    <form role="form" class="form-inline" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="input-group">
            <input type="text" class="form-control" id="sftf" value="<?php echo get_search_query(); ?>" name="s" placeholder="Search &hellip;" />
            <div class="input-group-append">
                <button class="btn btn-secondary text-white" type="submit">
                    <i class="fa fa-search"> Search</i>
                </button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    .has-search .form-control {
        padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }

    .has-search span.fa {
        background-color: transparent;
        padding-right: 0px !important;
    }
</style>