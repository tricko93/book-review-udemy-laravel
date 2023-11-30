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

```
	# Clone the repository
	git clone https://www.github.com/tricko93/book-review-udemy-laravel book-review

	# Change directory
	cd book-review
```

Install the dependencies using Composer.

```
	# Install dependencies
	composer install
```

Copy the config file and edit the database name and password.

```
	# Copy config file
	copy .env.example .env

	# Edit database name and password 
	code .env
```

Start the database container using Docker Compose.

```
	# Start the database container
	docker compose up
```

Run the application using PHP Artisan.

```
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

```
	# Edit the .env file
	code .env

	# Change the database name to
	DB_DATABASE=laravel-10-book-review

	# Change the database password to
	DB_PASSWORD=root
```
