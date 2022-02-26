import {Component, OnInit} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {MessageService} from "../../services/messge-service.service";
import {catchError, retry} from "rxjs";
import {NgForm} from "@angular/forms";


@Component({
  selector: 'app-boite-communication',
  templateUrl: './boite-communication.component.html',
  styleUrls: ['./boite-communication.component.css']
})
export class BoiteCommunicationComponent implements OnInit {
  allMessages: any

  constructor(messageService: MessageService, private http: HttpClient) {
    messageService.getAllMessages().subscribe((data: any) => this.allMessages = data);
  }

  createEmployee() {

  }


  ngOnInit(): void {
  }

  add(f: NgForm) {
    let httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    }
    let data = {
      "partie": 1,
      "contenu": "hello play it please",
      "envoyeur": 1
    }
    let urlApi = 'http://127.0.0.1:8000/api/v1/message';
    this.http.post(urlApi, JSON.stringify(data), httpOptions)
    console.log(this.http.post(urlApi, data, httpOptions))
  }
}
