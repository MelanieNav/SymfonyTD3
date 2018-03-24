<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/03/2018
 * Time: 23:33
 */

namespace App\Repository;


use App\Entity\Story;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StoryRepository extends MainRepository{
    public function __construct(RegistryInterface $registry){
        parent::__construct($registry, Story::class);
    }
}