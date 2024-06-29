import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { ElevesModel } from '../model/elevesmodel';

@Injectable({
  providedIn: 'root'
})
export class ElevesService {

  constructor(private http:HttpClient) {
  }
 saveEleves(data:any):Observable<ElevesModel>{
   return this.http.post<ElevesModel>(environment.urlApi+"api/eleves" , data )
 }
 listEleves():Observable<ElevesModel[]>{
   return this.http.get<ElevesModel[]>(environment.urlApi+"api/eleves")
 }
 detailEleves(id:any):Observable<ElevesModel>{
  return this.http.get<ElevesModel>(environment.urlApi+"api/eleves/detail/"+id)
 }
}
