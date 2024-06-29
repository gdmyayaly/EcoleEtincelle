import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NiveauEtudeAddComponent } from './niveau-etude-add.component';

describe('NiveauEtudeAddComponent', () => {
  let component: NiveauEtudeAddComponent;
  let fixture: ComponentFixture<NiveauEtudeAddComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [NiveauEtudeAddComponent]
    });
    fixture = TestBed.createComponent(NiveauEtudeAddComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
