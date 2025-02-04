import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeAdminComponent } from './pages/home-admin/home-admin.component';
import { AdminComponent } from './admin.component';
import { ElevesListComponent } from './pages/eleves/eleves-list/eleves-list.component';
import { ElevesAddComponent } from './pages/eleves/eleves-add/eleves-add.component';
import { ParentListComponent } from './pages/parentEleves/parent-list/parent-list.component';
import { ParentAddComponent } from './pages/parentEleves/parent-add/parent-add.component';
import { ScolariteComponent } from './pages/scolarite/scolarite.component';
import { ElevesDetailComponent } from './pages/eleves/eleves-detail/eleves-detail.component';
import { NiveauEtudeDetailComponent } from './pages/scolarite/niveauEtude/niveau-etude-detail/niveau-etude-detail.component';
import { EvaluationComponent } from './pages/evaluation/evaluation.component';
import { CritereComponent } from './pages/evaluation/critere/critere.component';
import { CritereDetailComponent } from './pages/evaluation/critere/critere-detail/critere-detail.component';
import { SessionComponent } from './pages/evaluation/session/session.component';

const routes: Routes = [
  {
    path: '',
    component: AdminComponent,children:[
      {path: '', component: HomeAdminComponent},
      {path: 'eleves', component: ElevesListComponent},
      {path: 'eleves/add', component: ElevesAddComponent},
      {path: 'eleves/detail/:id', component: ElevesDetailComponent},

      {path: 'parent', component: ParentListComponent},
      {path: 'parent/add', component: ParentAddComponent},
      {path: 'parent/add/:id', component: ParentAddComponent},
      {path: 'scolarite', component: ScolariteComponent},
      {path: 'scolarite/niveau-etude/:id', component: NiveauEtudeDetailComponent},
      {path: 'evaluation/critere', component: CritereComponent},
      {path: 'evaluation/critere/:id', component: CritereDetailComponent},
      {path: 'evaluation/session', component: SessionComponent},
      {path: 'evaluation/session/:id', component: CritereDetailComponent},
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AdminRoutingModule { }
