import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {JoueurService} from "./joueur.service";
import {Router} from "@angular/router";
import {PartieService} from "./partie.service";
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