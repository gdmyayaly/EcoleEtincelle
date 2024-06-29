import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CritereEvaluationFamilyService } from '../service/niveau-etude.service';
import { CritereEvaluationFamily } from '../model/critereEvaluationFamily';

@Component({
  selector: 'app-evaluation-final-list',
  templateUrl: './evaluation-final-list.component.html',
  styleUrls: ['./evaluation-final-list.component.css']
})
export class EvaluationFinalListComponent implements OnInit,OnDestroy{
  public showModal:boolean=false;
  public showDetail:boolean=false;
  public showFormAddSub:boolean=false;
  public idSelected:number=0;
  public formAddNiveauEtude = new FormGroup({
    nom:new FormControl('',Validators.required),
    commentaire : new FormControl('')
  });
  public formAddNiveauEtudes = new FormGroup({
    nom:new FormControl('',Validators.required),
    commentaire : new FormControl(''),
    id : new FormControl('')
  });
  public listCritereEvaluationFamily:CritereEvaluationFamily[]=[];
  constructor(private critereEvaluationFamily:CritereEvaluationFamilyService){}

  ngOnInit(): void {
    this.loadData();
    this.showDetail=false;
  }
  ngOnDestroy(): void {
    this.showDetail=false;

  }
  openDialog(): void {
    this.showModal=true;
    this.showFormAddSub=false;

  }
  cancelModal(){
    this.showModal=false;
    this.showFormAddSub=false;
    this.formAddNiveauEtude.reset();
    this.formAddNiveauEtudes.reset();

  }
  saveAnnee(){
    console.log(this.formAddNiveauEtude.value);
    this.critereEvaluationFamily.saveCritereEvaluationFamily(this.formAddNiveauEtude.value).subscribe(
      res=>{
        console.log(res);
        this.loadData();
      },
      error=>{
        console.log(error);
        
      }
    )
    this.cancelModal();
  }
  loadData(){
    this.critereEvaluationFamily.loadListCritereEvaluationFamily().subscribe(
      res=>{
        console.log("Perfect");
        console.log(res);
        this.listCritereEvaluationFamily=res;
      },
      error=>{
        console.log("Error");
        console.error(error)
      }
    )
  }
  exploreEvaluation(id:number){
    this.idSelected=id;
    this.showDetail=true;
  }
  cancelSeeDetail(){
    this.idSelected=0;
    this.showDetail=false;
    this.showFormAddSub=false;
  }
  addSousSection(){

  }
  openModalDetail(id:number){
    this.showFormAddSub=true;
    this.showModal=false;
    this.formAddNiveauEtudes.get('id')?.setValue(id.toString());

  }
  saveSubData(){
    this.critereEvaluationFamily.saveCritereEvaluationGroupe(this.formAddNiveauEtudes.value).subscribe(
      res=>{
        console.log(res);
        this.loadData();
      },
      error=>{
        console.log(error);
        
      }
    )
    this.cancelModal();
  }
}
