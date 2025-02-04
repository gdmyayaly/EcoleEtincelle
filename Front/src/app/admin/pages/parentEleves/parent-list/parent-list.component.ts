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
  public searchTerm: string = '';

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
        this.listParentEleves=res;
      },
      error=>{
        console.error(error);
      }
    )
  }
  search(): void {
    if (this.searchTerm) {
      this.listParentEleves = this.listParentEleves.filter(parent =>
        parent.nom.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
        parent.prenom.toLowerCase().includes(this.searchTerm.toLowerCase())
      );
    } else {
      this.loadListParent();
    }
  }
}
