import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { CritereEvaluationFamilyService } from '../service/niveau-etude.service';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CritereEvaluationFamily } from '../model/critereEvaluationFamily';
import { CriteresEvaluationsModel } from '../model/criteresEvaluations';

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
  dataFormSelected!:CriteresEvaluationsModel;
  public idQuestionSelected:number=0;
  public showBtnUpdateForm:boolean=false;
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
  onChangeSelectedCritere(id:number,idSelec:number){
    // console.log(ev.target.value);
    this.critereService.detailOneGroupCritereEvaluation(id).subscribe(
      res=>{console.log(res);
        this.dataFormSelected=res;
        if (this.dataFormSelected!=null) {
          this.idQuestionSelected=this.dataFormSelected.id;
          this.formAddCritere.get('id')?.setValue(idSelec.toString())
          this.formAddCritere.get('question')?.setValue(this.dataFormSelected.question)
          this.formAddCritere.get('faitSeul')?.setValue(this.dataFormSelected.faitSeul)
          this.formAddCritere.get('neFaitPas')?.setValue(this.dataFormSelected.neFaitPas)
          this.formAddCritere.get('faitAvecDeLAide')?.setValue(this.dataFormSelected.faitAvecDeLAide)
          this.formAddCritere.get('nonEvaluer')?.setValue(this.dataFormSelected.nonEvaluer)
          this.showBtnUpdateForm=true;
        } else {
          this.showBtnUpdateForm=false;
          this.formAddCritere.get('question')?.setValue("")
          this.formAddCritere.get('faitSeul')?.setValue("")
          this.formAddCritere.get('neFaitPas')?.setValue("")
          this.formAddCritere.get('faitAvecDeLAide')?.setValue("")
          this.formAddCritere.get('nonEvaluer')?.setValue("")
        }
        
      },
      error=>{console.log(error);
      }
    )

  }
  updateFrom(){
    console.log("Update Formulaire");
    console.log(this.formAddCritere.value);
    console.log(this.dataFormSelected.id);
    this.critereService.updateOneCritereEvaluation(this.formAddCritere.value,this.dataFormSelected.id).subscribe(
      res=>{console.log(res);
        this.loadDetail(this.id);
        // this.showBtnUpdateForm=false;
        // this.formAddCritere.reset();
      },
      error=>{console.log(error);
      }
    )
  }
  cancelModifData(){
    // this.loadDetail(this.id);
    this.showBtnUpdateForm=false;
    this.formAddCritere.get('question')?.setValue("")
    this.formAddCritere.get('faitSeul')?.setValue("")
    this.formAddCritere.get('neFaitPas')?.setValue("")
    this.formAddCritere.get('faitAvecDeLAide')?.setValue("")
    this.formAddCritere.get('nonEvaluer')?.setValue("")
  }
}
