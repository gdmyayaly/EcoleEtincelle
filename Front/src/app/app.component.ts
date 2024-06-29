import { Component } from '@angular/core';
import { LoadderService } from './modules/loadder/services/services.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'angular17Auth';
  public isLoadingStatus:boolean=false;
  constructor(private loaderService:LoadderService){
    this.loaderService.isLoading().subscribe(val=>{this.isLoadingStatus=val});

  }
}
