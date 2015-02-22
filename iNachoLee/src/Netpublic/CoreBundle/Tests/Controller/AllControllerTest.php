<?php

namespace Netpublic\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AllControllerTest
 *
 * @author yuri
 */
class AllControllerTest extends WebTestCase{
    //Interaccion de toodos los controladores.
    //1°- Crear grado
            // Create a new client to browse the application
   /*  public function testCompleteScenario()
    {
         $client = static::createClient();
          // select the login form
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'yuri',
            '_password' => 'admin'          
        )); 
        $client->submit($form);
         
         $crawler = $client->request('GET', '/grado/new');
         // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_gradotype[nombre]'  => 'Octavo'           
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();       
        $id_grado=$crawler->filter('td')->eq(0)->text();
        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Octavo")')->count() > 0);
        
        $crawler = $client->request('GET', '/asignatura/new');
         // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ntp_inacholeebundle_asignaturatype[nombre]'  => 'Matematicas',
            'ntp_inacholeebundle_asignaturatype[grado]'=> "$id_grado",
        ));
        $client->submit($form);
        
        $crawler = $client->followRedirect();       
        $id_asignatura=$crawler->filter('td')->eq(0)->text();
        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Matematicas")')->count() > 0);
        
        
        
        $crawler = $client->request('GET', '/grupo/new');
         // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(             
            'ntp_inacholeebundle_grupotype[grado]'  => "$id_grado",
            'ntp_inacholeebundle_grupotype[nombre]'=> 'Octavo A'
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();       
        $id_grupo=$crawler->filter('td')->eq(0)->text();
        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Octavo A")')->count() > 0);
        
        
       $crawler = $client->request('GET', '/profesor/new');
         // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(             
            'ntp_inacholeebundle_profesortype[nombre]'  => "Manuel Bermudez Moreno",
            
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();       
        $id_profesor=$crawler->filter('td')->eq(0)->text();
        $this->assertTrue($crawler->filter("td:contains('$id_profesor')")->count() > 0);
        $crawler = $client->request('GET', '/logout');
        $crawler = $client->followRedirect();       
        //$crawler = $client->request('GET', '/login');
        
        $form = $crawler->selectButton('LOGIN')->form(array(
            '_username' => 'Manuel',
            '_password' => 'Manuel123'          
        )); 
        $client->submit($form);
         
        // Check data in the show view

        $crawler = $client->request('GET', '/cargaacademica/new');
         // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(             
            'ntp_inacholeebundle_cargaacademicatype[profesor]'  =>$id_profesor,
            'ntp_inacholeebundle_cargaacademicatype[grupo]'  => array($id_grupo),
            'ntp_inacholeebundle_cargaacademicatype[asignatura]'  => array($id_asignatura)
            
        ));
        $client->submit($form);
        for ($index = 0; $index < 5; $index++) {
            $crawler = $client->request('GET', '/alumno/new');
         // Fill in the form and submit it
            $form = $crawler->selectButton('Create')->form(array(             
            'ntp_inacholeebundle_alumnotype[nombre]'  =>"alumno".$index,
            'ntp_inacholeebundle_alumnotype[movil]'  => "312 453 23 23".$index,
            'ntp_inacholeebundle_alumnotype[grupo]'  => $id_grupo,
            'ntp_inacholeebundle_alumnotype[grado]'  => $id_grado
            
        ));
        $client->submit($form);
        }
        $crawler = $client->request('GET', "/grupo/$id_asignatura/$id_grupo/1/calificar");
        $this->assertEquals(30,$crawler->filter('li')->count());        
        echo $id_alumno=$crawler->filter('input[type=text]')->eq(7)->attr("name");
         $form = $crawler->selectButton('Calificar')->form(array(             
            "$id_alumno"  =>'1,8',
             "asignatura_grupo"=>"$id_asignatura;$id_grupo;1"
        ));
        $client->submit($form);
        $crawler = $client->request('GET', "/grupo/$id_asignatura/$id_grupo/1/calificar");
        $this->assertEquals('1,8',$crawler->filter('input[type=text]')->eq(7)->attr("value"));        
        //Creamos una nueva dimension
        
         $crawler = $client->request('GET', '/dimension/new');
         // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(             
         'ntp_inacholeebundle_dimensiontype[nombre]'=>"Segunda Tarea del Primer periodo",
         'ntp_inacholeebundle_dimensiontype[es_carita_feliz]'=>1,
         'ntp_inacholeebundle_dimensiontype[padre]'=>2,
         'ntp_inacholeebundle_dimensiontype[asignatura]'=>$id_asignatura,
         'ntp_inacholeebundle_dimensiontype[grupo]'=>array($id_grupo)   
            
        ));
        $client->submit($form);        
        $crawler = $client->followRedirect();       
        $crawler = $client->request('GET', "/grupo/$id_asignatura/$id_grupo/2/calificar");
        $this->assertEquals(12,$crawler->filter('li')->count());        
     }
    */
  
    //1°- Crear Asignatura
    //1°- Ingresar nuevo alumnos
    //1°- Crear grupo
    //1°- Crear Profesora
    //1°- Crear Carga Academica
    //1°- Listar estudiantes de grupo creado
    //1°- Calificar estudiante.
}

?>
