import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BoiteCommunicationComponent } from './boite-communication.component';

describe('BoiteCommunicationComponent', () => {
  let component: BoiteCommunicationComponent;
  let fixture: ComponentFixture<BoiteCommunicationComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BoiteCommunicationComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BoiteCommunicationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
