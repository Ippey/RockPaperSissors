<?php
namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testFirstPoint(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $crawler = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'user_form[name]' => 'abc',
        ]);
        /** @var User $user */
        $user = $userRepository->findOneBy(['name' => 'abc']);
        $this->assertEquals($user->getPoint(), 100);
    }

    public function testNullName(): void
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $crawler = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();
        $client->submit($form, [
            'user_form[name]' => '',
        ]);
        /** @var User $user */
        $user = $userRepository->findOneBy(['name' => '']);
        $this->assertNull($user);
    }
}
