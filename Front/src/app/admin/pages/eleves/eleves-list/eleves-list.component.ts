import { Component, OnDestroy, OnInit } from '@angular/core';
import { ElevesService } from '../service/eleves.service';
import { environment } from 'src/environments/environment';
import { ElevesModel } from '../model/elevesmodel';

@Component({
  selector: 'app-eleves-list',
  templateUrl: './eleves-list.component.html',
  styleUrls: ['./eleves-list.component.css']
})
export class ElevesListComponent implements OnInit,OnDestroy{
  public urlAssets:string="";
  public listEleves:ElevesModel[]=[];
  constructor(private elevesService:ElevesService){}

  ngOnInit(): void {
    this.loadListEleves();
    this.urlAssets=environment.urlApi+"images/";

  }
  ngOnDestroy(): void {
    
  }
  loadListEleves(){
    this.elevesService.listEleves().subscribe(
      res=>{
        console.log(res);
        this.listEleves=res;
      },
      error=>{
        console.log(error);
        
      }
    )
  }
}
