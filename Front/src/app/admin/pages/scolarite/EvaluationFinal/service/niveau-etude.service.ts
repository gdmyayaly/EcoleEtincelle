import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';
import { CritereEvaluationFamily } from '../model/critereEvaluationFamily';
import { CriteresEvaluationsModel } from '../model/criteresEvaluations';

@Injectable({
  providedIn: 'root'
})
export class CritereEvaluationFamilyService {

  constructor(private http:HttpClient) { }

  loadListCritereEvaluationFamily():Observable<CritereEvaluationFamily[]>{
    return this.http.get<CritereEvaluationFamily[]>(environment.urlApi+"api/scolarite/critere-evaluation-family")
  }
  saveCritereEvaluationFamily(data:any):Observable<CritereEvaluationFamily>{
    return this.http.post<CritereEvaluationFamily>(environment.urlApi+"api/scolarite/critere-evaluation-family",data)
  }
  loadDetailCritereEvaluationFamily(id:number):Observable<CritereEvaluationFamily>{
    return this.http.get<CritereEvaluationFamily>(environment.urlApi+"api/scolarite/critere-evaluation-family/detail/"+id)
  }

  listGroupCritereEvaluation():Observable<CritereEvaluationFamily[]>{
    return this.http.get<CritereEvaluationFamily[]>(environment.urlApi+"api/scolarite/critere-evaluation-group")
  }
  saveCritereEvaluationGroupe(data:any):Observable<CritereEvaluationFamily>{
    return this.http.post<CritereEvaluationFamily>(environment.urlApi+"api/scolarite/critere-evaluation-group",data)
  }

  listCritereEvaluation():Observable<CriteresEvaluationsModel[]>{
    return this.http.get<CriteresEvaluationsModel[]>(environment.urlApi+"api/scolarite/critere-evaluation")
  }
  saveCritereEvaluation(data:any):Observable<any>{
    return this.http.post<any>(environment.urlApi+"api/scolarite/critere-evaluation",data)
  }
}
