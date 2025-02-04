<?php

namespace App\Controller;

use App\Entity\CritereQuestions;
use App\Repository\CritereQuestionsRepository;
use App\Repository\CritereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'app_critere_questions')]

class CritereQuestionsController extends AbstractController
{
    // #[Route('/questions', name: 'app_critere_questions')]
    // public function index(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/CritereQuestionsController.php',
    //     ]);
    // }
    // CRITERE EVALUATION 
    #[Route('/questions', name: 'app_critere_evaluation_get',methods:['GET'])]
    function listCritereEvaluation(CritereQuestionsRepository $criteresEvaluationsRepository,SerializerInterface $serializer) : Response {
        $critereFamily= $criteresEvaluationsRepository->findAll();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/questions', name: 'app_critere_evaluation_post',methods:['POST'])]
    public function saveCritereEvaluation(Request $request,CritereRepository $critereRepository,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $groupe=$critereRepository->find($data["id"]);
        $criteresEvaluation = new CritereQuestions();
        $criteresEvaluation->setQuestion(trim($data["question"]))
                           ->setFaitSeul(trim($data["faitSeul"]))
                           ->setNeFaitPas(trim($data["neFaitPas"]))
                           ->setFaitAvecDeLAide(trim($data["faitAvecDeLAide"]))
                           ->setCritere($groupe)
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
    #[Route('/questions/update', name: 'app_critere_evaluation_update',methods:['POST'])]
    public function updateCritereEvaluation(Request $request,CritereRepository $critereRepository,CritereQuestionsRepository $critereQuestionsRepository,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        // $oldCritere=$critereRepository->find($data["id"]);
        // $newCritere=$oldCritere;

        $criteresEvaluation = $critereQuestionsRepository->find($data["questionId"]);
        $criteresEvaluation->setQuestion(trim($data["question"]))
                           ->setFaitSeul(trim($data["faitSeul"]))
                           ->setNeFaitPas(trim($data["neFaitPas"]))
                           ->setFaitAvecDeLAide(trim($data["faitAvecDeLAide"]))
                        //    ->setCritere($oldCritere)
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
