<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail('admin@mail.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin123'
        ));
        $user->setRoles(['ROLE_ADMIN','ROLE_USER']);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@mail.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'user123'
        ));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
