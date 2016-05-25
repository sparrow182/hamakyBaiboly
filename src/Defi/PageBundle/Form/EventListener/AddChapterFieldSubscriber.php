<?php

namespace Defi\PageBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Description of AddChapterFieldSubscriber
 *
 * @author sparrow
 */
class AddChapterFieldSubscriber implements EventSubscriberInterface {

    private $propertyPathToBook;
    private $em;

    public function __construct($propertyPathToBook, \Doctrine\ORM\EntityManager $em) {
        $this->propertyPathToBook = $propertyPathToBook;
        $this->em = $em;
    }

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addChapterForm($form, $bookId = null) {
        $chapters = array();

        if ($bookId) {
            $contentRepository = $this->em->getRepository('DefiCommonBundle:Content');
            $upperBoundChapter = $contentRepository->getUpperBoundChapter($bookId);
            
            for ($i=1; $i <= $upperBoundChapter; $i++) {
                $chapters[$i] = $i;
            }
        }


        $form->add('chapter', ChoiceType::class, array(
            'required' => false,
            'choices' => $chapters,
            'placeholder' => 'Toko',
            'label' => false
        ));
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $bookId = null;

        if (null !== $data) {
            $accessor = PropertyAccess::createPropertyAccessor();
            $book = $accessor->getValue($data, $this->propertyPathToBook);

            if ($book) {
                $bookId = $book->getId;
            }
        }

        $this->addChapterForm($form, $bookId);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        $bookId = array_key_exists('book', $data) ? $data['book'] : null;

        $this->addChapterForm($form, $bookId);
    }

}
