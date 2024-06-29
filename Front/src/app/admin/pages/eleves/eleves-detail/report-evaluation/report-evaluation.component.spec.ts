import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportEvaluationComponent } from './report-evaluation.component';

describe('ReportEvaluationComponent', () => {
  let component: ReportEvaluationComponent;
  let fixture: ComponentFixture<ReportEvaluationComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ReportEvaluationComponent]
    });
    fixture = TestBed.createComponent(ReportEvaluationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
