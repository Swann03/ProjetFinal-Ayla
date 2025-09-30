<?php
namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UtilisateurFixtures extends Fixture
{
    
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
         $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager):void
    {
        for ($i = 0; $i < 5 ; $i++){
            $user = new Utilisateur();
            $user->setEmail ("utilisateur".$i."@lala.com");
            $user->setPassword($this->passwordHasher->hashPassword(
                 $user,
                 'lePassword'.$i
             ));
            $manager->persist ($user);
        }
        $manager->flush();
    }
}