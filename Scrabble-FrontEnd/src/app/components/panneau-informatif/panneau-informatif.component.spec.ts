import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PanneauInformatifComponent } from './panneau-informatif.component';

describe('PanneauInformatifComponent', () => {
  let component: PanneauInformatifComponent;
  let fixture: ComponentFixture<PanneauInformatifComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PanneauInformatifComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PanneauInformatifComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
