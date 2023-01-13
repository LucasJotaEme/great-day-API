<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserControllerTest extends WebTestCase
{
    const API_KEY_TEST = "f3870b8158dfd5dd432b587ae482662f";

    public function testCreateUser(): void
    {
        $method = "POST";
        $uri = "/user/create";
        $files  = array();
        $header = array(
            'CONTENT_TYPE'=> "application/json",
            'HTTP_ACCEPT' => "application/json",
            "HTTP_APIKEY" => self::API_KEY_TEST
        );
        $rawBodyData = array(
            "email" => "lucasmaldonado",
            "password" => "xd"
        );
        $params = array(
            "json" => "test",
            "description" => 'The Handmaid\'s Tale'
        );
        $client = static::createClient();
        $crawler = $client->request($method, $uri, $params, $files, $header, '{"id":"34"}');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }

    // public function testLogin(): void
    // {
    //     $client = static::createClient();
    //     $parameters = array(
    //         "HTTP_USER" => "lucas@test",
    //         "HTTP_PASSWORD" => "lucas"
    //     );
    //     $uri = "/login";
    //     $crawler = $client->request('GET', $uri, array(), array(), $parameters);
    //     dump($client->getResponse()->getContent());die;
    //     $this->assertResponseIsSuccessful();
    //     $this->assertSelectorTextContains('h1', 'Hello World');
    // }
}
