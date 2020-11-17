<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->client = static::createClient();
        $this->userRepository = static::$container->get(UserRepository::class);
    }

    public function testFirstPoint(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();
        $this->client->submit($form, [
            'user_form[name]' => 'LoginTest',
        ]);
        $user = $this->userRepository->findOneBy(['name' => 'LoginTest']);
        $this->assertEquals($user->getPoint(), 100);
    }

    public function testNullName(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();
        $this->client->submit($form, [
            'user_form[name]' => '',
        ]);
        $user = $this->userRepository->findOneBy(['name' => '']);
        $this->assertNull($user);
    }
}
