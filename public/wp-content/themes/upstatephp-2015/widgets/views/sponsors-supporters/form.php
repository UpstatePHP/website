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
    <label for="<?php echo $widget->get_field_id('show'); ?>">Show</label>
    <select name="<?php echo $widget->get_field_name('show'); ?>" id="<?php echo $widget->get_field_id('show'); ?>">
        <option value="sponsors" <?php echo $show === 'sponsors' ? 'selected' : ''; ?>>Sponsors</option>
        <option value="supporters" <?php echo $show === 'supporters' ? 'selected' : ''; ?>>Supporters</option>
        <option value="both" <?php echo $show === 'both' ? 'selected' : ''; ?>>Both</option>
    </select>
</p>
<p>
    <label for="<?php echo $widget->get_field_id('limit'); ?>">Limit</label>
    <input
        type="number"
        name="<?php echo $widget->get_field_name('limit'); ?>"
        id="<?php echo $widget->get_field_id('limit'); ?>"
        value="<?php echo $limit; ?>"
    />
</p>
<hr>
