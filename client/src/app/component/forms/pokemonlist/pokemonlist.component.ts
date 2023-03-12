import {Component, OnInit} from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Component({
  selector: 'app-pokemonlist',
  templateUrl: './pokemonlist.component.html',
  styleUrls: ['./pokemonlist.component.scss']
})
export class PokemonlistComponent implements OnInit{
  pokemonList: any;
  constructor(private http: HttpClient) {}

  getPokemonList(){
      this.http.get('http://localhost:8000/pokemon',  {
        reportProgress: false,  //could set to true and show a progress bar if Ash catches loads of pokemon!
        observe: 'response'
      }).subscribe((response) => {
        this.pokemonList = response.body;
        console.log(this.pokemonList)
      });
  }

  ngOnInit(){
    this.getPokemonList()
  }
}
