<?php

use TypeRocket\Models\SponsorsModel;

class UpstatePHP_TwentyFifteen_Sponsors_and_Supporters extends WP_Widget
{
    private $engine;
    private $sponsorsModel;

    public function __construct()
    {
        parent::__construct(
            'upstatephp_sponsors_supporters_widget',
            __('Sponsors and Supporters', 'upstatephp' ),
            [
                'description' => __('Display the sponsors and supporters.', 'upstatephp' )
            ]
        );

        $this->engine = new \League\Plates\Engine(__DIR__ . '/views/sponsors-supporters');
        $this->sponsorsModel = new SponsorsModel;
    }

    public function widget($args, $instance)
    {
        $showType = isset($instance['show']) ? $instance['show'] : 'both';
        $limit = isset($instance['limit']) ? $instance['limit'] : 4;
        $widgetTitle = $title = apply_filters('widget_title', empty($instance['widget_title']) ? '' : $instance['widget_title'], $instance, $this->id_base );
        $sponsors = [];

        $allSponsors = $this->sponsorsModel->getSponsorsAndSupporters();
        shuffle($allSponsors);

        foreach ($allSponsors as $sponsor) {
            if (count($sponsors) == $limit) {
                break;
            }

            $sponsors[] = $sponsor;
        }

        echo $args['before_widget'];
        if (!empty($widgetTitle)) {
            echo $args['before_title'] . $widgetTitle . $args['after_title'];
        }
        echo $this->engine->render('display', compact('sponsors'));
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $defaults = array(
            'show' => 'both',
            'limit' => 4,
            'widget_title' => 'Sponsors and Supporters'
        );
        $data = array_merge(
            $defaults,
            $instance,
            ['widget' => $this]
        );

        echo $this->engine->render('form', $data);
    }
}
