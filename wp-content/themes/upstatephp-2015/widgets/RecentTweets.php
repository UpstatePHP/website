<?php

use Endroid\Twitter\Twitter;
use League\Plates\Engine;

class UpstatePHP_TwentyFifteen_RecentTweets extends WP_Widget
{
    private $engine;

    public function __construct()
    {
        parent::__construct(
            'upstatephp_recent_tweets_widget',
            __('Recent Tweets', 'upstatephp' ),
            [
                'description' => __('Display recent tweets for a Twitter username.', 'upstatephp' )
            ]
        );

        $this->engine = new Engine(__DIR__ . '/views/recent-tweets');
    }

    public function widget($args, $instance)
    {
        $widgetTitle = $title = apply_filters('widget_title', empty($instance['widget_title']) ? '' : $instance['widget_title'], $instance, $this->id_base );

        $recentTweets = get_cache('recent-tweets', 3600, function() use ($instance) {
            $twitter = new Twitter(
                $instance['consumer_key'],
                $instance['consumer_secret'],
                $instance['access_token'],
                $instance['access_token_secret']
            );

            return $twitter->getTimeline(array(
                'count' => $instance['tweet_count'],
                'screen_name' => $instance['screen_name']
            ));
        });

        echo $args['before_widget'];
        if (!empty($widgetTitle)) {
            echo $args['before_title'] . $widgetTitle . $args['after_title'];
        }
        echo $this->engine->render(
            'display',
            [
                'recentTweets' => $recentTweets,
                'widget' => $this
            ]
        );
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $defaults = [
            'widget_title' => 'Recent Tweets',
            'tweet_count' => 3,
            'screen_name' => '',
            'consumer_key' => '',
            'consumer_secret' => '',
            'access_token' => '',
            'access_token_secret' => ''
        ];
        $data = array_merge(
            $defaults,
            $instance,
            ['widget' => $this]
        );

        echo $this->engine->render('form', $data);
    }

    public function linkify($tweet)
    {
        if (is_object($tweet))
        {
            $type = 'object';
            $tweet = json_decode($tweet, true);
        }
        else if (is_array($tweet))
        {
            $type = 'array';
        }
        else
        {
            $type = 'text';
            $text = ' '.$tweet;
        }
        $patterns             = [];
        $patterns['url']      = '(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
        $patterns['mailto']   = '([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))';
        $patterns['user']     = ' +@([a-z0-9_]*)?';
        $patterns['hashtag']  = '(?:(?<=\s)|^)#(\w*[\p{L}-\d\p{Cyrillic}\d]+\w*)';
        $patterns['long_url'] = '>(([[:alnum:]]+:\/\/)|www\.)?([^[:space:]]{12,22})([^[:space:]]*)([^[:space:]]{12,22})([[:alnum:]#?\/&=])<';
        if ($type == 'text')
        {
            // URL
            $pattern = '(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
            $text   = preg_replace_callback('#'.$patterns['url'].'#i', function($matches)
            {
                $input = $matches[0];
                $url   = preg_match('!^https?://!i', $input) ? $input : "http://$input";
                return '<a href="'.$url.'" target="_blank" rel="nofollow">'."$input</a>";
            }, $text);
        }
        else
        {
            $text     = $tweet['text'];
            $entities = $tweet['entities'];
            $search = [];
            $replace = [];
            if (array_key_exists('media', $entities))
            {
                foreach ($entities['media'] as $media)
                {
                    $search[]  = $media['url'];
                    $replace[] = '<a href="'.$media['media_url_https'].'" target="_blank">'.$media['display_url'].'</a>';
                }
            }
            if (array_key_exists('urls', $entities))
            {
                foreach ($entities['urls'] as $url)
                {
                    $search[]  = $url['url'];
                    $replace[] = '<a href="'.$url['expanded_url'].'" target="_blank" rel="nofollow">'.$url['display_url'].'</a>';
                }
            }
            $text = str_replace($search, $replace, $text);
        }
        // Mailto
        $text = preg_replace('/'.$patterns['mailto'].'/i', "<a href=\"mailto:\\1\">\\1</a>", $text);
        // User
        $text = preg_replace('/'.$patterns['user'].'/i', " <a href=\"https://twitter.com/\\1\" target=\"_blank\">@\\1</a>", $text);
        // Hashtag
        $text = preg_replace('/'.$patterns['hashtag'].'/ui', "<a href=\"https://twitter.com/search?q=%23\\1\" target=\"_blank\">#\\1</a>", $text);
        // Long URL
        $text = preg_replace('/'.$patterns['long_url'].'/', ">\\3...\\5\\6<", $text);
        // Remove multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    public function linkUser($user)
    {
        return 'https://twitter.com/' . (is_object($user) ? $user->screen_name : $user);
    }
    public function linkTweet($tweet)
    {
        return $this->linkUser($tweet->user) . '/status/' . $tweet->id_str;
    }
    public function linkRetweet($tweet)
    {
        return 'https://twitter.com/intent/retweet?tweet_id=' . $tweet->id_str;
    }
    public function linkAddTweetToFavorites($tweet)
    {
        return 'https://twitter.com/intent/favorite?tweet_id=' . $tweet->id_str;
    }
    public function linkReply($tweet)
    {
        return 'https://twitter.com/intent/tweet?in_reply_to=' . $tweet->id_str;
    }
}
