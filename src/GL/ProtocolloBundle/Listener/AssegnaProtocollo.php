<?php

namespace GL\ProtocolloBundle\Listener;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\Event\LifecycleEventArgs;
use GL\ProtocolloBundle\Entity\Protocollo;

/**
 * Description of Protocollo
 *
 * @author luca
 */
class AssegnaProtocollo {

    public function prePersist(LifecycleEventArgs $args) {
        $protocollo = $args->getEntity();

        if ($protocollo instanceof Protocollo) {
            $em = $args->getEntityManager();
            if ($protocollo->getAnno() == date('Y') && $protocollo->getProtocollo() == 0) {
                $np = $em->getRepository('GLProtocolloBundle:Protocollo')
                        ->createQueryBuilder('p')
                        ->select('p.protocollo')
                        ->where('p.anno = :anno')
                        ->orderBy('p.protocollo', 'DESC')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->setParameter('anno', $protocollo->getAnno())
                        ->getOneOrNullResult();
                if ($np) {
                    $protocollo->setProtocollo($np['protocollo'] + 1);
                } else {
                    $protocollo->setProtocollo(1);
                }
            }
        }
    }

}

?>
