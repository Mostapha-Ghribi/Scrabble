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
  private result: any;
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
    //this.id = localStorage.getItem('idJoueur');
    this.pusherService.channel.bind("SendPlayer", (data: any)=> {
      //console.log(data);
      this.joueurs = data.partie.joueurs;
      console.log("from send player",data.partie.joueurs);
      this.typePartie = data.partie.typePartie;
      this.players = [];
      for(var i=0;i<this.typePartie;i++){
        this.players.push(this.joueurs[i]);
      }
    });
      this.getPartieByIdJoueur();

    //this.getPartieByIdJoueur();
    //console.log("id SendPlayer",this.id);
    this.startTimer()
   // this.players = [{name : "mostapha",avatar:"mostapha.jpg"},{name : "haithem",avatar:"haithem.jpg"},"",""];
   // console.log("Players",this.players);
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
    this.id = localStorage.getItem('idJoueur');
    //console.log("id joueur",this.id);
      this.partieService.getPartieByIdJoueur(this.id).subscribe( data =>{
        console.log(data);
        this.joueurs = data.joueurs;
        this.typePartie = data.typePartie;
        this.players = [];
        for(var i=0;i<this.typePartie;i++){
        this.players.push(this.joueurs[i]);
        }
      })

    //this.pusherService.getPlayers(this.id);
    //if(this.pusherService.getPlayers(this.id)){
     // console.log(this.pusherService.joueurs);
    //}

    //console.log(this.pusherService.result);
    //this.result = this.pusherService.result;
    //this.joueurs = this.result.joueurs;
    //this.typePartie = this.result.typePartie;
    //this.players = [];
    //for(var i=0;i<this.typePartie;i++){
      //this.players.push(this.joueurs[i]);
    //}
    }





}
