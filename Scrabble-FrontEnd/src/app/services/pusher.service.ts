import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
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
      this.pusher.connection
      this.channel = this.pusher.subscribe('player');
  }






}