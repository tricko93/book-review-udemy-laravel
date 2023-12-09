# Book Review

## Project Description

This application uses the following technologies:

	- PHP
	- Laravel framework
	- TailwindCSS
	- AlpineJS

## Prerequisites

These are prerequisites in order to run the project locally on your machine:

		- Code editor (VS Code, Sublime Text)
		- Git
		- PHP
		- Composer
		- Docker or XAMPP

## Installation

Clone the repository and change directory to the project folder.

```sh
	# Clone the repository
	git clone https://www.github.com/tricko93/book-review-udemy-laravel book-review

	# Change directory
	cd book-review
```

Install the dependencies using Composer.

```sh
	# Install dependencies
	composer install --prefer-dist
```

Copy the config file and edit the database name and password.

```sh
	# Copy config file
	copy .env.example .env
	
	# Edit database name and password 
	# For Visual Studio Code (VS Code) users
	code .env
	
	# For Sublime Text users
	subl .env
```

Start the database container using Docker Compose.

```sh
	# Start the database container
	docker compose up
```

Run the application using PHP Artisan.

```sh
	# Generate the unique application key
	php artisan key:generate

	# Run the database migrations
	php artisan migrate --seed

	# Run the application
	php artisan serve
```

Open http://localhost:8000 in Web browser.

## Configuration

You can change the configuration variables by editing the .env file in the root directory of the project. For example:

```sh
	# Edit database name and password 
	# For Visual Studio Code (VS Code) users
	code .env
	
	# For Sublime Text users
	subl .env

	# Change the database name to
	DB_DATABASE=book-review

	# Change the database password to
	DB_PASSWORD=root
```
