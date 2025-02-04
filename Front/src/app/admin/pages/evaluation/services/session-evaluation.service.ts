import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { SessionEvaluationModel } from '../model/session.model';

@Injectable({
  providedIn: 'root'
})
export class SessionEvaluationService {

  constructor(private http:HttpClient) { }
   
  getSessions(): Observable<SessionEvaluationModel[]> {
    return this.http.get<SessionEvaluationModel[]>(`${environment.urlApi}api/sessions`)
  }

  getSession(id: number): Observable<SessionEvaluationModel> {
    return this.http.get<SessionEvaluationModel>(`${environment.urlApi}api/sessions/${id}`);
  }

  createSession(session: SessionEvaluationModel): Observable<SessionEvaluationModel> {
    return this.http.post<SessionEvaluationModel>(`${environment.urlApi}api/sessions`, session);
  }

  updateSession(id: number, session: SessionEvaluationModel): Observable<SessionEvaluationModel> {
    return this.http.put<SessionEvaluationModel>(`${environment.urlApi}api/sessions/${id}`, session);
  }

  deleteSession(id: number): Observable<void> {
    return this.http.delete<void>(`${environment.urlApi}api/sessions/${id}`);
  }

  getSessionsByNiveau(niveauId: number): Observable<SessionEvaluationModel[]> {
    return this.http.get<SessionEvaluationModel[]>(`${environment.urlApi}api/sessions/niveau/${niveauId}`);
  }
  // getAllCritere():Observable<CritereModel[]>{
  //   return this.http.get<CritereModel[]>(environment.urlApi+"api/critere")
  // }
}
