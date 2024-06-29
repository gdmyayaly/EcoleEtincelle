import { Component, OnDestroy, OnInit } from '@angular/core';

@Component({
  selector: 'app-scolarite',
  templateUrl: './scolarite.component.html',
  styleUrls: ['./scolarite.component.css']
})
export class ScolariteComponent implements OnInit,OnDestroy{
  public tabsNavigation:{name:string,isActive:boolean,componennt:string}[]=[
    {name:"Année Scolaire",componennt:"app-annee-scolaire-list",isActive:true},
    {name:"Niveau d'étude",componennt:"app-niveau-etude-list",isActive:false},
    {name:"Critères d'Évaluation Fin d'année",componennt:"app-evaluation-final-list",isActive:false},
  ]
  public activeView:string="app-annee-scolaire-list";
  constructor(){}

  ngOnInit(): void {
    
  }
  ngOnDestroy(): void {
    
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
}
