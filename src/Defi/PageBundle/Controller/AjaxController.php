<?php

namespace Defi\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * AjaxController
 *
 * @author sparrow
 */
class AjaxController extends Controller {
    
    public function loadingChaptersByBookAction($bookId) {
        
        $em = $this->getDoctrine()->getManager();
        $contentRepository = $em->getRepository('DefiCommonBundle:Content');
        $upperChapter = $contentRepository->getUpperBoundChapter($bookId);
        
        return $this->render('DefiPageBundle:Ajax:chaptersByBook.html.twig', array(
            'upperBound' => $upperChapter
        ));
        
    }
    
}
