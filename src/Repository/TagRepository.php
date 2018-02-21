<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/02/2018
 * Time: 09:31
 */

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Tag;

class TagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tag::class);
    }
    /**
     * @Route("tag/update/{id}", name="tag_update")
     */
    public function update(Tag $tag){
        $this->_em->persist($tag);
        $this->_em->flush();
    }

}