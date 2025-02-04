import { Component, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CritereModel } from '../../model/critere.model';
import { ActivatedRoute, Router } from '@angular/router';
import { CritereService } from '../../services/critere.service';

@Component({
  selector: 'app-critere-detail',
  templateUrl: './critere-detail.component.html',
  styleUrls: ['./critere-detail.component.css']
})
export class CritereDetailComponent implements OnInit{
  public id: number=0;

  public detailCritereEvaluation!:CritereModel;
  public formAddCritere= new FormGroup({
    question: new FormControl('',Validators.required),
    faitSeul: new FormControl('',Validators.required),
    neFaitPas: new FormControl('',Validators.required),
    faitAvecDeLAide: new FormControl('',Validators.required),
    nonEvaluer: new FormControl(''),
    id: new FormControl(''),
    questionId : new FormControl('')
  });
  public showBtnUpdateForm:boolean=false;
  constructor(public critereService:CritereService,private route: ActivatedRoute,private router:Router){}
  ngOnInit(): void {
    this.id = this.route.snapshot.params['id'];
    if (this.id!=0) {
      this.loadDetail(this.id);
      this.formAddCritere.get('id')?.setValue(this.id.toString())
    }
    else{
      alert("Page inaccessible")
      this.router.navigateByUrl("/admin/evaluation/critere");
    }
  }
  ngOnDestroy(): void {
    
  }
  loadDetail(id:number){
    this.critereService.getId(id).subscribe(
      res=>{console.log(res);
        this.detailCritereEvaluation=res;
      },
      error=>{console.log(error);
      }
    )
  }
  saveData(){
    this.critereService.createQuestion(this.formAddCritere.value).subscribe(
      res=>{console.log(res);
        this.loadDetail(this.id);
        this.showBtnUpdateForm=false;
        this.resetForm();
      },
      error=>{console.error(error)}
    )
  }
  onChangeSelectedCritere(idQuestion:number){
    this.showBtnUpdateForm=true;
    this.formAddCritere.get('questionId')?.setValue(idQuestion.toString());
    let Question=this.detailCritereEvaluation.critereQuestions.find(r=>r.id==idQuestion);
    this.formAddCritere.get('question')?.setValue(Question?.question ?? "");
    this.formAddCritere.get('faitSeul')?.setValue(Question?.faitSeul ?? "");
    this.formAddCritere.get('neFaitPas')?.setValue(Question?.neFaitPas ?? "");
    this.formAddCritere.get('faitAvecDeLAide')?.setValue(Question?.faitAvecDeLAide ?? "");
    this.formAddCritere.get('nonEvaluer')?.setValue(Question?.nonEvaluer ?? "");
  }
  updateFrom(){
    this.critereService.updateQuestion(this.formAddCritere.value).subscribe(
      res=>{console.log(res);
        this.loadDetail(this.id);
        this.showBtnUpdateForm=false;
        this.resetForm();
      },
      error=>{console.error(error)}
    )
  }
  cancelModifData(){
    this.showBtnUpdateForm=false;
  }
  resetForm(){
    this.formAddCritere.reset();
    this.formAddCritere.get('id')?.setValue(this.id.toString())
  }
}
