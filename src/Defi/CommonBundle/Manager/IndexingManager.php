<?php

namespace Defi\CommonBundle\Manager;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Indexing data
 *
 * @author sparrow
 */
class IndexingManager {
    
    private $container;
    private $em;

    public function __construct(Container $container) {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }
    
    public function indexContent ($content) {
        
    }
    
    public function optimizeIndex ($index) {
        
    }
    
}
