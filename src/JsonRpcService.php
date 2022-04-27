<?php

namespace App;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\JsonRpcService\Result;

class JsonRpcService
{
    /**
     *
     * @var HttpClientInterface
     */
    private $client;

    /**
     *
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     *
     * @param string $url
     * @return Result
     */
    public function putActivity(string $url): Result
    {
        try {
            $id = 1;
            $response = $this->client->request(
                'POST',
                'http://localhost:8000/json-rpc',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'jsonrpc' => '2.0',
                        'method' => 'activity.put',
                        'params' => [
                            'url' => $url,
                            'date' => date('Y-m-d H:i:s'),
                        ],
                        'id' => $id,
                    ]
                ]
            );

            $data = $response->toArray();
        } catch (\Throwable $e) {
            $data = ['error' => $e->getMessage()];
        }

        return new Result($data);
    }

    /**
     *
     * @param int $page
     * @return Result
     */
    public function getActivity(int $page = 1): Result
    {
        try {
            $response = $this->client->request(
                'POST',
                'http://localhost:8000/json-rpc',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'jsonrpc' => '2.0',
                        'method' => 'activity.get',
                        'params' => ['page' => (integer) $page],
                        'id' => 1,
                    ]
                ]
            );

            $data = $response->toArray();
        } catch (\Throwable $e) {
            $data = ['error' => $e->getMessage()];
        }

        return new Result($data);
    }
}