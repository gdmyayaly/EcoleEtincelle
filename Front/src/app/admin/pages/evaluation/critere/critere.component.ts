import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';

import Swal from 'sweetalert2';
import { CritereModel } from '../model/critere.model';
import { CritereService } from '../services/critere.service';

@Component({
  selector: 'app-critere',
  templateUrl: './critere.component.html',
  styleUrls: ['./critere.component.css']
})
export class CritereComponent implements OnInit,OnDestroy{
public showModal:boolean=false;
  public showDetail:boolean=false;
  public showFormAddSub:boolean=false;
  public showEditFormGroup:boolean=false;
  public idSelected:number=0;
  public formAddNiveauEtude = new FormGroup({
    nom:new FormControl('',Validators.required),
    commentaire : new FormControl('')
  });
  public listCritere:CritereModel[]=[];
  constructor(private critereService:CritereService){}

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
    this.showEditFormGroup=false;
  }
  saveCritere(){
    console.log(this.formAddNiveauEtude.value);
    this.critereService.create(this.formAddNiveauEtude.value).subscribe(
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
    this.critereService.getAllCritere().subscribe(
      res=>{
        console.log("Perfect");
        console.log(res);
        this.listCritere=res;
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
  // openModalDetail(id:number){
  //   this.showFormAddSub=true;
  //   this.showModal=false;
  //   this.showEditFormGroup=false;
  //   this.formAddNiveauEtudes.get('id')?.setValue(id.toString());

  // }
  // saveSubData(){
  //   this.critereService.create(this.formAddNiveauEtudes.value).subscribe(
  //     res=>{
  //       console.log(res);
  //       this.loadData();
  //     },
  //     error=>{
  //       console.log(error);
        
  //     }
  //   )
  //   this.cancelModal();
  // }
  // editCritereGroup(infosGroup:CritereEvaluationGroupsModel){
  //   console.log(infosGroup);
    
  //   this.showFormAddSub=true;
  //   this.showModal=false;
  //   this.showEditFormGroup=true;
  //   this.formAddNiveauEtudes.get('id')?.setValue(infosGroup.id.toString());
  //   this.formAddNiveauEtudes.get('nom')?.setValue(infosGroup.nom.toString());
  //   this.formAddNiveauEtudes.get('commentaire')?.setValue(infosGroup.commentaire.toString());
  // }
  // submitEditCritereGroup(){
  //   this.critereEvaluationFamily.updateOneCritereEvaluationGroupe(this.formAddNiveauEtudes.value).subscribe(
  //     res=>{
  //       console.log(res);
  //       this.loadData();
  //     },
  //     error=>{
  //       console.log(error);
        
  //     }
  //   )
  //   this.cancelModal();
  // }
  // removeCritereGroupe(infosGroup:CritereEvaluationGroupsModel){
  //   Swal.fire({
  //     title: "Do you want to save the changes?",
  //     // showDenyButton: true,
  //     showCancelButton: true,
  //     confirmButtonText: "Confirmer",
  //     cancelButtonText:"Annuler",
  //     // denyButtonText: `Don't save`
  //   }).then((result) => {
  //     /* Read more about isConfirmed, isDenied below */
  //     if (result.isConfirmed) {
  //       this.critereEvaluationFamily.removeOneGroupCritereEvaluation(infosGroup.id).subscribe(
  //         res=>{
  //           console.log(res);
  //           this.loadData();
  //           Swal.fire("Saved!", "", "success");

  //         },
  //         error=>{
  //           console.log(error);
            
  //         }
  //       )
  //     } 
  //     // else if (result.isDenied) {
  //     //   Swal.fire("Changes are not saved", "", "info");
  //     // }
  //   });
  // }
}
