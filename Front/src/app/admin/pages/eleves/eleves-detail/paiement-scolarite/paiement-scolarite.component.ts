import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ElevesModel } from '../../model/elevesmodel';
import { AnneeScolaireModel } from '../../../scolarite/anneeScolaire/model/anneeScolaire';
import { AnneeScolaireService } from '../../../scolarite/anneeScolaire/service/niveau-etude.service';
import { ElevesService } from '../../service/eleves.service';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ElevesPaiementModel } from '../../model/elevespaiement';
import { DetailMensualiteNiveauEtudeModel } from '../../../scolarite/anneeScolaire/model/detailMensualite';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
@Component({
  selector: 'app-paiement-scolarite',
  templateUrl: './paiement-scolarite.component.html',
  styleUrls: ['./paiement-scolarite.component.css']
})
export class PaiementScolariteComponent implements OnInit,OnDestroy{
  @Input() eleve!:ElevesModel;
  public listAnneeScolaire:AnneeScolaireModel[]=[];
  evaluationForm= new FormGroup({
    anneeScolaire: new FormControl('',Validators.required),
  });
  public detailPaiement!:ElevesPaiementModel;
  public formAddPaiement = new FormGroup({
    moi: new FormControl('',Validators.required),
    montant: new FormControl('',Validators.required),
    eleve: new FormControl('',Validators.required),
    anneeScolaire: new FormControl('',Validators.required),
    commentaire: new FormControl(''),
  })
  public mensualiteSelected!:DetailMensualiteNiveauEtudeModel;
  public showModal:boolean=false;
  public showFacture:boolean=false;
  constructor(private anneScolaireService:AnneeScolaireService,private elevesService:ElevesService){}
  ngOnInit(): void {
    console.log(this.eleve);
    this.loadAnneScolaire()
  }
  ngOnDestroy(): void {
    
  }
  loadAnneScolaire(){
    this.anneScolaireService.loadListAnneeScolaire().subscribe(
      res=>{
        console.log("Année Scolaire");
        console.log(res);
        this.listAnneeScolaire=res;
      },
      error=>{console.log(error);
      }
    )
  }
  oneDateSelected(ev:any){
    console.log(ev.target.value);
    this.elevesService.detailPaiementEleves(ev.target.value,this.eleve.id).subscribe(
      res=>{
        console.log(res);
        this.detailPaiement=res;
      },
      error=>{console.log(error);
      }
    )
    
  }
  submitPaiement(item:DetailMensualiteNiveauEtudeModel){
    this.showModal=true;
    this.mensualiteSelected=item;
    this.formAddPaiement.get('moi')?.setValue(this.mensualiteSelected.mensualite.id.toString())
    this.formAddPaiement.get('montant')?.setValue(this.mensualiteSelected.montant.toString())
    this.formAddPaiement.get('eleve')?.setValue(this.eleve.id.toString())
    this.formAddPaiement.get('anneeScolaire')?.setValue(this.evaluationForm.get('anneeScolaire')?.value ?? "");

  }
  savePaiement(){
    console.log(this.formAddPaiement.value);
    let idAnnee=this.formAddPaiement.get('anneeScolaire')?.value;
    console.log(idAnnee);
    
    this.elevesService.submitPaiement(this.formAddPaiement.value).subscribe(
      res=>{
        console.log(res);
        this.cancelModal();
        this.elevesService.detailPaiementEleves(idAnnee,this.eleve.id).subscribe(
          resP=>{
            console.log(resP);
            this.detailPaiement=resP;
          },
          errors=>{console.log(errors);
          }
        )

      },
      error=>{console.log(error);
      }
    )
  }
  cancelModal(){
    this.showModal=false;
    this.formAddPaiement.reset();
    this.showFacture=false;
  }
  isPayed(item:DetailMensualiteNiveauEtudeModel):boolean{
    if (this.detailPaiement.dataFicheDePaiement.find(r=>r.scolaritePaiement.mensualite.name==item.mensualite.name)) {
      return true;
    } else {
      return false;
    }
  }
  generateFacture(item:DetailMensualiteNiveauEtudeModel){
    let goodData=this.detailPaiement.dataFicheDePaiement.find(r=>r.scolaritePaiement.mensualite.name==item.mensualite.name);
    this.mensualiteSelected=item;
    this.showFacture=true;
    // console.log(goodData);
    // console.log(goodData?.htmlFacture);
    // this.downloadPDF(goodData?.htmlFacture)
  }
  downloadPDF(data:any) {
    // var data = document.getElementById('contentToConvert');
    html2canvas(data).then(canvas => {
    // Few necessary setting options
    var imgWidth = 208;
    var pageHeight = 295;
    var imgHeight = canvas.height * imgWidth / canvas.width;
    var heightLeft = imgHeight;

    const contentDataURL = canvas.toDataURL('image/png')
    let pdf = new jsPDF('p', 'mm', 'a4'); // A4 size page of PDF
    var position = 0;
    pdf.addImage(contentDataURL, 'PNG', 0, position, imgWidth, imgHeight)
    pdf.save('new-file.pdf'); // Generated PDF
    });
    }
    // const DATA = data;
    // html2canvas(DATA).then(canvas => {
    //   const imgWidth = 208;
    //   const imgHeight = canvas.height * imgWidth / canvas.width;
    //   const contentDataURL = canvas.toDataURL('image/png');
    //   let pdf = new jsPDF('p', 'mm', 'a4'); 
    //   const position = 0;
    //   pdf.addImage(contentDataURL, 'PNG', 0, position, imgWidth, imgHeight);
    //   pdf.save('facture.pdf');
    // });
  //}
}