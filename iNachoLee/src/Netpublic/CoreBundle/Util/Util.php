<?php
namespace Netpublic\CoreBundle\Util;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author yuri
 */
class Util {
    static public function addHoraMinutos($fecha,$hora,$minutos) {
        //$fecha = date("Y-m-j h:i");
        $nuevafecha = strtotime ( "+$hora hour" , strtotime ( $fecha ) ) ;
        $nuevafecha = strtotime ( "+$minutos minute" , $nuevafecha ) ;
        $nuevafecha1=date ( 'Y m j H:i' , $nuevafecha );
        $resutado=new \DateTime();
        $resutado->setDate(date ( 'Y' , $nuevafecha ),date ( 'm' , $nuevafecha ),date ( 'j' , $nuevafecha ));
        $resutado->setTime(date ( 'H' , $nuevafecha ),date ( 'i' , $nuevafecha ));
        return $resutado;
        
    }
    static public function restaHoraMinutos($fecha,$hora,$minutos) {
        //$fecha = date("Y-m-j h:i");
        $nuevafecha = strtotime ( "-$hora hour" , strtotime ( $fecha ) ) ;
        $nuevafecha = strtotime ( "-$minutos minute" , $nuevafecha ) ;
        $nuevafecha1=date ( 'Y m j h:i' , $nuevafecha );
        $resutado=new \DateTime();
        $resutado->setDate(date ( 'Y' , $nuevafecha ),date ( 'm' , $nuevafecha ),date ( 'j' , $nuevafecha ));
        $resutado->setTime(date ( 'h' , $nuevafecha ),date ( 'i' , $nuevafecha ));
        return $resutado;
    }


    
    static public function getSlug($cadena, $separador = '-')
{
// Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
$slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
$slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
$slug = strtolower(trim($slug, $separador));
$slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
return $slug;
}

static public function getDiaEspanol(){
    $r=array();
    $r[]="Domingo";    
    $r[]="Lunes";
    $r[]="Martes";
    $r[]="Miercoles";
    $r[]="Jueves";
    $r[]="Viernes";
    $r[]="Sabado";
    
    return $r;
}
static public function getDia($posicion){
    if($posicion==0){
        return "Lunes";
    }
    if($posicion==1){
        return "Martes";
    }
    if($posicion==2){
        return "Miercoles";
    }
    if($posicion==3){
        return "Jueves";
    }
    if($posicion==4){
        return "Viernes";
    }
    if($posicion==5){
        return "Sabado";
    }
    if($posicion==6){
        return "Domingo";
    }

}
static public function getMesEspanol(){
            $r=array();            
            $r[]="--";
            $r[]="Enero";
            $r[]="Febrero";
            $r[]="Marzo";
            $r[]="Abril";
            $r[]="Mayo";
            $r[]="Junio";
            $r[]="Julio";
            $r[]="Agosto";
            $r[]="Septiembre";
            $r[]="Octubre";
            $r[]="Noviembre";
            $r[]="Diciembre";
        
    return $r;
}
static public function setBackgroundColor($libro,$color,$columna){
    $libro->getActiveSheet()
                        ->getStyle("$columna")->applyFromArray(
                              array(
                                'fill' => array(
                                 'type' => "solid",
                                 'color' => array('rgb' => "$color")
            )
            )
            );
     
     
}
static public function setColor($libro,$color,$columna){
    $font=array(
    'font'    => array(
        'name'      => 'Arial',
        'size'        => 14,
        'bold'      => true,
        'italic'    => false,
        'underline' => false,
        'strike'    => false,
        'color'     => array(
            'rgb' => $color
        )
    ));
    $libro->getActiveSheet()->getStyle($columna)->applyFromArray($font);    
    
    
}
static public function getColumnaLetra($columna){
              $posicion=array(
         "A",
         "B",
         "C",
         "D",
         "E",
         "F",
         "G",
          "H",
          "I",
          "J",
          "K",
          "L",
          "M",
         "N",
         "O",
         "P",
         "Q",
         "R",
         "S",
         "T",
          "U",
          "V",
          "W",
          "X",
          "Y",
          "Z",
         "AA",
         "AB",
         "AC",
         "AD",
         "AE",
         "AF",
         "AG",
          "AH",
          "AI",
          "AJ",
          "AK",
          "AL",
          "AM",
         "AN",
         "AO",
         "AP",
         "AQ",
         "AR",
         "AS",
         "AT",
          "AU",
          "AV",
          "AW",
          "AX",
          "AY",
          "AZ",
         "BA",
         "BB",
         "BC",
         "BD",
         "BE",
         "BF",
         "BG",
          "BH",
          "BI",
          "BJ",
          "BK",
          "BL",
          "BM",
         "BN",
         "BO",
         "BP",
         "BQ",
         "BR",
         "BS",
         "BT",
          "BU",
          "BV",
          "BW",
          "BX",
          "BY",
          "BZ",
         "CA",
         "CB",
         "CC",
         "CD",
         "CE",
         "CF",
         "CG",
          "CH",
          "CI",
          "CJ",
          "CK",
          "CL",
          "CM",
         "CN",
         "CO",
         "CP",
         "CQ",
         "CR",
         "CS",
         "CT",
          "CU",
          "CV",
          "CW",
          "CX",
          "CY",
          "CZ",        
         "DA",
         "DB",
         "DC",
         "DD",
         "DE",
         "DF",
         "DG",
          "DH",
          "DI",
          "DJ",
          "DK",
          "DL",
          "DM",
         "DN",
         "DO",
         "DP",
         "DQ",
         "DR",
         "DS",
         "DT",
          "DU",
          "DV",
          "DW",
          "DX",
          "DY",
          "DZ",        
         "EA",
         "EB",
         "EC",
         "EE",
         "EE",
         "EF",
         "EG",
          "EH",
          "EI",
          "EJ",
          "EK",
          "EL",
          "EM",
         "EN",
         "EO",
         "EP",
         "EQ",
         "ER",
         "ES",
         "ET",
          "EU",
          "EV",
          "EW",
          "EX",
          "EY",
          "EZ"        
              
              
              
    );
    return $posicion[$columna];          
    
}
static public function getColorEstadares($posicion) {
    $colores=array('DEDEDE','BDB76B','F0FFF0','F5F5DC','DEB887','EAEAEA','DEDEDE','DEFFFF','CCCCCC','AAAAAA','ADADAD','EAEAEA');
    return $colores[$posicion];
    
}
static public function getColorCompObligatorios($posicion) {
    
    $colores=array('D9EDF7','3A87AD');
    $re= $colores[$posicion];
    if($posicion>2){
        $re='FEFEFE';
    }
    return$re;
    
}

}
?>
