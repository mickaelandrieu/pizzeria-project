<?php

namespace Tests\AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalControllerTest extends WebTestCase
{
    /**
     * @dataProvider getActions
     * 
     * Survival tests: every page should be visible
     */
    public function testActions($url)
    {
        $client = static::createClient();
        $container = $client->getContainer();
        
        $crawler = $client->request('HEAD', $url, [], [], [
            'PHP_AUTH_USER' => $container->getParameter('test_user'),
            'PHP_AUTH_PW'   => $container->getParameter('test_password'),
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function getActions()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        
        $pizzaId = $em->getRepository('AppBundle:Pizza')
            ->findOneBy(['name' => 'Fun Pizza'])
            ->getId()
        ;
        
        $ingredientId = $em->getRepository('AppBundle:Ingredient')
            ->findOneBy(['name' => 'tomato'])
            ->getId()
        ;
        return [
            'Home page' => ['/'],
            'Admin pizza list' => ['/admin/pizza/'],
            'Admin pizza create' => ['/admin/pizza/new'],
            'Admin pizza show' => ['/admin/pizza/'.$pizzaId],
            'Admin pizza edit' => ['/admin/pizza/'.$pizzaId.'/edit'],

            'Admin ingredient list' => ['/admin/ingredient/'],
            'Admin ingredient create' => ['/admin/ingredient/new'],
            'Admin ingredient show' => ['/admin/ingredient/'.$ingredientId],
            'Admin ingredient edit' => ['/admin/ingredient/'.$ingredientId.'/edit'],
        ];
    }
}
