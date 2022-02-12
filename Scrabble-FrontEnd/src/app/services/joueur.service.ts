import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Joueur} from "../model/joueur.model";

@Injectable({
  providedIn: 'root'
})
export class JoueurService {
  private InscriptionAPI = "http://localhost:8000/api/v1/inscrire";


  constructor(private http: HttpClient) { }
  public addPlayer(joueur: any) {
    return this.http.post<any>(this.InscriptionAPI, joueur);
  }
}
