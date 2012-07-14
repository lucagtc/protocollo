<?php

namespace GL\ProtocolloBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GL\ProtocolloBundle\Entity\Protocollo;

/**
 * ProtocolloRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProtocolloRepository extends EntityRepository {

    /**
     * Salva un protocollo e se l'anno è il corrente e protocollo=0
     * allora assegna il numero di protocollo sucessivo all'ultimo
     *
     * @var Protocollo $protocollo
     *
     * @return Protocollo
     */
    public function persist(Protocollo $protocollo) {
        $anno = date('Y');

        if ($protocollo->getAnno() == $anno && $protocollo->getProtocollo() == 0) {

            $np = $this->getEntityManager()
                    ->getRepository('GLProtocolloBundle:Protocollo')
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

        $this->getEntityManager()->persist($protocollo);

        return $protocollo;
    }

}