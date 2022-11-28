

### INSTALLATION INSTRUCTIONS

- ** Upon Downloading the app, create a database named 'Laravel' with username of 'root', no password is required
- ** fire up the command line and run 'php artisan serve' command 
- ** open another terminal window run 'npm run dev' command
- ** run 'php artisan migrate' to create database tables 
- ** open web browser and load app url
- ** setup page will load, create the super user
- ** now populate the db table with data by running the following commands:
- ** php artisan db:seed --class=UserSeeder
- ** php artisan db:seed --class=CompaniesSeeder
- ** php artisan db:seed --class=CompaniesEmployeesSeeder
- ** Now it's time to fully navigate the system :)
