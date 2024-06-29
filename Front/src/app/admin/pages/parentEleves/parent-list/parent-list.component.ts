import { Component, OnDestroy, OnInit } from '@angular/core';
import { ParentElevesService } from '../service/parent-eleves.service';
import { environment } from 'src/environments/environment';
import { ParentElevesModel } from '../model/parentEleves';

@Component({
  selector: 'app-parent-list',
  templateUrl: './parent-list.component.html',
  styleUrls: ['./parent-list.component.css']
})
export class ParentListComponent implements OnInit,OnDestroy{
  public urlAssets:string="";
  public listParentEleves:ParentElevesModel[]=[];
  constructor(private parentService:ParentElevesService){}

  ngOnInit(): void {
    this.loadListParent();
    this.urlAssets=environment.urlApi+"images/";
  }
  ngOnDestroy(): void {
    
  }
  loadListParent(){
    this.parentService.listParentEleves().subscribe(
      res=>{
        console.log("Perfect");
        console.log(res);
        this.listParentEleves=res;
      },
      error=>{
        console.log("Error");
        console.error(error);
      }
    )
  }
}
