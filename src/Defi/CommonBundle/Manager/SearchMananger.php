<?php

namespace Defi\CommonBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;

/**
 * SearchMananger
 *
 * @author sparrow
 */
class SearchMananger {

    private $container;
    private $em;

    public function __construct(Container $container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    /**
     * Recherche d'une livre
     * 
     * @param type $bookId
     * @param type $chapter
     * @param type $verse
     * @param type $translationId
     */
    public function searchContent($bookId, $chapter, $verseStart, $verseEnd, $translationId = 3, $freeSearch = "") {
        $contentRepository = $this->em->getRepository('DefiCommonBundle:Content');

        if (!empty($freeSearch)) {
            $searchResults = $this->searchInLuceneIndex($freeSearch, $bookId, $chapter, $verseStart, $verseEnd, $translationId);
        } else {
            $searchResults = $contentRepository->findContent($bookId, $chapter, $verseStart, $verseEnd, $translationId);
        }

        return $searchResults;
    }

    /**
     * Make search in lucene index
     * 
     * @param type $bookId
     * @param type $chapter
     * @param type $verseStart
     * @param type $verseEnd
     * @param type $translationId
     * @param type $freeSearch
     */
    public function searchInLuceneIndex($freeSearch, $bookId = null, $chapter = null, $verseStart = null, $verseEnd = null, $translationId = 3) {
        $query = new \ZendSearch\Lucene\Search\Query\Boolean();
        
        $subquery1 = new \ZendSearch\Lucene\Search\Query\MultiTerm();
        
        if ($translationId) {
            $subquery1->addTerm(new \ZendSearch\Lucene\Index\Term($translationId, 'translationId'), true);
        }
        
        if ($bookId) {
            $subquery1->addTerm(new \ZendSearch\Lucene\Index\Term($bookId, 'bookId'), true);
        }
        
        if ($verseStart && !$verseEnd) {
            $subquery1->addTerm(new \ZendSearch\Lucene\Index\Term($verseStart, 'verse'), true);
        } else if ($verseEnd && $verseStart) {
            $indexingManger = new IndexingManager($this->container);
            $verseStartIdx = $indexingManger->numberToLetter($verseStart);
            $verseEndIdx = $indexingManger->numberToLetter($verseEnd);
            $from = new \ZendSearch\Lucene\Index\Term($verseStartIdx, 'verseIdx');
            $to = new \ZendSearch\Lucene\Index\Term($verseEndIdx, 'verseIdx');
            $queryRange = new \ZendSearch\Lucene\Search\Query\Range($from, $to, true);
            $query->addSubquery($queryRange, true);
        }
        
        $tokenizedText = $this->tokenize($freeSearch);
        $subquery2 = new \ZendSearch\Lucene\Search\Query\Phrase($tokenizedText, null, 'optimizedText');
        $subquery2->setSlop(50);
        $query->addSubquery($subquery1, true);
        $query->addSubquery($subquery2, true);
        $hits = $this->container->get('ivory_lucene_search')->getIndex('contentTest')->find($query);
        $contentIds = array();
        
        foreach ($hits as $hit) {
            $contentIds[] = $hit->contentId ;
        }
        
        $searchResults = array();
        
        if (count($contentIds) > 0) {
            $contentRepository = $this->em->getRepository('DefiCommonBundle:Content');
            $searchResults = $contentRepository->findContentByIds($contentIds);
        }
        
        return $searchResults;
    }

    /**
     * Get all book text by translation
     * @param type $translationId
     */
    public function getAllContents($translationId = 3) {
        $contentRepository = $this->em->getRepository('DefiCommonBundle:Content');
        
        $results = $contentRepository->findByTranslation($translationId, array('book' => 'asc'), 100);
        
        return $results;
    }

    
    /**
     * Extract token from given text
     * 
     * @param type $text
     * @param type $minTextLength
     */
    public function tokenize($text, $minTextLength = 3) {
        $text = preg_replace("/[^a-zA-Z 0-9]+/", " ", $text);
        $tokens = explode(" ", $text);
        $results = array();
        
        foreach ($tokens as $token) {
            
            if (strlen($token) >= $minTextLength) {
                $token = strtolower($token);
                $results[] = $token;
            }
            
        }
        
        return $results;
    }
    
}
