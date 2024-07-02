import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AnneeScolaireDetailMoreComponent } from './annee-scolaire-detail-more.component';

describe('AnneeScolaireDetailMoreComponent', () => {
  let component: AnneeScolaireDetailMoreComponent;
  let fixture: ComponentFixture<AnneeScolaireDetailMoreComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AnneeScolaireDetailMoreComponent]
    });
    fixture = TestBed.createComponent(AnneeScolaireDetailMoreComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
