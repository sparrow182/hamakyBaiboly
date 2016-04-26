<?php

namespace Defi\CommonBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

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
        $searchResults = $contentRepository->findContent($bookId, $chapter, $verseStart, $verseEnd, $translationId);

        if (!empty($freeSearch)) {
            $searchResults = $this->searchInLuceneIndex($bookId, $chapter, $verseStart, $verseEnd, $translationId, $freeSearch);
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
    public function searchInLuceneIndex($freeSearch, $bookId, $chapter, $verseStart, $verseEnd, $translationId = 3) {
        
        
        return null;
    }

    /**
     * Get all book text by translation
     * @param type $translationId
     */
    public function getAllContents($translationId = 3) {
        $contentRepository = $this->em->getRepository('DefiCommonBundle:Content');
        $results = $contentRepository->findByTranslation($translationId, array('book' => 'asc'), 10);
        
        return $results;
    }

    
    /**
     * Extract token from given text
     * 
     * @param type $text
     * @param type $minTextLength
     */
    public function tokenize($text, $minTextLength = 3) {
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
