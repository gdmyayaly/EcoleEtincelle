<?php

namespace App\Controller;

use App\Entity\ParentEleves;
use App\Repository\ParentElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'app_api_parent_eleves')]

class ParentElevesController extends AbstractController
{
    #[Route('/parent_eleves', name: 'app_parent_eleves_list',methods:['GET'])]
    public function listParentEleves(ParentElevesRepository $parentElevesRepository,SerializerInterface $serializer): Response
    {
        $parents= $parentElevesRepository->findBy(['isDeleted'=>false]);
        $data = $serializer->serialize($parents, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/parent_eleves', name: 'app_parent_eleves_add',methods:['POST'])]
    public function createParentEleves(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        $img="";
        $defaultMen="";
        $defaultWomen="";
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        if ($data["isUpload"]=="true") {
            $sfile = $requestFile["image"];
            $img=$this->saveimage($sfile); 
        }
        else{
            if ($data["sex"]=="Masculin") {
                $img=$defaultMen;
            } else {
                $img=$defaultWomen;
            }
        }
        $parentEleves = new ParentEleves();
        $parentEleves->setPrenom($data["prenom"])
                     ->setNom($data["nom"])
                     ->setTelephone($data["telephone"])
                     ->setEmail($data["email"])
                     ->setAdresse($data["adresse"])
                     ->setProfession($data["profession"])
                     ->setImage($img)
                     ->setSex($data["sex"])
                     ->setCommentaire($data["commentaire"])
                     ->setDeleted(false);
        $entityManagerInterface->persist($parentEleves);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($parentEleves, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function saveimage($file){
        try {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->getParameter('chemin').'/', $fileName);
        return $fileName;
        } 
        catch (FileException $e) {
            throw $e;
        } 
    }
}
