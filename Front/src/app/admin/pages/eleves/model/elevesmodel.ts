import { ParentElevesModel } from "../../parentEleves/model/parentEleves";
import { AnneeScolaireModel } from "../../scolarite/anneeScolaire/model/anneeScolaire"
import { NiveauEtudeModel } from "../../scolarite/niveauEtude/model/niveauEtute";

export interface ElevesModel{
        id: number;
        prenom: string;
        nom: string;
        age: number;
        sex: string;
        dateDeNaissance: string;
        parentsElevesLinks: Array<{
            id:number,
            parents:ParentElevesModel
        }>;
        image: string;
        commentaire: string;
        elevesAnneScolaires: Array<
            {
                id: number;
                niveauEtude: NiveauEtudeModel;
                anneeScolaire: AnneeScolaireModel
            }
        >
}