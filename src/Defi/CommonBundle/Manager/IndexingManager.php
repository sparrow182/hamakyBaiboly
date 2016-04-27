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
    
    public function stripPunctuation ($text) {
        $striped = preg_replace("/[^a-zA-Z 0-9]+/", " ", $text);
        
        return $striped;
    }
    
    public function numberToLetter($c){
        
        $letter = "";
        
        $c = intval($c);
        
        if ($c <= 0) { 
            return '';
        };

        while($c != 0){
           $p = ($c - 1) % 26;
           $c = intval(($c - $p) / 26);
           $letter = chr(65 + $p) . $letter;
        }

        return $letter;
    }
    
}
