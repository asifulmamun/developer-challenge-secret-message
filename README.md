### Start
- Clone the repo ```git clone https://github.com/asifulmamun/developer-challenge-secret-message.git chat```
- Go to the folder ```cd chat```
- Install vendor files ```composer i```
- (Optional) - If you want to develp ```npm i```


### Change the .env
- Crate a database with utf8mb4-unicode-ci
- Copy the .env.example file to .env file
- Change the database info and pusher data from .env
- Migrate the database ```php artisan migrate```

### Run locally
- Run the application ```php artisan serve```
- Run the ```php artisan schedule:run``` in another terminal


### Use
- Register by any email without verification
- Login with 2 accounts and start message

