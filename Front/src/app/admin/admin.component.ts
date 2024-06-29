import { DOCUMENT } from '@angular/common';
import { Component, Inject, OnInit, Renderer2 } from '@angular/core';
import { SidebarService } from './layout/sidebar/service/sidebar.service';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css']
})
export class AdminComponent implements OnInit{
  // constructor(private renderer: Renderer2, @Inject(DOCUMENT) private document: any) {}
  public activeClass:string="active";
  public isActive:boolean=true;
  constructor(private sideBarService:SidebarService){
    this.sideBarService.getStatusMenu().subscribe(
      (value) => {
        this.activeClass=value;
      }
    )
  }
  ngOnInit(): void {
   // this.loadScript("assets/js/admin-menu.js");
  }
  // loadScript(url: string): void {
  //   const script = this.renderer.createElement('script');
  //   script.type = 'text/javascript';
  //   script.src = url;
  //   script.onload = () => {
  //     console.log('Script loaded successfully.');
  //   };
  //   script.onerror = () => {
  //     console.error('Error loading script.');
  //   };
  //   this.renderer.appendChild(this.document.body, script);
  // }
  

}
