import {Component, HostListener, OnInit} from '@angular/core';
import {JoueurService} from "../../services/joueur.service";
import {Router} from "@angular/router";
import {PusherService} from "../../services/pusher.service";
import {PartieService} from "../../services/partie.service";

@Component({
  selector: 'app-jeu',
  templateUrl: './jeu.component.html',
  styleUrls: ['./jeu.component.css']
})
export class JeuComponent implements OnInit {
  private id: any;
  public joueurs: any;
  public reserve: any;
  private idPartie: any;
  @HostListener('window:keydown.escape', ['$event'])
  //@HostListener('window:beforeunload', ['$event'])
  handleKeyDown(event: KeyboardEvent) {
    this.quitGamePartie();
  }
  tiles: [] | undefined;

  constructor(private joueurService : JoueurService,private router : Router,private pusherService : PusherService, private partieService : PartieService) { }

  ngOnInit(): void {
    this.id = localStorage.getItem('idJoueur');
    this.pusherService.channel.bind("getJoueurs", (data: any)=> {
      this.partieService.getPartieByIdJoueur(this.id).subscribe( data =>{
        console.log(data);
        this.joueurs = data.joueurs;
        this.reserve = data.reserve;
      })
    });
    this.pusherService.channel.bind("quitJoueurPartie");
    this.partieService.getPartieByIdJoueur(this.id).subscribe( data =>{
      console.log(data);
      this.joueurs = data.joueurs;
      this.reserve = data.reserve;

    })
    // @ts-ignore
    this.tiles=["TM","","","DL","","","","TM","","","","DL","","","TM","","DM","","","","TL","","","","TL","","","","DM","","","","DM","","","","DL","","DL","","","","DM","","","DL","","","DM","","","","DL","","","","DM","","","DL","","","","","DM","","","","","","DM","","","","","","TL","","","","TL","","","","TL","","","","TL","","","","DL","","","","DL","","DL","","","","DL","","","TM","","","DL","","","","ii","","","","DL","","","TM","","","DL","","","","DL","","DL","","","","DL","","","","TL","","","","TL","","","","TL","","","","TL","","","","","","DM","","","","","","DM","","","","","DL","","","DM","","","","DL","","","","DM","","","DL","","","DM","","","","DL","","DL","","","","DM","","","","DM","","","","TL","","","","TL","","","","DM","","TM","","","DL","","","","TM","","","","DL","","","TM"];

  }
  quitGamePartie(){
    this.joueurService.quitGamePartie(this.id).subscribe(
        res =>{
          this.router.navigate(['/inscription']);
          console.log(res);
        },
        err =>{
          console.log(err);
        }
    )
  }

  public BackGroundColor(l : String){
    let color : string = "#D6EDFF";
    switch(l){
      case "TM": color = "#FC4F4F";
        break;
      case "DM" : color = "#FC997C"
        break;
      case "DL" : color = "#84DCC6";
        break;
      case "TL" : color = "#35589A";
    }
    return "background:"+color;
  }

  isLettre(tile: string) {
    return tile.length == 1
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
