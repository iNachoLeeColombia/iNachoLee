<?php

namespace Netpublic\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GrupoControllerTest extends WebTestCase
{
   /*
    public function testCompleteScenario()
    {
        
        
        $cliente=static::createClient();
        // Creamos un nuevo estudiante
        $crawler = $cliente->request('GET', '/login');
        
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'yuri',
            '_password' => 'admin'          
        )); 
        $cliente->submit($form);
        // request the index action
        $crawler = $cliente->request('GET', '/');
 
        $this->assertEquals(200, $cliente->getResponse()->getStatusCode());
 
        // select the login form
        $form = $crawler->selectButton('LOGIN')->form();
 
        // submit the form with bad credentials
        $crawler = $cliente->submit(
            $form,
            array(
                '_username' => 'john.doe',
                '_password' => 'wrong_password'
            )
        );
 
        // response should be success
        $this->assertTrue($cliente->getResponse()->isSuccessful());
 
        // we should have been redirected back to the login page because
        // invalid credentials were supplied
        $this->assertTrue($crawler->filter('h1:contains("Login")')->count() <0);
 
        // select the login form
        $form = $crawler->selectButton('submit')->form();
 
        // submit the form with valid credentials
        $crawler = $client->submit(
            $form,
            array(
                '_username' => 'john.doe',
                '_password' => 'admin'
            )
        );
 
        // response should be success
        $this->assertTrue($cliente->getResponse()->isSuccessful());
 
        $tractor=$cliente->request('GET','/grupo/1/1/1/calificar');
        $this->assertEquals(21+4*21,$tractor->filter('li')->count());
        //Ingresamos un nuevo estudiante grupo 1        
        $tractor=$cliente->request('GET','/alumno/new');
        $form = $tractor->selectButton('Create')->form(array(
            'ntp_inacholeebundle_alumnotype[nombre]'  => 'Yina Marcela',
            'ntp_inacholeebundle_alumnotype[movil]'  => '311 123',
            'ntp_inacholeebundle_alumnotype[grupo]'  => '1',
            'ntp_inacholeebundle_alumnotype[grado]'  => '1'
            
        ));
        $cliente->submit($form);
        $crawler = $cliente->followRedirect();
        //Id alumno
        $id_alumno=$crawler->filter('input[type=hidden]')->eq(1)->attr("value");
        // Verifica que Alumno es ingresado               
        $this->assertTrue($crawler->filter("td:contains('$id_alumno')")->count() > 0);
        //Varifica que se liste en nuevo estudiante en grupo
        $tractor=$cliente->request('GET','/grupo/1/1/1/calificar');
        $this->assertEquals(21+4*21+5,$tractor->filter('li')->count());
        //Verifica la eliminacion de un Alumno
        $tractor=$cliente->request('GET',"/alumno/$id_alumno/show");
        $this->assertTrue($tractor->filter("td:contains('$id_alumno')")->count() > 0);
        $form = $tractor->selectButton('Delete')->form(array(            
            'form[id]'  =>"$id_alumno",            
        ));
        $cliente->submit($form);
        $tractor=$cliente->request('GET','/grupo/1/1/1/calificar');
        $this->assertEquals(21+4*21,$tractor->filter('li')->count());
         //$tractor=$cliente->request('GET','/grupo/1/1/1/calificar');
        $this->assertEquals(21+4*21,$tractor->filter('li')->count());
        //$tractor = $client->click($tractor->selectLink('Create a new entry')->link());
        // Create a new client to browse the application
        $client = static::createClient();0

        // Create a new entry in the database
        $crawler = $client->request('GET', '/grupo/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'grupo[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Test")')->count() > 0);

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'grupo[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertTrue($crawler->filter('[value="Foo"]')->count() > 0);

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }*/
    
}