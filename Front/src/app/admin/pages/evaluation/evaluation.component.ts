import { Component } from '@angular/core';

@Component({
  selector: 'app-evaluation',
  templateUrl: './evaluation.component.html',
  styleUrls: ['./evaluation.component.css']
})
export class EvaluationComponent {
  public tabsNavigation:{name:string,isActive:boolean,componennt:string}[]=[
    {name:"Critères d'évaluation",componennt:"app-critere",isActive:true},
    {name:"Session d'évaluation",componennt:"app-session",isActive:false},
  ]
  public activeView:string="app-critere";
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
