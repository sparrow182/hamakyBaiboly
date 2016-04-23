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
        $this->em =  $container->get('doctrine.orm.entity_manager');
    }
    
    /**
     * Recherche d'une livre
     * 
     * @param type $bookId
     * @param type $chapter
     * @param type $verse
     * @param type $translationId
     */
    public function searchContent($bookId, $chapter, $verseStart, $verseEnd, $translationId = 3 ) {
        $contentRepository = $this->em->getRepository('DefiCommonBundle:Content');
        $searchResults = $contentRepository->findContent($bookId, $chapter, $verseStart, $verseEnd, $translationId);
        
        return $searchResults;
        
    }
    
}
