<?php

use TypeRocket\Models\EventsModel;

class UpstatePHP_TwentyFifteen_FeaturedEvent extends WP_Widget
{
    private $engine;

    public function __construct()
    {
        parent::__construct(
            'upstatephp_featured_event_widget',
            __('Display the featured event', 'upstatephp' ),
            [
                'description' => __('Display the featured event, next event, or next meeting date.', 'upstatephp' )
            ]
        );

        $this->engine = new \League\Plates\Engine(__DIR__ . '/views/featured-event');
        $this->eventsModel = new EventsModel;
    }

    public function widget($args, $instance)
    {
        $featuredEventId = isset($instance['featured_event']) ? $instance['featured_event'] : 'next';
        $featuredEvent = null;

        $nextEvent = $this->eventsModel->getNextEvent();

        if ($nextEvent
            && ($featuredEventId === 'next'
                || $featuredEventId == $nextEvent['ID'])
        ) {
            $featuredEvent = $nextEvent;
        }

        $thisMonth = strtotime('third thursday of this month');
        $nextMonth = strtotime('third thursday of next month');

        if (time() < $thisMonth) {
            $nextScheduledEvent = date('n/d @ 6\p\m', $thisMonth);
        } else {
            $nextScheduledEvent = date('n/d @ 6\p\m', $nextMonth);
        }

        echo $this->engine->render('display', compact('featuredEvent', 'nextScheduledEvent'));
    }

    public function form($instance)
    {
        $defaults = array(
            'featured_event' => 'next'
        );
        $data = array_merge(
            $defaults,
            $instance,
            [
                'upcomingEvents' => $this->eventsModel->getUpcomingEvents(),
                'widget' => $this,
            ]
        );

        echo $this->engine->render('form', $data);
    }
}
