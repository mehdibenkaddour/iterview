## ITerview Laravel Web Application & Web API

## App Features List

 - [x] Manage users [API included]
 - [x] Manage sections [API included]
 - [x] Manage topics [API included]
 - [ ] Manage questions [API included]
 - [ ] Manage statistics on users [API included]
 - [ ] Manage quizzes creation [API included]

## How to run this project

 1. **Clone the project**

		git clone https://github.com/mehdibenka001/iterview.git iterview

 2. **Change directory to it**

	     cd iterview

 3. **Install Composer Dependencies**

	    composer install

 4. **Install NPM Dependencies**

	    npm install
	   
	   

 5. **Create a copy of your .env file**
			
		cp .env.example .env

 6. **Generate an app encryption key**

		php artisan key:generate
		
		

 7. **Create an empty database for our application**

 8. **In the .env file, add database information to allow Laravel to connect to the database**

In the .env file fill in the `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.

9. **Migrate the database**
		
		php artisan migrate 

10. **Generate Passport keys and clients**

		php artisan passport:install