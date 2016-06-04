<?php

namespace Defi\PageBundle\Controller;

use Defi\CommonBundle\Controller\CommonController;
use Defi\PageBundle\Type\BibleSearchType;
use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify;

class MainController extends CommonController {

    /**
     * Search subdivision, chapter and verse in bible
     *
     * @return type
     */
    public function indexAction(Request $request) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $bibleSearchType = new BibleSearchType($em);
        $formSearch = $this->get('form.factory')->create($bibleSearchType, null, array('action' => $this->generateUrl('defi_page_search')));
        $formSearch->handleRequest($request);
        $this->redirectToSearchPage($request, $formSearch);
        $this->viewParams['formSearch'] = $formSearch->createView();
        $this->viewParams['formData'] = $formSearch->getData();

        return $this->render('DefiPageBundle:Main:index.html.twig', $this->viewParams);
    }
    
    public function searchAction(Request $request) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $bibleSearchType = new BibleSearchType($em);
        $formSearch = $this->get('form.factory')->create($bibleSearchType, null, array('action' => $this->generateUrl('defi_page_search')));
        $formSearch->handleRequest($request);
        
        return $this->redirectToSearchPage($request, $formSearch);
    }
    
    /**
     *  Bible search page 
     * 
     * @param Request $request
     */
    public function bibleSearchResultAction($bookName, $bookId, $chapter = 0, $verseStart = 0, $verseEnd = 0) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $request = Request::createFromGlobals();
        
        $freeSearch = $request->query->get('s');
        $searchManager = new \Defi\CommonBundle\Manager\SearchMananger($this->container);
        $searchResults = $searchManager->searchContent($bookId, $chapter, $verseStart, $verseEnd, 3, $freeSearch);
        $bibleSearchType = new BibleSearchType($em);
        $formSearch = $this->get('form.factory')->create($bibleSearchType, null, array('action' => $this->generateUrl('defi_page_search')));
        $formSearch->handleRequest($request);
        $bookRepository = $em->getRepository("DefiCommonBundle:Book");
        $book = $bookRepository->find($bookId);
        
        $this->viewParams['formSearch'] = $formSearch->createView();
        $this->viewParams['formData'] = $formSearch->getData();
        $this->viewParams['searchResults'] = $searchResults;
        $this->viewParams['book'] = $book;
        $this->viewParams['chapter'] = $chapter;
        $this->viewParams['verseStart'] = $verseStart;
        $this->viewParams['verseEnd'] = $verseEnd;
        $this->viewParams['freeSearch'] = $freeSearch;
        
        return $this->render('DefiPageBundle:Main:searchResults.html.twig', $this->viewParams);
    }
    
    
    private function redirectToSearchPage (Request $request, $formSearch) {
        
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $data = $formSearch->getData();
            $bookId = $data['book'] ? $data['book']->getId() : null;
            $slugify = new Slugify();
            $bookName = $data['book'] ? $data['book']->getNameMg() : 'boky';
            $bookName = $slugify->slugify($bookName);
            $chapter = $data['chapter'] ? $data['chapter'] : 0;
            $verseStart = isset($data['verseStart']) ? $data['verseStart'] : 0;
            $verseEnd = isset($data['verseEnd']) ? $data['verseEnd'] : 0;
            $translationId = isset($data['translation']) ? $data['translation']->getId() : 3;
            $searchManager = new \Defi\CommonBundle\Manager\SearchMananger($this->container);
            $freeSearch = isset($data['freeSearch']) ? $data['freeSearch'] : '';
            
            $urlParams = array();
            $urlParams['bookName'] = $bookName;
            $urlParams['bookId'] = $bookId ? : 0;
            $urlParams['chapter'] = $chapter;
            $urlParams['verseStart'] = $verseStart;
            $urlParams['verseEnd'] = $verseEnd;
            
            if (!empty($freeSearch)) {
                $urlParams['s'] = $freeSearch;
            }
            
            $searchResultURL = $this->generateUrl('defi_page_bible_search_results', $urlParams);
            
            return $this->redirect($searchResultURL);
            
        }
    }

}
