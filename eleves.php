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