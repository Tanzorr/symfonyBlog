<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\User;


class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getPostsData() as [$title, $description, $text, $created_data, $created_by])
        {
            $author = $manager->getRepository(User::class)->find($created_by);
            $post = new Post();
            $post->setTitle($title);
            $post->setDescription($description);
            $post->setText($text);
            $post->setCreatedData($created_data);
            $post->getCreatedBy($author);
            $manager->persist($post);
        }
        $manager->flush();
    }

    private function getPostsData()
    {
        return [
            ['Post title', 'Post description', 'Post test ......',  new \DateTime(), 1],
            ['Post title2', 'Post description', 'Post test ......',  new \DateTime(), 1],
            ['Post title3', 'Post description', 'Post test ......',  new \DateTime(), 1],
            ['Post title4', 'Post description', 'Post test ......',  new \DateTime(), 1],
        ];
    }
}
