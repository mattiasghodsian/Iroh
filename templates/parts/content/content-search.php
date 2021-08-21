<div class="col col-md-12 my-3">
    <?= the_title( '<h2>', '</h2>' ); ?>
    <div class="excerpt">
        <?= get_the_excerpt(); ?>
    </div>
    <a href="<?= get_the_permalink(); ?>" class="btn btn-sm btn-primary mt-2 float-end"><?= _('Read more', APP_DOMAIN) ?></a>
</div>