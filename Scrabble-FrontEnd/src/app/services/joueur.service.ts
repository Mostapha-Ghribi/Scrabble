import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class JoueurService {

  private InscriptionAPI = "http://localhost:8000/api/v1/inscrire";
  private quitGameAPI = "http://localhost:8000/api/v1/quitter/joueur/";
  private getJoueurAPI = "http://localhost:8000/api/v1/joueur/";
  private quitGamePartieAPI = "http://localhost:8000/api/v1/quitter/partie/joueur/";
  public messageError: any;
  public isError: any = false;



  constructor(private http: HttpClient) { }
  public addPlayer(joueur: any) {
    return this.http.post<any>(this.InscriptionAPI, joueur);
  }
  public getJoueur(id: any) {
    return this.http.get<any>(this.getJoueurAPI+id);
  }
  public quitGame(id: any) {
    const headers = new HttpHeaders();
    headers.append('Content-Type', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    return this.http.get<any>(this.quitGameAPI+ id,{headers: headers});
  }
  public quitGamePartie(id: any) {
    const headers = new HttpHeaders();
    headers.append('Content-Type', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    return this.http.get<any>(this.quitGamePartieAPI+ id,{headers: headers});
  }
}
