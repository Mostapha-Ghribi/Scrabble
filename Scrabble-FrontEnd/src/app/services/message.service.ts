import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class MessageService {

  constructor(private http: HttpClient) {}

  addMessageAPI = 'http://127.0.0.1:8000/api/v1/message';
  passerAPI = 'http://127.0.0.1:8000/api/v1/passerTour/';

  public addMessage(message: any) {
    return this.http.post<any>(this.addMessageAPI, message);
  }
  public passer(id : any) {
    return this.http.get<any>(this.passerAPI+id);
  }
}
