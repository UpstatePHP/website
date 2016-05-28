<div class="row">

    <?php foreach ($sponsors as $sponsor) : ?>

    <div class="supporter col-lg-6">
        <a href="<?php echo $this->e($sponsor['url']); ?>" title="<?php echo $this->e($sponsor['post_title']); ?>" target="_blank" class="thumbnail">
            <?php
                list($logo) = wp_get_attachment_image_src(tr_posts_field('[logo]', $sponsor['ID']), 'sponsor-logo');
            ?>
            <img src="<?php echo $logo; ?>" />
        </a>
    </div>

    <?php endforeach; ?>

</div>
