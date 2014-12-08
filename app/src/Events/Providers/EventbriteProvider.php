<?php namespace UpstatePHP\Website\Events\Providers;

use UpstatePHP\Website\Events\Event;
use GuzzleHttp\Client;
use Illuminate\Foundation\Application;
use UpstatePHP\Website\Events\EventRepository;
use UpstatePHP\Website\Events\Mappers\Eventbrite\Event as EventMapper;

class EventbriteProvider implements EventRepository
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Application
     */
    private $app;

    /**
     * @param Client $client
     * @param Application $app
     */
    public function __construct(Client $client, Application $app)
    {
        $this->client = $client;
        $this->app = $app;
    }

    public function fetchRemoteEvents($sinceId = null)
    {
        $query = [
            'organizer.id' => $this->app['config']->get('events.organizer_id'),
            'token' => getenv('EB_OAUTH_TOKEN')
        ];

        if (! is_null($sinceId)) {
            $query['since_id'] = $sinceId;
        }

        $response = $this->client->get(
            'https://www.eventbriteapi.com/v3/events/search',
            ['query' => $query]
        );

        return array_map(function($event){
            return (new EventMapper((array) $event))->map();
        }, $response->json(['object' => true])->events);
    }

    public function importNewRemoteEvents()
    {
        $query = (new Event)->newQuery();
        $query->select('remote_id')->orderBy('remote_id', 'desc');
        $sinceId = array_get((array) $query->first(), 'remote_id', null);

        return $this->fetchRemoteEvents($sinceId);
    }

}