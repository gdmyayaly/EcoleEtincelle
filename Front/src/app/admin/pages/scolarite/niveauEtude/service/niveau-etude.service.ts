import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { NiveauEtudeModel } from '../model/niveauEtute';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class NiveauEtudeService {

  constructor(private http:HttpClient) { }

  loadListEtude():Observable<NiveauEtudeModel[]>{
    return this.http.get<NiveauEtudeModel[]>(environment.urlApi+"api/scolarite/niveau-etude")
  }
  saveNiveauEtude(data:any):Observable<NiveauEtudeModel>{
    return this.http.post<NiveauEtudeModel>(environment.urlApi+"api/scolarite/niveau-etude",data)
  }
  loadOneNiveauEtude(id:string):Observable<NiveauEtudeModel>{
    return this.http.get<NiveauEtudeModel>(environment.urlApi+"api/scolarite/niveau-etude_detail/"+id)
  }
  updateOneNiveauEtude(data:any):Observable<NiveauEtudeModel>{
    return this.http.post<NiveauEtudeModel>(environment.urlApi+"api/scolarite/niveau-etude_update/"+data.id,data)
  }
}
