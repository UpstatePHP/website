
    </div><!-- END #page-container -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <footer id="site-footer">
                    <div class="social-links pull-right">
                        <?php
                            $footerLinks = get_bookmarks([
                                'category' => 3
                            ]);
                            foreach ($footerLinks as $link) :
                        ?>
                        <a
                            href="<?php echo $link->link_url; ?>"
                            class="social-link <?php echo strtolower(str_replace(' ', '-', $link->link_name)); ?>"
                            target="<?php echo $link->link_target; ?>"
                            title="<?php echo $link->description; ?>"
                        >
                            <?php
                                $svg = get_template_directory() . '/assets/svgs/' . strtolower(str_replace(' ', '', $link->link_name)) . '.php';
                                if (file_exists($svg)) {
                                    include $svg;
                                }
                            ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </footer>
            </div>
        </div>
    </div>
<?php wp_footer(); ?>
</body>
</html>
