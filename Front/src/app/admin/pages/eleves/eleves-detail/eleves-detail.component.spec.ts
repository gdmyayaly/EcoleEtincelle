import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ElevesDetailComponent } from './eleves-detail.component';

describe('ElevesDetailComponent', () => {
  let component: ElevesDetailComponent;
  let fixture: ComponentFixture<ElevesDetailComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ElevesDetailComponent]
    });
    fixture = TestBed.createComponent(ElevesDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
