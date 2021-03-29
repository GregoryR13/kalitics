<?php

namespace App\Validator\Constraints;

use App\Repository\PointagesRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PointagesConstraintValidator extends ConstraintValidator
{

    /**
     * @var PointagesRepository
     */
    private $repository;

    /**
     * @param PointagesRepository $repository
     */
    public function __construct(PointagesRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof PointagesConstraint) {
            throw new UnexpectedTypeException($constraint, PointagesConstraint::class);
        }

        $user = $value->getUserId()->getId();
        $chantier = $value->getChantierId()->getId();
        $date = $value->getDatePointage()->format('Y-m-d');

        if($this->repository->findUserByDateAndChantier($user, $chantier, $date)) {
            $this->context->buildViolation($constraint->doublonMessage)
                ->addViolation()
            ;
        }
        
        $duree = $value->getDureePointage()->format('H:i');

        if($this->repository->findDureeByUserAndSemaine($user, $date, $duree)) {
            $this->context->buildViolation($constraint->overHoursMessage)
                ->addViolation()
            ;
        }

    }

}
