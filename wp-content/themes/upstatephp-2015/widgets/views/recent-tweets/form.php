<fieldset>
    <p>
        <legend>Display Settings</legend>
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id('widget_title'); ?>">Widget Title</label>
        <input
            type="text"
            name="<?php echo $widget->get_field_name('widget_title'); ?>"
            id="<?php echo $widget->get_field_id('widget_title'); ?>"
            value="<?php echo $widget_title; ?>"
        />
    </p>
    <p>
        <label for="<?php echo $widget->get_field_id('tweet_count'); ?>">Tweet Count</label>
        <input
            type="number"
            name="<?php echo $widget->get_field_name('tweet_count'); ?>"
            id="<?php echo $widget->get_field_id('tweet_count'); ?>"
            value="<?php echo $tweet_count; ?>"
        />
    </p>
    <p>
        <label for="<?php echo $widget->get_field_id('screen_name'); ?>">Screen Name</label>
        <input
            type="text"
            name="<?php echo $widget->get_field_name('screen_name'); ?>"
            id="<?php echo $widget->get_field_id('screen_name'); ?>"
            value="<?php echo $screen_name; ?>"
        />
    </p>
</fieldset>

<hr>

<fieldset>
    <p>
        <legend>Auth Settings</legend>
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id('consumer_key'); ?>">Consumer Key</label>
        <input
            type="text"
            name="<?php echo $widget->get_field_name('consumer_key'); ?>"
            id="<?php echo $widget->get_field_id('consumer_key'); ?>"
            value="<?php echo $consumer_key; ?>"
        />
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id('consumer_secret'); ?>">Consumer Secret</label>
        <input
            type="text"
            name="<?php echo $widget->get_field_name('consumer_secret'); ?>"
            id="<?php echo $widget->get_field_id('consumer_secret'); ?>"
            value="<?php echo $consumer_secret; ?>"
        />
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id('access_token'); ?>">Access Token</label>
        <input
            type="text"
            name="<?php echo $widget->get_field_name('access_token'); ?>"
            id="<?php echo $widget->get_field_id('access_token'); ?>"
            value="<?php echo $access_token; ?>"
        />
    </p>

    <p>
        <label for="<?php echo $widget->get_field_id('access_token_secret'); ?>">Access Token Secret</label>
        <input
            type="text"
            name="<?php echo $widget->get_field_name('access_token_secret'); ?>"
            id="<?php echo $widget->get_field_id('access_token_secret'); ?>"
            value="<?php echo $access_token_secret; ?>"
        />
    </p>
</fieldset>
<hr>
