<div class="container">

    <div class="row">
        <div class="col">
            <h1>
                <?php
                    printf(
                        esc_html__( 'Results for "%s"', APP_DOMAIN ),
                        '<span>' . esc_html( get_search_query() ) . '</span>'
                    );
                ?>
            </h1>
            <span>
                <?php
                printf(
                    esc_html(
                        _n(
                            'Found %d result.',
                            'Found %d results.',
                            (int) $wp_query->found_posts,
                            APP_DOMAIN
                        )
                    ),
                    (int) $wp_query->found_posts
                );
                ?>
            </span>
        </div>
    </div>

    <div class="row">
        <?php 
        if ( have_posts() ) :
            while (  have_posts() ) : the_post();
                get_template_part( 'templates/parts/content/content-search', get_post_format() );
            endwhile; 
        else : ?> 
            <h2><?php __('Sorry nothing found', APP_DOMAIN); ?></h2>
        <?php endif; ?> 
    </div>

</div>