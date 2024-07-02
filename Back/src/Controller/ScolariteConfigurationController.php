<?php

namespace App\Controller;

use App\Entity\AnneeScolaire;
use App\Entity\AnneeScolaireMensualite;
use App\Entity\CritereEvaluationFamily;
use App\Entity\CritereEvaluationGroup;
use App\Entity\CriteresEvaluations;
use App\Entity\NiveauEtude;
use App\Repository\AnneeScolaireRepository;
use App\Repository\CritereEvaluationFamilyRepository;
use App\Repository\CritereEvaluationGroupRepository;
use App\Repository\CriteresEvaluationsRepository;
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
    // CRITERE EVALUATION FAMILY
    #[Route('/critere-evaluation-family', name: 'app_critere_evaluation_family_get',methods:['GET'])]
    function listFamilyCritereEvaluation(CritereEvaluationFamilyRepository $critereEvaluationFamily,SerializerInterface $serializer) : Response {
        $critereFamily= $critereEvaluationFamily->findAll();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-family', name: 'app_critere_evaluation_family_post',methods:['POST'])]
    public function saveCritereEvaluationFamily(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $criteFamily = new CritereEvaluationFamily();
        $criteFamily->setNom(trim($data["nom"]))
                    ->setCommentaire(trim($data["commentaire"]));
        $entityManagerInterface->persist($criteFamily);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($criteFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-family/detail/{id}', name: 'app_critere_evaluation_family_detail',methods:['GET'])]
    function detailFamilyCritereEvaluation(int $id,CritereEvaluationFamilyRepository $critereEvaluationFamily,SerializerInterface $serializer) : Response {
        $critereFamily= $critereEvaluationFamily->find($id);
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-family-update/{id}', name: 'app_critere_evaluation_family_update',methods:['POST'])]
    public function updateOneCritereEvaluationFamily(int $id,CritereEvaluationFamilyRepository $critereEvaluationFamily,Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $criteFamily= $critereEvaluationFamily->find($id);
        // $criteFamily = new CritereEvaluationFamily();
        $criteFamily->setNom(trim($data["nom"]))
                    ->setCommentaire(trim($data["commentaire"]));
        $entityManagerInterface->persist($criteFamily);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($criteFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    // CRITERE EVALUATION GROUP
    #[Route('/critere-evaluation-group', name: 'app_critere_evaluation_group_get',methods:['GET'])]
    function listGroupCritereEvaluation(CritereEvaluationGroupRepository $critereEvaluationGroupRepository,SerializerInterface $serializer) : Response {
        $critereFamily= $critereEvaluationGroupRepository->findAll();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-group', name: 'app_critere_evaluation_group_post',methods:['POST'])]
    public function saveCritereEvaluationGroupe(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface,CritereEvaluationFamilyRepository $critereEvaluationFamilyRepository): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $family=$critereEvaluationFamilyRepository->find($data["id"]);
        $criteFamily = new CritereEvaluationGroup();
        $criteFamily->setNom(trim($data["nom"]))
                    ->setFamily($family)
                    ->setCommentaire(trim($data["commentaire"]));
        $entityManagerInterface->persist($criteFamily);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($criteFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-group-detail/{id}', name: 'app_critere_evaluation_group_detail',methods:['GET'])]
    function detailOneGroupCritereEvaluation(int $id,CritereEvaluationGroupRepository $critereEvaluationGroupRepository,SerializerInterface $serializer) : Response {
        $critereFamily= $critereEvaluationGroupRepository->find($id);
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-group-update/{id}', name: 'app_critere_evaluation_group_update',methods:['POST'])]
    public function updateOneCritereEvaluationGroupe(int $id,CritereEvaluationGroupRepository $critereEvaluationGroupRepository,Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface,CritereEvaluationFamilyRepository $critereEvaluationFamilyRepository): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
       // $family=$critereEvaluationFamilyRepository->find($data["id"]);
        $critereFamily= $critereEvaluationGroupRepository->find($id);
        // $criteFamily = new CritereEvaluationGroup();
        $critereFamily->setNom(trim($data["nom"]))
                    // ->setFamily($family)
                    ->setCommentaire(trim($data["commentaire"]));
        $entityManagerInterface->persist($critereFamily);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-group-remove/{id}', name: 'app_critere_evaluation_group_remove',methods:['GET'])]
    function removeOneGroupCritereEvaluation(int $id,CritereEvaluationGroupRepository $critereEvaluationGroupRepository,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface) : Response {
        $critereFamily= $critereEvaluationGroupRepository->find($id);
        $entityManagerInterface->remove($critereFamily);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    // CRITERE EVALUATION ONLY
    #[Route('/critere-evaluation', name: 'app_critere_evaluation_get',methods:['GET'])]
    function listCritereEvaluation(CriteresEvaluationsRepository $criteresEvaluationsRepository,SerializerInterface $serializer) : Response {
        $critereFamily= $criteresEvaluationsRepository->findAll();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation', name: 'app_critere_evaluation_post',methods:['POST'])]
    public function saveCritereEvaluation(Request $request,CritereEvaluationGroupRepository $critereEvaluationGroupRepository,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface,CritereEvaluationFamilyRepository $critereEvaluationFamilyRepository): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $groupe=$critereEvaluationGroupRepository->find($data["id"]);
        $criteresEvaluation = new CriteresEvaluations();
        $criteresEvaluation->setQuestion(trim($data["question"]))
                           ->setFaitSeul(trim($data["faitSeul"]))
                           ->setNeFaitPas(trim($data["neFaitPas"]))
                           ->setFaitAvecDeLAide(trim($data["faitAvecDeLAide"]))
                           ->setFamilyGroup($groupe)
                           ->setNonEvaluer(trim($data["nonEvaluer"]));
        $entityManagerInterface->persist($criteresEvaluation);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($criteresEvaluation, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-detail/{id}', name: 'app_critere_evaluation_detail',methods:['GET'])]
    function detailOneCritereEvaluation(int $id,CriteresEvaluationsRepository $criteresEvaluationsRepository,SerializerInterface $serializer) : Response {
        $critereFamily= $criteresEvaluationsRepository->find($id);
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-detail-group/{id}', name: 'app_critere_evaluation_detail_group',methods:['GET'])]
    function detailOneFromGroupCritereEvaluation(int $id,CritereEvaluationGroupRepository $critereEvaluationGroupRepository,CriteresEvaluationsRepository $criteresEvaluationsRepository,SerializerInterface $serializer) : Response {
        // $groupe=$critereEvaluationGroupRepository->find($id);
        // return $this->json(['id'=>$id]);
        // dd($groupe);
        $critereFamily= $criteresEvaluationsRepository->find($id);
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-remove/{id}', name: 'app_critere_evaluation_remove',methods:['GET'])]
    function removeOneCritereEvaluation(int $id,CriteresEvaluationsRepository $criteresEvaluationsRepository,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface) : Response {
        $critereFamily= $criteresEvaluationsRepository->find($id);
        $entityManagerInterface->remove($critereFamily);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere-evaluation-update/{id}', name: 'app_critere_evaluation_update',methods:['POST'])]
    public function updateOneCritereEvaluation(int $id,CriteresEvaluationsRepository $criteresEvaluationsRepository,Request $request,CritereEvaluationGroupRepository $critereEvaluationGroupRepository,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface,CritereEvaluationFamilyRepository $critereEvaluationFamilyRepository): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        // $groupe=$critereEvaluationGroupRepository->find($data["id"]);
        $criteresEvaluation= $criteresEvaluationsRepository->find($id);

        // $criteresEvaluation = new CriteresEvaluations();
        $criteresEvaluation->setQuestion(trim($data["question"]))
                           ->setFaitSeul(trim($data["faitSeul"]))
                           ->setNeFaitPas(trim($data["neFaitPas"]))
                           ->setFaitAvecDeLAide(trim($data["faitAvecDeLAide"]))
                        //    ->setFamilyGroup($groupe)
                           ->setNonEvaluer(trim($data["nonEvaluer"]));
        $entityManagerInterface->persist($criteresEvaluation);
        $entityManagerInterface->flush();
        $data = $serializer->serialize($criteresEvaluation, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }
}
