<?php

namespace App\Tests\Controller;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase{
//TODO: 入力のテストケース作成+テスト方法用意
    public function TestMainController()
    {
        $client = static::createClient();
        $repositry = static::$container->get(UserRepository::class);
        $user = $repositry->findOneBy(["user" => "test"]);
        $client->loginUser($user);
        //TODO: 画面操作
        //相手がグーの時
        
        $client->request('GET',"/main/0");
        //相手がチョキの時
        $client->request('GET',"/main/1");
        //相手がパーの時
        $client->request('GET',"/main/2");

    }
   
}