import { AnneeScolaireModel } from "../../scolarite/anneeScolaire/model/anneeScolaire"

export interface OneEvaluationElevesModel{
        id: number,
        htmlReport: string,
        anneeScolaire: AnneeScolaireModel,
        notesEvaluationAnnuelEleves: Array<
            {
                id: number,
                question: string,
                tagReponse: string,
                reponse: string
            }>
}