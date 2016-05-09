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
class AddVerseFieldSubscriber implements EventSubscriberInterface {

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

    private function addVerseForm($form, $bookId = null, $chapterId = null, $verseStartIdx = null) {
        $verseStart = array();
        $verseEnd = array();

        if ($bookId !== null && $chapterId !== null) {
            $contentRepository = $this->em->getRepository('DefiCommonBundle:Content');
            $upperBoundVerse = $contentRepository->getUpperBoundVerse($bookId, $chapterId, $verseStartIdx);
            
            for ($i = 1; $i <= $upperBoundVerse; $i++) {
                $verseStart[$i] = $i;
            }

            if ($verseStartIdx) {
                for ($i = $verseStartIdx; $i <= $upperBoundVerse; $i++) {
                    $verseEnd[$i] = $i;
                }
            }
        }

        $form->add('verseStart', ChoiceType::class, array(
            'required' => false,
            'choices' => $verseStart,
            'placeholder' => '-- Andininy --',
            'label' => false
        ));

        $form->add('verseEnd', ChoiceType::class, array(
            'required' => false,
            'choices' => $verseEnd,
            'placeholder' => "-- Hatramin'ny --",
            'label' => false
        ));
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $bookId = null;
        $chapterId = null;

        if (null !== $data) {
            $accessor = PropertyAccess::createPropertyAccessor();
            $book = $accessor->getValue($data, $this->propertyPathToBook);
            $chapter = $accessor->getValue($data, 'chapter');

            if ($book) {
                $bookId = $book->getId();
            }

            if ($chapter) {
                $chapterId = $chapter->getId();
            }
        }

        $this->addVerseForm($form, $bookId, $chapterId);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        $bookId = array_key_exists('book', $data) ? $data['book'] : null;
        $chapterId = array_key_exists('chapter', $data) ? $data['chapter'] : null;
        $verseStart = array_key_exists('verseStart', $data) ? $data['verseStart'] : null;

        $this->addVerseForm($form, $bookId, $chapterId, $verseStart);
    }

}
