<?php

namespace Defi\PageBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Defi\PageBundle\Form\EventListener\AddChapterFieldSubscriber;
use Defi\PageBundle\Form\EventListener\AddVerseFieldSubscriber;
/**
 * Holy Bible search Form
 *
 * @author dera.andrian <ared09@gmail.com>
 */
class BibleSearchType extends AbstractType {
    
    private $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
//            ->add('translation', EntityType::class, array(
//                'class' => 'DefiCommonBundle:Translation',
//                'choice_label' => 'title',
//                'required' => false
//            ))
            ->add('book', EntityType::class, array(
                'class' => 'DefiCommonBundle:Book',
                'choice_label' => 'nameMg',
                'required' => false
        ));

        $propertyPathToBook = 'book';

        $builder
            ->addEventSubscriber(new AddChapterFieldSubscriber($propertyPathToBook, $this->em))
            ->addEventSubscriber(new AddVerseFieldSubscriber($propertyPathToBook, $this->em))
        ;
        
        $builder
            ->add('freeSearch', TextType::class, array(
                'required' => false
            ))
            ->add('search', SubmitType::class);
//        
    }

}
