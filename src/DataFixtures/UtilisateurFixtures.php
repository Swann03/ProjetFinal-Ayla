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
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail ("utilisateur".$i."@gmail.com");
            $utilisateur->setPseudo('Pseudo'.$i);
            $utilisateur->setDateNaissance(new \DateTimeBetween('-100 years', '-18 years'));

            $utilisateur->setPassword($this->passwordHasher->hashPassword(
                 $utilisateur,
                 'lePassword'.$i
             ));
            $manager->persist ($utilisateur);
        }
        $manager->flush();
    }
}