import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { ParentElevesModel } from '../model/parentEleves';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ParentElevesService {

  constructor(private http:HttpClient) {
   }
  saveParentEleves(data:any):Observable<ParentElevesModel>{
    return this.http.post<ParentElevesModel>(environment.urlApi+"api/parent_eleves" , data )
  }
  listParentEleves():Observable<ParentElevesModel[]>{
    return this.http.get<ParentElevesModel[]>(environment.urlApi+"api/parent_eleves")
  }
  getById(id:number):Observable<ParentElevesModel>{
    return this.http.get<ParentElevesModel>(environment.urlApi+"api/parent_eleves_detail/"+id)
  }
  update(data:any,id:number):Observable<ParentElevesModel>{
    return this.http.post<ParentElevesModel>(environment.urlApi+"api/parent_eleves_update/"+id , data )
  }
}
