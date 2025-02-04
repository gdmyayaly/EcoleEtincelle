import { Component } from '@angular/core';
import { SessionEvaluationService } from '../services/session-evaluation.service';
import { NiveauEtudeService } from '../../scolarite/niveauEtude/service/niveau-etude.service';
import { NiveauEtudeModel } from '../../scolarite/niveauEtude/model/niveauEtute';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { SessionEvaluationModel } from '../model/session.model';

@Component({
  selector: 'app-session',
  templateUrl: './session.component.html',
  styleUrls: ['./session.component.css']
})
export class SessionComponent {
  sessions: SessionEvaluationModel[] = [];
  niveaux: NiveauEtudeModel[] = [];
  sessionForm: FormGroup;
  editingSession: SessionEvaluationModel | null = null;

  constructor(private sessionService:SessionEvaluationService,private niveauEtudeService:NiveauEtudeService,private fb: FormBuilder) {
    this.sessionForm = this.fb.group({
      nom: ['', Validators.required],
      dateLimit: ['', Validators.required],
      isActive: [false],
      niveauxEtudes: this.fb.array([], Validators.required)
    });
  }

  ngOnInit(): void {
    this.loadDataNiveau();
    this.loadSessions();
  }
  loadDataNiveau(){
    this.niveauEtudeService.loadListEtude().subscribe(
      res=>{
        console.log("Perfect");
        console.log(res);
        this.niveaux=res;
      },
      error=>{
        console.log("Error");
        console.error(error)
      }
    )
  }
  get niveauxFormArray() {
    return this.sessionForm.get('niveauxEtudes') as FormArray;
  }

  onNiveauChange(niveauId: number, event: any): void {
    if (event.target.checked) {
      this.niveauxFormArray.push(this.fb.control(niveauId));
    } else {
      const index = this.niveauxFormArray.controls.findIndex(x => x.value === niveauId);
      if (index >= 0) {
        this.niveauxFormArray.removeAt(index);
      }
    }
  }

  isNiveauSelected(niveauId: number): boolean {
    return this.niveauxFormArray.controls.some(x => x.value === niveauId);
  }

  loadSessions(): void {
    this.sessionService.getSessions().subscribe(
      data => this.sessions = data
    );
  }

  onSubmit(): void {
    if (this.sessionForm.valid) {
      const session = this.sessionForm.value;
      if (this.editingSession) {
        this.sessionService.updateSession(this.editingSession.id!, session)
          .subscribe(() => {
            this.loadSessions();
            this.resetForm();
          });
      } else {
        this.sessionService.createSession(session)
          .subscribe(() => {
            this.loadSessions();
            this.resetForm();
          });
      }
    }
  }

  editSession(session: SessionEvaluationModel): void {
    this.editingSession = session;
    console.log(session);
    
    this.sessionForm.patchValue({
      nom: session.nom,
      dateLimit: session.dateLimit.toString().split('T')[0],
      isActive: session.isActive
    });
    console.log(this.sessionForm);
    
    // Reset niveaux checkboxes
    this.niveauxFormArray.clear();
    session.sessionsNiveauxes?.forEach(niveau => {
      this.niveauxFormArray.push(this.fb.control(niveau.niveauEtude.id));
    });
  }

  deleteSession(id: number): void {
    this.sessionService.deleteSession(id)
      .subscribe(() => this.loadSessions());
  }

  resetForm(): void {
    this.editingSession = null;
    this.sessionForm.reset();
    this.niveauxFormArray.clear();
  }
}
