<?php
namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;


class UtilisateurFixtures extends Fixture
{
    
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
         $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager):void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10 ; $i++){
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail ("user".$i."@gmail.com");
            $utilisateur->setNom("user".$i);
            $utilisateur->setDateNaissance($faker->dateTimeBetween('-100 years', '-18 years'));
            $utilisateur->setRoles(['ROLE_USER']);
            $utilisateur->setPassword($this->passwordHasher->hashPassword(
            $utilisateur,"Lepassword".$i));
            $manager->persist ($utilisateur);
        }
        
        for ($i = 0; $i < 5 ; $i++){
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail ("admin".$i."@gmail.com");
            $utilisateur->setNom("admin".$i);
            $utilisateur->setDateNaissance($faker->dateTimeBetween('-100 years', '-18 years'));
            $utilisateur->setRoles(['ROLE_ADMIN']);
            $utilisateur->setPassword($this->passwordHasher->hashPassword(
            $utilisateur,"Lepassword".$i));
            $manager->persist ($utilisateur);
        }
        $manager->flush();
    }
}