<?php


namespace App\Http\Controllers;

use App\Http\Requests\ActivityListRequest;
use App\Repository\ActivityRepository;
use App\Service\Pagination\Pagination;
use App\Service\Transformer\ActivityTransformer;
use App\Service\Transformer\TransformerException;
use Illuminate\Http\Response;

class ActivityController extends ApiController
{
    private $repository;
    private $transformer;

    /**
     * AuthController constructor.
     * @param ActivityTransformer $transformer
     */
    public function __construct(ActivityTransformer $transformer)
    {
        $this->repository = new ActivityRepository(app('redisCache'));
        $this->transformer = $transformer;
    }

    /**
     * @param ActivityListRequest $request
     * @return Response
     * @throws TransformerException
     */
    public function index(ActivityListRequest $request)
    {
        $perPage = $request->get('perPage', 25);
        $page = $request->get('page', 1);

        $offset = ($page - 1) * $perPage;
        $limit = $offset + $perPage;
        $data = $this->repository->findBy(sprintf('user:%d:activity', $request->request->user()->id), $offset, $limit);
        $pagination = new Pagination($data);

        return $this->sendResponse(
            $this->transformer->transformCollection(
                $pagination->paginate($perPage, $page),
                'transform',
                'history'
            ),
            'Activity history list'
        );
    }
}
