<?php
namespace UpstatePHP\Website\Services;

use GuzzleHttp\Client;

class ReCaptcha
{
    const VERIFICATION_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function verify($secret, $captchaResponse)
    {
        $response = $this->client->post(
            self::VERIFICATION_URL,
            [
                'body' => [
                    'secret' => $secret,
                    'response' => $captchaResponse
                ]
            ]
        );

        $json = (array) $response->json();

        return $json['success'];
    }
}
