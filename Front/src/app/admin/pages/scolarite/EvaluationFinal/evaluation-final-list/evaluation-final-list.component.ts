import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CritereEvaluationFamilyService } from '../service/niveau-etude.service';
import { CritereEvaluationFamily } from '../model/critereEvaluationFamily';
import { CritereEvaluationGroupsModel } from '../model/critereEvaluationGroups';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-evaluation-final-list',
  templateUrl: './evaluation-final-list.component.html',
  styleUrls: ['./evaluation-final-list.component.css']
})
export class EvaluationFinalListComponent implements OnInit,OnDestroy{
  public showModal:boolean=false;
  public showDetail:boolean=false;
  public showFormAddSub:boolean=false;
  public showEditFormGroup:boolean=false;
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
    this.showEditFormGroup=false;
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
    this.showEditFormGroup=false;
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
  editCritereGroup(infosGroup:CritereEvaluationGroupsModel){
    console.log(infosGroup);
    
    this.showFormAddSub=true;
    this.showModal=false;
    this.showEditFormGroup=true;
    this.formAddNiveauEtudes.get('id')?.setValue(infosGroup.id.toString());
    this.formAddNiveauEtudes.get('nom')?.setValue(infosGroup.nom.toString());
    this.formAddNiveauEtudes.get('commentaire')?.setValue(infosGroup.commentaire.toString());
  }
  submitEditCritereGroup(){
    this.critereEvaluationFamily.updateOneCritereEvaluationGroupe(this.formAddNiveauEtudes.value).subscribe(
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
  removeCritereGroupe(infosGroup:CritereEvaluationGroupsModel){
    Swal.fire({
      title: "Do you want to save the changes?",
      // showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: "Confirmer",
      cancelButtonText:"Annuler",
      // denyButtonText: `Don't save`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.critereEvaluationFamily.removeOneGroupCritereEvaluation(infosGroup.id).subscribe(
          res=>{
            console.log(res);
            this.loadData();
            Swal.fire("Saved!", "", "success");

          },
          error=>{
            console.log(error);
            
          }
        )
      } 
      // else if (result.isDenied) {
      //   Swal.fire("Changes are not saved", "", "info");
      // }
    });
  }
}
