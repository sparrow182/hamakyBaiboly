<?php

namespace Defi\PageBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


/**
 * Holy Bible search Form
 *
 * @author dera.andrian <ared09@gmail.com>
 */
class BibleSearchType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
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
            ))
            ->add('chapter', ChoiceType::class, array(
                'required' => false
            ))
            ->add('verseStart', ChoiceType::class, array(
                'required' => false
            ))
            ->add('verseEnd', ChoiceType::class, array(
                'required' => false
            ))
            ->add('freeSearch', TextType::class, array(
                'required' => false
            ))
            ->add('search', SubmitType::class);
        
    }
    
}
