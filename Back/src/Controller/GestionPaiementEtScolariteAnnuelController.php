<?php

namespace App\Controller;

use App\Entity\PaiementNiveauEtudeAnneeScolaire;
use App\Entity\PaiementScolariteEleves;
use App\Repository\AnneeScolaireMensualiteRepository;
use App\Repository\AnneeScolaireRepository;
use App\Repository\ElevesRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\PaiementNiveauEtudeAnneeScolaireRepository;
use App\Repository\PaiementScolariteElevesRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/gestion_paiement', name: 'app_gestion_paiement_et_scolarite_annuel')]

class GestionPaiementEtScolariteAnnuelController extends AbstractController
{
    #[Route('/verification/{id}', name: 'app_gestion_paiement_et_scolarite_annuel-verification-niveauEtude',methods:['GET'])]
    public function verificationPaiementNiveauEtude(int $id,PaiementNiveauEtudeAnneeScolaireRepository $paiementNiveauEtudeAnneeScolaireRepository,SerializerInterface $serializer): Response
    {
        $verif=$paiementNiveauEtudeAnneeScolaireRepository->findBy(['niveauEtude'=>$id]);
        $data = $serializer->serialize($verif, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/saveplanningpaiementscolaire', name: 'app_gestion_paiement_et_scolarite_annuel-savefacturation-niveauEtude',methods:['POST'])]
    function saveDataPaiementMensuelScolarite(AnneeScolaireRepository $anneeScolaireRepository,Request $request,NiveauEtudeRepository $niveauEtudeRepository,AnneeScolaireMensualiteRepository $anneeScolaireMensualiteRepository,EntityManagerInterface $entityManagerInterface) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $anneeScolaire=$anneeScolaireRepository->find($data['anneeScolaire']);
        $allMensualite=$anneeScolaireMensualiteRepository->findBy(['anneeScolaire'=>$anneeScolaire]);
        $niveauEtude=$niveauEtudeRepository->find($data['niveauEtude']);
        for ($i=0; $i <count($allMensualite) ; $i++) { 
            $txt="paiement".$allMensualite[$i]->getId();
            $paiementNiveauEtudeAnneeScolaire= new PaiementNiveauEtudeAnneeScolaire();
            $paiementNiveauEtudeAnneeScolaire->setNiveauEtude($niveauEtude)
                                             ->setAnneeScolaire($anneeScolaire)
                                             ->setMensualite($allMensualite[$i])
                                             ->setMontant($data[$txt]);
            $entityManagerInterface->persist($paiementNiveauEtudeAnneeScolaire);
        }
        $entityManagerInterface->flush();
        $data = [
            "message"=>"Création success"
        ];
        return new JsonResponse($data, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/verificationpaiement/{anneeScolaire}/{eleve}', name: 'app_gestion_paiement_et_scolarite_annuel-verification-paiement',methods:['GET'])]
    public function listElevesAnneeScolaire(int $anneeScolaire,int $eleve,PaiementNiveauEtudeAnneeScolaireRepository $paiementNiveauEtudeAnneeScolaireRepository,PaiementScolariteElevesRepository $paiementScolariteElevesRepository,SerializerInterface $serializer): Response
    {
        $paiementList=$paiementNiveauEtudeAnneeScolaireRepository->findBy(['anneeScolaire'=>$anneeScolaire]);
        $paiementEleves=$paiementScolariteElevesRepository->findBy(['eleves'=>$eleve]);
        $dataPaiementList = $serializer->serialize($paiementList, 'json', [
            'groups' => ['list']
        ]);
        $dataFicheDePaiement = $serializer->serialize($paiementEleves, 'json', [
            'groups' => ['list']
        ]);
        return new JsonResponse([
            "dataPaiementList"=>json_decode($dataPaiementList),
            "dataFicheDePaiement"=>json_decode($dataFicheDePaiement)
        ], Response::HTTP_OK, );
    }
    #[Route('/submitpaiementeleves', name: 'app_gestion_paiement_et_scolarite_annuel-submit-paiement',methods:['POST'])]
    public function submitPaiementMensuelEleves(Request $request,AnneeScolaireMensualiteRepository $anneeScolaireMensualiteRepository,EntityManagerInterface $entityManagerInterface,PaiementNiveauEtudeAnneeScolaireRepository $paiementNiveauEtudeAnneeScolaireRepository,ElevesRepository $elevesRepository,SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        // {moi: '23', montant: '50000', eleve: '5', anneeScolaire: '3'}
        // $moi=$anneeScolaireMensualiteRepository->find();
        $fichePaiementMensuel=$paiementNiveauEtudeAnneeScolaireRepository->findOneBy(['mensualite'=>$data['moi']]);
        $eleve=$elevesRepository->find($data['eleve']);
        $paiementScolariteEleves= new PaiementScolariteEleves();
        $facture="<h1 style='color:red'>Je suis la facture</h1>";
        // "The identifier id is missing for a query of App\Entity\PaiementNiveauEtudeAnneeScolaire"
        // PaiementNiveauEtudeAnneeScolaire
        $paiementScolariteEleves->setEleves($eleve)
                                ->setScolaritePaiement($fichePaiementMensuel)
                                ->setMontantPaier($data['montant'])
                                ->setCommentaire($data['commentaire'])
                                ->setCreatedAt(new DateTimeImmutable('now'))
                                ->setHtmlFacture($facture);
        $entityManagerInterface->persist($paiementScolariteEleves);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($paiementScolariteEleves, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }
}

// #[Route('/parent_eleves', name: 'app_parent_eleves_add',methods:['POST'])]
// public function createParentEleves(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
// {
    // $data = json_decode($request->getContent(),true);
    // $img="";
    // $defaultMen="";
    // $defaultWomen="";
    // if(!$data){
    //     $data=$request->request->all();
    // }
//     $requestFile=$request->files->all();
//     if ($data["isUpload"]=="true") {
//         $sfile = $requestFile["image"];
//         $img=$this->saveimage($sfile); 
//     }
//     else{
//         if ($data["sex"]=="Masculin") {
//             $img=$defaultMen;
//         } else {
//             $img=$defaultWomen;
//         }
//     }
//     $parentEleves = new ParentEleves();
//     $parentEleves->setPrenom(trim($data["prenom"]))
//                  ->setNom(trim($data["nom"]))
//                  ->setTelephone(trim($data["telephone"]))
//                  ->setEmail(trim($data["email"]))
//                  ->setAdresse(trim($data["adresse"]))
//                  ->setProfession(trim($data["profession"]))
//                  ->setImage($img)
//                  ->setSex(trim($data["sex"]))
//                  ->setCommentaire(trim($data["commentaire"]))
//                  ->setDeleted(false);
//     $entityManagerInterface->persist($parentEleves);
//     $entityManagerInterface->flush();
//     $data = $serializer->serialize($parentEleves, 'json', [
//         'groups' => ['list']
//     ]);
    // return new Response($data, Response::HTTP_CREATED, [
    //     'Content-Type' => 'application/json'
    // ]);
// }
