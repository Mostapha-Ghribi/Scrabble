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

  private idPartie: any;
  private isFive: boolean = true;
  @HostListener('window:keydown.escape', ['$event'])
  //@HostListener('window:beforeunload', ['$event'])
  handleKeyDown(event: KeyboardEvent) {
    this.quitGame();
    this.partieService.getJoueursByIdPartie(this.idPartie).subscribe( data =>{
      this.joueurs = data;
      this.players = [];
      for(let i=0; i<this.typePartie; i++){
        this.players.push(this.joueurs[i]);
      }
    })
  }
  players: Array<any> = [];
  joueurs:[] |any;
  time: any;
  display: any ;
  interval: any;
  id :any;
  channel : any;
  private typePartie: any;
 five(){
   if(this.isFive){
     this.time = 6;
     this.isFive = false;
   }
       this.time--;
       if(this.time == 0){
         this.router.navigate(['/jeu']);
       }
 }
  startTimer(time : any) {
    this.time = time;
    console.log("=====>");
    this.interval = setInterval(() => {
      if(this.typePartie == this.joueurs.length){
        this.five();
      }else {
          this.time++;
      }
      this.display=this.transform( this.time)
    }, 1000);
  }

  transform(value: number): string {
    const minutes: number = Math.floor(value / 60);
    return minutes + ':' + (value - minutes * 60);
  }


  constructor(private pusherService : PusherService,private joueurService : JoueurService,private partieService : PartieService,private router: Router) { }
  ngOnInit(): void {
    this.pusherService.channel.bind("getJoueurs", (data: any)=> {
      this.idPartie = data.idPartie;
      this.typePartie = data.typePartie;
      this.getJoueursByIdPartie();
    });
    this.pusherService.channel.bind("quitJoueur",(data : any)=>{
      this.getJoueursByIdPartie();
    })
    this.getPartieByIdJoueur();
    this.startTimer(0);
  }
  quitGame(){
    this.joueurService.quitGame(this.id).subscribe(
      res =>{
        this.router.navigate(['/inscription']);
        console.log(res);
      },
      err =>{
        console.log(err);
      }
    )
  }
  getPartieByIdJoueur() {
    this.id = localStorage.getItem('idJoueur');
      this.partieService.getPartieByIdJoueur(this.id).subscribe( data =>{
        console.log(data);
        this.joueurs = data.joueurs;
        this.typePartie = data.typePartie;
        this.players = [];
        for(var i=0;i<this.typePartie;i++){
        this.players.push(this.joueurs[i]);
        }
      })
    }
    getJoueursByIdPartie(){
      this.partieService.getJoueursByIdPartie(this.idPartie).subscribe( data =>{
        this.joueurs = data;
        this.players = [];
        for(let i=0; i<this.typePartie; i++){
          this.players.push(this.joueurs[i]);
        }
      })
    }





}
