<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\TaskRepository;

class TaskControllerTest extends WebTestCase
{

    public function testListAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste de vos tâches');
    }

    public function testCreateAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/create');
        
        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        
        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        
        // set values on a form object
        $form['task[title]'] = 'Titre test';
        $form['task[content]'] = 'Contenu test';

        // retrieve last created task
        $last = $taskRepository->findOneBy([], ['id' => 'desc']);
        
        // submit the Form object
        $client->submit($form);
        $this->assertSame('Titre test', $last->getTitle());

    }

    public function testUpdateAction()
    {

        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/9/edit');
        
        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        
        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        
        // set values on a form object
        $form['task[title]'] = 'Modif test';
        $form['task[content]'] = 'Contenu modif test';
        
        // retrieve last created task
        $updated = $taskRepository->find(9);
        
        // submit the Form object
        $client->submit($form);
        $this->assertSame('Modif test', $updated->getTitle());

    }

    public function testToggleTaskAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/tasks/8/toggle');

        // checking what happen after redirection
        $crawler = $client->followRedirect();


        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testDeleteAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('ruiz.nico64@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/tasks/49/delete');

        // checking what happen after redirection
        $crawler = $client->followRedirect();


        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}