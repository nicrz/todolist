<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\TaskRepository;

class UserControllerTest extends WebTestCase
{

    public function testUsersList()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
    }

    public function testCreateUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);

        $crawler = $client->request('GET', '/users/create');
        $this->assertResponseIsSuccessful();
        
        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        
        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        
        // set values on a form object
        $form['user[username]'] = 'Pseudo 2';
        $form['user[password][first]'] = 'mdp2';
        $form['user[password][second]'] = 'mdp2';
        $form['user[email]'] = 'user2@gmail.com';

        // retrieve last created task
        $last = $userRepository->findOneBy([], ['id' => 'desc']);
        
        // submit the Form object
        $client->submit($form);
        $this->assertSame('Pseudo 2', $last->getUsername());

    }

    public function testUpdateUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users/2/edit');
        $this->assertResponseIsSuccessful();
        
        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        
        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        
        // set values on a form object
        $form['user_edit[username]'] = 'Modif 1';
        $form['user_edit[password][first]'] = 'mdpmodif1';
        $form['user_edit[password][second]'] = 'mdpmodif1';
        $form['user_edit[email]'] = 'usermodif1@gmail.com';

        // retrieve last created task
        $updated = $userRepository->find(2);
        
        // submit the Form object
        $client->submit($form);
        $this->assertSame('Modif 1', $updated->getUsername());

    }

}