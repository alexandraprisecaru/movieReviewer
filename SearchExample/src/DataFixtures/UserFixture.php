<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\UserReview;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new UserReview();
        $user->setUsername('alle');
        $user->setPassword(
            $this->encoder->encodePassword($user, 'password'));

        $user->setFirstName('Alexandra');
        $user->setLastName('P');
        $user->setRole('ROLE_USER');

        $manager->persist($user);
        $manager->flush();
    }
}
