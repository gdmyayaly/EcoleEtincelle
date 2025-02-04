import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CritereDetailComponent } from './critere-detail.component';

describe('CritereDetailComponent', () => {
  let component: CritereDetailComponent;
  let fixture: ComponentFixture<CritereDetailComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CritereDetailComponent]
    });
    fixture = TestBed.createComponent(CritereDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
