import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { NiveauEtudeService } from '../service/niveau-etude.service';
import { NiveauEtudeModel } from '../model/niveauEtute';

@Component({
  selector: 'app-niveau-etude-list',
  templateUrl: './niveau-etude-list.component.html',
  styleUrls: ['./niveau-etude-list.component.css']
})
export class NiveauEtudeListComponent implements OnInit,OnDestroy {
  public showModal:boolean=false;
  public formAddNiveauEtude = new FormGroup({
    nom:new FormControl('',Validators.required),
    commentaire : new FormControl('')
  });
  public listNiveauEtude:NiveauEtudeModel[]=[];
  constructor(private niveauEtudeService:NiveauEtudeService){}

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
    this.formAddNiveauEtude.reset();
  }
  saveAnnee(){
    console.log(this.formAddNiveauEtude.value);
    this.niveauEtudeService.saveNiveauEtude(this.formAddNiveauEtude.value).subscribe(
      res=>{
        console.log(res);
        this.loadData();
      },
      error=>{
        console.log(error);
        
      }
    )
    this.cancelModal();
  }
  loadData(){
    this.niveauEtudeService.loadListEtude().subscribe(
      res=>{
        console.log("Perfect");
        console.log(res);
        this.listNiveauEtude=res;
      },
      error=>{
        console.log("Error");
        console.error(error)
      }
    )
  }
}
