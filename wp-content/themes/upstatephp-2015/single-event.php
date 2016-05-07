<?php get_header(); ?>

<div id="home-content" class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="event card">
                <div class="card-content hero">
                    <?php while ( have_posts() ) : the_post(); ?>
                    <div class="event-details">
                        <div class="event-title page-header">
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="event-body">
                            <div class="event-datetime">
                                <?php echo date('m/d', strtotime(tr_posts_field('[starts_at]'))); ?>
                            </div>
                            <div class="event-meta-line">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="event-sponsors">
                        <div class="page-header">
                            <h3>Sponsors</h3>
                        </div>
                        @foreach($event->sponsors as $sponsor)
                        <div class="event-sponsor col-lg-4">
                            <a href="{!! $sponsor->url !!}" class="thumbnail" target="_blank">
                                <img src="/uploads/{!! $sponsor->logo !!}" title="{!! $sponsor->name !!}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php get_template_part('parts/sidebars/right-column'); ?>
    </div>
</div>

<?php get_footer(); ?>
