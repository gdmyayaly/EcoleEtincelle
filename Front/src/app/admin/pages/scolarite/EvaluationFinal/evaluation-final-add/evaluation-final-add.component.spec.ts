import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EvaluationFinalAddComponent } from './evaluation-final-add.component';

describe('EvaluationFinalAddComponent', () => {
  let component: EvaluationFinalAddComponent;
  let fixture: ComponentFixture<EvaluationFinalAddComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EvaluationFinalAddComponent]
    });
    fixture = TestBed.createComponent(EvaluationFinalAddComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
