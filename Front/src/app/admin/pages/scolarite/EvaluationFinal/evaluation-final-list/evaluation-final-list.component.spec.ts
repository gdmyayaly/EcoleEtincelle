import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EvaluationFinalListComponent } from './evaluation-final-list.component';

describe('EvaluationFinalListComponent', () => {
  let component: EvaluationFinalListComponent;
  let fixture: ComponentFixture<EvaluationFinalListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EvaluationFinalListComponent]
    });
    fixture = TestBed.createComponent(EvaluationFinalListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
