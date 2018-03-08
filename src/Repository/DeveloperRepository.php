<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 28/02/2018
 * Time: 09:42
 */

namespace App\Repository;


use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DeveloperRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Developer::class);
    }

    /**
     * @Route("developer/update/{id}", name="developer_update")
     */
    public function  update(Developer $developer)
    {
        $this->_em->persist($developer);
        $this->_em->flush();
    }
}