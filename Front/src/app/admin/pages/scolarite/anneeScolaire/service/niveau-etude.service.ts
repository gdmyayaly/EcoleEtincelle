import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';
import { AnneeScolaireModel } from '../model/anneeScolaire';

@Injectable({
  providedIn: 'root'
})
export class AnneeScolaireService {

  constructor(private http:HttpClient) { }

  loadListAnneeScolaire():Observable<AnneeScolaireModel[]>{
    return this.http.get<AnneeScolaireModel[]>(environment.urlApi+"api/scolarite/annee")
  }
  saveAnneeScolaire(data:any):Observable<AnneeScolaireModel>{
    return this.http.post<AnneeScolaireModel>(environment.urlApi+"api/scolarite/annee",data)
  }
}
