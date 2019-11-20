<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Correo', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('nombre', TextType::class, ['label' => 'Nombre completo', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('telmovil', TextType::class, ['label' => 'Telefono movil', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('edad', TextType::class, ['label' => 'Edad', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('pais', TextType::class, ['label' => 'Pais', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('ciudad', TextType::class, ['label' => 'Ciudad', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('monedasBitcoin', NumberType::class, ['label' => 'BTC', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('monedasMarketcoin', NumberType::class, ['label' => 'MLM', 'attr'  => ['class' => 'form-control form-control-lg']])
            ->add('vecesRecividas', NumberType::class, ['label' => 'Veces recibidas', 'attr'  => ['class' => 'form-control form-control-lg']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
