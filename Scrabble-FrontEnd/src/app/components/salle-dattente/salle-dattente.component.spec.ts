import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SalleDattenteComponent } from './salle-dattente.component';

describe('SalleDattenteComponent', () => {
  let component: SalleDattenteComponent;
  let fixture: ComponentFixture<SalleDattenteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SalleDattenteComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SalleDattenteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
