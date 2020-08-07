<?php
namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    /** @var KernelBrowser */
    private $client;
    /** @var UserRepository */
    private $userRepository;

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
            'user_form[name]' => 'abc',
        ]);
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['name' => 'abc']);
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
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['name' => '']);
        $this->assertNull($user);
    }
}
