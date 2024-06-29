import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AnneeScolaireDetailComponent } from './annee-scolaire-detail.component';

describe('AnneeScolaireDetailComponent', () => {
  let component: AnneeScolaireDetailComponent;
  let fixture: ComponentFixture<AnneeScolaireDetailComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AnneeScolaireDetailComponent]
    });
    fixture = TestBed.createComponent(AnneeScolaireDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
