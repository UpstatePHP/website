<?php
/**
 * Template Name: Home Page
 */

get_header(); ?>

<div class="container">
    <div class="row">

    </div>
</div>

<?php if(is_active_sidebar('home-buckets')): ?>
<div id="home-buckets" class="section-bg-light">
    <div class="container">
        <div class="row">
            <?php dynamic_sidebar('home-buckets'); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
