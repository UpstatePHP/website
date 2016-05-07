<?php foreach ($recentTweets as $tweet) : ?>

<div class="tweet media">
    <div class="pull-left">
        <a href="<?php echo $widget->linkUser($tweet->user); ?>" target="_blank">
            <img src="<?php echo $tweet->user->profile_image_url; ?>" class="media-object"/>
        </a>
    </div>

    <div class="media-body">
        <?php echo $widget->linkify($tweet->text); ?>
        <div class="ago">
            <a href="<?php echo $widget->linkTweet($tweet); ?>">
                <?php echo date('g:ia - j M Y', strtotime($tweet->created_at)); ?>
            </a>
        </div>
    </div>

</div>

<?php endforeach; ?>
