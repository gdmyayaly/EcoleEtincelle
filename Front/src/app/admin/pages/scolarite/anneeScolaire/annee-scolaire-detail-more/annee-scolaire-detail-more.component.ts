import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { AnneeScolaireModel } from '../model/anneeScolaire';
import { NiveauEtudeModel } from '../../niveauEtude/model/niveauEtute';
import { NiveauEtudeService } from '../../niveauEtude/service/niveau-etude.service';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { AnneeScolaireService } from '../service/niveau-etude.service';
import { DetailMensualiteNiveauEtudeModel } from '../model/detailMensualite';

@Component({
  selector: 'app-annee-scolaire-detail-more',
  templateUrl: './annee-scolaire-detail-more.component.html',
  styleUrls: ['./annee-scolaire-detail-more.component.css']
})
export class AnneeScolaireDetailMoreComponent implements OnInit,OnDestroy{
  @Input() anneeScolaire!:AnneeScolaireModel;
  public listNiveauEtude:NiveauEtudeModel[]=[];
  public niveauEtudeSelected!:NiveauEtudeModel;
  public showSubmitBtn:boolean=true;
  public formPaiement:FormGroup=this.formBuilder.group({
    anneeScolaire: new FormControl('',Validators.required),
    niveauEtude: new FormControl('',Validators.required),
  });
  FixTerm:string="";
  public detailMensualiteNiveauEtudeSelected:DetailMensualiteNiveauEtudeModel[]=[];

  
  constructor(private niveauEtudeService:NiveauEtudeService,private anneeScolaireService:AnneeScolaireService,private formBuilder:FormBuilder){}
  ngOnInit(): void {
    console.log(this.anneeScolaire);
    this.loadDataNiveauEtude();
    this.loadForm();
  }
  ngOnDestroy(): void {
    
  }
  loadDataNiveauEtude(){
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
  loadForm(){
    for (let index = 0; index < this.anneeScolaire.anneeScolaireMensualites.length; index++) {
        this.formPaiement.addControl('paiement'+this.anneeScolaire.anneeScolaireMensualites[index].id,new FormControl('',Validators.required))      
    }
    this.formPaiement.disable();
  }
  paiementNiveauEtude(item:NiveauEtudeModel){
    console.log(item);
    this.FixTerm="";
    this.niveauEtudeSelected=item;
    this.anneeScolaireService.verificationPaiementScolarite(item.id).subscribe(
      res=>{
        console.log(res);
        this.detailMensualiteNiveauEtudeSelected=res;
        if (this.detailMensualiteNiveauEtudeSelected.length>0) {
          this.formPaiement.get('niveauEtude')?.setValue(this.niveauEtudeSelected.id)  
          this.formPaiement.get('anneeScolaire')?.setValue(this.anneeScolaire.id)  
          for (let index = 0; index < this.detailMensualiteNiveauEtudeSelected.length; index++) {
            this.formPaiement.get('paiement'+this.detailMensualiteNiveauEtudeSelected[index].anneeScolaire.anneeScolaireMensualites[index].id)?.setValue(this.detailMensualiteNiveauEtudeSelected[index].montant)  
          }
          this.showSubmitBtn=false;
        }
        else{
          this.showSubmitBtn=true;
          this.formPaiement.reset();
          this.formPaiement.get('niveauEtude')?.setValue(this.niveauEtudeSelected.id)  
          this.formPaiement.get('anneeScolaire')?.setValue(this.anneeScolaire.id)  
          this.formPaiement.enable();

        }
      },
      error=>{
        console.log(error);
      }
    )
  }
  saveData(){
    console.log(this.formPaiement.value);

    this.anneeScolaireService.savePlannigDePaiement(this.formPaiement.value).subscribe(
      res=>{
        console.log(res);
        this.formPaiement.reset();
        this.showSubmitBtn=false;
      },
      error=>{
        console.log(error);
      }
    )
  }
  FixMensualite(): void {
    // this.FixTerm
    for (let index = 0; index < this.anneeScolaire.anneeScolaireMensualites.length; index++) {
      this.formPaiement.get('paiement'+this.anneeScolaire.anneeScolaireMensualites[index].id)?.setValue(this.FixTerm);
      // this.formPaiement.addControl('paiement'+this.anneeScolaire.anneeScolaireMensualites[index].id,new FormControl('',Validators.required))      
    }
  }
  onSearchChange(event: any) {
    this.FixTerm=event.target.value;
    for (let index = 0; index < this.anneeScolaire.anneeScolaireMensualites.length; index++) {
      this.formPaiement.get('paiement'+this.anneeScolaire.anneeScolaireMensualites[index].id)?.setValue(this.FixTerm);
      // this.formPaiement.addControl('paiement'+this.anneeScolaire.anneeScolaireMensualites[index].id,new FormControl('',Validators.required))      
    }
  }
}
