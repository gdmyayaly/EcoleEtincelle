import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EvaluationFinalDetailComponent } from './evaluation-final-detail.component';

describe('EvaluationFinalDetailComponent', () => {
  let component: EvaluationFinalDetailComponent;
  let fixture: ComponentFixture<EvaluationFinalDetailComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EvaluationFinalDetailComponent]
    });
    fixture = TestBed.createComponent(EvaluationFinalDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
