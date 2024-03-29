<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Document;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $article = new Document();
            $article->setTitle($faker->realText(50));
            $article->setBody($faker->paragraph);

            for ($i2= 0; $i2 < $i; $i2++) {
                $comment = new Comment();
                $comment->setBody($faker->realText(50));
                $comment->setDocument($article);
                $manager->persist($comment);
            }
            $manager->persist($article);
        }

        $user = new User();
        $user->setEmail('test@test.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'test'));
        $manager->persist($user);

        $manager->flush();
    }
}
