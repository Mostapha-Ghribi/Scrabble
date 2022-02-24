import {Component, ElementRef, HostListener, OnInit, ViewChild} from '@angular/core';
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
  public LettreChevalet: any;
  public reserveLength: any;
  @ViewChild('messageBoit') searchElement: ElementRef | any;
  @ViewChild('chevalet') chevalet: ElementRef | any;
  public ChevaletTabed: boolean = false;
  public KeyCode : any = -1;
  public indexlastArray: any;
  isTabed : boolean = false;
  tiles: [] | undefined;
  started :any = false;
  time: any;
  display: any ;
  interval: any;
  ordre: any = 1;
  private typePartie: any;
  @HostListener('window:keydown', ['$event'])
  handleKeyboardEvent(event: KeyboardEvent) {
    if (!this.isTabed) {
      let index = -1;
      if(event.keyCode == 106){
        index = this.LettreChevalet.indexOf(" ");
      }else{
        index = this.LettreChevalet.indexOf(String.fromCharCode(event.keyCode));
      }
      if ((event.keyCode >= 65 && event.keyCode <= 90) || event.keyCode == 106) {
        if (event.keyCode == this.KeyCode) {
          let arrayNext = this.LettreChevalet.slice(this.indexlastArray + 1,);
          let arrayPrevious = this.LettreChevalet.slice(0, this.indexlastArray);
          let fusionArray = arrayNext.concat(arrayPrevious);
          let fusionIndex = -1;
          if(event.keyCode == 106){
            fusionIndex = fusionArray.indexOf(" ");
          }else{
            fusionIndex = fusionArray.indexOf(String.fromCharCode(event.keyCode))
          }
          if (fusionIndex != -1) {
            this.indexlastArray = (fusionIndex + arrayPrevious.length + 1) % 7;
          }
        } else {
          this.KeyCode = event.keyCode;
          this.indexlastArray = index % 7;
        }
      }
      if(event.keyCode == 39){
        let aux = this.LettreChevalet[this.indexlastArray];
        if(this.indexlastArray==6){
          for (let i = 6; i >0; --i) {
            this.LettreChevalet[i] = this.LettreChevalet[i-1];
          }
          this.LettreChevalet[0] = aux;
          this.indexlastArray = 0;
        }
        else if(this.indexlastArray!= -1 && this.indexlastArray!=6){
          this.LettreChevalet[this.indexlastArray] = this.LettreChevalet[this.indexlastArray+1];
          this.LettreChevalet[this.indexlastArray+1] = aux;
          this.indexlastArray = this.indexlastArray+1;
        }
      }if(event.keyCode == 37){
          let auxLeft = this.LettreChevalet[this.indexlastArray];
        if(this.indexlastArray==0){
          for (let i = 0; i <6; i++) {
            this.LettreChevalet[i] = this.LettreChevalet[i+1];
          }
          this.LettreChevalet[6] = auxLeft;
          this.indexlastArray = 6;
        }
        else if(this.indexlastArray!= -1 && this.indexlastArray!=0){
          this.LettreChevalet[this.indexlastArray] = this.LettreChevalet[this.indexlastArray-1];
          this.LettreChevalet[this.indexlastArray-1] = auxLeft;
          this.indexlastArray = this.indexlastArray-1;
        }
      }
    }
  }
  @HostListener('window:keydown.tab', ['$event'])
  handleKeyDown(event: KeyboardEvent) {
    event.preventDefault();
    if(this.isTabed){
      this.searchElement.nativeElement.blur();
    this.ChevaletTabed = true;
    this.isTabed = false;
    }else{
      this.ChevaletTabed = false;
      this.indexlastArray = -1;
      this.searchElement.nativeElement.focus();
      this.isTabed = true;
    }
  }
  @HostListener('window:keydown.escape') hasPressed() {
    this.quitGamePartie();
  }
  constructor(private joueurService : JoueurService,private router : Router,private pusherService : PusherService, private partieService : PartieService) { }

  ngOnInit(): void {
    this.id = localStorage.getItem('idJoueur');
    this.pusherService.channel.bind("getJoueurs", ()=> {
      this.partieService.getPartieByIdJoueurBind(this.id).subscribe( data =>{
        this.joueurs = data.joueurs;
        this.reserve = data.reserve.length;
        this.typePartie = data.typePartie;
      })
    });
    this.partieService.getPartieByIdJoueur(this.id).subscribe( data =>{
      this.joueurs = data.joueurs;
      this.reserve = data.reserve.length;

    })
    // @ts-ignore
    this.tiles=["TM","","","DL","","","","TM","","","","DL","","","TM","","DM","","","","TL","","","","TL","","","","DM","","","","DM","","","","DL","","DL","","","","DM","","","DL","","","DM","","","","DL","","","","DM","","","DL","","","","","DM","","","","","","DM","","","","","","TL","","","","TL","","","","TL","","","","TL","","","","DL","","","","DL","","DL","","","","DL","","","TM","","","DL","","","","B","O","N","","DL","","","TM","","","DL","","","","DL","","DL","","","","DL","","","","TL","","","","TL","","","","TL","","","","TL","","","","","","DM","","","","","","DM","","","","","DL","","","DM","","","","DL","","","","DM","","","DL","","","DM","","","","DL","","DL","","","","DM","","","","DM","","","","TL","","","","TL","","","","DM","","TM","","","DL","","","","TM","","","","DL","","","TM"];
    this.joueurService.getJoueur(this.id).subscribe( data =>{
      this.LettreChevalet = this.ChevaletToArray(data.chevalet.toUpperCase());
    })
    this.startTimer(300);

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
  startTimer(time : any) {
    this.time = time;
    console.log("=====>");
    this.interval = setInterval(() => {

      if(this.time == 0){
        console.log("stop")
        if(this.ordre == this.typePartie){
          this.ordre = 1;
          console.log(this.ordre);
        }else{
          this.ordre = this.ordre+1;
          console.log(this.ordre);
        }
        this.time = 300;
      }
           this.time--;
      this.display=this.transform( this.time)
    }, 1000);
  }

  transform(value: number): string {
    const minutes: number = Math.floor(value / 60);
    return minutes + ':' + (value - minutes * 60);
  }

}
