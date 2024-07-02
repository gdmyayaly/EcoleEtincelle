import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';
import { AnneeScolaireModel } from '../model/anneeScolaire';
import { DetailMensualiteNiveauEtudeModel } from '../model/detailMensualite';

@Injectable({
  providedIn: 'root'
})
export class AnneeScolaireService {

  constructor(private http:HttpClient) { }

  loadListAnneeScolaire():Observable<any>{
    return this.http.get<any>(environment.urlApi+"api/scolarite/annee")
  }
  saveAnneeScolaire(data:any):Observable<AnneeScolaireModel>{
    return this.http.post<AnneeScolaireModel>(environment.urlApi+"api/scolarite/annee",data)
  }
  verificationPaiementScolarite(id:number):Observable<DetailMensualiteNiveauEtudeModel[]>{
    return this.http.get<DetailMensualiteNiveauEtudeModel[]>(environment.urlApi+"api/gestion_paiement/verification/"+id)
  }
  savePlannigDePaiement(data:any):Observable<any>{
    return this.http.post<any>(environment.urlApi+"api/gestion_paiement/saveplanningpaiementscolaire",data)
  }
}
