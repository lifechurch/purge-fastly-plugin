<?php

namespace lifechurch\purgefastly\services;

use GuzzleHttp\Exception\ClientException;
use yii\base\Component;
use GuzzleHttp\Client;
use Craft;

/**
 * @author    Dmitriy Pashchenko
 * @package   PurgeFastly
 * @since     1.0.0
 */
class FastlyService extends Component
{
    const FS_BASE_URI = 'https://api.fastly.com/';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    /**
     * @var
     */
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
        $this->session = \Craft::$app->getSession();
    }

    /**
     * @param $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param string $serviceId
     * @param string $keys
     */
    public function purgeByKey($serviceId, $keys)
    {
        if ($this->token) {
            try {
                $this->client->post(self::FS_BASE_URI . "service/{$serviceId}/purge", [
                    'headers' => [
                        'Surrogate-Key' => $keys,
                        'Fastly-Key' => $this->token,
                        'Accept'     => 'application/json'
                    ]
                ]);
            } catch (ClientException $e) {
                Craft::$app->session->setError('Fastly service purge request error, check the log file');

                Craft::error(
                    Craft::t(
                        'purge-fastly',
                        'Fastly service purge request error - ' . $e->getMessage()
                    ),
                    __METHOD__
                );
            }
        } else {
            Craft::$app->session->setError('You need to specify Fastly Service API token on Purge fastly plugin\'s settings page');
        }
    }
}