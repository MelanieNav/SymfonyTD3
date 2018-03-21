<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/03/2018
 * Time: 15:31
 */

namespace App\Repository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Task;

class TaskRepository extends MainRepository{
    public function __construct(RegistryInterface $registry){
        parent::__construct($registry, Task::class);
    }
}