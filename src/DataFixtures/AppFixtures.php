<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Item;
use App\Entity\Menu;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $categorias= [];
        //Usuarios
        $user = new User();
        $user->setRole("ROLE_ADMIN");
        $user->setName("admin");
        $user->setUsername("admin");
        $user->setPhoneNumber("666666666");
        $user->setEmail("admin@gmail.com");
        $passwdPlano = "admin";
        $hasedPaswd = $this->passwordHasher->hashPassword($user,$passwdPlano);
        $user->setPasswd($hasedPaswd);
        $manager->persist($user);

        $user = new User();
        $user->setRole("ROLE_CLIENTE");
        $user->setName("user");
        $user->setUsername("user");
        $user->setPhoneNumber("666666666");
        $user->setEmail("user@gmail.com");
        $passwdPlano = "user";
        $hasedPaswd = $this->passwordHasher->hashPassword($user,$passwdPlano);
        $user->setPasswd($hasedPaswd);
        $manager->persist($user);

        //Categorias

        $categoria = new Category();
        $categoria->setName("Tapas");
        $categoria->setImage("tapas");
        $categoria->setUrl("tapas");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        $categoria = new Category();
        $categoria->setName("Entrantes");
        $categoria->setImage("entrantes");
        $categoria->setUrl("entrantes");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        $categoria = new Category();
        $categoria->setName("Ensaladas");
        $categoria->setImage("ensaladas");
        $categoria->setUrl("ensaladas");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        $categoria = new Category();
        $categoria->setName("Carnes a la brasa");
        $categoria->setImage("carnes");
        $categoria->setUrl("carnes");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        $categoria = new Category();
        $categoria->setName("Pescados y mariscos");
        $categoria->setImage("pescados");
        $categoria->setUrl("pescados");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        $categoria = new Category();
        $categoria->setName("Opciones vegetarianas");
        $categoria->setImage("vegetales");
        $categoria->setUrl("vegetales");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        $categoria = new Category();
        $categoria->setName("Vinos");
        $categoria->setImage("vinos");
        $categoria->setUrl("vinos");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        $categoria = new Category();
        $categoria->setName("Postres");
        $categoria->setImage("postres");
        $categoria->setUrl("postres");
        $categorias[] = $categoria;
        $manager->persist($categoria);

        foreach ($categorias as $categoria){
            for($i=0 ;$i<30;$i++){
                $item= new Item();
                $item->setDescription("Las gambas, como otros mariscos son alimentos fuente de proteínas de calidad ante todo. En este caso también se trata de una opción muy reducida en grasas aunque dentro de estas predominan los ácidos grasos poliinsturados y sobre todo, el omega 3.");
                $item->setName('Gambas alajillo');
                $item->setPrice(10.22);
                $item->setCategory($categoria);
                $manager->persist($item);
            }
        }
        $manager->flush();
    }
}
