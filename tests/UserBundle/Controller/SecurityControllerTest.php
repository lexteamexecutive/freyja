<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/securite/connexion');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoginSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/securite/connexion');

        $form = $crawler->filter('button')->form();
        $form['_username'] = 'johndoe@gmail.com';
        $form['_password'] = 'testpwd';
        $client->submit($form);
        $client->followRedirects();

        $this->assertTrue(
            $client->getResponse()->isRedirect()
        );
    }

    public function testLogout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/securite/deconnexion');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
