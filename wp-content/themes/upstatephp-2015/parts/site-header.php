<div id="site-header" class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="/" id="main-brand" class="navbar-brand">
                <img src="<?php echo ASSETS_DIR; ?>/images/upstatephplogo.svg" alt="UpstatePHP" id="header-logo" />
                <span id="header-name">UpstatePHP</span>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'nav navbar-nav navbar-right',
                'walker' => new wp_bootstrap_navwalker()
            ]);
            ?>
        </div> <!-- /.nav-collapse -->
    </div>
</div>
<?php get_template_part('parts/sidebars/hero-banner'); ?>
