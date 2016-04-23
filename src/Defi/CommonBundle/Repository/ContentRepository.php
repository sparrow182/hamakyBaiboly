<?php

namespace Defi\CommonBundle\Repository;

/**
 * ContentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContentRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function findContent($bookId, $chapter, $verseStart, $verseEnd, $translationId = 3) {
        $qb = $this->getEntityManager()->createQueryBuilder('c');
        $qb
            ->select('c')
            ->from('DefiCommonBundle:Content', 'c')
            ->where($qb->expr()->eq('c.book', $bookId))
            ->andWhere($qb->expr()->eq('c.chapter', $chapter))
            ->andWhere($qb->expr()->between('c.verse', $verseStart, $verseEnd))
            ->andWhere($qb->expr()->eq('c.translation', $translationId));
        
        $query = $qb->getQuery();
        
        return $query->getResult();
                
    }
    
    
}
