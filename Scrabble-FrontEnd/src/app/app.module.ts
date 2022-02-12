import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { InscriptionComponent } from './components/inscription/inscription.component';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";

import { BoiteCommunicationComponent } from './components/boite-communication/boite-communication.component';

import { GrilleComponent } from './components/grille/grille.component';
import { PanneauInformatifComponent } from './components/panneau-informatif/panneau-informatif.component';

import { ChevaletComponent } from './components/chevalet/chevalet.component';
import { SalleDattenteComponent } from './components/salle-dattente/salle-dattente.component';
import {MatCardModule} from "@angular/material/card";
import {MatDividerModule} from "@angular/material/divider";
import {MatProgressBarModule} from "@angular/material/progress-bar";
import {MatButtonModule} from "@angular/material/button";
import {MatProgressSpinnerModule} from "@angular/material/progress-spinner";
import {HttpClientModule} from "@angular/common/http";

@NgModule({
  declarations: [
    AppComponent,
    InscriptionComponent,
    GrilleComponent,
    PanneauInformatifComponent,
    BoiteCommunicationComponent,
    GrilleComponent,
    ChevaletComponent,
    SalleDattenteComponent,

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    FormsModule,
    MatCardModule,
    MatDividerModule,
    MatProgressBarModule,
    MatButtonModule,
    MatProgressSpinnerModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
