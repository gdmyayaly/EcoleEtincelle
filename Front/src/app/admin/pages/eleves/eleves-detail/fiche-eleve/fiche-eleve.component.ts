import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ElevesModel } from '../../model/elevesmodel';

@Component({
  selector: 'app-fiche-eleve',
  templateUrl: './fiche-eleve.component.html',
  styleUrls: ['./fiche-eleve.component.css']
})
export class FicheEleveComponent implements OnInit,OnDestroy{
  @Input() eleve!:ElevesModel;
  constructor(){}
  ngOnInit(): void {
    
  }
  ngOnDestroy(): void {
    
  }
}
