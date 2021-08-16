<?php
get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        var_dump(get_post_type());
        get_template_part( 'template-parts/archive/' . get_post_type() );
    }
}

get_footer();