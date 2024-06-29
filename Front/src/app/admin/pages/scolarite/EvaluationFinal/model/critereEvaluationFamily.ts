import { CritereEvaluationGroupsModel } from "./critereEvaluationGroups";

export interface CritereEvaluationFamily{
    id:number,
    nom:string,
    commentaire:string;
    critereEvaluationGroups?:Array<CritereEvaluationGroupsModel>
}