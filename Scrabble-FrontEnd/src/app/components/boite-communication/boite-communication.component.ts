import {Component, OnInit} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {catchError, retry} from "rxjs";
import {NgForm} from "@angular/forms";


@Component({
  selector: 'app-boite-communication',
  templateUrl: './boite-communication.component.html',
  styleUrls: ['./boite-communication.component.css']
})
export class BoiteCommunicationComponent{


  constructor() {
  }

}

