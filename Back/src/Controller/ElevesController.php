<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\ElevesAnneScolaire;
use App\Entity\EvaluationAnnuelEleves;
use App\Entity\NotesEvaluationAnnuelEleves;
use App\Entity\ParentsElevesLink;
use App\Repository\AnneeScolaireRepository;
use App\Repository\CriteresEvaluationsRepository;
use App\Repository\ElevesRepository;
use App\Repository\EvaluationAnnuelElevesRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\NotesEvaluationAnnuelElevesRepository;
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
        $defaultMen="default/enfantM.jpg";
        $defaultWomen="default/enfantF.jpg";
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
        $eleves->setPrenom(trim($data["prenom"]))
               ->setNom(trim($data["nom"]))
               ->setAge(trim($data["age"]))
               ->setDateDeNaissance(trim($data["date"]))
               ->setImage($img)
               ->setSex(trim($data["sex"]))
               ->setDeleted(false)
               ->setCommentaire(trim($data["commentaire"]))
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
    #[Route('/eleves/save-evaluation', name: 'app_eleves_save_evaluation',methods:['POST'])]
    public function saveEvaluationAnnuel(ElevesRepository $elevesRepository,CriteresEvaluationsRepository $criteresEvaluationsRepository,AnneeScolaireRepository $anneeScolaireRepository,EvaluationAnnuelElevesRepository $evaluationAnnuelElevesRepository,Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $count=$data["size"];
        $eleve=$elevesRepository->find($data["eleve"]);
        $anneeScolaire=$anneeScolaireRepository->find($data["anneeScolaire"]);
        $evaluationAnnuelEleves = new EvaluationAnnuelEleves();
        $htmlRepport="";
        $evaluationAnnuelEleves->setEleve($eleve)
                               ->setHtmlReport($htmlRepport)
                               ->setAnneeScolaire($anneeScolaire);
        for ($i=0; $i <$count ; $i++) { 
            $rep=$data["reponse".$i];
            // idQestion,tagReponse
            $split = explode(",",$rep);
            $critere=$criteresEvaluationsRepository->find($split[0]);
            $rep="";
            if ($split[1]=="faitSeul") {
                $rep=$critere->getFaitSeul();
            } elseif($split[1]=="neFaitPas") {
                $rep=$critere->getNeFaitPas();
            }
            elseif($split[1]=="faitAvecDeLAide") {
                $rep=$critere->getFaitAvecDeLAide();
            }
            elseif($split[1]=="nonEvaluer") {
                $rep=$critere->getNonEvaluer();
            }
            $notesEvaluationAnnuelEleves = new NotesEvaluationAnnuelEleves();
            $notesEvaluationAnnuelEleves->setQuestion($critere->getQuestion())
                                        ->setTagReponse($split[1])
                                        ->setReponse($rep)
                                        ->setEvaluationAnnuelEleves($evaluationAnnuelEleves);
            $htmlRepport=$htmlRepport."<p>".$rep."</p><br>";
            $entityManagerInterface->persist($notesEvaluationAnnuelEleves);
        }
        $evaluationAnnuelEleves->setHtmlReport($htmlRepport);
        $entityManagerInterface->persist($evaluationAnnuelEleves);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($evaluationAnnuelEleves, 'json', [
            'groups' => ['eleves']
        ] );
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/eleves/one-evaluation/{id}', name: 'app_eleves_detail_one_evaluation',methods:['GET'])]
    public function detailOneEvaluation(int $id,AnneeScolaireRepository $anneeScolaireRepository,EvaluationAnnuelElevesRepository $evaluationAnnuelElevesRepository,Request $request,SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $anneeScolaire=$anneeScolaireRepository->find($id);
        $evaluationOfTheYear=$evaluationAnnuelElevesRepository->findOneBy(['anneeScolaire'=>$anneeScolaire]);
        $data = $serializer->serialize($evaluationOfTheYear, 'json', [
            'groups' => ['eleves']
        ] );
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/eleves/update-evaluation/{id}', name: 'app_eleves_update_evaluation',methods:['POST'])]
    public function updateOneEvaluation(int $id,ElevesRepository $elevesRepository,CriteresEvaluationsRepository $criteresEvaluationsRepository,AnneeScolaireRepository $anneeScolaireRepository,NotesEvaluationAnnuelElevesRepository $notesEvaluationAnnuelElevesRepository,EntityManagerInterface $entityManagerInterface,EvaluationAnnuelElevesRepository $evaluationAnnuelElevesRepository,Request $request,SerializerInterface $serializer): Response
    {
        $evaluationOfTheYear=$evaluationAnnuelElevesRepository->find($id);
        $allOldNote=$notesEvaluationAnnuelElevesRepository->findBy(['evaluationAnnuelEleves'=>$evaluationOfTheYear]);
        for ($i=0; $i < count($allOldNote); $i++) { 
            $entityManagerInterface->remove($allOldNote[$i]);
        }
        $entityManagerInterface->flush();
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $count=$data["size"];
        // $eleve=$elevesRepository->find($data["eleve"]);
        // $anneeScolaire=$anneeScolaireRepository->find($data["anneeScolaire"]);
        // $evaluationAnnuelEleves = new EvaluationAnnuelEleves();
        $htmlRepport="";
        // $evaluationAnnuelEleves->setEleve($eleve)
        //                        ->setHtmlReport($htmlRepport)
        //                        ->setAnneeScolaire($anneeScolaire);
        for ($i=0; $i <$count ; $i++) { 
            $rep=$data["reponse".$i];
            // idQestion,tagReponse
            $split = explode(",",$rep);
            $critere=$criteresEvaluationsRepository->find($split[0]);
            $rep="";
            if ($split[1]=="faitSeul") {
                $rep=$critere->getFaitSeul();
            } elseif($split[1]=="neFaitPas") {
                $rep=$critere->getNeFaitPas();
            }
            elseif($split[1]=="faitAvecDeLAide") {
                $rep=$critere->getFaitAvecDeLAide();
            }
            elseif($split[1]=="nonEvaluer") {
                $rep=$critere->getNonEvaluer();
            }
            $notesEvaluationAnnuelEleves = new NotesEvaluationAnnuelEleves();
            $notesEvaluationAnnuelEleves->setQuestion($critere->getQuestion())
                                        ->setTagReponse($split[1])
                                        ->setReponse($rep)
                                        ->setEvaluationAnnuelEleves($evaluationOfTheYear);
            $htmlRepport=$htmlRepport."<p>".$rep."</p><br>";
            $entityManagerInterface->persist($notesEvaluationAnnuelEleves);
        }
        $evaluationOfTheYear->setHtmlReport($htmlRepport);
        $entityManagerInterface->persist($evaluationOfTheYear);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($evaluationOfTheYear, 'json', [
            'groups' => ['eleves']
        ] );
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
