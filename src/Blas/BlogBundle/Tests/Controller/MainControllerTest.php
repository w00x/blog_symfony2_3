<?php

namespace Blas\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex() {
        //Testeando los componentes
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("Post ME!!")')->count() > 0);

        $this->assertTrue($crawler->filter('input[type=text]')->count() == 2);

        $this->assertTrue($crawler->filter('textarea')->count() == 1);

        $this->assertTrue($crawler->filter('button[type=submit]')->count() == 1);

        $form_button = $crawler->selectButton('Guardar');

        //Test de form post con parametros invalidos
        $random = rand(0,1000);
        $form = $form_button->form(array(
            'blas_blogbundle_post[title]' => 'Test title '.$random,
            'blas_blogbundle_post[post]'  =>  '',
            'blas_blogbundle_post[owner]' => '',
        ));

        $client->submit($form);

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("Test title '.$random.'")')->count() == 0);

        //Test de form valido
        $random = rand(1000,10000000000);

        $form = $form_button->form(array(
            'blas_blogbundle_post[title]' => 'Test title '.$random,
            'blas_blogbundle_post[post]'  =>  'Test Content',
            'blas_blogbundle_post[owner]' => 'gkjh',
        ));

        $client->submit($form);

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("Test title")')->count() > 0);


    }

    public function testComments() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $links = $crawler->selectLink('Coments (0)');

        $link = $links->last()->link();

        $comments_crawlers = $client->click($link);

        //Testeando existencia de compoenntes
        $this->assertTrue($comments_crawlers->filter('html:contains("Comentarios")')->count() > 0);

        $this->assertTrue($comments_crawlers->filter('input[type=text]')->count() == 1);

        $this->assertTrue($comments_crawlers->filter('textarea')->count() == 1);

        $this->assertTrue($comments_crawlers->filter('button[type=submit]')->count() == 1);

        $form_button = $comments_crawlers->selectButton('Comentar');

        //Testing con fallos
        $random = rand(0,1000);
        $form = $form_button->form(array(
            'blas_blogbundle_comment[comment]' => 'Test comentario '.$random,
            'blas_blogbundle_comment[owner]'  =>  '',
        ));

        $client->submit($form);

        $comments_crawlers = $client->click($link);
        $this->assertTrue($comments_crawlers->filter('html:contains("Test comentario '.$random.'")')->count() == 0);

        //Testing bueno
        $random = rand(0,1000);
        $form = $form_button->form(array(
            'blas_blogbundle_comment[comment]' => 'Test comentario '.$random,
            'blas_blogbundle_comment[owner]'  =>  'El comentario',
        ));

        $client->submit($form);

        $comments_crawlers = $client->click($link);
        $this->assertTrue($comments_crawlers->filter('html:contains("Test comentario '.$random.'")')->count() > 0);
    }
}
