import { ElevesModel } from "../../../eleves/model/elevesmodel";
import { NiveauEtudeModel } from "../../niveauEtude/model/niveauEtute";

export interface AnneeScolaireModel{
    id:number;
    moisStart:string;
    moisEnd:string;
    anneeStart:string;
    anneeEnd:string;
    anneeScolaireMensualites:{id:number,name:string}[];
    elevesAnneScolaires:Array<elevesAnneScolairesModel>
}
export interface elevesAnneScolairesModel{
        id:number,
        eleves:ElevesModel
        niveauEtude:NiveauEtudeModel
}