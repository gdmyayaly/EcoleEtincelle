import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AnneeScolaireAddComponent } from './annee-scolaire-add.component';

describe('AnneeScolaireAddComponent', () => {
  let component: AnneeScolaireAddComponent;
  let fixture: ComponentFixture<AnneeScolaireAddComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AnneeScolaireAddComponent]
    });
    fixture = TestBed.createComponent(AnneeScolaireAddComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
