import { TestBed } from '@angular/core/testing';

import { MessgeServiceService } from './messge-service.service';

describe('MessgeServiceService', () => {
  let service: MessgeServiceService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MessgeServiceService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
