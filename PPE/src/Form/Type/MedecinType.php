<?php

namespace PPE\Form\Type;
use PPE\Form\Type\MedecinType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Regex;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('id', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('nom', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('prenom', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('adresse', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('tel', TextType::class, array('attr'=> array('class'=>'form-control'), 'constraints' => new Regex("/^0[1-9][0-9]{8}$/")))
                ->add('specialitecomplementaire', TextType::class, array('required'  => false, 'attr'=> array('class'=>'form-control')))
                ->add('departement', NumberType::class, array('attr'=> array('class'=>'form-control')))
                ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-success')));
    }
}

