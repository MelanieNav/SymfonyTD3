<?php
/**
 * Created by PhpStorm.
 * User: navea
 * Date: 21/03/2018
 * Time: 13:38
 */

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Step;

class StepRepository extends MainRepository{
    public function __construct(RegistryInterface $registry){
        parent::__construct($registry, Step::class);
    }
}