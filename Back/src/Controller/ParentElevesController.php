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
        // $defaultMen="";
        // $defaultWomen="";
        $defaultMen="default/father.jpg";
        $defaultWomen="default/mom.jpg";
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
        $parentEleves->setPrenom(trim($data["prenom"]))
                     ->setNom(trim($data["nom"]))
                     ->setTelephone(trim($data["telephone"]))
                     ->setEmail(trim($data["email"]))
                     ->setAdresse(trim($data["adresse"]))
                     ->setProfession(trim($data["profession"]))
                     ->setImage($img)
                     ->setSex(trim($data["sex"]))
                     ->setCommentaire(trim($data["commentaire"]))
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
    #[Route('/parent_eleves_detail/{id}', name: 'app_parent_eleves_detail',methods:['GET'])]
    public function detailOnParentEleves(int $id,ParentElevesRepository $parentElevesRepository,SerializerInterface $serializer): Response
    {
        $parents= $parentElevesRepository->findOneBy(['isDeleted'=>false,'id'=>$id]);
        $data = $serializer->serialize($parents, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/parent_eleves_update/{id}', name: 'app_parent_eleves_update',methods:['POST'])]
    public function updateOneParentEleves(int $id,ParentElevesRepository $parentElevesRepository,Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        $img="";
        // $defaultMen="";
        // $defaultWomen="";
        $defaultMen="default/father.jpg";
        $defaultWomen="default/mom.jpg";
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
        $parents= $parentElevesRepository->findOneBy(['isDeleted'=>false,'id'=>$id]);

        //$parents = new ParentEleves();
        $parents->setPrenom(trim($data["prenom"]))
                     ->setNom(trim($data["nom"]))
                     ->setTelephone(trim($data["telephone"]))
                     ->setEmail(trim($data["email"]))
                     ->setAdresse(trim($data["adresse"]))
                     ->setProfession(trim($data["profession"]))
                     ->setImage($img)
                     ->setSex(trim($data["sex"]))
                     ->setCommentaire(trim($data["commentaire"]))
                     ->setDeleted(false);
        $entityManagerInterface->persist($parents);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($parents, 'json', [
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
