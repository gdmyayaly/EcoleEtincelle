import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PaiementScolariteComponent } from './paiement-scolarite.component';

describe('PaiementScolariteComponent', () => {
  let component: PaiementScolariteComponent;
  let fixture: ComponentFixture<PaiementScolariteComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [PaiementScolariteComponent]
    });
    fixture = TestBed.createComponent(PaiementScolariteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
