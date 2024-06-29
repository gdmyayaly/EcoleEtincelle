import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ElevesAddComponent } from './eleves-add.component';

describe('ElevesAddComponent', () => {
  let component: ElevesAddComponent;
  let fixture: ComponentFixture<ElevesAddComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ElevesAddComponent]
    });
    fixture = TestBed.createComponent(ElevesAddComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
