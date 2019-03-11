<?php

namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

final class PostService
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * PostService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /** 
     * @param string $title
     * @param string $message
     * @return Post
     */
    public function createPost(string $title, string $message): Post
    {
        $postEntity = new Post();
        $postEntity->setTitle($title);
        $postEntity->setMessage($message);
        $this->em->persist($postEntity);
        $this->em->flush();

        return $postEntity;
    }

    /**
     * @return object[]
     */
    public function getAll(): array
    {
        return $this->em->getRepository(Post::class)->findBy([], ['id' => 'ASC']);
    }

    /**
     * @param int $postId
     * @param string $title
     * @param string $message
     * 
     * @return Post
     */
    public function updatePost(int $postId, string $title, string $message): Post
    {
        $postEntity = $this->em->getRepository(Post::class)->find($postId);

        $postEntity->setTitle($title);
        $postEntity->setMessage($message);
        $this->em->persist($postEntity);
        $this->em->flush();

        return $postEntity;
    }
}