import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { InscriptionComponent } from './components/inscription/inscription.component';
import {FormsModule} from "@angular/forms";
import { GrilleComponent } from './components/grille/grille.component';
import { PanneauInformatifComponent } from './components/panneau-informatif/panneau-informatif.component';

@NgModule({
  declarations: [
    AppComponent,
    InscriptionComponent,
    GrilleComponent,
    PanneauInformatifComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    FormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
