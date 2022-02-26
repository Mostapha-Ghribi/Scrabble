import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class PartieService {
  private getPartieByIdJoueurAPI = "http://localhost:8000/api/v1/partie/joueur/";
  private getPartieByIdJoueurBindAPI = "http://localhost:8000/api/v1/partie/joueurBind/";
  private getJoueursByIdPartieAPI = "http://localhost:8000/api/v1/partie/";
  private InitChevaletAndReserveAPI = "http://localhost:8000/api/v1/addChevalet/partie/";
  constructor(private http: HttpClient) { }
  public getPartieByIdJoueur(id: any) {
    const headers = new HttpHeaders();
    headers.append('Content-Type', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    return this.http.get<any>(this.getPartieByIdJoueurAPI+id,{headers: headers});
  }
  public getPartieByIdJoueurBind(id: any) {
    const headers = new HttpHeaders();
    headers.append('Content-Type', 'multipart/form-data');
    headers.append('Accept', 'application/json');
    return this.http.get<any>(this.getPartieByIdJoueurBindAPI+id,{headers: headers});
  }
  public getJoueursByIdPartie(id :any){
    return this.http.get<any>(this.getJoueursByIdPartieAPI+id+"/joueurs");
  }
  public InitChevaletAndReserve(id :any){
    return this.http.get<any>(this.InitChevaletAndReserveAPI+id);
  }
  StringToArray(grille : any){
    let Arraygrille = grille.split('');
    for (let i=0;i<Arraygrille.length;i++){
      if(Arraygrille[i]=='-'){
        Arraygrille[i]="";
      }
    }
    return Arraygrille;
  }
}
