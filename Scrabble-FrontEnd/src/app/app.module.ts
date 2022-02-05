import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { InscriptionComponent } from './components/inscription/inscription.component';
import {FormsModule} from "@angular/forms";

import { BoiteCommunicationComponent } from './components/boite-communication/boite-communication.component';

import { GrilleComponent } from './components/grille/grille.component';
import { ChevaletComponent } from './components/chevalet/chevalet.component';


@NgModule({
  declarations: [
    AppComponent,
    InscriptionComponent,
    BoiteCommunicationComponent,
    GrilleComponent,
    ChevaletComponent,

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
