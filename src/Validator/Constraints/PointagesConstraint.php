<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class PointagesConstraint extends Constraint {
    
    public $doublonMessage = 'Cet utilisateur a déjà été pointé sur ce chantier pour cette journée.';
    public $overHoursMessage = 'Cet utilisateur ne peut pas dépasser les 35H pour cette semaine.';
}
