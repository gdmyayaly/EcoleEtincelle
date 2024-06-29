import { Component, OnDestroy, OnInit } from '@angular/core';
import { ElevesService } from '../service/eleves.service';
import { ActivatedRoute } from '@angular/router';
import { ElevesModel } from '../model/elevesmodel';

@Component({
  selector: 'app-eleves-detail',
  templateUrl: './eleves-detail.component.html',
  styleUrls: ['./eleves-detail.component.css']
})
export class ElevesDetailComponent implements OnInit,OnDestroy{
  public id:string="0";
  public onEleves!:ElevesModel;
  public tabsNavigation:{name:string,isActive:boolean,componennt:string}[]=[
    {name:"Fiche",componennt:"app-fiche-eleve",isActive:true},
    {name:"Paiement",componennt:"app-paiement-scolarite",isActive:false},
    {name:"Évaluation fin d'année",componennt:"app-evaluation-fin-annee",isActive:false},
    {name:"Rapport Fin d'année",componennt:"app-report-evaluation",isActive:false},

  ]
  public activeView:string="app-fiche-eleve";
  constructor(private elevesService:ElevesService,private activeRoute:ActivatedRoute){}
  ngOnInit(): void {
    this.id = this.activeRoute.snapshot.paramMap.get('id') ?? "0";
    this.loadOneEleves();
  }
  ngOnDestroy(): void {
    
  }
  loadOneEleves(){
    this.elevesService.detailEleves(this.id).subscribe(
      res=>{console.log(res);
        this.onEleves=res;
      },
      error=>{
        console.log(error);
        
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
}
