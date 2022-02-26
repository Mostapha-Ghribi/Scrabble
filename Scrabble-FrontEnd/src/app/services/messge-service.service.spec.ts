import { TestBed } from '@angular/core/testing';

import { MessageService } from './messge-service.service';

describe('MessgeServiceService', () => {
  let service: MessageService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MessageService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
