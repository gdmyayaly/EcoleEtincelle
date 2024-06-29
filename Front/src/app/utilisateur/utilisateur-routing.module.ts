import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeUtilisateurComponent } from './pages/home-utilisateur/home-utilisateur.component';
import { UtilisateurComponent } from './utilisateur.component';

const routes: Routes = [
  {
    path: '',
    component: UtilisateurComponent,children:[
      {path: '', component: HomeUtilisateurComponent},

    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UtilisateurRoutingModule { }
