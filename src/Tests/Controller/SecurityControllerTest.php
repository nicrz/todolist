<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\TaskRepository;

class SecurityControllerTest extends WebTestCase
{

    public function testLogin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testLogout()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $crawler = $client->request('GET', '/');

        // simulate the logout button click
        $crawler->selectLink('Se déconnecter')->link();
        $this->throwException(new \Exception('Logout'));

        $this->assertResponseIsSuccessful();
    }

}