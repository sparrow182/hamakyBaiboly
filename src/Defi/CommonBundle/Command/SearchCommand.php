<?php

namespace Defi\CommonBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Indexing data
 *
 * @author sparrow
 */
class SearchCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
            ->setName('system:search')
            ->setDescription('Search from index')
            ->addArgument('search-text', InputArgument::REQUIRED, 'The search text')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();
//        $searchManager = new \Defi\CommonBundle\Manager\SearchMananger($container);
        
        $searchText =  $name = $input->getArgument('search-text');
        
        $query = new \ZendSearch\Lucene\Search\Query\Boolean();
        
        $subquery1 = new \ZendSearch\Lucene\Search\Query\MultiTerm();
        $subquery1->addTerm(new \ZendSearch\Lucene\Index\Term(1, 'bookId'), true);
        $subquery1->addTerm(new \ZendSearch\Lucene\Index\Term(5, 'verse'), true);
        
        $searchManager = new \Defi\CommonBundle\Manager\SearchMananger($container);
        $tokenizedText = $searchManager->tokenize($searchText);
        $subquery2 = new \ZendSearch\Lucene\Search\Query\Phrase($tokenizedText, null, 'text');
        $subquery2->setSlop(2);
        
        $query->addSubquery($subquery1, true);
        $query->addSubquery($subquery2, true);
        
        $hits = $this->getContainer()->get('ivory_lucene_search')->getIndex('contentTest')->find($query);
            
        foreach ($hits as $hit) {
            $output->write($hit->contentId."-");
            $output->write($hit->chapter."-");
            $output->write($hit->verse.":");
            $output->writeln($hit->text);
        }
        
    }
    
}
