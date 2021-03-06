<?php

namespace Defi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Defi\PageBundle\Type\BibleSearchType;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    
    /**
     * Search subdivision, chapter and verse in bible
     * 
     * @return type
     */
    public function indexAction(Request $request)
    {
        
        $formSearch = $this->get('form.factory')->create(BibleSearchType::class);
        
        $formSearch->handleRequest($request);
        $searchResults = array();
        
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            // Searching ...
            $data = $formSearch->getData();
            $searchManager = new \Defi\CommonBundle\Manager\SearchMananger($this->container);
            $bookId = $data['book']->getId();
            $chapter = $data['chapter'];
            $verseStart = $data['verseStart'];
            $verseEnd = $data['verseEnd'];
            $translationId = $data['translation']->getId();
            $translationId = 3;
            
            $searchResults = $searchManager->searchContent($bookId, $chapter, $verseStart, $verseEnd, $translationId);
        }
        
        return $this->render('DefiPageBundle:Main:index.html.twig', array(
            'formSearch' => $formSearch->createView(),
            'searchResults' => $searchResults
        ));
    }
    
}
