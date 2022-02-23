import { Component, OnInit } from '@angular/core';
import {PartieService} from "../../services/partie.service";
import {Joueur} from "../../model/joueur.model";
import {JoueurService} from "../../services/joueur.service";

@Component({
  selector: 'app-chevalet',
  templateUrl: './chevalet.component.html',
  styleUrls: ['./chevalet.component.css']
})
export class ChevaletComponent implements OnInit {
  LettreChevalet: any;
  private idJoueur: any;


  constructor(private joueurService : JoueurService) { }
  ngOnInit(): void {
    this.idJoueur = localStorage.getItem('idJoueur');
    this.joueurService.getJoueur(this.idJoueur).subscribe( data =>{
      this.LettreChevalet = this.ChevaletToArray(data.chevalet.toUpperCase());
    })
  }
  ChevaletToArray(grille : any){
    let Arraygrille = grille.split('');
    for (let i=0;i<Arraygrille.length;i++){
      if(Arraygrille[i]=='*'){
        Arraygrille[i]=" ";
      }
    }
    return Arraygrille;
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
      case "V":
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
