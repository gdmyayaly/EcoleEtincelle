import { Component, OnDestroy, OnInit } from '@angular/core';
import { NiveauEtudeService } from '../service/niveau-etude.service';
import { NiveauEtudeModel } from '../model/niveauEtute';
import { ActivatedRoute } from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-niveau-etude-detail',
  templateUrl: './niveau-etude-detail.component.html',
  styleUrls: ['./niveau-etude-detail.component.css']
})
export class NiveauEtudeDetailComponent implements OnInit,OnDestroy{
  public listNiveauEtude!:NiveauEtudeModel;
  public idNiveauEtude:string="";
  public tabsNavigation:{name:string,isActive:boolean,componennt:string}[]=[
    {name:"Detail",componennt:"app-detail",isActive:true},
    {name:"Formulaire",componennt:"app-form",isActive:false},
  ]
  public activeView:string="app-detail";
  public formAddNiveauEtude = new FormGroup({
    nom:new FormControl('',Validators.required),
    commentaire : new FormControl(''),
    id : new FormControl('')

  });
  constructor(private niveauEtudeService:NiveauEtudeService,private activeRoute: ActivatedRoute){}
  ngOnInit(): void {
    this.idNiveauEtude = this.activeRoute.snapshot.paramMap.get('id')??"";
    this.loadData();
  }
  ngOnDestroy(): void {
    
  }
  loadData(){
    this.niveauEtudeService.loadOneNiveauEtude(this.idNiveauEtude).subscribe(
      res=>{
        console.log("Perfect");
        console.log(res);
        this.listNiveauEtude=res;
        this.formAddNiveauEtude.get('nom')?.setValue(this.listNiveauEtude.nom);
        this.formAddNiveauEtude.get('id')?.setValue(this.listNiveauEtude.id.toString());
        this.formAddNiveauEtude.get('commentaire')?.setValue(this.listNiveauEtude.commentaire);
      },
      error=>{
        console.log("Error");
        console.error(error)
      }
    )
  }
  changeSelectedView(name:string){
    this.resetAll();
    console.log("On clic");
    let index = this.tabsNavigation.findIndex(r=>r.name==name)
    this.activeView=this.tabsNavigation[index].componennt;
    this.tabsNavigation[index].isActive=true;
  }
  onChangeSelectedView(ev:any){
   this.resetAll();
    let index = this.tabsNavigation.findIndex(r=>r.name==ev.target.value);
    this.activeView=this.tabsNavigation[index].componennt;
    this.tabsNavigation[index].isActive=true;
  }
  resetAll(){
    for (let index = 0; index < this.tabsNavigation.length; index++) {
      this.tabsNavigation[index].isActive=false;
    }
  }
  saveAnnee(){
    console.log(this.formAddNiveauEtude.value);
    this.niveauEtudeService.updateOneNiveauEtude(this.formAddNiveauEtude.value).subscribe(
      res=>{
        console.log(res);
        this.loadData();
      },
      error=>{
        console.log(error);
        
      }
    )
  }
}
