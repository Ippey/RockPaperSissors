<?php
namespace App\Form;

use App\Entity\CpuResultLog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BattleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('myResult', ChoiceType::class, [
                'label' => 'じゃんけんの手を選んでください。',
                'required' => true,
                'choices'  => [
                    'グー'   => CpuResultLog::ID_ROCK,
                    'パー' => CpuResultLog::ID_PAPER,
                    'チョキ' => CpuResultLog::ID_SISSORS,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
