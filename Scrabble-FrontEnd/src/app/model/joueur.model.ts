export class Joueur {
  constructor(
    public idJoueur?: Number,
    public nom?: String,
    public photo?: String,
    public chevalet?: String,
    public score?: Number,
    public statusJoueur?: Boolean,
    public order?: Number,
    public partie?: Number
  ) {
  }
}
