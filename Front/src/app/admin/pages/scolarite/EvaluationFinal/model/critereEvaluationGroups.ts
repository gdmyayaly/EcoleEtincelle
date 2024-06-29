import { CriteresEvaluationsModel } from "./criteresEvaluations";

export interface CritereEvaluationGroupsModel{
    id:number,
    nom:string,
    commentaire:string;
    criteresEvaluations?:Array<CriteresEvaluationsModel>
}