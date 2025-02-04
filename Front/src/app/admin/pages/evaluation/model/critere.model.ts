import { CriteresQuestionModel } from "./critere-question.model";

export interface CritereModel{
    id:number,
    nom:string,
    commentaire:string;
    critereQuestions:Array<CriteresQuestionModel>
}