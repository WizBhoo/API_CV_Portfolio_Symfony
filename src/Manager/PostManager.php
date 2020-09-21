<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Manager;

use App\Entity\Post;
use App\Repository\PostRepository;

/**
 * Class postManager.
 */
class PostManager
{
    /**
     * A PostRepository Instance.
     *
     * @var PostRepository
     */
    private $postRepository;

    /**
     * PostManager constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Retrieve all posts from db order by DESC.
     *
     * @return Post[]
     */
    public function findAllPosts(): array
    {
        return $this->postRepository->findBy(
            [],
            ['createdAt' => 'DESC']
        );
    }
}
