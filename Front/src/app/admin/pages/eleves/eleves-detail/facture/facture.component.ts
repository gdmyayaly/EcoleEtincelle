import { Component, ElementRef, Input, ViewChild } from '@angular/core';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { ElevesModel } from '../../model/elevesmodel';
@Component({
  selector: 'app-facture',
  templateUrl: './facture.component.html',
  styleUrls: ['./facture.component.css']
})
export class FactureComponent {
  @ViewChild('invoice') invoiceElement!: ElementRef;
  @Input() eleve!:ElevesModel;
  @Input() montant:string="";
  @Input() moi:string="";
  @Input() niveauEtude:string="";
  @Input() anneeScolaire:string="";

  downloadPDF() {
    const DATA = this.invoiceElement.nativeElement;
    html2canvas(DATA, { backgroundColor: null }).then(canvas => {
      const imgWidth = 208;
      const imgHeight = canvas.height * imgWidth / canvas.width;
      const contentDataURL = canvas.toDataURL('image/png');
      let pdf = new jsPDF('p', 'mm', 'a4'); 
      const position = 0;
      pdf.addImage(contentDataURL, 'PNG', 0, position, imgWidth, imgHeight);
      pdf.save('facture.pdf');
    });
  }
}
