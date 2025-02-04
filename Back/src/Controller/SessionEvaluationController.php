<?php

namespace App\Controller;

use App\Entity\NiveauEtude;
use App\Entity\SessionEvaluation;
use App\Entity\SessionsNiveaux;
use App\Repository\NiveauEtudeRepository;
use App\Repository\SessionEvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/sessions', name: 'app_session_evaluation')]

class SessionEvaluationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ) {}

    #[Route('', methods: ['GET'])]
    public function index(SessionEvaluationRepository $repository): JsonResponse
    {
        $sessions = $repository->findAll();
        return $this->json($sessions, Response::HTTP_OK, [], ['groups' => 'session:read']);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(SessionEvaluation $session): JsonResponse
    {
        return $this->json($session, Response::HTTP_OK, [], ['groups' => 'session:read']);
    }
    #[Route('', methods: ['POST'])]
    public function create(Request $request, NiveauEtudeRepository $niveauEtudeRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            $data = $request->request->all();
        }
        // Création de la session
        $session = new SessionEvaluation();
        $session->setNom($data['nom']);
        $session->setDateLimit(new \DateTime($data['dateLimit']));
        //if ($data['isActive']!=null) {
            $session->setActive($data['isActive'] ?? false);
        //}
        $this->entityManager->persist($session);
        $this->entityManager->flush(); // Nécessaire pour obtenir l'ID de la session
        // Gestion des SessionsNiveaux
        if (isset($data['niveauxEtudes']) && is_array($data['niveauxEtudes'])) {
            foreach ($data['niveauxEtudes'] as $niveauId) {
                $niveau = $niveauEtudeRepository->find($niveauId);
                if ($niveau) {
                    $sessionNiveau = new SessionsNiveaux();
                    $sessionNiveau->setSession($session);
                    $sessionNiveau->setNiveauEtude($niveau);
                    
                    $this->entityManager->persist($sessionNiveau);
                }
            }
            $this->entityManager->flush();
        }

        return $this->json($session, 201, [], ['groups' => 'session:read']);
    }
    // #[Route('', methods: ['POST'])]
    // public function create(Request $request): JsonResponse
    // {
        // $session = $this->serializer->deserialize(
        //     $request->getContent(),
        //     SessionEvaluation::class,
        //     'json'
        // );

        // $this->entityManager->persist($session);
        // $this->entityManager->flush();

    //     return $this->json($session, Response::HTTP_CREATED, [], ['groups' => 'session:read']);
    // }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, SessionEvaluationRepository $sessionEvaluationRepository, NiveauEtudeRepository $niveauEtudeRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $session = $sessionEvaluationRepository->find($id);
    
        if (!$session) {
            return $this->json(['message' => 'Session not found'], 404);
        }
    
        // Mise à jour des informations de la session
        if (isset($data['nom'])) {
            $session->setNom($data['nom']);
        }
        if (isset($data['dateLimit'])) {
            $session->setDateLimit(new \DateTime($data['dateLimit']));
        }
        if (isset($data['isActive'])) {
            $session->setActive($data['isActive']);
        }
    
        // Mise à jour des relations avec les niveaux d'étude
        if (isset($data['niveauxEtudes']) && is_array($data['niveauxEtudes'])) {
            // Supprimer les anciennes relations
            foreach ($session->getSessionsNiveauxes() as $sessionNiveau) {
                $this->entityManager->remove($sessionNiveau);
            }
            $this->entityManager->flush(); // Important pour éviter les doublons
    
            // Ajouter les nouvelles relations
            foreach ($data['niveauxEtudes'] as $niveauId) {
                $niveau = $niveauEtudeRepository->find($niveauId);
                if ($niveau) {
                    $sessionNiveau = new SessionsNiveaux();
                    $sessionNiveau->setSession($session);
                    $sessionNiveau->setNiveauEtude($niveau);
    
                    $this->entityManager->persist($sessionNiveau);
                }
            }
        }
    
        $this->entityManager->flush();
    
        return $this->json($session, 200, [], ['groups' => 'session:read']);
    }
    

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(SessionEvaluation $session): JsonResponse
    {
        $this->entityManager->remove($session);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    // #[Route('/niveau/{id}', methods: ['GET'])]
    // public function getSessionsByNiveau(NiveauEtude $niveau): JsonResponse
    // {
    //     $sessions = $niveau->getSessionsEvaluations();
    //     return $this->json($sessions, Response::HTTP_OK, [], ['groups' => 'session:read']);
    // }
}
