<?php

namespace Netpublic\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Kernel;

class AsignaturaControllerTest extends WebTestCase
{
    
   /*public function testCompleteScenario()
    {
       /*
        * 
        * Asignatura Area
        * 
        * 
        */ 
        // Creamos un cliente para la aplicacion
     /*   $client = static::createClient();
         
        //Iniciamos sesion
       $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'gabriel',
            '_password' => 'bermu4523'          
        ));
         
        $client->submit($form);       
        $crawler = $client->followRedirect();        
        $crawler = $client->request('GET', '/grado/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_gradotype[nombre]'  => 'grado (test)'            
        ));
        $client->submit($form); 
        $crawler = $client->followRedirect();                
        // Create a new entry in the database                
        $crawler = $client->request('GET', '/asignatura/1');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
       $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Area-Test',
            'ntp_inacholeebundle_asignaturatype[duracion_minutos]'=>'120',
            'ntp_inacholeebundle_asignaturatype[frucuencia_semana]' =>'2'
        ));
       $id_grado=$crawler->filter("#ntp_inacholeebundle_asignaturatype_grado option")->first()->attr("value");
        $form['ntp_inacholeebundle_asignaturatype[grado]']->select($id_grado);
        $client->submit($form);
        $crawler = $client->followRedirect();        
        // Check data in the show viewuuuu
        $crawler = $client->request('GET', '/asignatura/1');
        $crawler = $client->click($crawler->selectLink('editar')->link());        
        $form = $crawler->selectButton('Editar')->form(array(            
             'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Area-modificada-test',
            'ntp_inacholeebundle_asignaturatype[duracion_minutos]'=>'120',
            'ntp_inacholeebundle_asignaturatype[frucuencia_semana]' =>'2'
            
        ));
        $form['ntp_inacholeebundle_asignaturatype[grado]']->select($id_grado);
        $client->submit($form); 
        $crawler = $client->followRedirect();       
        // Check the element contains an attribute with value equals "Foo"               
        $this->assertTrue($crawler->filter('[value="Area-modificada-test"]')->count() > 0);
        // Delete the entity
        $crawler = $client->request('GET', '/asignatura/1');
        $client->submit($crawler->selectButton('eliminar')->form());
        // Check the entity has been delete on the list
        $crawler = $client->request('GET', '/asignatura/1');
        $this->assertNotRegExp('/Area-modificada-test/', $client->getResponse()->getContent());
        //Eliminamos el grado 
        $crawler = $client->request('GET', '/grado/');
        $client->submit($crawler->selectButton('eliminar')->form());
    }*/
   public function testCompleteScenarioAsignatura(){
        // Creamos un cliente para la aplicacion
       /* $client = static::createClient();         
        //Iniciamos sesion
       $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'gabriel',
            '_password' => 'bermu4523'          
        ));         
        $client->submit($form);       
        $crawler = $client->followRedirect();  
        
         $crawler = $client->request('GET', '/grado/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_gradotype[nombre]'  => 'grado (test)'            
        ));
        $client->submit($form); 
        $crawler = $client->followRedirect();  
        
        $crawler = $client->request('GET', '/asignatura/1');
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Area Test',
            'ntp_inacholeebundle_asignaturatype[duracion_minutos]'=>'120',
            'ntp_inacholeebundle_asignaturatype[frucuencia_semana]' =>'2'
        ));
        $id_grado=$crawler->filter("#ntp_inacholeebundle_asignaturatype_grado option")->first()->attr("value");
        $form['ntp_inacholeebundle_asignaturatype[grado]']->select($id_grado);
        $client->submit($form);
        $crawler = $client->followRedirect(); 

        // Create a new entry in the database                
        $crawler = $client->request('GET', '/asignatura/2');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Matematicas Test',
            'ntp_inacholeebundle_asignaturatype[duracion_minutos]'=>'120',
            'ntp_inacholeebundle_asignaturatype[frucuencia_semana]' =>'2'
            
        ));
        $id_grado=$crawler->filter("#ntp_inacholeebundle_asignaturatype_grado option")->first()->attr("value");        
        $form['ntp_inacholeebundle_asignaturatype[grado]']->select($id_grado);
        
        $id_area=$crawler->filter("#ntp_inacholeebundle_asignaturatype_area option")->first()->attr("value");
        $form['ntp_inacholeebundle_asignaturatype[area]']->select($id_area);
        $client->submit($form);   
        
        $crawler = $client->followRedirect();      
        // Check data in the show viewuuuu        
        $crawler = $client->request('GET', '/asignatura/2');
        $crawler->selectLink('editar')->link();
        //$crawler = $client->click();        
/*        $form = $crawler->selectButton('Editar')->form(array(            
            'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Asignatura-modif-Test',
            'ntp_inacholeebundle_asignaturatype[duracion_minutos]'=>'120',
            'ntp_inacholeebundle_asignaturatype[frucuencia_semana]' =>'2'
            
        ));
        $form['ntp_inacholeebundle_asignaturatype[grado]']->select($id_grado);
        $form['ntp_inacholeebundle_asignaturatype[area]']->select($id_area);
        $client->submit($form); 
        $crawler = $client->followRedirect();      

        // Check the element contains an attribute with value equals "Foo"               
        $this->assertTrue($crawler->filter('[value="Asignatura-modif-Test"]')->count() > 0);
        // Delete the entity
        $crawler = $client->request('GET', '/asignatura/0');
        $client->submit($crawler->selectButton('eliminar')->form());
        // Check the entity has been delete on the list
        $crawler = $client->request('GET', '/asignatura/0');
        $this->assertNotRegExp('/Asignatura-modif-Test/', $client->getResponse()->getContent());
        //Eliminamos el grado 
        $crawler = $client->request('GET', '/grado/');
        $client->submit($crawler->selectButton('eliminar')->form());
        */
    }
    
   
}