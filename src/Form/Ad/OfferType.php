<?php


namespace App\Form\Ad;


use App\Entity\Item;
use App\Entity\User;
use App\Form\ItemAdType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OfferType extends AbstractType
{
    /** @var User  */
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemAd', ItemAdType::class)
            ->add('price', MoneyType::class, [
                'divisor' => 100,
            ])
            ->add('item', EntityType::class, [
                'label' => 'Item',
                'multiple' => false,
                'expanded' => true,
                'class' => Item::class,
                'choice_label' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->where('i.is_visible = true')
                        ->join('i.author', 'a', Join::WITH, 'a.id = ' . $this->user->getId() )
                        ->leftJoin('i.offer','o')
                        ->having('COUNT(o.id) = 0')
                        ->groupBy('i.id, i.name')
                        ->orderBy('i.name', 'ASC');
                },
            ])
            ->add('submit', SubmitType::class)
            ;
    }
}