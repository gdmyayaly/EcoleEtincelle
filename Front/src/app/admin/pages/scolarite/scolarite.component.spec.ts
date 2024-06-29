import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ScolariteComponent } from './scolarite.component';

describe('ScolariteComponent', () => {
  let component: ScolariteComponent;
  let fixture: ComponentFixture<ScolariteComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ScolariteComponent]
    });
    fixture = TestBed.createComponent(ScolariteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
