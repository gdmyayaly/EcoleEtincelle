<?php

namespace App\Controller;

use App\Entity\Critere;
use App\Repository\CritereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'app_critere_evaluation')]

class CritereEvaluationController extends AbstractController
{
    // CRITERE EVALUATION
    #[Route('/critere', name: 'app_critere_evaluation_get',methods:['GET'])]
    function listCritereEvaluation(CritereRepository $critereEvaluationFamily,SerializerInterface $serializer) : Response {
        $critereFamily= $critereEvaluationFamily->findAll();
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere', name: 'app_critere_evaluation_post',methods:['POST'])]
    public function saveCritereEvaluation(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $criteFamily = new Critere();
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
    #[Route('/critere/detail/{id}', name: 'app_critere_evaluation_family_detail',methods:['GET'])]
    function detailCritereEvaluation(int $id,CritereRepository $critereEvaluationFamily,SerializerInterface $serializer) : Response {
        $critereFamily= $critereEvaluationFamily->find($id);
        $data = $serializer->serialize($critereFamily, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/critere/update/{id}', name: 'app_critere_evaluation_family_update',methods:['POST'])]
    public function updateOneCritereEvaluation(int $id,CritereRepository $critereEvaluationFamily,Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface): Response
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $criteFamily= $critereEvaluationFamily->find($id);
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
}
