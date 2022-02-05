import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-chevalet',
  templateUrl: './chevalet.component.html',
  styleUrls: ['./chevalet.component.css']
})
export class ChevaletComponent implements OnInit {
  LettreChevalet: String[] | any;


  constructor() { }

  ngOnInit(): void {
    this.LettreChevalet = ['J','O','U','E','U','R','S'];
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
