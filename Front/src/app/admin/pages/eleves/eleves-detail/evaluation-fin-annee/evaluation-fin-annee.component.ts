import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ElevesModel } from '../../model/elevesmodel';
import { CritereEvaluationFamilyService } from '../../../scolarite/EvaluationFinal/service/niveau-etude.service';
import { CriteresEvaluationsModel } from '../../../scolarite/EvaluationFinal/model/criteresEvaluations';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { AnneeScolaireModel } from '../../../scolarite/anneeScolaire/model/anneeScolaire';
import { AnneeScolaireService } from '../../../scolarite/anneeScolaire/service/niveau-etude.service';
import { ElevesService } from '../../service/eleves.service';
import { OneEvaluationElevesModel } from '../../model/oneEvaluation';

@Component({
  selector: 'app-evaluation-fin-annee',
  templateUrl: './evaluation-fin-annee.component.html',
  styleUrls: ['./evaluation-fin-annee.component.css']
})
export class EvaluationFinAnneeComponent implements OnInit,OnDestroy{
  @Input() eleve!:ElevesModel;
  public listCritere:CriteresEvaluationsModel[]=[];
  evaluationForm:FormGroup= this.formBuilder.group({
    anneeScolaire: new FormControl('',Validators.required),
  });
  public editorContent: string = 'My initial content';
  public listAnneeScolaire:AnneeScolaireModel[]=[];
  public selectedEvaluation!:OneEvaluationElevesModel;
  public showBtnUpdateEvaluation:boolean=false;
  constructor(private anneScolaireService:AnneeScolaireService,private evaluationService:CritereEvaluationFamilyService,private formBuilder: FormBuilder,private elevesService:ElevesService){}
  ngOnInit(): void {
    console.log("Je construit l'éléve");
    console.log(this.eleve);
    this.loadListCritereEvaluation();
    this.loadAnneScolaire();
  }
  ngOnDestroy(): void {
    console.log("Je detruit l'éléve");
    console.log(this.eleve);
  }
  loadListCritereEvaluation(){
    this.evaluationService.listCritereEvaluation().subscribe(
      res=>{
        console.log(res);
        this.listCritere=res;
        this.evaluationForm.addControl('size', new FormControl(this.listCritere.length, [Validators.required]))
        this.evaluationForm.addControl('eleve', new FormControl(this.eleve.id, [Validators.required]))

        for (let index = 0; index < this.listCritere.length; index++) {
          // this.evaluationForm.addControl('question'+index, new FormControl(this.listCritere[index].question, [Validators.required]))
          this.evaluationForm.addControl('reponse'+index, new FormControl('', [Validators.required]))
        }
      },
      error=>{
        console.log(error);
        
      }
    )
  }
  loadAnneScolaire(){
    this.anneScolaireService.loadListAnneeScolaire().subscribe(
      res=>{
        console.log("Année Scolaire");
        console.log(res);
        this.listAnneeScolaire=res;
      },
      error=>{console.log(error);
      }
    )
  }
  saveData(){
      console.log(this.evaluationForm.value);
      this.elevesService.saveOneEvaluationEleves(this.evaluationForm.value).subscribe(
        res=>{
          console.log("Année Scolaire");
          console.log(res);
        },
        error=>{console.log(error);
        }
      )
  }
  oneDateSelected(ev:any){
    console.log(ev.target.value);
    this.elevesService.detailOneEvaluationFromDateId(ev.target.value).subscribe(
      res=>{
        console.log("Détail evaluation");
        console.log(res);
        this.selectedEvaluation=res;
        if (this.selectedEvaluation!=null) {
          let size:number = this.evaluationForm.get('size')?.value
          for (let index = 0; index < this.selectedEvaluation.notesEvaluationAnnuelEleves.length; index++) {
            this.evaluationForm.get('reponse'+index)?.setValue(this.listCritere[index].id+","+this.selectedEvaluation.notesEvaluationAnnuelEleves[index].tagReponse)
          }
          this.showBtnUpdateEvaluation=true;
        }
        else{
          for (let index = 0; index < this.listCritere.length; index++) {
            this.evaluationForm.get('reponse'+index)?.setValue("")
          }
          this.showBtnUpdateEvaluation=false;
        }
      },
      error=>{console.log(error);
      }
    )
    
  }
  updateEvaluation(){
    console.log("Modification soumise");
    console.log(this.evaluationForm.value);
    console.log("idEvaluation "+this.selectedEvaluation.id);
    
    // this.elevesService.saveOneEvaluationEleves(this.evaluationForm.value).subscribe(
    //   res=>{
    //     console.log("Année Scolaire");
    //     console.log(res);
    //   },
    //   error=>{console.log(error);
    //   }
    // )
  }
}
