<?php

namespace App\Form;

use App\Entity\BankTransaction;
use App\Entity\BankTransactionPart;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BankTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('bookingDate', TextType::class, [
                'by_reference' => false
            ])
            ->add('bankTransactionParts', CollectionType::class, [
                'entry_type' => BankTransactionPartType::class,
                'by_reference' => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'error_bubbling'=> false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BankTransaction::class
        ]);
    }
}
