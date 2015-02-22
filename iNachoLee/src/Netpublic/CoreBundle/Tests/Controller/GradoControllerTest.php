<?php

namespace Netpublic\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GradoControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
       /*
        * 
        * Grado
        * 
        * 
        */ 
        // Creamos un cliente para la aplicacion
        /*$client = static::createClient();
        //Iniciamos sesion
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'gabriel',
            '_password' => 'bermu4523'          
        )); 
        $client->submit($form);
        $crawler = $client->followRedirect();       
        $this->assertTrue($crawler->filter('html:contains("Carga Academica.")')->count() > 0);                            
        // Create a new entry in the database
        
        
        $crawler = $client->request('GET', '/grado/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_gradotype[nombre]'  => 'Primero'            
        ));
        $client->submit($form);        
        // Check data in the show viewuuuu
        $crawler = $client->request('GET', '/grado/');
        $crawler = $client->click($crawler->selectLink('editar')->link());
        
        $form = $crawler->selectButton('Edit')->form(array(
            'ntp_inacholeebundle_gradotype[nombre]'  => 'PrimeroModificado',           
            
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        // Check the element contains an attribute with value equals "Foo"

               
        $this->assertTrue($crawler->filter('[value="PrimeroModificado"]')->count() > 0);
        // Delete the entity
        $crawler = $client->request('GET', '/grado/');
        $client->submit($crawler->selectButton('eliminar')->eq(0)->form());
        // Check the entity has been delete on the list
        $crawler = $client->request('GET', '/grado/');
        $this->assertNotRegExp('/PrimeroModificado/', $client->getResponse()->getContent());
         
         $crawler = $client->click($crawler->selectLink('salir')->link());
        */
    }
    
}