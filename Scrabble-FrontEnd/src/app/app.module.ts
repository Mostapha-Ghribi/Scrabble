import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { InscriptionComponent } from './components/inscription/inscription.component';
import {FormsModule} from "@angular/forms";
import { BoiteCommunicationComponent } from './components/boite-communication/boite-communication.component';

@NgModule({
  declarations: [
    AppComponent,
    InscriptionComponent,
    BoiteCommunicationComponent
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
