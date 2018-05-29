<?php

namespace PPE\Form\Type;
use PPE\Form\Type\GroupeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('date', DateType::class, array('attr'=> array('class'=>'form-control'), 'widget'=> 'single_text','format'=>'yyyy-MM-dd'))
                ->add('bilan', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('motif', ChoiceType::class, array('attr'=> array('class'=>'form-control'), 'choices'=>array('Demande du médecin'=> 'Demande du médecin', 'Installation'=> 'installation', 'Installation nouvelle' => 'Installation nouvelle', 'Installation récente'=> 'installation récente', 'Nouveau'=> 'nouveau', 'Prise de contact'=> 'Prise de contact', 'Recommandation de confrère'=> 'recommandation de confrère',  'Visite annuelle'=> 'Visite annuelle')))
                ->add('Visiteur', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('Medecin', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-success')));
    }
}
