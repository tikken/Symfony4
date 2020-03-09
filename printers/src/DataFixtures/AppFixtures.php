<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\BlogPost;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    /**
     * @var \Faker\Factory
     */
    private $faker;

    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'adminblog1',
            'name' => 'admin',
            'password' => 'secret123',
            'roles' => [User::ROLE_SUPERADMIN]
        ],
        [
            'username' => 'admin2',
            'email' => 'adminblog2',
            'name' => 'admin2',
            'password' => 'secret123',
            'roles' => [User::ROLE_WRITER]
        ],
        [
            'username' => 'admin3',
            'email' => 'adminblog3',
            'name' => 'admin3',
            'password' => 'secret123',
            'roles' => [User::ROLE_EDITOR]
        ],
        [
            'username' => 'admin4',
            'email' => 'adminblog4',
            'name' => 'admin4',
            'password' => 'secret123',
            'roles' => [User::ROLE_ADMIN]
        ],
        [
            'username' => 'admin5',
            'email' => 'adminblog5',
            'name' => 'admin5',
            'password' => 'secret123',
            'roles' => [User::ROLE_SUPERADMIN]
        ]
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker = Factory::create();
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        for($i = 0; $i < 100; $i++) {
            $blogPost = new BlogPost();

            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->dateTime);
            $blogPost->setContent($this->faker->realText());


            $authorReference = $this->getRandomUserReference($blogPost);


            $blogPost->setAuthor($authorReference);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference("blog_post_$i",$blogPost);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {
        for($i = 0; $i < 100; $i++) {
            for($j = 0; $j < rand(1,10); $j++) {
                $comment = new Comment();

                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);


                $authorReference = $this->getRandomUserReference($comment);


                $comment->setAuthor($this->getReference($authorReference));
                $comment->setLikes($this->faker->numberBetween(1, 20));
                $comment->setBlogPost($this->getReference("blog_post_$i"));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userFix) {
            $user = new User();

            $user->setUsername($userFix['username']);
            $user->setEmail($userFix['email']);
            $user->setName($userFix['name']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $userFix['password']));
            $user->setRoles($userFix['roles']);

            $this->addReference('user' . $userFix['username'], $user);

            $manager->persist($user);
        }

        $manager->flush();

    }

    protected function getRandomUserReference($entity): User
    {
//        $randomUser = self::USERS[rand(0,4)];
//
//        if($entity instanceof BlogPost && !count(
//            array_intersect(
//                $randomUser['roles'],
//                [
//                    User::ROLE_SUPERADMIN,
//                    User::ROLE_ADMIN,
//                    User::ROLE_WRITER
//                ]
//            )))
//        {
//            return $this->getRandomUserReference($entity);
//        }
//
//        if($entity instanceof Comment && !count(
//            array_intersect($randomUser['roles'],
//                [
//                    User::ROLE_SUPERADMIN,
//                    User::ROLE_ADMIN,
//                    User::ROLE_WRITER
//                ]
//            )))
//        {
//            return $this->getRandomUserReference($entity);
//        }
//
//        return $this->getReference($randomUser['username']);
    }
}
