<?php

namespace Defi\PageBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

/**
 * Holy Bible search Form
 *
 * @author dera.andrian <ared09@gmail.com>
 */
class BibleSearchType extends AbstractType
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('translation', EntityType::class, array(
                'class' => 'DefiCommonBundle:Translation',
                'choice_label' => 'title',
                'required' => false
            ))
            ->add('book', EntityType::class, array(
                'class' => 'DefiCommonBundle:Book',
                'choice_label' => 'nameMg',
                'required' => false
        ));

        $formModifier = function(FormInterface $form, \Defi\CommonBundle\Entity\Book $book) {
            $chapters = array(1, 2, 3, 4, 5);

            $form->add('chapter', ChoiceType::class, array(
                'required' => false,
                'choices' => $chapters
            ));
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($formModifier) {
            $data = $event->getData();
            $book = $data ? $data->getData() : new \Defi\CommonBundle\Entity\Book();
            $formModifier($event->getForm(), $book);
        });

        $builder->get('book')->addEventListener(
            FormEvents::POST_SUBMIT, function(FormEvent $event) use ($formModifier) {
            // Il est important de récupérer ici $event->getForm()->getData(),
            // car $event->getData() vous renverra la données initiale (vide)
            $book = $event->getForm()->getData();

            // puisque nous avons ajouté l'écouteur à l'enfant, il faudra passer
            // le parent aux fonctions de callback!
            $formModifier($event->getForm()->getParent(), $book);
        });


//            ->add('chapter', ChoiceType::class, array(
//                'required' => false
//            ))
//            ->add('verseStart', ChoiceType::class, array(
//                'required' => false
//            ))
//            ->add('verseEnd', ChoiceType::class, array(
//                'required' => false
//            ))


        $builder
            ->add('freeSearch', TextType::class, array(
                'required' => false
            ))
            ->add('search', SubmitType::class);
    }

}
