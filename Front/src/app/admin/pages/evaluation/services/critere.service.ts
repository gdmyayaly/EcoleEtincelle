import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { CritereModel } from '../model/critere.model';
import { CriteresQuestionModel } from '../model/critere-question.model';

@Injectable({
  providedIn: 'root'
})
export class CritereService {

  constructor(private http:HttpClient) { }
 
   getAllCritere():Observable<CritereModel[]>{
     return this.http.get<CritereModel[]>(environment.urlApi+"api/critere")
   }
   create(data:any):Observable<CritereModel>{
    return this.http.post<CritereModel>(environment.urlApi+"api/critere",data)
  }
  getId(id:number):Observable<CritereModel>{
    return this.http.get<CritereModel>(environment.urlApi+"api/critere/detail/"+id)
  }
  update(data:any,id:number):Observable<CritereModel>{
    return this.http.post<CritereModel>(environment.urlApi+"api/critere/update/"+id,data)
  }
  createQuestion(data:any):Observable<CriteresQuestionModel>{
    return this.http.post<CriteresQuestionModel>(environment.urlApi+"api/questions",data)
  }
  updateQuestion(data:any):Observable<CriteresQuestionModel>{
    return this.http.post<CriteresQuestionModel>(environment.urlApi+"api/questions/update",data)
  }
}
