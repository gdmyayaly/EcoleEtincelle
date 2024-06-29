import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ElevesModel } from '../../model/elevesmodel';
import { CritereEvaluationFamilyService } from '../../../scolarite/EvaluationFinal/service/niveau-etude.service';
import { CriteresEvaluationsModel } from '../../../scolarite/EvaluationFinal/model/criteresEvaluations';
import { FormBuilder, FormControl, Validators } from '@angular/forms';
import { AnneeScolaireModel } from '../../../scolarite/anneeScolaire/model/anneeScolaire';
import { AnneeScolaireService } from '../../../scolarite/anneeScolaire/service/niveau-etude.service';

@Component({
  selector: 'app-evaluation-fin-annee',
  templateUrl: './evaluation-fin-annee.component.html',
  styleUrls: ['./evaluation-fin-annee.component.css']
})
export class EvaluationFinAnneeComponent implements OnInit,OnDestroy{
  @Input() eleve!:ElevesModel;
  public listCritere:CriteresEvaluationsModel[]=[];
  evaluationForm = this.formBuilder.group({
  });
  public editorContent: string = 'My initial content';
  public listAnneeScolaire:AnneeScolaireModel[]=[];

  constructor(private anneScolaireService:AnneeScolaireService,private evaluationService:CritereEvaluationFamilyService,private formBuilder: FormBuilder){}
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
        for (let index = 0; index < this.listCritere.length; index++) {
          this.evaluationForm.setControl('question'+index, new FormControl(this.listCritere[index].question, [Validators.required]))
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
    console.log(this.editorContent);
    
  }
}
