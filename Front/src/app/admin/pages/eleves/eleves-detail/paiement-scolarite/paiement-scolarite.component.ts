import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ElevesModel } from '../../model/elevesmodel';

@Component({
  selector: 'app-paiement-scolarite',
  templateUrl: './paiement-scolarite.component.html',
  styleUrls: ['./paiement-scolarite.component.css']
})
export class PaiementScolariteComponent implements OnInit,OnDestroy{
  @Input() eleve!:ElevesModel;
  constructor(){}
  ngOnInit(): void {
    
  }
  ngOnDestroy(): void {
    
  }
}