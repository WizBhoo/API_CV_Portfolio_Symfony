<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use App\Entity\Post;
use App\Manager\PostManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlogController.
 */
class BlogController extends AbstractController
{
    /**
     * A PostManager Instance.
     *
     * @var PostManager
     */
    private $postManager;

    /**
     * BlogController constructor.
     *
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * Blog homepage showing all Posts.
     *
     * @return Response
     */
    public function blogHome(): Response
    {
        return $this->render(
            'blog/home.html.twig',
            [
                'posts' => $this->postManager->findAllPosts(),
            ]
        );
    }

    /**
     * Show a Post's details.
     *
     * @param Post $post
     *
     * @return Response
     */
    public function show(Post $post): Response
    {
        return $this->render(
            'blog/show.html.twig',
            ['post' => $post]
        );
    }
}
