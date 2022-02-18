import {Component, HostListener, OnInit} from '@angular/core';
import {PartieService} from "../../services/partie.service";
import {Router} from "@angular/router";
import {JoueurService} from "../../services/joueur.service";
import {PusherService} from "../../services/pusher.service";

@Component({
  selector: 'app-salle-dattente',
  templateUrl: './salle-dattente.component.html',
  styleUrls: ['./salle-dattente.component.css']
})
export class SalleDattenteComponent implements OnInit {
  private idPlayer: any;
  @HostListener('window:keydown.escape', ['$event'])
  //@HostListener('window:beforeunload', ['$event'])
  handleKeyDown(event: KeyboardEvent) {
    this.quitGame();

    this.router.navigate(['/inscription'])


  }
  players: Array<any> = [];
  joueurs:[] |any;
  time: number = 0;
  display: any ;
  interval: any;
  id :any;
  channel : any;
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

  constructor(private pusherService : PusherService,private joueurService : JoueurService,private partieService : PartieService,private router: Router) { }
  ngOnInit(): void {
    this.id = localStorage.getItem('idJoueur');
    this.pusherService.channel.bind("SendPlayer", function(data:any) {
      console.log("hello",data);
    });
    this.getPartieByIdJoueur();
    //console.log("id SendPlayer",this.idPlayer);

    this.startTimer()
   // this.players = [{name : "mostapha",avatar:"mostapha.jpg"},{name : "haithem",avatar:"haithem.jpg"},"",""];
   // console.log("Players",this.players);
  }
  inscrire(){


  }
  quitGame(){
    this.joueurService.quitGame(this.id).subscribe(
      res =>{
        console.log(res);
      },
      err =>{
        console.log(err);
      }
    )
  }
  getPartieByIdJoueur() {
    setInterval(() => {

      this.partieService.getPartieByIdJoueur(this.id).subscribe(
        res => {
         // console.log(this.id);
          //console.log("le res : ",res);
          this.joueurs = res.joueurs;
         // console.log("Joueurs from result",this.joueurs);
          this.typePartie = res.typePartie;
          //console.log("typePartie",this.typePartie);
          this.players = [];
          for(var i=0;i<this.typePartie;i++){
            this.players.push(this.joueurs[i]);
          }
         // console.log("players from interval",this.players)
        },
        err => {
          console.log(err);
        }
      )
    }, 5000);

    }



}
