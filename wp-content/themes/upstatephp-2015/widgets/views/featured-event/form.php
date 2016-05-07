<p>
    <label for="<?php echo $widget->get_field_id('featured_event'); ?>">Featured Event</label>
    <select name="<?php echo $widget->get_field_name('featured_event'); ?>" id="<?php echo $widget->get_field_id('featured_event'); ?>">
        <option>Choose an event</option>
        <option value="next" <?php echo $featured_event == 'next' ? 'selected' : ''?>>Next available event</option>
        <?php foreach($upcomingEvents as $event) : ?>
        <option
            <?php echo $featured_event == $event['ID'] ? 'selected' : ''?>
            value="<?php echo $this->e($event['ID']); ?>"><?php echo $this->e($event['post_title']); ?></option>
        <?php endforeach; ?>
    </select>
</p>
<hr>
