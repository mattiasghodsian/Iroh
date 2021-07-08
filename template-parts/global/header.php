<header class="py-1 bg-primary">
    <nav class="navbar container navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-secondary" href="https://github.com/mattiasghodsian/Iroh/">Iroh</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <?php 
                    wp_nav_menu([
                        'theme_location'  => 'primary',
                        'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                        'container'       => 'div',
                        'container_class' => 'collapse navbar-collapse',
                        'container_id'    => 'bs-example-navbar-collapse-1',
                        'menu_class'      => 'navbar-nav me-auto mb-2 mb-lg-0',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    ]);
                ?>
            </div>
        </div>
    </nav>
</header>

<main>