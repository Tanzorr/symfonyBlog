<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->CommentData() as [$content, $user, $post, $created_at])
        {
            $comment = new Comment();
            $_user = $manager->getRepository(User::class)->find($user);
            $_post = $manager->getRepository(Post::class)->find($post);
            $comment->setContent($content);
            $comment->setRelation($_user);
            $comment->setPost($_post);
            $comment->setCreatedAt(new \DateTime($created_at));
            $manager->persist($comment);

        }

        $manager->flush();
    }

    private function CommentData()
    {
        return [

            ['Comment 1 Cras sit amet  Donec lacinia congue felis in faucibus.', 57, 57,'2018-10-08 12:34:45'],


        ];
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            PostFixtures::class
        );
    }
}