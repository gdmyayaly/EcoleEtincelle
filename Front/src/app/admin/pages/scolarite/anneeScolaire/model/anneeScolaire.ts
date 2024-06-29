export interface AnneeScolaireModel{
    id:number;
    moisStart:string;
    moisEnd:string;
    anneeStart:string;
    anneeEnd:string;
    anneeScolaireMensualites:{id:number,name:string}[];
}