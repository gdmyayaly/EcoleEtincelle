import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SidebarService {

  private activeCssMenu = new BehaviorSubject<string>("active");

  constructor() { }
  getStatusMenu():Observable<string>{
    return this.activeCssMenu;
  }
  updateStatusToogleMenu(isOpen:boolean=false){    
    if (!isOpen) {
      this.activeCssMenu.next("active")
    }
    else{
      this.activeCssMenu.next("")
    }
  }
}
