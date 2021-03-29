<?php

namespace App\Form;

use App\Entity\Chantiers;
use App\Entity\Pointages;
use App\Entity\Users;
use App\Repository\ChantiersRepository;
use App\Repository\UsersRepository;
use App\Validator\Constraints\PointagesConstraint;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointagesFormType extends AbstractType
{

    private $chantiersRepository;
    private $usersRepository;

    public function __construct(ChantiersRepository $chantiersRepository, UsersRepository $usersRepository)
    {
        $this->chantiersRepository = $chantiersRepository;
        $this->usersRepository = $usersRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('userId',  EntityType::class, [
                'label' => 'Utilisateurs',
                'placeholder'  => 'Choisissez un utilisateur',
                'class' => Users::class,
                'choice_label' => 'identite',
            ])

           ->add('chantierId',  EntityType::class, [
               'label' => 'Chantier',
               'placeholder'  => 'Choisissez un chantier',
               'class' => Chantiers::class,
               'choice_label' => 'nom',
           ])

            ->add('datePointage', DateType::class, [
                'format' => 'dd/MM/yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('dureePointage', TimeType::class, [
                'placeholder' => [
                    'hour' => 'Heures', 'minute' => 'Minutes',
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pointages::class,
            'constraints' => [
                new PointagesConstraint(/*[
                    'notBlankDateMessage'    => 'test',
                    'notBlankPeriodeMessage' => $this->translator->trans('salarie.demande.form.fail-blank-periode'),
                    'startToCloseMessage'    => $this->translator->trans('salarie.demande.form.fail-prevenance'),
                    'tooLongMessage'         => $this->translator->trans('salarie.demande.form.fail-consecutif'),
                    'overlapMessage'         => $this->translator->trans('salarie.demande.form.fail-chevauchement'),
                ]*/),
            ]
        ]);
    }
}
