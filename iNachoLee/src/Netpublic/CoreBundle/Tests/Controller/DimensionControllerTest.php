<?php

namespace Netpublic\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DimensionControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        
       /*
        * 
        * Dimension tipo AÑO ESCOLAR
        * 
        * 
        */ 
        // Creamos un cliente para la aplicacion
        //$client = static::createClient();
        //$client->insulate();
        //Iniciamos sesion
        /*$crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'gabriel',
            '_password' => 'bermu4523'          
        )); 
        $client->submit($form);
        
        $crawler = $client->followRedirect();       
//        $this->assertTrue($crawler->filter('html:contains("Carga Academica.")')->count() > 0);                            
        // Create a new entry in the database
        $crawler = $client->request('GET', '/dimension/0');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        // Tomamos el token
        //$token=$crawler->filter("#ntp_inacholeebundle_dimensiontype__token")->attr("value");
        //$this->assertEquals(1,$token);
        $crawler=$crawler->selectButton('Crear');
        $form = $crawler->form(array(
            'ntp_inacholeebundle_dimensiontype[nombre]'=>"Ano Escolar 2013",
            //'ntp_inacholeebundle_dimensiontype[_token]'=>$token
        ));
        
        $client->submit($form);  
                  
        //$crawler = $client->request('GET', '/dimension/0');
        //$crawler = $client->click($crawler->selectLink('salir')->link());

        // Check data in the show view
        $crawler = $client->request('GET', '/dimension/0');
        $this->assertTrue($crawler->filter('tr')->count() > 0);
        // Edit the entity
        $crawler = $client->click($crawler->selectLink('editar')->link());
        $form = $crawler->selectButton('Actualizar')->form(array(
            'ntp_inacholeebundle_dimensiontype[nombre]'  => 'Ano Escolar 2014',           
            
        ));
        $client->submit($form);
        //$crawler = $client->followRedirect();
        // Check the element contains an attribute with value equals "Foo"
        $crawler = $client->request('GET', '/dimension/0');
        $crawler = $client->click($crawler->selectLink('editar')->eq(0)->link());        
        $this->assertTrue($crawler->filter('[value="Ano Escolar 2014"]')->count() > 0);
        // Delete the entity
        $crawler = $client->request('GET', '/dimension/0');
        $client->submit($crawler->selectButton('eliminar')->eq(0)->form());
        $crawler = $client->followRedirect();
        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Ano Escolar 2014/', $client->getResponse()->getContent());
         
       /*
        * 
        * Dimension tipo Periodos Academicos
        * 
        * 
        */ 
        /*$crawler = $client->request('GET', '/dimension/0');
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_dimensiontype[nombre]'  => 'Ano Escolar 2013'            
        ));
        $client->submit($form);
        $crawler = $client->request('GET', '/dimension/0');
        $id_ano_escolar=$crawler->filter("a.ids_dimension")->first()->text();
        //ids_dimension
        // Create a new entry in the database
        $crawler = $client->request('GET', '/dimension/1');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_dimensiontype[nombre]'  => 'Periodo 1'            
        ));
        $form['ntp_inacholeebundle_dimensiontype[padre]']->select($id_ano_escolar);
        $client->submit($form);        
        // Check data in the show view
        $crawler = $client->request('GET', '/dimension/1');
        $this->assertTrue($crawler->filter('tr')->count() > 0);
       // Edit the entity
        $crawler = $client->click($crawler->selectLink('editar')->link());
        $form = $crawler->selectButton('Actualizar')->form(array(
            'ntp_inacholeebundle_dimensiontype[nombre]'  => 'PeridoModificado',           
            
        ));
        $client->submit($form);
        //$crawler = $client->followRedirect();
        // Check the element contains an attribute with value equals "Foo"
        $crawler = $client->request('GET', '/dimension/1');
        $crawler = $client->click($crawler->selectLink('editar')->eq(0)->link());        
        $this->assertTrue($crawler->filter('[value="PeridoModificado"]')->count() > 0);
        // Delete the entity
        $crawler = $client->request('GET', '/dimension/1');
        $client->submit($crawler->selectButton('eliminar')->eq(0)->form());
        $crawler = $client->followRedirect();
        // Check the entity has been delete on the list
        $this->assertNotRegExp('/PeridoModificado/', $client->getResponse()->getContent());
        // Eliminamos demiension creada para prueba
        $crawler = $client->request('GET', '/dimension/0');
        $client->submit($crawler->selectButton('eliminar')->eq(0)->form());
       // $crawler = $client->click($crawler->selectLink('salir')->link());
        */
    }
    
}