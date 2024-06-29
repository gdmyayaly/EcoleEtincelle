import { TestBed } from '@angular/core/testing';

import { ParentElevesService } from './parent-eleves.service';

describe('ParentElevesService', () => {
  let service: ParentElevesService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ParentElevesService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
