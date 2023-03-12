import { Component } from '@angular/core';

import {HttpClient} from "@angular/common/http";

@Component({
  selector: 'app-uploadcsv',
  templateUrl: './uploadcsv.component.html',
  styleUrls: ['./uploadcsv.component.scss']
})
export class UploadcsvComponent {

  fileName = '';
  file = null;
  csvError = '';
  response:any;
  errors=''

  constructor(private http: HttpClient) {}

  onFileChange(event: any){
    let type = event.target.files[0].type
    this.file = event.target.files[0]
    if(type.indexOf("csv")===-1){
      this.csvError = "Unrecognised file type.  Please upload a CSV file!"
    }else{
      this.csvError='';
    }

  }

  submitCSV(){
    if(this.csvError=='' && this.file !== null){
      const file:File = this.file;

      if(file){
        this.fileName = file.name;
        const formData = new FormData();
        formData.append("pokemon_csv",file);

        //could possibly use an observable/interface here to improve this.
        //could probably do a better job of globalising this base url.
        const upload$ = this.http.post('http://localhost:8000/pokemon', formData, {
          reportProgress: false,  //could set to true and show a progress bar if Ash catches loads of pokemon!
          observe: 'response'
        }).subscribe((response) => {
          let data = response.body;
          this.response = data;
        });
      }else{
        this.csvError = "No CSV file found!  Please select one."
      }
    }
  }
}
