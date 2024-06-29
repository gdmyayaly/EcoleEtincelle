import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { CritereEvaluationFamilyService } from '../service/niveau-etude.service';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CritereEvaluationFamily } from '../model/critereEvaluationFamily';

@Component({
  selector: 'app-evaluation-final-detail',
  templateUrl: './evaluation-final-detail.component.html',
  styleUrls: ['./evaluation-final-detail.component.css']
})
export class EvaluationFinalDetailComponent implements OnInit, OnDestroy{
  @Input() id:number=0;
  public detailCritereEvaluation!:CritereEvaluationFamily;
  public formAddCritere= new FormGroup({
    question: new FormControl('',Validators.required),
    faitSeul: new FormControl('',Validators.required),
    neFaitPas: new FormControl('',Validators.required),
    faitAvecDeLAide: new FormControl('',Validators.required),
    nonEvaluer: new FormControl(''),
    id: new FormControl('')
  });
  constructor(private critereService:CritereEvaluationFamilyService){}
  ngOnInit(): void {
    this.loadDetail(this.id);
  }
  ngOnDestroy(): void {
    
  }
  loadDetail(id:number){
    this.critereService.loadDetailCritereEvaluationFamily(id).subscribe(
      res=>{console.log(res);
        this.detailCritereEvaluation=res;
      },
      error=>{console.log(error);
      }
    )
  }
  saveData(){
    console.log(this.formAddCritere.value);
    this.critereService.saveCritereEvaluation(this.formAddCritere.value).subscribe(
      res=>{console.log(res);
        this.detailCritereEvaluation=res;
        this.formAddCritere.reset();
        this.loadDetail(this.id);
      },
      error=>{console.log(error);
      }
    )
  }
}
