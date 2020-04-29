<?php


namespace App\Form\Items;


use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class ItemType extends AbstractType
{
    private const CAT_GENRE_ID = 2;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('is_visible', CheckboxType::class, [
                'label' => 'Public',
                'attr' => [
                    'class' => 'switch',
                    'checked' => 'checked'
                ]
            ])
            ->add('image_cover', FileType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('image_large', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Categories',
                'multiple' => true,
                'expanded' => true,
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.is_active = true')
                        ->join(
                            'c.parent',
                            'cp',
                            Join::WITH,
                            "cp.id = " . self::CAT_GENRE_ID
                        )
                        ->orderBy('c.name', 'ASC');
                },
            ])
        ;
    }
}