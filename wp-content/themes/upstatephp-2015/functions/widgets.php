<?php

add_action('widgets_init', function(){

    require_once __DIR__ . '/../widgets/FeaturedEvent.php';
    register_widget('UpstatePHP_TwentyFifteen_FeaturedEvent');

    require_once __DIR__ . '/../widgets/SponsorsAndSupporters.php';
    register_widget('UpstatePHP_TwentyFifteen_Sponsors_and_Supporters');

    require_once __DIR__ . '/../widgets/RecentTweets.php';
    register_widget('UpstatePHP_TwentyFifteen_RecentTweets');

});

