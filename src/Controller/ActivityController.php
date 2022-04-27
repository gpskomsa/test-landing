<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ActivityController extends AbstractController
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
     * @Route("/", name="activity.put")
     */
    public function putActivity(Request $request): Response
    {
        try {
            $this->client->request(
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
                            'url' => $request->getUri(),
                            'date' => date('Y-m-d H:i:s'),
                        ],
                        'id' => 1,
                    ]
                ]
            );

            $result = 'success';
        } catch (\Throwable $e) {
            $result = $e->getMessage();
        }

        return new Response(
            '<html><body>' . $result . '</body></html>'
        );
    }

    /**
     * @Route("/admin/activity/{page}", name="activity.get")
     */
    public function getActivity($page = 1): Response
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
                        'params' => ['page' => $page],
                        'id' => 1,
                    ]
                ]
            );

            $result = $response->toArray()['result'] ?? [];
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            $result = [];
        }

        return $this->render('admin/activity.html.twig', ['result' => $result, 'error' => $error ?? null]);
    }
}