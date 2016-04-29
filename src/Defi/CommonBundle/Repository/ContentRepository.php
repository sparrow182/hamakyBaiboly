<?php

namespace Defi\CommonBundle\Repository;

/**
 * ContentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContentRepository extends \Doctrine\ORM\EntityRepository {


    /**
     * Find content by criterias
     *
     * @param type $bookId
     * @param type $chapter
     * @param type $verseStart
     * @param type $verseEnd
     * @param type $translationId
     * @return type
     */
    public function findContent($bookId, $chapter, $verseStart, $verseEnd, $translationId = 3)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('c');
        $qb
            ->select('c')
                ->from('DefiCommonBundle:Content', 'c');

        if ($bookId) {
            $qb->where($qb->expr()->eq('c.book', $bookId));
        }

        if ($chapter) {
            $qb->andWhere($qb->expr()->eq('c.chapter', $chapter));
        }

        if ($verseStart && !$verseEnd) {
            $qb->andWhere($qb->expr()->eq('c.verse', $verseStart));
        } else if ($verseStart && $verseEnd) {
            $qb->andWhere($qb->expr()->between('c.verse', $verseStart, $verseEnd));
        }

        $qb->andWhere($qb->expr()->eq('c.translation', $translationId));
        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * Find content by given ids
     * @param array $contentIds
     */
    public function findContentByIds(array $contentIds)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('c');
        $qb
            ->select('c')
            ->from('DefiCommonBundle:Content', 'c')
            ->where($qb->expr()->in('c.id', $contentIds));

        $query = $qb->getQuery();

        return $query->getResult();
    }

    
    public function getUpperBoundChapter($bookId) {
        $qb = $this->createQueryBuilder('c');
        $qb
                ->select('MAX(c.chapter) AS upper_chapter')
                ->where($qb->expr()->eq('c.book', ':bookId'))
                ->setParameter('bookId', $bookId);

        return $qb->getQuery()->getSingleScalarResult();
}

}
