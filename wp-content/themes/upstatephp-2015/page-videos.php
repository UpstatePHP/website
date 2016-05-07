<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card-deck-wrapper">
                <div class="card-deck card-columns">

                <?php
                    $videos_loop = new WP_Query([
                        'post_type' => 'video',
                        'posts_per_page' => -1,
                        'meta_key' => 'published_on',
                        'orderby' => 'meta_value'
                    ]);

                    while($videos_loop->have_posts()) :
                        $videos_loop->the_post();
                        $videoId = tr_posts_field('[video_id]');
                ?>
                    <div class="col-lg-4 video card">
                        <div>
                            <img class="card-img-top" src="<?php echo (new TypeRocket\Objects\YouTubeThumbnail($videoId))->url('medium'); ?>" title="<?php the_title(); ?>" />
                            <div class="card-block">
                                <p>
                                <h4><?php the_title(); ?></h4>
                                </p>
                                <p><?php echo date('F j, Y', strtotime(tr_posts_field('[published_on]'))); ?></p>
                            </div>
                            <div class="media__body">
                                <a href="https://www.youtube.com/watch?v=<?php echo $videoId; ?> " target="_blank">
                                        <span class="play-circle">
                                            <span class="glyphicon glyphicon-play"></span>
                                        </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
