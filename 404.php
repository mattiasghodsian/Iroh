<?php get_header(); ?>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col col-lg-2">
        </div>
        <div class="col-md-auto">
            <h1><?php _e( 'Oops! That page can&rsquo;t be found.', APP_DOMAIN ); ?></h1>
            <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', APP_DOMAIN ); ?></p>
			<?php get_search_form(); ?>
        </div>
        <div class="col col-lg-2">
        </div>
    </div>
</div>

<?php get_footer(); ?>