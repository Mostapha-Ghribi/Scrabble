import { Component, OnInit } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {MessageService} from "../../services/messge-service.service";


@Component({
  selector: 'app-boite-communication',
  templateUrl: './boite-communication.component.html',
  styleUrls: ['./boite-communication.component.css']
})
export class BoiteCommunicationComponent implements OnInit {
  allMessages:any
  constructor(messageService: MessageService) {
    messageService.getAllMessages().subscribe((data: any) => this.allMessages=data);

  }

  ngOnInit(): void {
  }



}
