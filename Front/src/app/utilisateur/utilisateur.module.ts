import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { UtilisateurRoutingModule } from './utilisateur-routing.module';
import { HomeUtilisateurComponent } from './pages/home-utilisateur/home-utilisateur.component';
import { UtilisateurComponent } from './utilisateur.component';


@NgModule({
  declarations: [
    HomeUtilisateurComponent,
    UtilisateurComponent
  ],
  imports: [
    CommonModule,
    UtilisateurRoutingModule
  ]
})
export class UtilisateurModule { }
