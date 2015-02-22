<?php

namespace Netpublic\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CargaAcademicaControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();
        //Iniciamos sesion
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'gabriel',
            '_password' => 'bermu4523'          
        )); 
       $client->submit($form);
        $crawler = $client->followRedirect();   
       
//GRADO  
        $crawler = $client->request('GET', '/grado/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_gradotype[nombre]'  => 'Primero'            
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();   
//GRUPO  
      $crawler = $client->request('GET', '/grupo/');
        //$this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_grupotype[nombre]'  => 'Primero A'            
        ));
         $id_grado=$crawler->filter("#ntp_inacholeebundle_grupotype option")->first()->attr("value");
        $form['ntp_inacholeebundle_grupotype[grado]']->select($id_grado);
        $client->submit($form);
        $crawler = $client->followRedirect();   
//AREA        
      $crawler = $client->request('GET', '/asignatura/1');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        // Fill in the form and submit it
       $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Area-Test',
            'ntp_inacholeebundle_asignaturatype[duracion_minutos]'=>'120',
            'ntp_inacholeebundle_asignaturatype[frucuencia_semana]' =>'2'
        ));
        //$id_grado=$crawler->filter("#ntp_inacholeebundle_asignaturatype_grado option")->first()->attr("value");
        $form['ntp_inacholeebundle_asignaturatype[grado]']->select($id_grado);
        $client->submit($form);
        $crawler = $client->followRedirect();  
//ASIGNATURA        
       $crawler = $client->request('GET', '/asignatura/2');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Nuevo')->link());
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Crear')->form(array(
            'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Matematicas Test',
            'ntp_inacholeebundle_asignaturatype[duracion_minutos]'=>'120',
            'ntp_inacholeebundle_asignaturatype[frucuencia_semana]' =>'2'
            
        ));
        
        $form['ntp_inacholeebundle_asignaturatype[grado]']->select($id_grado);
        
        $id_area=$crawler->filter("#ntp_inacholeebundle_asignaturatype_area option")->first()->attr("value");
        $form['ntp_inacholeebundle_asignaturatype[area]']->select($id_area);
        $client->submit($form);   
        $crawler = $client->followRedirect();   
//CONTRATO
        $crawler = $client->request('GET', '/contrato/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_contratotype[horas_contratadas]'  => '4'            
            
        ));       
        $id_asignatura=$crawler->filter("#ntp_inacholeebundle_contratotype_asignatura option")->eq(1)->attr("value");
        $form['ntp_inacholeebundle_contratotype[asignatura]']->select($id_asignatura);
        $id_profesor=$crawler->filter("#ntp_inacholeebundle_contratotype_profesor_contrato option")->first()->attr("value");
        $form['ntp_inacholeebundle_contratotype[profesor_contrato]']->select($id_profesor);
        $client->submit($form); 
//DISPONIBILIDAD DE AULAS
        $crawler = $client->request('GET', '/horarioclase/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_horarioclasetype[hora_inicio]'  => '6',
            'ntp_inacholeebundle_horarioclasetype[hora_final]' =>'12'
            
        ));       
        $id_dia_semana=$crawler->filter("#ntp_inacholeebundle_horarioclasetype_dia_semana option")->eq(3)->attr("value");
        $form['ntp_inacholeebundle_horarioclasetype[dia_semana]']->select($id_dia_semana);
        
        $client->submit($form);   
       
        $crawler = $client->request('GET', '/aula/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('new')->link());
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_aulatype[ubicacion]'  => 'Salon',
            'ntp_inacholeebundle_aulatype[nombre]' => 'Bloque'
            
        ));       
        $id_disponibilidad=$crawler->filter("#ntp_inacholeebundle_aulatype_horario_clase option")->first()->attr("value");
        $form['ntp_inacholeebundle_aulatype[horario_clase]']->select(array($id_disponibilidad));
        $id_materias_dictar=$crawler->filter("#ntp_inacholeebundle_aulatype_contrato_aula option")->eq(1)->attr("value");
        $form['ntp_inacholeebundle_aulatype[contrato_aula]']->select(array($id_materias_dictar));
        $client->submit($form);
        $crawler = $client->followRedirect();

//Verificamos que existan recursos.
        $crawler = $client->request('GET', '/cargaacademica/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Test Verificar')->link());
        $this->assertTrue($crawler->filter("span:contains('1')")->count() > 0);
        $crawler = $client->request('GET', '/cargaacademica/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Test Generar')->link());
        $r="Se ha generado la Carga Automatica Exitosamente!!";
        $this->assertTrue($crawler->filter("span:contains('Se ha generado la Carga Automatica Exitosamente!!')")->count() > 0);
//NUEVO GRUPO        
      $crawler = $client->request('GET', '/grupo/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('nuevo')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_grupotype[nombre]'  => 'Primero B'            
        ));
         $id_grado=$crawler->filter("#ntp_inacholeebundle_grupotype option")->first()->attr("value");
        $form['ntp_inacholeebundle_grupotype[grado]']->select($id_grado);
        $client->submit($form);
        $crawler = $client->followRedirect();   

//Verificamos que existan recursos.
        $crawler = $client->request('GET', '/cargaacademica/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Test Verificar')->link());
        $this->assertTrue($crawler->filter("span:contains('0')")->count() > 0);

//ACTUALIZAR CONTRATO
        $crawler = $client->request('GET', '/contrato/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('edit')->link());
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_contratotype[horas_contratadas]'  => '8'            
            
        ));       
        $id_asignatura=$crawler->filter("#ntp_inacholeebundle_contratotype_asignatura option")->eq(1)->attr("value");
        $form['ntp_inacholeebundle_contratotype[asignatura]']->select($id_asignatura);
        $id_profesor=$crawler->filter("#ntp_inacholeebundle_contratotype_profesor_contrato option")->first()->attr("value");
        $form['ntp_inacholeebundle_contratotype[profesor_contrato]']->select($id_profesor);
        $client->submit($form); 
//Verificamos que existan recursos.
        $crawler = $client->request('GET', '/cargaacademica/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Test Verificar')->link());
        $this->assertTrue($crawler->filter("span:contains('1')")->count() > 0);  
//Generamos aulas        
        $crawler = $client->request('GET', '/cargaacademica/');        
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Test Generar')->link());
        $r="Se ha generado la Carga Automatica Exitosamente!!";
        $this->assertTrue($crawler->filter("span:contains('Se ha generado la Carga Automatica Exitosamente!!')")->count() > 0);
// PRUEBA COMPLEJA
// Pruebas para Colegio        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
//Borramos contexto.
//BORRAR GRADO
        $crawler = $client->request('GET', '/grado/');
        $client->submit($crawler->selectButton('eliminar')->first()->form());
//BORRAR GRUPO        
        $crawler = $client->request('GET', '/grupo/');
        $client->submit($crawler->selectButton('eliminar')->eq(0)->form());
        $crawler = $client->request('GET', '/grupo/');
        $client->submit($crawler->selectButton('eliminar')->eq(0)->form());
//BORRAR ASIGNATURAS Y AULAS.
        $crawler = $client->request('GET', '/asignatura/1');
        $client->submit($crawler->selectButton('eliminar')->first()->form());      
        $crawler = $client->request('GET', '/asignatura/2');
        $client->submit($crawler->selectButton('eliminar')->first()->form()); 
//BORRAR CONTRATO        
        $crawler = $client->request('GET', '/contrato/');
        $client->submit($crawler->selectButton('eliminar')->first()->form());  
//HORARIOS CLASES
        $crawler = $client->request('GET', '/horarioclase/');
        $client->submit($crawler->selectButton('eliminar')->first()->form()); 
//BORRAR AULAS        
        $crawler = $client->request('GET', '/aula/');
        $client->submit($crawler->selectButton('eliminar')->first()->form()); 

        // Create a new entry in the database
        /*$crawler = $client->request('GET', '/cargaacademica/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_cargaacademicatype[profesor]'  => '1',             
            'ntp_inacholeebundle_cargaacademicatype[asignatura]'  => array('1','2'),            
            'ntp_inacholeebundle_cargaacademicatype[grupo]'  => array('1','2'),
            
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        
        
       
        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Nelia Luciana Asprilla")')->count() > 0);

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('edit')->last()->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'ntp_inacholeebundle_cargaacademicatype[profesor]'  => '2',             
            'ntp_inacholeebundle_cargaacademicatype[grupo]'  => '2',            
            'ntp_inacholeebundle_cargaacademicatype[asignatura]'  => '1',
             ));

        $client->submit($form);        

        // Check the element contains an attribute with value equals "Foo"
//        $this->assertTrue($crawler->filter('[value="Foo"]')->count() > 0);

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/No importar/', $client->getResponse()->getContent());
         * 
         */
    }
    
   public function testGetHorasSemanalesProfesor()
   {
       return 1;
   }
}