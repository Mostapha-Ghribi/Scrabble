import {Component, HostListener, OnInit} from '@angular/core';
import {PartieService} from "../../services/partie.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-salle-dattente',
  templateUrl: './salle-dattente.component.html',
  styleUrls: ['./salle-dattente.component.css']
})
export class SalleDattenteComponent implements OnInit {
  @HostListener('window:keydown.escape', ['$event'])
  handleKeyDown(event: KeyboardEvent) {
    this.router.navigate(['/inscription'])
  }
  players: Array<any> = [];
  joueurs:[] |any;
  time: number = 0;
  display: any ;
  interval: any;
  private typePartie: any;
  startTimer() {
    console.log("=====>");
    this.interval = setInterval(() => {
      if (this.time === 0) {
        this.time++;
      } else {
        this.time++;
      }
      this.display=this.transform( this.time)
    }, 1000);
  }
  transform(value: number): string {
    const minutes: number = Math.floor(value / 60);
    return minutes + ':' + (value - minutes * 60);
  }
  pauseTimer() {
    clearInterval(this.interval);
  }

  constructor(private partieService : PartieService,private router: Router) { }
  ngOnInit(): void {
    this.getPartieByIdJoueur();
    this.startTimer()
   // this.players = [{name : "mostapha",avatar:"mostapha.jpg"},{name : "haithem",avatar:"haithem.jpg"},"",""];
    console.log("Players",this.players);
  }
  getPartieByIdJoueur() {
    setInterval(() => {
      let id = localStorage.getItem('idJoueur');
      this.partieService.getPartieByIdJoueur(id).subscribe(
        res => {
          this.joueurs = res.joueurs;
          console.log("Joueurs from result",this.joueurs);
          this.typePartie = res.typePartie;
          console.log("typePartie",this.typePartie);
          this.players = [];
          for(var i=0;i<this.typePartie;i++){
            this.players.push(this.joueurs[i]);
          }
          console.log("players from interval",this.players)
        },
        err => {
          console.log(err);
        }
      )
    }, 5000);

    }



}
