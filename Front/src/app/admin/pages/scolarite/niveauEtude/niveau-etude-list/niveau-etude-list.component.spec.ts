import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NiveauEtudeListComponent } from './niveau-etude-list.component';

describe('NiveauEtudeListComponent', () => {
  let component: NiveauEtudeListComponent;
  let fixture: ComponentFixture<NiveauEtudeListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [NiveauEtudeListComponent]
    });
    fixture = TestBed.createComponent(NiveauEtudeListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
