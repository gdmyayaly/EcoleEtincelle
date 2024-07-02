import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ElevesModel } from '../../model/elevesmodel';
import { AnneeScolaireService } from '../../../scolarite/anneeScolaire/service/niveau-etude.service';
import { AnneeScolaireModel } from '../../../scolarite/anneeScolaire/model/anneeScolaire';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ElevesService } from '../../service/eleves.service';
import { OneEvaluationElevesModel } from '../../model/oneEvaluation';

@Component({
  selector: 'app-report-evaluation',
  templateUrl: './report-evaluation.component.html',
  styleUrls: ['./report-evaluation.component.css']
})
export class ReportEvaluationComponent implements OnInit,OnDestroy{
  @Input() eleve!:ElevesModel;
  public editorContent: string = '<strong>My initial content</strong>';
  public listAnneeScolaire:AnneeScolaireModel[]=[];
  evaluationForm= new FormGroup({
    anneeScolaire: new FormControl('',Validators.required),
  });
  public selectedEvaluation!:OneEvaluationElevesModel;
  constructor(private anneScolaireService:AnneeScolaireService,private elevesService:ElevesService){}
  ngOnInit(): void {
    this.loadAnneScolaire();
  }
  ngOnDestroy(): void {
    
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
  oneDateSelected(ev:any){
    console.log(ev.target.value);
    this.elevesService.detailOneEvaluationFromDateId(ev.target.value).subscribe(
      res=>{
        console.log("Détail evaluation");
        console.log(res);
        this.selectedEvaluation=res;
        this.editorContent=this.selectedEvaluation.htmlReport;
      },
      error=>{console.log(error);
      }
    )
    
  }
  saveRapport(){}
  exportWord(){
    var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
       var footer = "</body></html>";
       var sourceHTML = header+this.editorContent;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = this.eleve.prenom+this.eleve.nom+'.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
  }
  exportPdf(){}

}
