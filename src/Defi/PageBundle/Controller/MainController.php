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
        $em = $this->container->get('doctrine.orm.entity_manager');
        $bibleSearchType = new BibleSearchType($em);
        $formSearch = $this->get('form.factory')->create($bibleSearchType);
        $formSearch->handleRequest($request);
        $searchResults = array();

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            // Searching ...
            $data = $formSearch->getData();
            $searchManager = new \Defi\CommonBundle\Manager\SearchMananger($this->container);
            $bookId = $data['book'] ? $data['book']->getId() : null;
            $chapter = $data['chapter'];
            $verseStart = isset($data['verseStart']) ? $data['verseStart'] : null;
            $verseEnd = isset($data['verseEnd']) ? $data['verseEnd'] : null;
            $translationId = isset($data['translation']) ? $data['translation']->getId() : 3;
            $translationId = 3;
            $freeSearch = isset($data['freeSearch']) ? $data['freeSearch'] : '';
            $searchResults = $searchManager->searchContent($bookId, $chapter, $verseStart, $verseEnd, $translationId, $freeSearch);
        }

        return $this->render('DefiPageBundle:Main:index.html.twig', array(
                'formSearch' => $formSearch->createView(),
                'searchResults' => $searchResults,
                'formData' => $formSearch->getData()
        ));
    }

}
