import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AdminRoutingModule } from './admin-routing.module';
import { HomeAdminComponent } from './pages/home-admin/home-admin.component';
import { AdminComponent } from './admin.component';
import { MenuComponent } from './layout/menu/menu.component';
import { SidebarComponent } from './layout/sidebar/sidebar.component';
import { TopbarComponent } from './layout/topbar/topbar.component';
import { ElevesDetailComponent } from './pages/eleves/eleves-detail/eleves-detail.component';
import { ElevesListComponent } from './pages/eleves/eleves-list/eleves-list.component';
import { ElevesAddComponent } from './pages/eleves/eleves-add/eleves-add.component';
import { ParentAddComponent } from './pages/parentEleves/parent-add/parent-add.component';
import { ParentListComponent } from './pages/parentEleves/parent-list/parent-list.component';
import { ParentDetailComponent } from './pages/parentEleves/parent-detail/parent-detail.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ScolariteComponent } from './pages/scolarite/scolarite.component';
import { NiveauEtudeListComponent } from './pages/scolarite/niveauEtude/niveau-etude-list/niveau-etude-list.component';
import { NiveauEtudeAddComponent } from './pages/scolarite/niveauEtude/niveau-etude-add/niveau-etude-add.component';
import { NiveauEtudeDetailComponent } from './pages/scolarite/niveauEtude/niveau-etude-detail/niveau-etude-detail.component';
import { AnneeScolaireAddComponent } from './pages/scolarite/anneeScolaire/annee-scolaire-add/annee-scolaire-add.component';
import { AnneeScolaireListComponent } from './pages/scolarite/anneeScolaire/annee-scolaire-list/annee-scolaire-list.component';
import { AnneeScolaireDetailComponent } from './pages/scolarite/anneeScolaire/annee-scolaire-detail/annee-scolaire-detail.component';
import { EvaluationFinalListComponent } from './pages/scolarite/EvaluationFinal/evaluation-final-list/evaluation-final-list.component';
import { EvaluationFinalAddComponent } from './pages/scolarite/EvaluationFinal/evaluation-final-add/evaluation-final-add.component';
import { EvaluationFinalDetailComponent } from './pages/scolarite/EvaluationFinal/evaluation-final-detail/evaluation-final-detail.component';
import {MatDialogModule} from '@angular/material/dialog';
import { FicheEleveComponent } from './pages/eleves/eleves-detail/fiche-eleve/fiche-eleve.component';
import { EvaluationFinAnneeComponent } from './pages/eleves/eleves-detail/evaluation-fin-annee/evaluation-fin-annee.component';
import { PaiementScolariteComponent } from './pages/eleves/eleves-detail/paiement-scolarite/paiement-scolarite.component';
import { FroalaEditorModule, FroalaViewModule } from 'angular-froala-wysiwyg';
import { ReportEvaluationComponent } from './pages/eleves/eleves-detail/report-evaluation/report-evaluation.component';

@NgModule({
  declarations: [
    AdminComponent,
    HomeAdminComponent,
    MenuComponent,
    SidebarComponent,
    TopbarComponent,
    ElevesDetailComponent,
    ElevesListComponent,
    ElevesAddComponent,
    ParentAddComponent,
    ParentListComponent,
    ParentDetailComponent,
    ScolariteComponent,
    NiveauEtudeListComponent,
    NiveauEtudeAddComponent,
    NiveauEtudeDetailComponent,
    AnneeScolaireAddComponent,
    AnneeScolaireListComponent,
    AnneeScolaireDetailComponent,
    EvaluationFinalListComponent,
    EvaluationFinalAddComponent,
    EvaluationFinalDetailComponent,
    FicheEleveComponent,
    EvaluationFinAnneeComponent,
    PaiementScolariteComponent,
    ReportEvaluationComponent
  ],
  
  imports: [
    CommonModule,
    AdminRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    MatDialogModule,
    FroalaEditorModule.forRoot(),
    FroalaViewModule.forRoot()

  ],

  // schemas: [CUSTOM_ELEMENTS_SCHEMA],
})
export class AdminModule { }
