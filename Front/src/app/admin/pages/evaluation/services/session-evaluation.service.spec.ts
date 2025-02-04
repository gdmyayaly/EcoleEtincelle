import { TestBed } from '@angular/core/testing';

import { SessionEvaluationService } from './session-evaluation.service';

describe('SessionEvaluationService', () => {
  let service: SessionEvaluationService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(SessionEvaluationService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
