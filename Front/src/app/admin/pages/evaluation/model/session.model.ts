import { NiveauEtudeModel } from "../../scolarite/niveauEtude/model/niveauEtute";

export interface SessionEvaluationModel {
    id?: number;
    nom: string;
    dateLimit: string;
    isActive: boolean;
    sessionsNiveauxes: SessionNiveau[];
  } 
  export interface SessionNiveau {
    niveauEtude: NiveauEtudeModel;
  }
  