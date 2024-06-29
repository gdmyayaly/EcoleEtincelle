import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ParentAddComponent } from './parent-add.component';

describe('ParentAddComponent', () => {
  let component: ParentAddComponent;
  let fixture: ComponentFixture<ParentAddComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ParentAddComponent]
    });
    fixture = TestBed.createComponent(ParentAddComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
