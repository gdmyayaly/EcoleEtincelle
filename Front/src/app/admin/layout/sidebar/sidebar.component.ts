import { Component } from '@angular/core';
import { SidebarService } from './service/sidebar.service';

@Component({
  selector: 'app-sidebar-admin',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent {
  public activeClass:string="";
  public isActive:boolean=false;
  constructor(private sideBarService:SidebarService){
    this.sideBarService.getStatusMenu().subscribe(
      (value) => {
        this.activeClass=value;
      }
    )
  }
  toogleMenu(){    
    this.isActive=!this.isActive;
    this.sideBarService.updateStatusToogleMenu(this.isActive);
  }
}
