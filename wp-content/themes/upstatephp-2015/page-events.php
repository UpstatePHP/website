<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-content hero">
                    <?php
                        $eventsModel = new \TypeRocket\Models\EventsModel;

                        $pastEvents = $eventsModel->getPastEvents();

                        foreach ($pastEvents as $event) :
                    ?>
                        <div class="past-event">
                            <p>
                                <h4 class="past-event-title"><?php echo $event['post_title']; ?></h4> - <?php echo date('F d, Y', strtotime($event['starts_at'])); ?>
                            </p>
                            <p>
                                <a href="<?php echo $event['post_name']; ?>#videos">Videos &raquo;</a>
                                &nbsp;|&nbsp;
                                <a class="btn btn-primary btn-xs" href="<?php echo $event['post_name']; ?>" role="button">Details &raquo;</a>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
