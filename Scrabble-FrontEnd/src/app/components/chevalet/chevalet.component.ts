import { Component, OnInit } from '@angular/core';
import {PartieService} from "../../services/partie.service";

@Component({
  selector: 'app-chevalet',
  templateUrl: './chevalet.component.html',
  styleUrls: ['./chevalet.component.css']
})
export class ChevaletComponent implements OnInit {
  LettreChevalet: String[] | any;
  private idJoueur: any;
  private joueurs: any;
  private reserve: any;
  private chevalet : any;


  constructor(private partieService : PartieService) { }

  ngOnInit(): void {
    this.idJoueur = localStorage.getItem('idJoueur');
    this.partieService.getPartieByIdJoueur(this.idJoueur).subscribe( data =>{
      this.joueurs = data.joueurs;
      this.reserve = data.reserve;
      for (let i = 0; i < this.joueurs.length; i++) {
        let Add = this.AddToChevalet(this.joueurs[i].chevalet,this.reserve);
        this.joueurs.chevalet = Add.chevaletPlayer;
        this.reserve = Add.ReservePartie;
      }
      console.log(this.reserve.length);
    })
  }
  AddToChevalet(chevaletPlayer : String , ReservePartie : String){
      while (chevaletPlayer.length < 7) {
        chevaletPlayer += ReservePartie[Math.floor(Math.random() * ReservePartie.length)];
      }
    for (let i = 0; i < 7; i++) {
      let index = ReservePartie.indexOf(chevaletPlayer[i]);
      ReservePartie = ReservePartie.slice(0, index - 1) + ReservePartie.slice(index, ReservePartie.length);
    }
    return { chevaletPlayer, ReservePartie };
  }
  valueLettre(tile: String) {
    let value: number;
    switch(tile){
      case "A":
      case "E":
      case "I":
      case "L":
      case "N":
      case "O":
      case "R":
      case "S":
      case "T":
      case "U":
        value=1;
        break;
      case "D":
      case "G":
      case "M":
        value=2;
        break;
      case "B":
      case "C":
      case "P":
        value=3;
        break;
      case "F":
      case "H":
      case "v":
        value = 4;
        break;
      case "J":
      case "Q":
        value = 8;
        break;
      case "K":
      case "W":
      case "X":
      case "Y":
      case "Z":
        value = 10;
        break;
      default:
        value = 0;
    }
    return value;
  }

}
