import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
@Injectable({
  providedIn: 'root'
})
export class PusherService {
    private pusher: any;
    channel: any;

  constructor() {
      Pusher.logToConsole = true;
      this.pusher = new Pusher(environment.pusher.key, {
          cluster: environment.pusher.cluster,
          encrypted: true
      });
      this.channel = this.pusher.subscribe('player');
  }
}