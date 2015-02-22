<?php

namespace Netpublic\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlumnoControllerTest extends WebTestCase
{
    /*
    public function testCompleteScenario()
    {
        // Creamos un nuevo cliente 
        $client = static::createClient();

        // Creamos un nuevo estudiante
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'yuri',
            '_password' => 'admin'          
        )); 
        $client->submit($form);
        $crawler = $client->request('GET', '/alumno/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Cargamos datos para el formulario
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_alumnotype[nombre]'  => 'Yina Marcela',
            'ntp_inacholeebundle_alumnotype[movil]'  => '313 8167569',
            'ntp_inacholeebundle_alumnotype[grupo]'  => '1',
            'ntp_inacholeebundle_alumnotype[grado]'  => '1'
            
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Testear si ha creado  el alumno
        $this->assertTrue($crawler->filter('td:contains("Yina Marcela")')->count() > 0);

        // Editar Alumno
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'ntp_inacholeebundle_alumnotype[nombre]'  => 'Yina M',
            'ntp_inacholeebundle_alumnotype[movil]'  => '313 8167569',
            'ntp_inacholeebundle_alumnotype[grupo]'  => '1',
            'ntp_inacholeebundle_alumnotype[grado]'  => '1'             
        ));


        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertTrue($crawler->filter('[value="Yina M"]')->count() > 0);

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Yina M/', $client->getResponse()->getContent());
    }*/
    
}