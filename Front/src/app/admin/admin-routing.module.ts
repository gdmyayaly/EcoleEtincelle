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
      {path: 'scolarite', component: ScolariteComponent},

    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AdminRoutingModule { }
