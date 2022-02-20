import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class PartieService {
  private getPartieByIdJoueurAPI = "http://localhost:8000/api/v1/partie/joueur/";
  private getJoueursByIdPartieAPI = "http://localhost:8000/api/v1/partie/";
  constructor(private http: HttpClient) { }
  public getPartieByIdJoueur(id: any) {
    const headers = new HttpHeaders();
    headers.append('Content-Type', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    return this.http.get<any>(this.getPartieByIdJoueurAPI+id,{headers: headers});
  }
  public getJoueursByIdPartie(id :any){
    return this.http.get<any>(this.getJoueursByIdPartieAPI+id+"/joueurs");
  }
}
