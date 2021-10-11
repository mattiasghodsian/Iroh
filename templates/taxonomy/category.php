<div class="container">

    <div class="row">
        <div class="col">
            <?php the_archive_title( '<h1>', '</h1>' ); ?>   
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