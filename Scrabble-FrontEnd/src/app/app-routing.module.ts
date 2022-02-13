import { NgModule } from '@angular/core';
import {InscriptionComponent} from './components/inscription/inscription.component';
import {SalleDattenteComponent} from "./components/salle-dattente/salle-dattente.component";
import { RouterModule, Routes } from '@angular/router';

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
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
