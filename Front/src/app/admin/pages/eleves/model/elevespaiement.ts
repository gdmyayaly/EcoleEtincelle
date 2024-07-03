import { AnneeScolaireModel } from "../../scolarite/anneeScolaire/model/anneeScolaire";
import { DetailMensualiteNiveauEtudeModel } from "../../scolarite/anneeScolaire/model/detailMensualite";
import { NiveauEtudeModel } from "../../scolarite/niveauEtude/model/niveauEtute";

export interface ElevesPaiementModel{
    dataFicheDePaiement:Array<
    {
        id: number,
        scolaritePaiement: {
            id: number,
            niveauEtude: NiveauEtudeModel,
            anneeScolaire: AnneeScolaireModel,
            mensualite: {
                id: number,
                name: string
            },
            montant: number
        },
        montantPaier: number,
        createdAt: string,
        commentaire: string,
        htmlFacture: string
    }
    >,
    dataPaiementList:Array<DetailMensualiteNiveauEtudeModel>
}