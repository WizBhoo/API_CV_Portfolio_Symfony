<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use App\Manager\PostManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController.
 */
class PostController extends AbstractController
{
    /**
     * A PostManager Instance.
     *
     * @var PostManager
     */
    private $postManager;

    /**
     * PostController constructor.
     *
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * Show the Posts list.
     *
     * @return Response
     */
    public function postsList(): Response
    {
        return $this->render(
            'admin/posts.html.twig',
            [
                'posts' => $this->postManager->findAllPosts(),
            ]
        );
    }
}
