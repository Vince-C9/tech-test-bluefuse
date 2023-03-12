import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './ui/header/header.component';
import { FooterComponent } from './ui/footer/footer.component';
import { UploadcsvComponent } from './component/forms/uploadcsv/uploadcsv.component';
import { ViewComponent } from './view/view.component';
import { HomeComponent } from './home/home.component';
import { PokemonlistComponent } from './component/forms/pokemonlist/pokemonlist.component';


@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    UploadcsvComponent,
    ViewComponent,
    HomeComponent,
    PokemonlistComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
