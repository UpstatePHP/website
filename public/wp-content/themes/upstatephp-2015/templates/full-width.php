<?php
/**
 * Template Name: Full Width
 */

get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-content">
                    <?php while(have_posts()) : the_post() ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="page-header">
                                <h1><?php the_title(); ?></h1>
                            </div>
                            <?php the_content(); ?>
                            <div class="tags"><?php the_tags(); ?></div>
                            <?php wp_link_pages(); ?>
                            <?php comments_template( '', true ); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
