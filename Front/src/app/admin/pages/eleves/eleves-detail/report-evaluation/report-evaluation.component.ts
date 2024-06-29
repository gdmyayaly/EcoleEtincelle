import { Component, Input, OnDestroy, OnInit } from '@angular/core';
import { ElevesModel } from '../../model/elevesmodel';

@Component({
  selector: 'app-report-evaluation',
  templateUrl: './report-evaluation.component.html',
  styleUrls: ['./report-evaluation.component.css']
})
export class ReportEvaluationComponent implements OnInit,OnDestroy{
  @Input() eleve!:ElevesModel;
  public editorContent: string = 'My initial content';
  constructor(){}
  ngOnInit(): void {
    
  }
  ngOnDestroy(): void {
    
  }

}
