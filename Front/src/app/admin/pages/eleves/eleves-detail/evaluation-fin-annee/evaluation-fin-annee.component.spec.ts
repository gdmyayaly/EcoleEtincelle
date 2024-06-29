import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EvaluationFinAnneeComponent } from './evaluation-fin-annee.component';

describe('EvaluationFinAnneeComponent', () => {
  let component: EvaluationFinAnneeComponent;
  let fixture: ComponentFixture<EvaluationFinAnneeComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EvaluationFinAnneeComponent]
    });
    fixture = TestBed.createComponent(EvaluationFinAnneeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
