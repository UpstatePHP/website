<?php namespace UpstatePHP\Website\Domain\Events\Mappers\Eventbrite;

use UpstatePHP\Website\Contracts\MapperInterface;

class Event implements MapperInterface
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function map()
    {
        return [
            'title' => $this->data['name']->text,
            'description' => $this->data['description']->html ?: '',
            'registration_link' => $this->data['url'],
            'remote_id' => (int) $this->data['id'],
            'begins_at' => $this->data['start']->local,
            'ends_at' => $this->data['end']->local,
            'location_name' => $this->data['venue']->name,
            'street' => $this->data['venue']->address->address_1 . ' ' . $this->data['venue']->address->address_2,
            'city' => $this->data['venue']->address->city,
            'state' => $this->data['venue']->address->region,
            'zipcode' => $this->data['venue']->address->postal_code,
            'latitude' => $this->data['venue']->address->latitude,
            'longitude' => $this->data['venue']->address->longitude
        ];
    }

}
