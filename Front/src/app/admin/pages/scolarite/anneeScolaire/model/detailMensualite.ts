import { NiveauEtudeModel } from "../../niveauEtude/model/niveauEtute"
import { AnneeScolaireModel } from "./anneeScolaire"

export interface DetailMensualiteNiveauEtudeModel{
        id: number,
        niveauEtude: NiveauEtudeModel,
        anneeScolaire: AnneeScolaireModel,
        mensualite: {
            id: number,
            name: string
        },
        montant: number
}