<?php

namespace Netpublic\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Netpublic\CoreBundle\Entity\Profesor;

/**
 * HorarioProfesorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HorarioProfesorRepository extends EntityRepository
{
    public function getHorasSemanalesProfesor($profesor_id){
        $horarios_profesor=$this->findBy(array('profesor'=>$profesor_id,'es_disponible'=>FALSE));
        return 1;
    }
}