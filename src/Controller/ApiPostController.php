<?php

namespace App\Controller;

use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

final class ApiPostController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var $postService */
    private $postService;

    /**
     * ApiPostController constructor
     * @param SerializerInterface $serializer
     * @param PostService $postService
     *
     */
    public function __construct(SerializerInterface $serializer, PostService $postService)
    {
        $this->serializer = $serializer;
        $this->postService = $postService;
    }


    /**
     * @Rest\Get("/api/posts", name="getAllPosts")
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $postEntities = $this->postService->getAll();
        $data = $this->serializer->serialize($postEntities, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Post("/api/post/create", name="createPost")
     * @param Request $request
     * @return JsonResponse
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request): JsonResponse
    {
        $title = $request->request->get('title');
        $message = $request->request->get('message');
        $postEntity = $this->postService->createPost($title, $message);
        $data = $this->serializer->serialize($postEntity, 'json');

        return new JsonResponse($data, 200, [], true);
    }
}
