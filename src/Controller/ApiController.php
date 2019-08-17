<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Service\SourceService;

/**
 * @Route("/Api")
 */
class ApiController extends AbstractController
{
    /**
     * Api index
     * @Route("/", name="api_index", methods={"POST"})
     */
    public function index(Request $request, SourceService $source): Response
    {
        //parse json
        $parameters = [];
        if ($content = $request->getContent()) {
            $parameters = json_decode($content, true);
        }

        //check parameters
        if (!isset($parameters['sourceId']) || !isset($parameters['year']) || !isset($parameters['limit'])) {
            throw new BadRequestHttpException('Wrong parameters');
        }

        $date = new \DateTime();
        $sourceId = $parameters['sourceId'];
        $year = (int) $parameters['year'];
        $limit = (int) $parameters['limit'];

        //call to source api/cache
        $data = $source->getProvider($sourceId, $year, $limit);

        //return json results
        $result = [
            'meta' => [
                'request' => [
                    'sourceId' => $sourceId,
                    'year' => $year,
                    'limit' => $limit
                ],
                'timestamp' => $date->format('Y-m-d\TH:i:s.v\Z')
            ],
            'data' => $data
        ];
        return $this->json($result);
    }

}