<?php namespace UpstatePHP\Website\Domain\Events\Providers;

use UpstatePHP\Website\Domain\Events\Event;
use GuzzleHttp\Client;
use Illuminate\Foundation\Application;
use UpstatePHP\Website\Domain\Events\EventRepository;
use UpstatePHP\Website\Domain\Events\Mappers\Eventbrite\Event as EventMapper;

class EventbriteProvider extends EloquentProvider implements EventRepository
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
            'organizer.id' => getenv('EB_ORGANIZER_ID'),
            'token' => getenv('EB_OAUTH_TOKEN'),
            'expand' => 'venue'
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
        $latestEvent = $query->first();
        $sinceId = array_get(
            ($latestEvent ? $latestEvent->toArray() : []),
            'remote_id',
            null
        );

        return $this->fetchRemoteEvents($sinceId);
    }

}
