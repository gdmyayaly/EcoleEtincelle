<?php

namespace App\Controller;

use App\Entity\AnneeScolaire;
use App\Entity\AnneeScolaireMensualite;
use App\Entity\NiveauEtude;
use App\Repository\AnneeScolaireRepository;
use App\Repository\NiveauEtudeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/scolarite', name: 'app_api_scolarite_configuration')]

class ScolariteConfigurationController extends AbstractController
{
    // ANNEE SCOLAIRE
    #[Route('/annee', name: 'app_scolarite_configuration_get',methods:['GET'])]
    public function listAnneeScolaire(AnneeScolaireRepository $anneeScolaireRepository,SerializerInterface $serializer): Response
    {
        $anneeScolaire= $anneeScolaireRepository->findAll();
        $data = $serializer->serialize($anneeScolaire, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/annee', name: 'app_scolarite_configuration_post',methods:['POST'])]
    public function saveAnneScolaire(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $anneeScolaire = new AnneeScolaire();
        $anneeScolaire->setMoisStart($data["moistart"])
                      ->setMoisEnd($data["moiend"])
                      ->setAnneeStart($data["startYears"])
                      ->setAnneeEnd($data["endYears"]);
        $entityManagerInterface->persist($anneeScolaire);
        $mouth=["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Décembre"]; 
        //$keyMois=(int) array_keys($mouth,$data["moistart"]);
        $keyMois =array_search($data["moistart"],$mouth);
        $txt="Inscription".$data["startYears"];
        $tabsMensualite=[$txt];
        for ($i=$keyMois; $i <count($mouth) ; $i++) { 
            array_push($tabsMensualite,$mouth[$i]." ".$data["startYears"]);
        }
        for ($i=0; $i < count($mouth); $i++) { 
           if ($data["moiend"]==$mouth[$i]) {
            // Dernier mois
            array_push($tabsMensualite,$mouth[$i]." ".$data["endYears"]);
            break;
           } else {
            array_push($tabsMensualite,$mouth[$i]." ".$data["endYears"]);
           }
           
        }
        for ($i=0; $i <count($tabsMensualite) ; $i++) { 
            $anneeScolaireMensualite = new AnneeScolaireMensualite();
            $anneeScolaireMensualite->setName($tabsMensualite[$i]);
            $anneeScolaireMensualite->setAnneeScolaire($anneeScolaire);
            $entityManagerInterface->persist($anneeScolaireMensualite);
        }
        $entityManagerInterface->flush();
        $data = $serializer->serialize($anneeScolaire, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }
    // NIVEAU ETUDE
    #[Route('/niveau-etude', name: 'app_niveau_etude_get',methods:['GET'])]
    function listNiveauEtude(NiveauEtudeRepository $niveauEtudeRepository,SerializerInterface $serializer) : Response {
        $niveauEtudes= $niveauEtudeRepository->findAll();
        $data = $serializer->serialize($niveauEtudes, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/niveau-etude', name: 'app_niveau_etude_post',methods:['POST'])]
    public function saveNiveauEtude(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $niveauEtude = new NiveauEtude();
        $niveauEtude->setNom(trim($data["nom"]))
                    ->setCommentaire(trim($data["commentaire"]));
        $entityManagerInterface->persist($niveauEtude);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($niveauEtude, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/niveau-etude_detail/{id}', name: 'app_niveau_etude_detail',methods:['GET'])]
    function detailOneNiveauEtude(int $id,NiveauEtudeRepository $niveauEtudeRepository,SerializerInterface $serializer) : Response {
        $niveauEtudes= $niveauEtudeRepository->find($id);
        $data = $serializer->serialize($niveauEtudes, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/niveau-etude_update/{id}', name: 'app_niveau_etude_update',methods:['POST'])]
    public function updateOneNiveauEtude(int $id,NiveauEtudeRepository $niveauEtudeRepository,Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $niveauEtude= $niveauEtudeRepository->find($id);
       // $niveauEtude = new NiveauEtude();
        $niveauEtude->setNom(trim($data["nom"]))
                    ->setCommentaire(trim($data["commentaire"]));
        // $entityManagerInterface->persist($niveauEtude);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($niveauEtude, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
}
