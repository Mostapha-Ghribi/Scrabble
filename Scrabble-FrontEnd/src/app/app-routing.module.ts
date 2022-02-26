import { NgModule } from '@angular/core';
import {InscriptionComponent} from './components/inscription/inscription.component';
import {SalleDattenteComponent} from "./components/salle-dattente/salle-dattente.component";
import { RouterModule, Routes } from '@angular/router';
import {BoiteCommunicationComponent} from "./components/boite-communication/boite-communication.component";
import {JeuComponent} from "./components/jeu/jeu.component";

const routes: Routes = [
  {
    path: "",
    redirectTo: "inscription",
    pathMatch: 'full'
  },
  {
    path: "inscription",
    component: InscriptionComponent
  },
  {
    path: "room",
    component : SalleDattenteComponent
  },{
    path: "jeu",
    component : JeuComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
