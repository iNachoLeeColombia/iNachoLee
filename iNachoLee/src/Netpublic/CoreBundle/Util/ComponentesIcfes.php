<?php
namespace Netpublic\CoreBundle\Util;
use Netpublic\RedsaberBundle\Entity\Componente;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Plantillas
 *
 * @author yuri
 */
class ComponentesIcfes {
    static public function getComponentesIcfes($em,$grado,$tipo=0){
        //Grado 3°  Prueba de lenguaje        
        if($tipo==1){
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de lenguaje.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Competencia comunicativa-lectora.");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Semántico (¿qué dice el texto?)");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Recupera información explícita contenida en el texto");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Recupera información implícita contenida en el texto. ");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Compara textos de diferentes formatos y finalidades, y establece relaciones entre sus contenidos.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

        
                $prueba112=new Componente();
                $prueba112->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Identifica la estructura explícita del texto.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Identifica la estructura implícita del texto.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba123=new Componente();
                $prueba123->setNombre("Pragmático (¿cuál es el propósito del texto?)");
                $prueba123->setPadre($prueba11);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Reconoce información explícita sobre los propósitos del texto.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Reconoce elementos implícitos sobre los propósitos del texto.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
     
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Analiza información explícita o implícita sobre los propósitos del texto. ");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);

            $prueba12=new Componente();
            $prueba12->setNombre("Competencia comunicativa-escritora.");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Semántico (¿qué dice el texto?)");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Prevé temas, contenidos o ideas para producir textos, de acuerdo con el propósito de lo que requiere comunicar");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Realiza consultas con base en las características del tema y el propósito del escrito.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Da cuenta de ideas, tópicos o líneas de desarrollo que un texto  debe seguir, de acuerdo con el tema propuesto y lo que se requiere comunicar.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                        $prueba1214=new Componente();
                        $prueba1214->setNombre("Propone el desarrollo de un texto a partir de las especificaciones del tema.");
                        $prueba1214->setPadre($prueba121);
                        $prueba1214->setGrado($grado);
                        $prueba1214->setTipo(4);
                        $prueba1214->setEsUltimo(1);
                        $em->persist($prueba1214);

                        $prueba1215=new Componente();
                        $prueba1215->setNombre("Selecciona los elementos que permiten la articulación de las ideas en un texto (presentación, continuación, transición, digresión, enumeración, cierre o conclusión), atendiendo al tema central.");
                        $prueba1215->setPadre($prueba121);
                        $prueba1215->setGrado($grado);
                        $prueba1215->setTipo(4);
                        $prueba1215->setEsUltimo(1);
                        $em->persist($prueba1215);

                        $prueba1216=new Componente();
                        $prueba1216->setNombre("Comprende los elementos formales que regulan el desarrollo de un tema en un texto, teniendo en cuenta lo que quiere comunicarse.");
                        $prueba1216->setPadre($prueba121);
                        $prueba1216->setGrado($grado);
                        $prueba1216->setTipo(4);
                        $prueba1216->setEsUltimo(1);
                        $em->persist($prueba1216);
                       
                        
        
                $prueba122=new Componente();
                $prueba122->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Prevé el plan para organizar el texto..");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Conoce la organización que un texto debe tener para lograr coherencia y cohesión.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                $prueba123=new Componente();
                $prueba123->setNombre("Pragmático (¿cuál es el propósito del texto?)");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Establece el destinatario del texto (para quién se escribe) así como su propósito, para atender a las necesidades de comunicación.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Utiliza las estrategias discursivas pertinentes y adecuadas de acuerdo con el propósito de la comunicación que debe tener  un texto.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
        //Grado 3°  Prueba de Matematica           
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de matematicas.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Comunicación,representación y modelación");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico-variacional");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Reconoce el uso de números naturales en diferentes contextos.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Reconoce equivalencias entre diferentes tipos de representaciones relacionadas con números.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Construye y describe secuencias numéricas y geométricas.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

                        $prueba1114=new Componente();
                        $prueba1114->setNombre("Usa fracciones comunes para describir situaciones continuas y discretas.");
                        $prueba1114->setPadre($prueba111);
                        $prueba1114->setGrado($grado);
                        $prueba1114->setEsUltimo(1);
                        $prueba1114->setTipo(4);
                        $em->persist($prueba1114);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Geométrico-métrico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Describe características de figuras que son semejantes o congruentes entre sí.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Establece correspondencia entre objetos o eventos y patrones o instrumentos de medida.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Identifica atributos de objetos y eventos que son susceptibles de medirse.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Ubica objetos con base en instrucciones referentes a dirección, distancia y posición.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Aleatorio");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Clasifica y ordena datos.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Describe características de un conjunto a partir de los datos que lo representan.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Representa un conjunto de datos a partir de un diagrama de barras e interpreta lo que un diagrama de barras determinado representa.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        

                        
                        
            $prueba12=new Componente();
            $prueba12->setNombre("Razonamiento y argumentación");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Numérico-variacional");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Establece conjeturas acerca de regularidades en contextos geométricos y numéricos.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Genera equivalencias entre expresiones numéricas.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Usa operaciones y propiedades de los números naturales para establecer relaciones entre ellos en situaciones específicas.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                        $prueba1214=new Componente();
                        $prueba1214->setNombre("Establece conjeturas acerca del sistema de numeración decimal a partir de representaciones pictóricas.");
                        $prueba1214->setPadre($prueba121);
                        $prueba1214->setGrado($grado);
                        $prueba1214->setTipo(4);
                        $prueba1214->setEsUltimo(1);
                        $em->persist($prueba1214);
                $prueba122=new Componente();
                $prueba122->setNombre("Componente Geométrico-métrico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Establece diferencias y similitudes entre objetos bidimensionales y tridimensionales de acuerdo con sus propiedades. ");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Ordena objetos bidimensionales y tridimensionales de acuerdo con atributos  medibles. ");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Establece conjeturas que se aproximen a las nociones de paralelismo y perpendicularidad en figuras planas. ");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Establece conjeturas acerca de las propiedades de las figuras planas cuando sobre ellas se ha hecho una transformación  (traslación, rotación, reflexión (simetría), ampliación, reducción). ");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);

                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Establece diferencias y similitudes entre objetos bidimensionales y tridimensionales de acuerdo con sus propiedades. ");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Relaciona objetos tridimensionales con sus respectivas vistas.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                $prueba123=new Componente();
                $prueba123->setNombre("Componente Aleatorio");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Describe tendencias que se presentan en un conjunto a partir de los datos que lo describen.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Establece conjeturas acerca de la posibilidad de ocurrencia de eventos.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
//Planteamiento y resolucion de problemas
            $prueba12=new Componente();
            $prueba12->setNombre("Planteamiento y resolución de problemas");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Numérico-variacional");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Resuelve problemas aditivos rutinarios de composición y transformación e interpreta condiciones necesarias para su solución.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Resuelve y formula problemas multiplicativos rutinarios de adición repetida.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Resuelve y formula problemas sencillos de proporcionalidad directa.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                $prueba122=new Componente();
                $prueba122->setNombre("Componente Geométrico-métrico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Usa propiedades geométricas para solucionar problemas relativos al diseño y construcción de figuras planas.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Estima medidas con patrones arbitrarios. ");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Desarrolla procesos de medición usando patrones e instrumentos estandarizados.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                $prueba123=new Componente();
                $prueba123->setNombre("Componente Aleatorio");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Resuelve problemas a partir del análisis de datos recolectados.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Resuelve situaciones que requieren estimar grados de posibilidad de ocurrencia de eventos.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
        }
        
/*--------------------------------------------------------GRADO 5-------------------------------------------------------------*/
        if($tipo==2){
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de lenguaje.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Competencia comunicativa-lectora.");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Semántico (¿qué dice el texto?)");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Recupera información explícita contenida en el texto");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Recupera información implícita contenida en el texto. ");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Relaciona textos entre sí y recurre a saberes previos para ampliar referentes e ideas.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

        
                $prueba112=new Componente();
                $prueba112->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Identifica la estructura explícita del texto.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Recupera información implícita de la organización, la estructura y de los componentes de los textos.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Analiza estrategias, explícitas o implícitas, de organización, estructura y componentes de los textos. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Pragmático (¿cuál es el propósito del texto?)");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Reconoce información explícita sobre los propósitos del texto");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce elementos implícitos sobre los propósitos del texto.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Analiza información explícita o implícita sobre los propósitos del texto.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        
            $prueba12=new Componente();
            $prueba12->setNombre("Competencia comunicativa-escritora.");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Semántico (¿qué dice el texto?)");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Prevé temas, contenidos, ideas o enunciados para producir textos que respondan a diversas necesidades comunicativas.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Realiza consultas con base en las características del tema y el propósito del escrito ");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

        
                $prueba122=new Componente();
                $prueba122->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Prevé el plan para organizar las ideas y para definir el tipo de texto pertinente, de acuerdo con lo que quiere comunicar. ");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Conoce la organización que un texto debe tener para lograr coherencia y cohesión.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Conoce los elementos formales de la lengua y de la gramática para lograr la coherencia y la cohesión del texto, en una situación de comunicación particular. ");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                

                $prueba123=new Componente();
                $prueba123->setNombre("Pragmático (¿cuál es el propósito del texto?)");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Prevé el propósito o las intenciones que un texto debe cumplir para atender a las necesidades de comunicación.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Utiliza las estrategias discursivas pertinentes y adecuadas de acuerdo con el propósito de la comunicación que debe tener un texto.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Utiliza los elementos formales de las estrategias discursivas con el fin de adecuar el texto a la situación de comunicación.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);

//  Prueba de Matematica           
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de matematicas.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Comunicación,representación y modelación");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico-variacional");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Reconoce significados del número en diferentes contextos (medición, conteo,comparación, codificación, localización,entre otros).");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Reconoce diferentes representaciones de un mismo número.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Describe e interpreta propiedades y relaciones de los números y sus operaciones.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

                        $prueba1114=new Componente();
                        $prueba1114->setNombre("Traduce relaciones numéricas expresadas gráfica y simbólicamente.");
                        $prueba1114->setPadre($prueba111);
                        $prueba1114->setGrado($grado);
                        $prueba1114->setEsUltimo(1);
                        $prueba1114->setTipo(4);
                        $em->persist($prueba1114);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Geométrico-métrico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Establece relaciones entre los atributos mensurables de un objeto o evento y sus respectivas magnitudes.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Identifica unidades tanto estandarizadas como no convencionales apropiadas para diferentes mediciones y establece relaciones entre ellas.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Utiliza sistemas de coordenadas para especificar localizaciones.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                       
                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Aleatorio");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Clasifica y organiza la presentación de datos.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta cualitativamente datos relativos a situaciones del entorno escolar.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Representa un conjunto de datos e interpreta representaciones gráficas de un conjunto de datos.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Hace traducciones entre diferentes representaciones.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Expresa el grado de probabilidad de un suceso.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        

                        
                        
            $prueba12=new Componente();
            $prueba12->setNombre("Razonamiento y argumentación");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Numérico-variacional");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Reconoce patrones numéricos.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Justifica propiedades y relaciones numéricas
usando ejemplos y contraejemplos.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Reconoce y genera equivalencias entre expresiones numéricas.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                        $prueba1214=new Componente();
                        $prueba1214->setNombre("Analiza relaciones de dependencia en diferentes situaciones.");
                        $prueba1214->setPadre($prueba121);
                        $prueba1214->setGrado($grado);
                        $prueba1214->setTipo(4);
                        $prueba1214->setEsUltimo(1);
                        $em->persist($prueba1214);
                        $prueba1214=new Componente();
                        $prueba1214->setNombre("Usa y justifica propiedades (aditiva y posicional del sistema de numeración decimal).");
                        $prueba1214->setPadre($prueba121);
                        $prueba1214->setGrado($grado);
                        $prueba1214->setTipo(4);
                        $prueba1214->setEsUltimo(1);
                        $em->persist($prueba1214);

                $prueba122=new Componente();
                $prueba122->setNombre("Componente Geométrico-métrico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Compara y clasifica objetos tridimensionales y figuras bidimensionales de acuerdo con sus componentes.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Reconoce nociones de paralelismo y perpendicularidad en distintos contextos.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Hace conjeturas y verifica los resultados de aplicar transformaciones a figuras en el plano");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Describe y argumenta acerca del perímetro y el área de un conjunto de figuras planas cuando una de las magnitudes se fija.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);

                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Relaciona objetos tridimensionales y sus propiedades con sus respectivos desarrollos planos.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Construye y descompone figuras planas y sólidos a partir de condiciones dadas.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Identifica y justifica relaciones de semejanza y congruencia entre figuras.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);

                $prueba123=new Componente();
                $prueba123->setNombre("Componente Aleatorio");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Compara datos presentados en diferentes representaciones.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Hace arreglos condicionados o no condicionados.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Hace conjeturas acerca de la posibilidad de ocurrencia de eventos.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        
//Planteamiento y resolucion de problemas
            $prueba12=new Componente();
            $prueba12->setNombre("Planteamiento y resolución de problemas");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Numérico-variacional");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Resuelve y formula problemas aditivos de transformación, comparación, combinación e igualación.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Resuelve y formula problemas multiplicativos de adición repetida, factor multiplicante, razón y producto cartesiano.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Resuelve y formula problemas de proporcionalidad directa e inversa.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);
                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Resuelve y formula problemas que requieren el uso de la fracción como parte de un todo, como cociente y como razón.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                $prueba122=new Componente();
                $prueba122->setNombre("Componente Geométrico-métrico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Utiliza diferentes procedimientos de cálculo para hallar la medida de superficies y volúmenes.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Reconoce el uso de las magnitudes y de las dimensiones de las unidades respectivas en situaciones aditivas y multiplicativas.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Utiliza relaciones y propiedades geométricas para resolver problemas de medición.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Usa y construye modelos geométricos para solucionar problemas.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                $prueba123=new Componente();
                $prueba123->setNombre("Componente Aleatorio");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Resuelve problemas que requieren representar datos relativos al entorno usando una o diferentes representaciones.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Resuelve problemas que requieren encontrar y/o dar significado al promedio de un conjunto de datos.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Resuelve situaciones que requieren calcular la posibilidad o imposibilidad de ocurrencia de eventos.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
//PRUEBA DE CIENCIAS NATURALES.
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de ciencias naturales.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Uso comprensivo del conocimiento científico");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Entorno vivo");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Comprende que los seres vivos dependen del funcionamiento e interacción de sus partes.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Comprende que los seres vivos atraviesan diferentes etapas durante su ciclo de vida.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Comprende que existen relaciones entre los seres vivos y el entorno y que estos dependen de aquellas.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Entorno físico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende que existe una gran diversidad de materiales que se pueden diferenciar a partir de sus propiedades.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende que existen diversas fuentes y formas de energía y que esta se transforma continuamente.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende la estructura básica y el funcionamiento de los circuitos eléctricos.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce los principales elementos y características de la Tierra y del espacio.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende el funcionamiento de algunas máquinas simples y la relación fuerza-movimiento");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                       
                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Ciencia, tecnología y sociedad");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende el funcionamiento de diferentes objetos a partir de sus usos y propiedades.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende la diferencia entre varios o diversos tipos de máquinas.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Valora y comprende la necesidad de seguir hábitos para mantener la salud y el entorno.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        
                        
            $prueba12=new Componente();
            $prueba12->setNombre("Explicación de fenómenos");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Entorno vivo");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Comprende que los seres vivos dependen del funcionamiento e interacción de sus partes.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Comprende que los seres vivos atraviesan diferentes etapas durante su ciclo de vida.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Comprende que existen relaciones entre los seres vivos y el entorno y que estos dependen de aquellas.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                $prueba122=new Componente();
                $prueba122->setNombre("Componente Entorno físico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Comprende que existe una gran diversidad de materiales que se pueden diferenciar a partir de sus propiedades.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Comprende que existen diversas fuentes y formas de energía y que esta se transforma continuamente.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Comprende la estructura básica y el funcionamiento de los circuitos eléctricos.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Comprende y describe la ubicación y las características de la Tierra y algunos cuerpos celestes en nuestro sistema solar.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);

                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Comprende el funcionamiento de algunas máquinas simples y la relación fuerza-movimiento.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                $prueba123=new Componente();
                $prueba123->setNombre("Componente Ciencia, tecnología y sociedad");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Comprende el funcionamiento de diferentes objetos a partir de sus usos y propiedades.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Comprende la diferencia entre varios o diversos tipos de máquinas.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Valora y comprende la necesidad de seguir hábitos para mantener la salud y el entorno");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Comprende la importancia del desarrollo humano y su efecto sobre el entorno.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        
//Planteamiento y resolucion de problemas
            $prueba12=new Componente();
            $prueba12->setNombre("Indagación");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("En los componentes Entorno vivo y Entorno físico");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Comprende que a partir de la investigación científica se construyen explicaciones sobre el mundo natural.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Utiliza algunas habilidades de pensamiento y de procedimiento para evaluar predicciones.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Observa y relaciona patrones en los datos para evaluar las predicciones.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);
                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Elabora y propone explicaciones para algunos fenómenos de la naturaleza basadas en conocimiento científico y en la evidencia de su propia investigación y en
la de otros.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

        }   

/*--------------------------------------------------------GRADO 9°-------------------------------------------------------------*/
        if($tipo==3){
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de lenguaje.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Competencia comunicativa-lectora.");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Semántico (¿qué dice el texto?)");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Recupera información explícita contenida en el texto.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Relaciona, identifica y deduce información para construir el
sentido global del texto.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Relaciona textos entre sí y recurre a saberes previos para
ampliar referentes e ideas.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

        
                $prueba112=new Componente();
                $prueba112->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Identifica la estructura explícita del texto.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Recupera información implícita de la organización, la estructura
y de los componentes de los textos.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Analiza estrategias, explícitas o implícitas, de organización,
estructura y componentes de los textos. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Pragmático (¿cuál es el propósito del texto?)");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Reconoce información explícita sobre los propósitos del texto.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce los elementos implícitos sobre los propósitos
del texto.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Analiza información explícita o implícita sobre los propósitos
del texto.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        
            $prueba12=new Componente();
            $prueba12->setNombre("Competencia comunicativa-escritora.");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Semántico (¿qué dice el texto?)");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Prevé temas, contenidos, ideas o enunciados para producir
textos que respondan a diversas necesidades comunicativas.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Realiza consultas con base en las características del tema y el
propósito del escrito.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Da cuenta de ideas y tópicos que un texto debe seguir, de
acuerdo con el tema propuesto.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);
                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Comprende los elementos formales que regulan el desarrollo
de un tema en un texto, teniendo en cuenta lo que quiere
comunicarse.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);
                        
        
                $prueba122=new Componente();
                $prueba122->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Prevé el plan para organizar las ideas y para definir el tipo de
texto pertinente, de acuerdo con lo que quiere comunicar.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Conoce la organización que un texto debe tener para lograr
coherencia y cohesión.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Conoce los elementos formales de la lengua y de la gramática
para lograr la coherencia y la cohesión del texto, en una
situación de comunicación particular");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                

                $prueba123=new Componente();
                $prueba123->setNombre("Pragmático (¿cuál es el propósito del texto?)");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Prevé el propósito o las intenciones que un texto debe cumplir
para atender a las necesidades de comunicación.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Utiliza las estrategias discursivas pertinentes y adecuadas de
acuerdo con el propósito de la comunicación que debe tener
un texto.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Utiliza los elementos formales de las estrategias discursivas con el
fin de adecuar el texto a la situación de comunicación.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);

//  Prueba de Matematica           
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de matematicas.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Comunicación,representación y modelación");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico-variacional");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Identifica características de gráficas cartesianas
en relación con la situación que representan.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Identifica expresiones numéricas y algebraicas
equivalentes.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Establece relaciones entre propiedades de las
gráficas y propiedades de las ecuaciones
algebraicas.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

                        $prueba1114=new Componente();
                        $prueba1114->setNombre("Reconoce el lenguaje algebraico como forma
de representar procesos inductivos.");
                        $prueba1114->setPadre($prueba111);
                        $prueba1114->setGrado($grado);
                        $prueba1114->setEsUltimo(1);
                        $prueba1114->setTipo(4);
                        $em->persist($prueba1114);
                        $prueba1114=new Componente();
                        $prueba1114->setNombre("Reconoce el lenguaje algebraico como forma
de representar procesos inductivos.");
                        $prueba1114->setPadre($prueba111);
                        $prueba1114->setGrado($grado);
                        $prueba1114->setEsUltimo(1);
                        $prueba1114->setTipo(4);
                        $em->persist($prueba1114);

                        $prueba1114=new Componente();
                        $prueba1114->setNombre("Describe y representa situaciones de variación
relacionando diferentes representaciones.");
                        $prueba1114->setPadre($prueba111);
                        $prueba1114->setGrado($grado);
                        $prueba1114->setEsUltimo(1);
                        $prueba1114->setTipo(4);
                        $em->persist($prueba1114);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Geométrico-métrico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Representa y reconoce objetos tridimensionales
desde diferentes posiciones y vistas.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Usa sistemas de referencia para localizar o
describir posición de objetos y figuras.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y aplica transformaciones de figuras
planas.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                       
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Identifica relaciones entre distintas unidades
utilizadas para medir cantidades de la misma
magnitud");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Diferencia magnitudes de un objeto y relaciona
las dimensiones de éste con la determinación
de las magnitudes.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Aleatorio");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Interpreta y utiliza conceptos de media, mediana
y moda y explicita sus diferencias en
distribuciones diferentes.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Compara, usa e interpreta datos que provienen
de situaciones reales y traduce entre diferentes
representaciones de un conjunto de datos.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce la posibilidad o la imposibilidad de
ocurrencia de un evento a partir de una
información dada o de un fenómeno.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce relaciones entre un conjunto de datos
y sus representaciones.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                       
                        
                        
            $prueba12=new Componente();
            $prueba12->setNombre("Razonamiento y argumentación");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Numérico-variacional");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Reconoce patrones en secuencias numéricas.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Interpreta y usa expresiones algebraicas equivalentes");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Interpreta tendencias que se presentan en un
conjunto de variables relacionadas.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                        $prueba1214=new Componente();
                        $prueba1214->setNombre("Usa representaciones y procedimientos en
situaciones de proporcionalidad directa e inversa.");
                        $prueba1214->setPadre($prueba121);
                        $prueba1214->setGrado($grado);
                        $prueba1214->setTipo(4);
                        $prueba1214->setEsUltimo(1);
                        $em->persist($prueba1214);
                        $prueba1214=new Componente();
                        $prueba1214->setNombre("Reconoce el uso de las propiedades y las
relaciones de los números reales.");
                        $prueba1214->setPadre($prueba121);
                        $prueba1214->setGrado($grado);
                        $prueba1214->setTipo(4);
                        $prueba1214->setEsUltimo(1);
                        $em->persist($prueba1214);
                        $prueba1214->setNombre("Desarrolla procesos inductivos y deductivos con
el lenguaje algebraico para veri");
                        $prueba1214->setPadre($prueba121);
                        $prueba1214->setGrado($grado);
                        $prueba1214->setTipo(4);
                        $prueba1214->setEsUltimo(1);
                        $em->persist($prueba1214);

                $prueba122=new Componente();
                $prueba122->setNombre("Componente Geométrico-métrico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Argumenta formal e informalmente sobre
propiedades y relaciones de figuras planas y sólidos");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Hace conjeturas y verifica propiedades de
congruencias y semejanza entre figuras
bidimensionales.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Generaliza procedimientos de cálculo para
encontrar el área de figuras planas y el volumen
de algunos sólidos.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Analiza la validez o invalidez de usar
procedimientos para la construcción de figuras
planas y cuerpos con medidas dadas.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);

                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Predice y compara los resultados de aplicar
transformaciones rígidas (rotación, traslación y
reflexión) y homotecias (ampliaciones y
reducciones) sobre figuras bidimensionales en
situaciones matemáticas y artísticas");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);


                $prueba123=new Componente();
                $prueba123->setNombre("Componente Aleatorio");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Hace conjeturas acerca de los resultados de un
experimento aleatorio usando proporcionalidad.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Predice y justifica razonamientos y conclusiones
usando información estadística.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Calcula la probabilidad de eventos simples
usando métodos diversos.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Usa modelos para discutir la posibilidad de
ocurrencia de un evento.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Fundamenta conclusiones utilizando conceptos
de medidas de tendencia central.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        
//Planteamiento y resolucion de problemas
            $prueba12=new Componente();
            $prueba12->setNombre("Planteamiento y resolución de problemas");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Numérico-variacional");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Resuelve problemas en situaciones aditivas y
multiplicativas en el conjunto de los números
reales.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Resuelve problemas que involucran
potenciación, radicación y logaritmación.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Resuelve problemas en situaciones de variación
y modela situaciones de variación con
funciones polinómicas y exponenciales en
contextos aritméticos y geométricos.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);
                        
                $prueba122=new Componente();
                $prueba122->setNombre("Componente Geométrico-métrico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Resuelve problemas de medición utilizando
de manera pertinente instrumentos y unidades
de medida.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Resuelve y formula problemas usando modelos
geométricos.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Establece y utiliza diferentes procedimientos
de cálculo para hallar medidas de superficies
y volúmenes.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Resuelve y formula problemas que requieran
técnicas de estimación.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                $prueba123=new Componente();
                $prueba123->setNombre("Componente Aleatorio");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Usa e interpreta medidas de tendencia central
para analizar el comportamiento de un conjunto
de datos.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Resuelve y formula problemas a partir de un
conjunto de datos presentado en tablas,
diagramas de barras y diagrama circular.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Hace inferencias a partir de un conjunto de datos.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Plantea y resuelve situaciones relativas a otras
ciencias utilizando conceptos de probabilidad.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);

//PRUEBA DE CIENCIAS NATURALES.
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de ciencias naturales.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Uso comprensivo del conocimiento científico");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Entorno vivo");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Analiza el funcionamiento de los seres vivos en
términos de sus estructuras y procesos.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Comprende la función de la reproducción en la
conservación de las especies y los
mecanismos a través de los cuales se heredan
algunas características y se modifican otras.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Comprende que en un ecosistema las
poblaciones interactúan unas con otras y con el
ambiente físico.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Entorno físico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende las relaciones que existen entre las
características macroscópicas y microscópicas
de la materia y las propiedades físicas y
químicas de las sustancias que la constituyen.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende la naturaleza de los fenómenos
relacionados con la luz y el sonido.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende la naturaleza de los fenómenos
relacionados con la electricidad y el
magnetismo.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende la naturaleza y las relaciones entre
la fuerza y el movimiento.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende la dinámica de nuestro sistema
solar a partir de su composición.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende que existen distintas formas de
energía y que esta se transforma
continuamente.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                       
                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Ciencia, tecnología y sociedad");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende la necesidad de seguir hábitos
saludables para mantener la salud.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende que existen diversos recursos y
analiza su impacto sobre el entorno cuando son
explotados, así como las posibilidades de
desarrollo para las comunidades.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Comprende el papel de la tecnología en el
desarrollo de la sociedad actual.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        
                        
            $prueba12=new Componente();
            $prueba12->setNombre("Explicación de fenómenos");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Componente Entorno vivo");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Analiza el funcionamiento de los seres vivos
en términos de sus estructuras y procesos.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Comprende la función de la reproducción en la
conservación de las especies y los
mecanismos a través de los cuales se heredan
algunas características y se modifican otras.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Comprende que en un ecosistema las
poblaciones interactúan unas con otras y con
el ambiente físico.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);

                $prueba122=new Componente();
                $prueba122->setNombre("Componente Entorno físico");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Comprende las relaciones que existen entre las
características macroscópicas y microscópicas
de la materia y las propiedades físicas y
químicas de las sustancias que la constituyen.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Comprende la naturaleza de los fenómenos
relacionados con la luz y el sonido.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Comprende la naturaleza de los fenómenos
relacionados con la electricidad y el
magnetismo.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Comprende la naturaleza y las relaciones entre
la fuerza y el movimiento.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);

                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Comprende la dinámica de nuestro sistema
solar a partir de su composición.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Comprende que existen distintas fuentes y
formas de energía y que esta se transforma
continuamente.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                $prueba123=new Componente();
                $prueba123->setNombre("Componente Ciencia, tecnología y sociedad");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Comprende la necesidad de seguir hábitos
saludables para mantener la salud.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Comprende que existen diversos recursos y
analiza su impacto sobre el entorno cuando
son explotados, así como las posibilidades de
desarrollo para las comunidades.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Comprende el papel de la tecnología en el
desarrollo de la sociedad actual.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        
//Planteamiento y resolucion de problemas
            $prueba12=new Componente();
            $prueba12->setNombre("Indagación");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("En los componentes Entorno vivo y Entorno físico");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Comprende que a partir de la investigación
científica se construyen explicaciones sobre
el mundo natural.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Utiliza algunas habilidades de pensamiento y
de procedimiento para evaluar predicciones.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Observa y relaciona patrones en los datos
para evaluar las predicciones.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);
                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Elabora y propone explicaciones para
algunos fenómenos de la naturaleza basadas
en conocimiento científico y en la evidencia
de su propia investigación y en la de otros.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);
        }
        
/*--------------------------------------------------------GRADO 11°-------------------------------------------------------------*/
        if($tipo==4){
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de lenguaje.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Competencia comunicativa-lectora.");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Semántico (¿qué dice el texto?)");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Recupera información explícita contenida en el texto.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Relaciona, identifica y deduce información para construir el
sentido global del texto.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        $prueba1113=new Componente();
                        $prueba1113->setNombre("Relaciona textos entre sí y recurre a saberes previos para
ampliar referentes e ideas.");
                        $prueba1113->setPadre($prueba111);
                        $prueba1113->setGrado($grado);
                        $prueba1113->setEsUltimo(1);
                        $prueba1113->setTipo(4);
                        $em->persist($prueba1113);

        
                $prueba112=new Componente();
                $prueba112->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Identifica la estructura explícita del texto.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Recupera información implícita de la organización, la estructura
y de los componentes de los textos.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Analiza estrategias, explícitas o implícitas, de organización,
estructura y componentes de los textos. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Pragmático (¿cuál es el propósito del texto?)");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Reconoce información explícita sobre los propósitos del texto.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce los elementos implícitos sobre los propósitos
del texto.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Analiza información explícita o implícita sobre los propósitos
del texto.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        
            $prueba12=new Componente();
            $prueba12->setNombre("Competencia comunicativa-escritora.");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("Semántico (¿qué dice el texto?)");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Prevé temas, contenidos, ideas o enunciados para producir
textos que respondan a diversas necesidades comunicativas.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Realiza consultas con base en las características del tema y el
propósito del escrito.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Da cuenta de ideas y tópicos que un texto debe seguir, de
acuerdo con el tema propuesto.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);
                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Comprende los elementos formales que regulan el desarrollo
de un tema en un texto, teniendo en cuenta lo que quiere
comunicarse.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);
                        
        
                $prueba122=new Componente();
                $prueba122->setNombre("Sintáctico (¿cómo se organiza el texto?)");
                $prueba122->setPadre($prueba12);
                $prueba122->setGrado($grado);
                $prueba122->setTipo(3);
                $em->persist($prueba122);
                        $prueba1221=new Componente();
                        $prueba1221->setNombre("Prevé el plan para organizar las ideas y para definir el tipo de
texto pertinente, de acuerdo con lo que quiere comunicar.");
                        $prueba1221->setPadre($prueba122);
                        $prueba1221->setGrado($grado);
                        $prueba1221->setTipo(4);
                        $prueba1221->setEsUltimo(1);
                        $em->persist($prueba1221);

                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Conoce la organización que un texto debe tener para lograr
coherencia y cohesión.");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                        $prueba1222=new Componente();
                        $prueba1222->setNombre("Conoce los elementos formales de la lengua y de la gramática
para lograr la coherencia y la cohesión del texto, en una
situación de comunicación particular");
                        $prueba1222->setPadre($prueba122);
                        $prueba1222->setGrado($grado);
                        $prueba1222->setTipo(4);
                        $prueba1222->setEsUltimo(1);
                        $em->persist($prueba1222);
                        
                

                $prueba123=new Componente();
                $prueba123->setNombre("Pragmático (¿cuál es el propósito del texto?)");
                $prueba123->setPadre($prueba12);
                $prueba123->setGrado($grado);
                $prueba123->setTipo(3);
                $em->persist($prueba123);
                        $prueba1231=new Componente();
                        $prueba1231->setNombre("Prevé el propósito o las intenciones que un texto debe cumplir
para atender a las necesidades de comunicación.");
                        $prueba1231->setPadre($prueba123);
                        $prueba1231->setGrado($grado);
                        $prueba1231->setTipo(4);
                        $prueba1231->setEsUltimo(1);
                        $em->persist($prueba1231);

                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Utiliza las estrategias discursivas pertinentes y adecuadas de
acuerdo con el propósito de la comunicación que debe tener
un texto.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);
                        
                        $prueba1232=new Componente();
                        $prueba1232->setNombre("Utiliza los elementos formales de las estrategias discursivas con el
fin de adecuar el texto a la situación de comunicación.");
                        $prueba1232->setPadre($prueba123);
                        $prueba1232->setGrado($grado);
                        $prueba1232->setTipo(4);
                        $prueba1232->setEsUltimo(1);
                        $em->persist($prueba1232);

//  Prueba de Matematica           
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de matematicas.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Interpretación y representación");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Identifica y utiliza Orden de números e intervalos.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Identifica y utiliza Números racionales (representados como
fracciones, razones, números con decimales,
o en términos de porcentajes).
");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Identifica y utiliza Sucesiones y límites.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Identifica y utiliza Números reales ");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico-variacional");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Identifica Operaciones aritméticas (suma, resta,multiplicación, división y potenciación),  composición de operaciones y uso de sus   propiedades básicas");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Identifica Funciones polinomiales, racionales,radicales, exponenciales y logarítmicas.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Geométrico-métrico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Representa y reconoce Figuras geométricas básicas (triángulos,
  Figuras geométricas simples (polígonos,
   cuadrados, rectángulos, rombos, círculos,
    esferas, cubos).
   pirámides, elipses). Ademas reconoce 
   Relaciones de paralelismo y ortogonalidad Construcciones geométricas complejas.
   entre rectas.
.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce figuras  geométricas simples (Poligonos,pirámides, elipses).");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y aplica Construcciones geométricas complejas
");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Métrico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Identifica y utiliza Magnitudes y unidades físicas (tiempo, peso,temperatura).");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Identifica y utiliza Aproximación y orden de magnitud.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y aplica Notación científica.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Métrico variacional");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Identifica y utiliza Sistemas de coordenadas cartesianas bidimensionales.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Identifica y utiliza Relaciones lineales. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y aplica Representación gráfica del cambio. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Reconoce y aplica  Razones de magnitudes: velocidad, aceleración, tasas de cambio, tasas de interés,densidades..");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y aplica la Proporcionalidad directa e inversa.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y aplica el Crecimiento polinomial y exponencial.Periodicidad..");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Métrico Aleatorio");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Interpreta y utiliza conceptos de Promedio, rango estadístico.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Azar y relaciones probabilísticas entre eventos 
 complementarios o independientes. 
.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Medidas de tendencia central y dispersión.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y utiliza conceptos de Muestreo e inferencias muestrales.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Numerico Aleatorio");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Interpreta y utiliza conceptos de Intersección, unión y contenencia entre conjuntos.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Conteos que utilizan principios de suma y
multiplicación.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Combinaciones y permutaciones..");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y utiliza conceptos de Muestreo e inferencias muestrales.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                       
                        
                        
            $prueba12=new Componente();
            $prueba12->setNombre("Razonamiento y argumentación");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico");
                $prueba111->setPadre($prueba12);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Reconoce Orden de números e intervalos.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Usa Números racionales (representados como
fracciones, razones, números con decimales,
o en términos de porcentajes).
");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Interpreta y usa las Sucesiones y límites.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Interpreta y usa los Números reales ");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico-variacional");
                $prueba111->setPadre($prueba12);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Interpreta y usa las  Operaciones aritméticas (suma, resta,multiplicación, división y potenciación),  composición de operaciones y uso de sus   propiedades básicas");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Interpreta y usa las Funciones polinomiales, racionales,radicales, exponenciales y logarítmicas.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Geométrico-métrico");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Reconoce y analiza las Figuras geométricas básicas (triángulos,
  Figuras geométricas simples (polígonos,
   cuadrados, rectángulos, rombos, círculos,
    esferas, cubos).
   pirámides, elipses). Ademas reconoce 
   Relaciones de paralelismo y ortogonalidad Construcciones geométricas complejas.
   entre rectas.
.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y analiza las figuras  geométricas simples (Poligonos,pirámides, elipses).");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y analiza  Construcciones geométricas complejas
");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Métrico");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Reconoce y analiza las  Magnitudes y unidades físicas (tiempo, peso,temperatura).");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y usa la Aproximación y orden de magnitud.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y usa Notación científica.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Métrico variacional");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Hace congenturas y vereifica con  Sistemas de coordenadas cartesianas bidimensionales.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y usa Relaciones lineales. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce patrones de Representación gráfica del cambio. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Generaliza preocedimientos de calculo con   Razones de magnitudes: velocidad, aceleración, tasas de cambio, tasas de interés,densidades..");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y usa la Proporcionalidad directa e inversa.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y analiza el  Crecimiento polinomial y exponencial.Periodicidad..");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Métrico Aleatorio");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Interpreta y utiliza conceptos de Promedio, rango estadístico.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Azar y relaciones probabilísticas entre eventos 
 complementarios o independientes. 
.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Medidas de tendencia central y dispersión.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y utiliza conceptos de Muestreo e inferencias muestrales.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Numerico Aleatorio");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Interpreta y utiliza conceptos de Intersección, unión y contenencia entre conjuntos.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Conteos que utilizan principios de suma y
multiplicación.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Interpreta y utiliza conceptos de Combinaciones y permutaciones..");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Reconoce y utiliza conceptos de Muestreo e inferencias muestrales.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
//Planteamiento y resolucion de problemas
            $prueba12=new Componente();
            $prueba12->setNombre("Formulación y ejecución");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico");
                $prueba111->setPadre($prueba12);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Resuelve problemas que involucran Orden de números e intervalos.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Resuelve problemas que involucran  Números racionales (representados como
fracciones, razones, números con decimales,
o en términos de porcentajes).
");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Resuelve problemas que involucran  Sucesiones y límites.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Resuelve problemas que involucran  los Números reales ");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente Numérico-variacional");
                $prueba111->setPadre($prueba12);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Resuelve problemas que involucran  las  Operaciones aritméticas (suma, resta,multiplicación, división y potenciación),  composición de operaciones y uso de sus   propiedades básicas");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);

                        $prueba1112=new Componente();
                        $prueba1112->setNombre("Resuelve problemas que involucran  las Funciones polinomiales, racionales,radicales, exponenciales y logarítmicas.");
                        $prueba1112->setPadre($prueba111);
                        $prueba1112->setGrado($grado);
                        $prueba1112->setTipo(4);
                        $prueba1112->setEsUltimo(1);
                        $em->persist($prueba1112);

                        
                $prueba112=new Componente();
                $prueba112->setNombre("Geométrico-métrico");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Resuelve problemas que involucran  las Figuras geométricas básicas (triángulos,
  Figuras geométricas simples (polígonos,
   cuadrados, rectángulos, rombos, círculos,
    esferas, cubos).
   pirámides, elipses). Ademas reconoce 
   Relaciones de paralelismo y ortogonalidad Construcciones geométricas complejas.
   entre rectas.
.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  las figuras  geométricas simples (Poligonos,pirámides, elipses).");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran   Construcciones geométricas complejas
");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Métrico");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Resuelve problemas que involucran  las  Magnitudes y unidades físicas (tiempo, peso,temperatura).");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  la Aproximación y orden de magnitud.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  Notación científica.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Métrico variacional");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Resuelve problemas que involucran   Sistemas de coordenadas cartesianas bidimensionales.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  Relaciones lineales. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  Representación gráfica del cambio. ");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Resuelve problemas que involucran Razones de magnitudes: velocidad, aceleración, tasas de cambio, tasas de interés,densidades..");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  la Proporcionalidad directa e inversa.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran   Crecimiento polinomial y exponencial.Periodicidad..");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Métrico Aleatorio");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Resuelve problemas que involucran  conceptos de Promedio, rango estadístico.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  conceptos de Azar y relaciones probabilísticas entre eventos 
 complementarios o independientes. 
.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  conceptos de Medidas de tendencia central y dispersión.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran  conceptos de Muestreo e inferencias muestrales.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                $prueba112=new Componente();
                $prueba112->setNombre("Componente Numerico Aleatorio");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Resuelve problemas que involucran conceptos de Intersección, unión y contenencia entre conjuntos.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran conceptos de Conteos que utilizan principios de suma y
multiplicación.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);
                        
                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran conceptos de Combinaciones y permutaciones..");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

                        $prueba1122=new Componente();
                        $prueba1122->setNombre("Resuelve problemas que involucran conceptos de Muestreo e inferencias muestrales.");
                        $prueba1122->setPadre($prueba112);
                        $prueba1122->setGrado($grado);
                        $prueba1122->setTipo(4);
                        $prueba1122->setEsUltimo(1);
                        $em->persist($prueba1122);

//PRUEBA DE CIENCIAS NATURALES.
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de ciencias naturales.");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Uso comprensivo del conocimiento científico");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Componente biológico");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Analiza el funcionamiento homeóstasis en los seres vivos; la herencia y la
reproducción; las relaciones ecológicas; la evolución y transformación de la vida en el
planeta; la conservación de la energía.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);
                $prueba112=new Componente();
                $prueba112->setNombre("componente físico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende la cinemática, dinámica, energía mecánica, ondas,
energía térmica, electromagnetismo, campo gravitacional, transformación y conservación
de la energía.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        
                        
                $prueba112=new Componente();
                $prueba112->setNombre("componente químico");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende cambios químicos, el átomo, tipos de enlace,
propiedades de la materia, estequiometría, separación de mezclas, solubilidad, gases
ideales, transformación y conservación de la energía");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);
                $prueba112=new Componente();
                $prueba112->setNombre("componente de ciencia, tecnología y sociedad");
                $prueba112->setPadre($prueba11);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende la deforestación,
el efecto invernadero y la producción de transgénicos .Ademas la explotación de recursos y el tratamiento de basuras");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

            $prueba12=new Componente();
            $prueba12->setNombre("Explicación de fenómenos");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
                $prueba111=new Componente();
                $prueba111->setNombre("Componente biológico");
                $prueba111->setPadre($prueba12);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                        $prueba1111=new Componente();
                        $prueba1111->setNombre("Analiza el funcionamiento homeóstasis en los seres vivos; la herencia y la
reproducción; las relaciones ecológicas; la evolución y transformación de la vida en el
planeta; la conservación de la energía.");
                        $prueba1111->setPadre($prueba111);
                        $prueba1111->setGrado($grado);
                        $prueba1111->setTipo(4);
                        $prueba1111->setEsUltimo(1);
                        $em->persist($prueba1111);
                $prueba112=new Componente();
                $prueba112->setNombre("componente físico");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende la cinemática, dinámica, energía mecánica, ondas,
energía térmica, electromagnetismo, campo gravitacional, transformación y conservación
de la energía.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        
                        
                $prueba112=new Componente();
                $prueba112->setNombre("componente químico");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende cambios químicos, el átomo, tipos de enlace,
propiedades de la materia, estequiometría, separación de mezclas, solubilidad, gases
ideales, transformación y conservación de la energía");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);
                $prueba112=new Componente();
                $prueba112->setNombre("componente de ciencia, tecnología y sociedad");
                $prueba112->setPadre($prueba12);
                $prueba112->setGrado($grado);
                $prueba112->setTipo(3);
                $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("Comprende la deforestación,
el efecto invernadero y la producción de transgénicos .Ademas la explotación de recursos y el tratamiento de basuras");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

            
            $prueba12=new Componente();
            $prueba12->setNombre("Indagación");
            $prueba12->setPadre($prueba1);
            $prueba12->setGrado($grado);
            $prueba12->setTipo(2);
            $em->persist($prueba12);
        
                $prueba121=new Componente();
                $prueba121->setNombre("En los componentes Entorno vivo y Entorno físico ");
                $prueba121->setPadre($prueba12);
                $prueba121->setGrado($grado);
                $prueba121->setTipo(3);
                $em->persist($prueba121);
                        $prueba1211=new Componente();
                        $prueba1211->setNombre("Comprende que a partir de la investigación
científica se construyen explicaciones sobre
el mundo natural.");
                        $prueba1211->setPadre($prueba121);
                        $prueba1211->setGrado($grado);
                        $prueba1211->setTipo(4);
                        $prueba1211->setEsUltimo(1);
                        $em->persist($prueba1211);

                        $prueba1212=new Componente();
                        $prueba1212->setNombre("Utiliza algunas habilidades de pensamiento y
de procedimiento para evaluar predicciones.");
                        $prueba1212->setPadre($prueba121);
                        $prueba1212->setGrado($grado);
                        $prueba1212->setTipo(4);
                        $prueba1212->setEsUltimo(1);
                        $em->persist($prueba1212);

                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Observa y relaciona patrones en los datos
para evaluar las predicciones.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);
                        $prueba1213=new Componente();
                        $prueba1213->setNombre("Elabora y propone explicaciones para
algunos fenómenos de la naturaleza basadas
en conocimiento científico y en la evidencia
de su propia investigación y en la de otros.");
                        $prueba1213->setPadre($prueba121);
                        $prueba1213->setGrado($grado);
                        $prueba1213->setTipo(4);
                        $prueba1213->setEsUltimo(1);
                        $em->persist($prueba1213);
//PRUEBA DE Competencia ciudadanas.
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de Competencias Ciudadanas");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Pensamiento social");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("reconoce y usar conceptos básicos de las ciencias sociales
(por ejemplo, Estado, región, clase social, rol social) y para analizar problemáticas (por
ejemplo, la violencia y las desigualdades sociales).Ademas usa conocimiento de los fundamentos políticos, la estructura
política, y el funcionamiento político de la sociedad a la cual se pertenece en diferentes
niveles (la familia, el barrio, la localidad, la ciudad, el municipio, el departamento, el país,
otros países, el ámbito global). También reconoce y usa
conceptos básicos o fundamentales de la Constitución política de Colombia");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
                
           $prueba112=new Componente();
           $prueba112->setNombre("Interpretación y análisis de perspectivas");
           $prueba112->setPadre($prueba1);
           $prueba112->setGrado($grado);
           $prueba112->setTipo(3);
           $em->persist($prueba112);
                $prueba1121=new Componente();
                $prueba1121->setNombre("(i) evalua
los usos de evidencias en argumentaciones y explicaciones, así como la solidez y pertinencia
de estas; (ii) evalua la validez y coherencia de enunciados hechos por diferentes actores,
tanto desde el análisis de sus discursos como desde la caracterización de quien hace el
discurso o del momento en que se hace esto (por ejemplo, a través de ejercicios en los que
se les pide a los estudiantes relacionar fuentes con su contexto histórico o social); (iii) valora
la afinidad que pueda existir entre diferentes perspectivas, develar prejuicios e intenciones en
enunciados o argumentos, identificar casos en los cuales se hacen generalizaciones a partir
de pocas evidencias");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

                        
                        
          $prueba112=new Componente();
          $prueba112->setNombre("Pensamiento reflexivo y sistémico");
          $prueba112->setPadre($prueba1);
          $prueba112->setGrado($grado);
          $prueba112->setTipo(3);
          $em->persist($prueba112);
                        $prueba1121=new Componente();
                        $prueba1121->setNombre("establece qué tipos de elementos
están presentes en ella; (iii) comprende qué tipo de factores se enfrentan; (iv) comprende
qué dimensiones se privilegian en una determinada solución; (v) anticipa los efectos de la
implementación de una solución y (vi) evalua su aplicabilidad en determinado contexto.");
                        $prueba1121->setPadre($prueba112);
                        $prueba1121->setGrado($grado);
                        $prueba1121->setTipo(4);
                        $prueba1121->setEsUltimo(1);
                        $em->persist($prueba1121);

//PRUEBA DE Competencia ciudadanas.
        $prueba1=new Componente();
        $prueba1->setGrado($grado);
        $prueba1->setNombre("La Prueba de ingles");
        $prueba1->setTipo(1);
        $em->persist($prueba1);
        
            $prueba11=new Componente();
            $prueba11->setNombre("Competencia lingüística");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("maneja conceptos gramaticales, ortográficos o semánticos.");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $prueba111->setEsUltimo(1);
                $em->persist($prueba111);
            $prueba11=new Componente();
            $prueba11->setNombre("Competencia pragmática.");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("organiza las oraciones en secuencias para producir fragmentos textuales y
                    conoce, tanto las formas lingüísticas
 y sus funciones, como el modo en que se encadenan unas con otras en situaciones
comunicativas reales.

");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setEsUltimo(1);
                $prueba111->setTipo(3);
                $em->persist($prueba111);
            $prueba11=new Componente();
            $prueba11->setNombre("Competencia sociolingüística. ");
            $prueba11->setGrado($grado);
            $prueba11->setTipo(2);
            $prueba11->setPadre($prueba1);
            $em->persist($prueba11);
        
                $prueba111=new Componente();
                $prueba111->setNombre("Conoce las condiciones sociales
y culturales que están implícitas en el uso de la lengua
");
                $prueba111->setPadre($prueba11);
                $prueba111->setGrado($grado);
                $prueba111->setTipo(3);
                $prueba111->setEsUltimo(1);
                $em->persist($prueba111);
                
                
        }   
    }
}
?>