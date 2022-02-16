import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class MessageService {


  constructor(private http: HttpClient) {


  }

  urlApi = 'http://127.0.0.1:8000/api/v1/';

  getAllMessages() {
    return this.http.get(this.urlApi + 'messages')
  }


}
