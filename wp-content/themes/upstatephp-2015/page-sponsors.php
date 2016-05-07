<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-content hero">
                    <?php while (have_posts() ) : the_post(); ?>
                    <div class="page-header">
                        <h1><?php the_title(); ?></h1>
                    </div>
                    <?php endwhile; ?>
                    <div id="supporters">
                        <?php
                            $supporters_loop = new WP_Query([
                                'post_type' => 'sponsor',
                                'posts_per_page' => -1,
                                'meta_query' => [
                                    [
                                        'key' => 'type',
                                        'value' => 'supporter',
                                        'compare' => '='
                                    ]
                                ]
                            ]);
                        ?>
                        <?php
                            while($supporters_loop->have_posts()) :
                                $supporters_loop->the_post();

                                list($supporter_logo) = wp_get_attachment_image_src(tr_posts_field('[logo]'), 'sponsor-logo');
                        ?>
                            <div class="col-lg-6 sponsor">
                                <a href="<?php echo tr_posts_field('[url]'); ?>" class="thumbnail" target="_blank">
                                    <div class="supporter-ribbon">Supporter</div>
                                    <img src="<?php echo $supporter_logo; ?>" title="<?php the_title(); ?>">
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div id="sponsors">
                        <?php
                        $sponsors_loop = new WP_Query([
                            'post_type' => 'sponsor',
                            'posts_per_page' => -1,
                            'meta_query' => [
                                [
                                    'key' => 'type',
                                    'value' => 'sponsor',
                                    'compare' => '='
                                ]
                            ]
                        ]);
                        ?>
                        <?php
                            while($sponsors_loop->have_posts()) :
                                $sponsors_loop->the_post();
                                list($sponsor_logo) = wp_get_attachment_image_src(tr_posts_field('[logo]'), 'sponsor-logo');
                        ?>
                            <div class="col-lg-4 sponsor">
                                <a href="<?php echo tr_posts_field('[url]'); ?>" class="thumbnail" target="_blank">
                                    <img src="<?php echo $sponsor_logo; ?>" title="<?php the_title(); ?>">
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part('parts/sidebars/right-column'); ?>
    </div>
</div>

<?php get_footer(); ?>
