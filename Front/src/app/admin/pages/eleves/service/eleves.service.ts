import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { ElevesModel } from '../model/elevesmodel';
import { OneEvaluationElevesModel } from '../model/oneEvaluation';

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
 saveOneEvaluationEleves(data:any):Observable<OneEvaluationElevesModel>{
  return this.http.post<OneEvaluationElevesModel>(environment.urlApi+"api/eleves/save-evaluation",data)
  }
  detailOneEvaluationFromDateId(id:any):Observable<OneEvaluationElevesModel>{
    return this.http.get<OneEvaluationElevesModel>(environment.urlApi+"api/eleves/one-evaluation/"+id)
  }
}
