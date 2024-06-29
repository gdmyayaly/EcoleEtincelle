import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { MatDialog } from '@angular/material/dialog';
import { AnneeScolaireService } from '../service/niveau-etude.service';
import { AnneeScolaireModel } from '../model/anneeScolaire';

@Component({
  selector: 'app-annee-scolaire-list',
  templateUrl: './annee-scolaire-list.component.html',
  styleUrls: ['./annee-scolaire-list.component.css']
})
export class AnneeScolaireListComponent implements OnInit,OnDestroy{
  public showModal:boolean=false;
  public mouth:string[]=["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Décembre"]; 
  formAddScolarite= new FormGroup({
    moistart:new FormControl('',Validators.required),
    startYears:new FormControl('',Validators.required),
    moiend:new FormControl('',Validators.required),
    endYears:new FormControl('',Validators.required),
  })
  public listAnneeScolaire:AnneeScolaireModel[]=[];
  constructor(private anneeScolaireService:AnneeScolaireService){}
  ngOnInit(): void {
    this.loadData();
  }
  ngOnDestroy(): void {
    
  }
  openDialog(): void {
    this.showModal=true;
  }
  cancelModal(){
    this.showModal=false;
    this.formAddScolarite.reset();
  }
  saveAnnee(){
    console.log(this.formAddScolarite.value);
    this.anneeScolaireService.saveAnneeScolaire(this.formAddScolarite.value).subscribe(
      res=>{
        this.loadData();
      },
      error=>{
        console.error(error)
      }
    )
    this.cancelModal();
  }
  loadData(){
    this.anneeScolaireService.loadListAnneeScolaire().subscribe(
      res=>{
        this.listAnneeScolaire=res;
        console.log(res);
      },
      error=>{
        console.error(error)
      }
    )
  }
}
