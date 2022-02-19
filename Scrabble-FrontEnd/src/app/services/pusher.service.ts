import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {JoueurService} from "./joueur.service";
import {Router} from "@angular/router";
import {PartieService} from "./partie.service";
@Injectable({
  providedIn: 'root'
})
export class PusherService {
    private pusher: any;
    channel: any;
    public result: any;
    public joueurs: any;

  constructor(private partieService:PartieService,private router :Router,private joueurService : JoueurService) {
      Pusher.logToConsole = true;
      this.pusher = new Pusher(environment.pusher.key, {
          cluster: environment.pusher.cluster,
          encrypted: true
      });
      this.pusher.connection
      this.channel = this.pusher.subscribe('player');
  }
  inscrire(joueur : any){
    this.joueurService.addPlayer(joueur).subscribe(data => {
        this.router.navigate(['/room']);
        console.log(data);
        localStorage.setItem('idJoueur',data.idJoueur);
        console.log("Inscription Reussite");
    });
  }




}