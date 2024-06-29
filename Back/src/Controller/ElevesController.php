<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\ElevesAnneScolaire;
use App\Entity\ParentsElevesLink;
use App\Repository\AnneeScolaireRepository;
use App\Repository\ElevesRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\ParentElevesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'app_api_eleves')]

class ElevesController extends AbstractController
{
    // #[Route('/eleves', name: 'app_eleves',methods:['GET'])]
    // public function index(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/ElevesController.php',
    //     ]);
    // }
    #[Route('/eleves', name: 'app_eleves_list',methods:['GET'])]
    public function listParentEleves(ElevesRepository $elevesRepository,SerializerInterface $serializer): Response
    {
        $parents= $elevesRepository->findBy(['isDeleted'=>false]);
        $data = $serializer->serialize($parents, 'json', [
            'groups' => ['eleves']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/eleves', name: 'app_eleves_add',methods:['POST'])]
    public function createParentEleves(AnneeScolaireRepository $anneeScolaireRepository,NiveauEtudeRepository $niveauEtudeRepository,ParentElevesRepository $parentElevesRepository,Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
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
        $eleves = new Eleves();
        $eleves->setPrenom($data["prenom"])
               ->setNom($data["nom"])
               ->setAge($data["age"])
               ->setDateDeNaissance($data["date"])
               ->setImage($img)
               ->setSex($data["sex"])
               ->setDeleted(false)
               ->setCommentaire($data["commentaire"])
               ->setDeleted(false);
        $entityManagerInterface->persist($eleves);
        $splitParent = explode(",",$data["parents"]);
        for ($i=0; $i <count($splitParent) ; $i++) { 
            $parent=$parentElevesRepository->find($splitParent[$i]);
            $parentElevesLink = new ParentsElevesLink();
            $parentElevesLink->setEleves($eleves)
                             ->setParents($parent);
            $entityManagerInterface->persist($parentElevesLink);
        }
        $niveauEtude= $niveauEtudeRepository->find($data["niveauEtude"]);
        $anneScolaire=$anneeScolaireRepository->find($data["anneeScolaire"]);
        $anneeAcademique= new ElevesAnneScolaire();
        $anneeAcademique->setEleves($eleves)
                        ->setAnneeScolaire($anneScolaire)
                        ->setNiveauEtude($niveauEtude);
        $entityManagerInterface->persist($anneeAcademique);    
        $entityManagerInterface->flush();
        $data = $serializer->serialize($eleves, 'json', [
            'groups' => ['eleves']
        ]);
        return new Response($data, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/eleves/detail/{id}', name: 'app_eleves_detail',methods:['GET'])]
    public function detailOneEleves(int $id,ElevesRepository $elevesRepository,SerializerInterface $serializer): Response
    {
        $parents= $elevesRepository->find($id);
        $data = $serializer->serialize($parents, 'json', [
            'groups' => ['eleves']
        ]);
        return new Response($data, Response::HTTP_OK, [
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
