<?php
namespace TypeRocket\Models;

use TypeRocket\Models\PostTypesModel;
use WP_Post;
use WP_Query;

class SponsorsModel extends PostTypesModel
{
    protected $postType = 'sponsor';

    public function getSponsorsAndSupporters()
    {
        $query = new WP_Query([
            'post_type' => 'sponsor'
        ]);

        return array_map(function($sponsor)
        {
            return self::mapSponsor($sponsor);
        }, $query->get_posts());
    }

    public static function mapSponsor(WP_Post $sponsor)
    {
        $sponsorData = $sponsor->to_array();
        foreach (get_post_meta($sponsor->ID) as $key => $arr) {
            $sponsorData[$key] = $arr[0];
        }
        return $sponsorData;
    }
}
