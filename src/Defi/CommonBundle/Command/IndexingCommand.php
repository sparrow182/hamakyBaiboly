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
class IndexingCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
            ->setName('system:indexing')
            ->setDescription('Indexing datas')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();
        $searchManager = new \Defi\CommonBundle\Manager\SearchMananger($container);
        $output->writeln("Getting all text to index ...");
        $contentsToIndex = $searchManager->getAllContents();
        $output->writeln(sprintf("%s contents found", count($contentsToIndex)));
        $output->writeln("Indexing contents ...");
        $indexingManager = new \Defi\CommonBundle\Manager\IndexingManager($container);
        $luceneSearch = $this->getContainer()->get('ivory_lucene_search');
        $luceneSearch->eraseIndex("contentTest");
        // Request an index
        $index = $this->getContainer()->get('ivory_lucene_search')->getIndex('contentTest');
        
        $commitSize = 100;
        $counter = 1;
        // create a new progress bar (50 units)
        $progress = new ProgressBar($output, count($contentsToIndex));
        // start and displays the progress bar
        $progress->start();

        foreach ($contentsToIndex as $content) {
            // Create a new document
            $document = new Document();
            $document->addField(Field::keyword('contentId', $content->getId()));
            $document->addField(Field::keyword('partId', $content->getBook()->getPart()->getId()));
            $document->addField(Field::keyword('bookId', $content->getBook()->getId()));
            $document->addField(Field::keyword('translationId', $content->getTranslation()->getId()));
            $document->addField(Field::keyword('chapter', $content->getChapter()));
            $document->addField(Field::keyword('verse', $content->getVerse()));
            $text = $content->getText();
            $document->addField(Field::unIndexed('text', $text));
            $optimizedText = $indexingManager->stripPunctuation($text);
            $document->addField(Field::text('optimizedText', $optimizedText));
            $index->addDocument($document);
            $index->commit();

            // advance the progress bar 1 unit
            $progress->advance();
        }

        $index->optimize();
        // ensure that the progress bar is at 100%
        $progress->finish();

        $output->writeln("End of indexing");
    }
    
}
