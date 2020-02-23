<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\BlogPost;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
    }

    public function loadBlogPosts($manager)
    {
        $user = $this->getReference('user_admin');

        $blogPost = new BlogPost();

        $blogPost->setTitle('A first post!');
        $blogPost->setPublished(new \DateTime('2018-07-01 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a-first-post');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();

        $blogPost->setTitle('A second post!');
        $blogPost->setPublished(new \DateTime('2018-07-01 12:00:00'));
        $blogPost->setContent('Second post text!');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a-second-post');

        $manager->persist($blogPost);
        $manager->flush();
    }

    public function loadComments($manager)
    {

    }

    public function loadUsers($manager)
    {
        $user = new User();

        $user->setUsername('tikken');
        $user->setEmail('tikken23@gmail.com');
        $user->setName('tikken');
        $user->setPassword('secret12345');
        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}