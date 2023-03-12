# tech-test-bluefuse

Hi guys!  This is a basic implementation of a simple angular client talking to a Laravel back end.  The task was to provide a form to upload a pokemon from a valid CSV document list and be able to view the list via a separate page.

The focus throughout this has been on the following:

 - Containerised architecture utilising Docker & Docker Compose.
 - CircleCI integration and TDD approach.
 - Futureproofing for expansion / modular approach
 - Backend / Laravel is certainly my strong point!  Angular is something I've not dabbled in for 3-4 years.
 - Would have liked to implement eithe the angular tests (ng test) or cypress tests via circle CI to also demonstrate the front end tests running through CI, however I ran out of time.
 
 
# Installation 
- Clone down and run `docker-compose build`
- run `docker-compose up` and wait for the containers to spin up.
- run `docker-compose exec pokemon-api php artisan key:generate`
- run `docker-compose exec pokemon-api php artisan migrate`
- Client should handle the npm run/build etc when you run `docker-compose build`.  this will need to be re-run when you make changes to the client side.

#Images
Client - Upload
![screenshot-upload-csv](https://user-images.githubusercontent.com/78065068/224576725-ef394772-e701-49a8-983d-1a3f16aa57de.png)

Client - View
![screenshot-view-pokemon](https://user-images.githubusercontent.com/78065068/224577080-e4e69376-076e-4320-9c0a-b4f5dc2f49bd.png)

API - Index
![image](https://user-images.githubusercontent.com/78065068/224577139-3927267f-1eea-43f9-af75-2be3f147f769.png)

API - Get Pokemon
![image](https://user-images.githubusercontent.com/78065068/224577171-b5fe5fc3-db79-4e68-af9e-5a78009a3eda.png)

API (Postman) - Post Pokemon
![image](https://user-images.githubusercontent.com/78065068/224577217-52b7f091-aded-4046-937a-fb69534ec118.png)

