<div class="card w-100 mb-3 small">
    <div class="card-body">
        <span class="float-left"><span class="badge badge-warning padding-3 text-dark" style="font-size: 110%;"><?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span></span>
        <table class="table w-100">
            <tr>
                <td width="160">
                    <?php get_template_part( '/template-parts/featured-image' ); ?>
                </td>
                <td>
                    <h3 style="font-size: 125%;" class="card-title">
                        <a class="text-dark" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="_blank">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <div class="card-subtitle small mt-2"><span class="glyphicon glyphicon-calendar"></span><?php echo get_the_date(); ?></div>
                    <hr />
                    <?php the_excerpt(); ?>
                    <p class="mt-3 text-right">
                        <a class="btn btn-primary text-white" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="_blank">
                            <span class="glyphicon glyphicon-sunglasses"></span>Read more...
                        </a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>
