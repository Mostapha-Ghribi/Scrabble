import { Component, OnInit } from '@angular/core';
import {JoueurService} from "../../services/joueur.service";
import {FormBuilder, FormControl, Validators} from "@angular/forms";
import {Joueur} from "../../model/joueur.model";
import {Router} from "@angular/router";

@Component({
  selector: 'app-inscription',
  templateUrl: './inscription.component.html',
  styleUrls: ['./inscription.component.css']
})
export class InscriptionComponent implements OnInit {
  inscriptionForm: any;
  constructor(private joueurService:JoueurService , private fb: FormBuilder , private router: Router) {
    let formControls = {
      nom: new FormControl('', [
        Validators.required,
        Validators.pattern("[A-Za-z0-9]+"),
        Validators.minLength(4)
      ]),
      partie: new FormControl('', [
        Validators.required,
      ]),
      photo : File
    }

    this.inscriptionForm = this.fb.group(formControls);
  }
  get nom() { return this.inscriptionForm.get('nom'); }
  get partie() { return this.inscriptionForm.get('partie'); }
  get photo() { return this.inscriptionForm.get('photo'); }

  ngOnInit(): void {
  }

  inscrire() {
    let data = this.inscriptionForm.value ;
    let joueur = {"nom" : data.nom, "partie" : data.partie}
    console.log(joueur)
    this.joueurService.addPlayer(joueur).subscribe(
      res=>{
        this.router.navigate(['/room'])
      },
      err=>{
        console.log(err);
      }
    )
  }

  onSelectedFile(event : Event) {
    // @ts-ignore
    if(event.target.files.length>0){
      // @ts-ignore
      const file = event.target.files[0];
      this.inscriptionForm.get('photo').setValue(file);
    }
  }

}
