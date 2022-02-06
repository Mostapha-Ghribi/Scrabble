import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-salle-dattente',
  templateUrl: './salle-dattente.component.html',
  styleUrls: ['./salle-dattente.component.css']
})
export class SalleDattenteComponent implements OnInit {
  players: [] | any;
  time: number = 0;
  display: any ;
  interval: any;
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

  constructor() { }
  ngOnInit(): void {
    this.startTimer()
    this.players = [{name : "mostapha",avatar:"mostapha.jpg"},{name : "haithem",avatar:"haithem.jpg"},"",""];

  }


}
