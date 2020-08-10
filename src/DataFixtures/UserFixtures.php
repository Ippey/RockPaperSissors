<?php
//参考サイト：https://symfony.com/doc/current/security.html#user-data-fixture
namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    // private UserPasswordEncoderInterface $encoder;
    
    // public function __construct(UserPasswordEncoderInterface $encoder)
    // {
    //     $this->encoder = $encoder;
    // }
    public function load(ObjectManager $manager)
    {
        // $user = new User();
        // $user->setName("test");
        // $password = $this->encoder->encodePassword($user, "000000");
        // $user->setPassword($password);
        
        // $manager->persist($user);

        // $manager->flush();
    }
}
