<?php


namespace App\Form\Ad;


use App\Entity\Category;
use App\Form\ItemAdType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RequestType extends AbstractType
{
    /** @var integer */
    private $cat_genre_id;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->cat_genre_id = $parameterBag->get('cat_genre');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemAd', ItemAdType::class)
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
                            "cp.id = " . $this->cat_genre_id
                        )
                        ->orderBy('c.name', 'ASC');
                },
            ])
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