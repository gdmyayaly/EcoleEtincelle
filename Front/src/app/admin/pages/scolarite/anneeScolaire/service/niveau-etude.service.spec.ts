import { TestBed } from '@angular/core/testing';

import { AnneeScolaireService } from './niveau-etude.service';

describe('AnneeScolaireService', () => {
  let service: AnneeScolaireService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AnneeScolaireService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
