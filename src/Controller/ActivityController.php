<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\JsonRpcService;

class ActivityController extends AbstractController
{
    /**
     *
     * @var JsonRpcService
     */
    private $service;

    /**
     *
     * @param JsonRpcService $service
     */
    public function __construct(JsonRpcService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/", name="activity.put")
     */
    public function putActivity(Request $request): Response
    {
        $result = $this->service->putActivity($request->getUri());

        return $this->render(
            'admin/status.html.twig',
            ['result' => $result]
        );
    }

    /**
     *
     * @Route("/admin/activity/{page}", name="activity.get")
     *
     * @param Request $request
     * @param int $page
     * @return Response
     */
    public function getActivity(Request $request, $page = 1): Response
    {
        $this->service->putActivity($request->getUri());
        $result = $this->service->getActivity($page);

        return $this->render(
            'admin/activity.html.twig',
            ['result' => $result, 'page' => $page]
        );
    }
}