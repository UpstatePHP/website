<?php
namespace TypeRocket\Models;

use TypeRocket\Models\PostTypesModel;
use WP_Post;
use WP_Query;

class EventsModel extends PostTypesModel
{
    protected $postType = 'event';

    public function getNextEvent()
    {
        $query = new WP_Query([
            'post_type' => 'event',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => 'starts_at',
                    'value' => current_time('mysql'),
                    'compare' => '>=',
                    'type' => 'datetime'
                ]
            ]
        ]);

        $events = $query->get_posts();

        if (count($events) === 1) {
            return self::mapEvent($events[0]);
        }

        return null;
    }

    public function getUpcomingEvents()
    {
        $query = new WP_Query([
            'post_type' => 'event',
            'meta_query' => [
                [
                    'key' => 'starts_at',
                    'value' => current_time('mysql'),
                    'compare' => '>=',
                    'type' => 'date'
                ]
            ]
        ]);

        return array_map(function($event)
        {
            return self::mapEvent($event);
        }, $query->get_posts());
    }

    public function getPastEvents()
    {
        $query = new WP_Query([
            'post_type' => 'event',
            'meta_key' => 'starts_at',
            'orderby' => 'meta_value'
        ]);

        return array_map(function($event)
        {
            return self::mapEvent($event);
        }, $query->get_posts());
    }

    public static function mapEvent(WP_Post $event)
    {
        $eventData = $event->to_array();
        foreach (get_post_meta($event->ID) as $key => $arr) {
            $eventData[$key] = $arr[0];
        }
        return $eventData;
    }
}
