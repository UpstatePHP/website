<?php

/**
 * @registers Sponsors
 */

$sponsor = tr_post_type('Sponsor', 'Sponsors');
$sponsor->setIcon('star3');
$sponsor->setTitlePlaceholder('Enter sponsor name here');
//$sponsor->setSlug('sponsors');
tr_meta_box('Details')->apply($sponsor)->setCallback(function(){
    $form = tr_form();
    echo $form->image('Logo');
    echo $form->text('URL');
    echo $form->select('Type')->setOptions([
        'Sponsor' => 'sponsor',
        'Supporter' => 'supporter'
    ]);
});

/**
 * @registers Events
 */
$event = tr_post_type('Event', 'Events');
$event->setIcon('calendar');
tr_meta_box('Details')->apply($event)->setCallback(function(){
    $form = tr_form();
    echo $form->text('Remote ID');
    echo $form->text('Registration Link');
    echo $form->text('Starts At');
    echo $form->text('Ends At');
});
tr_meta_box('Location')->apply($event)->setCallback(function(){
    $form = tr_form();
    echo $form->text('Name');
    echo $form->text('Address');
    echo $form->text('Address 2');
    echo $form->text('City');
    echo $form->select('State')->setOptions(array_flip(get_states_list()));
    echo $form->text('Zip Code');
    echo $form->text('Latitude');
    echo $form->text('Longitude');
});

/**
 * @registers Videos
 */
$video = tr_post_type('Video', 'Videos');
$video->setIcon('camera2');
tr_meta_box('Meta')->apply($video)->setCallback(function(){
    $form = tr_form();
    echo $form->text('Video ID');
    echo $form->date('Published On');
});

//-----------------------------
// Handle Post Type Image Sizes
//-----------------------------

add_filter('intermediate_image_sizes_advanced', 'set_thumbnail_size_by_post_type', 10);

function set_thumbnail_size_by_post_type($sizes) {
    $post_type = get_post_type($_REQUEST['post_id']);

    switch ($post_type) {
        case 'sponsor' :
            $sizes = [
                'sponsor-logo' => ['width' => 600, 'height' => 341, 'crop' => false]
            ];
            break;
    }

    return $sizes;
}

function make_filename_hash($filename) {
    $info = pathinfo($filename);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($filename, $ext);
    return md5($name) . uniqid() . $ext;
}
add_filter('sanitize_file_name', 'make_filename_hash', 10);
