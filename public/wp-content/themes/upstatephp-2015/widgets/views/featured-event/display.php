<?php if ($featuredEvent) : ?>
<div class="event card">
    <div class="card-content hero">
        <div class="event-details">
            <div class="col-lg-8">
                <div class="event-title page-header">
                    <h1><?php echo $this->e($featuredEvent['post_title']); ?></h1>
                </div>
                <div class="event-body">
                    <div class="event-datetime">
                        <?php
                            echo date('m/d<\b\r>g:ia', strtotime($featuredEvent['starts_at']));
                        ?>
                    </div>
                    <div class="event-meta-line">
                        <?php echo apply_filters('the_content', $featuredEvent['post_content']); ?>
                    </div>
                </div>
                <div class="event-actions">
                    <a href="<?php echo $this->e($featuredEvent['registration_link']); ?>#?ref=ebtnebregn" target="_blank">
                        <button type="button" class="btn btn-primary btn-lg pull-right">Register Now &raquo;</button>
                    </a>
                </div>
            </div>
            <div class="map-thumbnail">
                <div id="event-location-map"></div>
                <?php
                    $locationData = json_encode([
                        'latitude' => $featuredEvent['latitude'],
                        'longitude' => $featuredEvent['longitude'],
                        'name' => $featuredEvent['name'],
                        'popup' => sprintf(
                            '<h5>UpstatePHP @ %s</h5><p>%s<br>%s %s %s',
                            $featuredEvent['name'],
                            $featuredEvent['address'] . ' ' . $featuredEvent['address_2'],
                            $featuredEvent['city'],
                            $featuredEvent['state'],
                            $featuredEvent['zip_code']
                        )
                    ]);
                ?>
                <div id="event-location-info" data-location="<?php echo $this->e($locationData); ?>">
                    <h4>OpenWorks</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else : ?>

    <div class="event">
        <div class="event-details">
            <div class="col-lg-8">
                <div class="event-title page-header">
                    <h1>Join us on <?php echo $nextScheduledEvent; ?></h1>
                </div>
                <div class="event-body">
                    Stay tuned for more details!
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
