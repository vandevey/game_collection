<?php


namespace App\Form\Ad;


use App\Form\ItemAdType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RequestType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemAd', ItemAdType::class)
            ->add('itemName', TextType::class)
            ->add('itemDescription', TextareaType::class)
            ->add('minPrice', MoneyType::class, [
                'required' => true,
                'divisor' => 100,
            ])
            ->add('maxPrice', MoneyType::class, [
                'required' => false,
                'divisor' => 100,
            ])
            ->add('submit', SubmitType::class)
            ;
    }

}