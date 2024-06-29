import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NiveauEtudeDetailComponent } from './niveau-etude-detail.component';

describe('NiveauEtudeDetailComponent', () => {
  let component: NiveauEtudeDetailComponent;
  let fixture: ComponentFixture<NiveauEtudeDetailComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [NiveauEtudeDetailComponent]
    });
    fixture = TestBed.createComponent(NiveauEtudeDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
