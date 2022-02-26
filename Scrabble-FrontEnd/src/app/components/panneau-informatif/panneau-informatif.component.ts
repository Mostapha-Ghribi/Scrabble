import { Component, OnInit } from '@angular/core';
import {PartieService} from "../../services/partie.service";
import {PusherService} from "../../services/pusher.service";

@Component({
  selector: 'app-panneau-informatif',
  templateUrl: './panneau-informatif.component.html',
  styleUrls: ['./panneau-informatif.component.css']
})
export class PanneauInformatifComponent implements OnInit {
  private idJoueur: any;
  public joueurs: any;
  public reserve: any;

  constructor(private partieService : PartieService, private pusherService : PusherService) { }

  ngOnInit(): void {
    this.idJoueur = localStorage.getItem('idJoueur');
    this.pusherService.channel.bind("quitJoueurPartie",(data : any)=>{
      this.partieService.getPartieByIdJoueur(this.idJoueur).subscribe( data =>{
        console.log(data);
        this.joueurs = data.joueurs;
        this.reserve = data.reserve;
      })
    })
    this.partieService.getPartieByIdJoueur(this.idJoueur).subscribe( data =>{
      this.joueurs = data.joueurs;
      this.reserve = data.reserve;

    })
  }

}
