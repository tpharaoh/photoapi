<?php
/**
 * PhotoViewCountController.php Created by TS for hanna
 * Email tim@live.fi
 * 23.3.2020 @ 14.38
 */

namespace App\Controller;


use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class PhotoViewCountController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    public function __invoke(Photo $data)
    {

        $data->setViewCount($data->getViewCount()+1);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return $data;
    }
}