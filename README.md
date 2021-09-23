# devICT Job Board

The greatest job board in all the universe. You've never seen job postings like this before. This baby is jam-packed with features: It's got jobs, it's got links; it's got it all! Before you visit the homepage for the first time, I recommend you find somewhere to sit down because you're not gonna know what hit you. When you first lay eyes on this thing, you might feel compelled to add a new life event to your Facebook timeline - that's normal - this job board is undoubtedly life changing. The ripples of its impact will be felt across space and time. Arias will be written, wars will be fought, masterworks will be produced all in the name of the devICT Job Board.

## Installation

Step one is to clone this repo:

```sh
git clone https://github.com/devict/jobs.devict jobs.devict
cd jobs.devict
```

If you're looking to get started quickly we recommend using our [Docker setup](#docker-setup). If you already have PHP (>= 7.2.0), PHP Composer, SQLite3, and NPM on your machine you can follow our [basic setup steps](#basic-setup).

### Docker Setup

Copy config files, install dependencies.

```sh
cp .env.example .env
cp .db.env.example .db.env
```

Edit both files to set a database password (they must match).

Next run..

```sh
make setup
```

Now, start things by running docker compose.

```sh
make start
```

Then in another terminal session, create and migrate the database. The server
must be running in order for the migrate command to work.

```sh
make db-migrate
```

Visit http://localhost:8001!

### Basic Setup

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm install
```

Build assets:

```sh
npm run watch
```

Create a SQLite database: (You can also use another database [MySQL, Postgres], simply [update your configuration accordingly](https://laravel.com/docs/master/database#configuration))

```sh
touch database/database.sqlite
```

Copy the environment config example and rename it to `.env`:

```sh
cp .env.example .env
```

Generate an application key:

```sh
php artisan key:generate
```

Run database migrations:

```sh
php artisan migrate
```

Start the built-in web server:

```sh
php artisan serve
```

You're ready to go! Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

## Notifications

The Job Board will send an email and Slack notification when new jobs are added to the board. The recipient of these notifications is configured in the `.env` file. Set the `JOBS_EMAIL` value to a valid email address and the `JOBS_SLACK_HOOK` to a valid [Slack webhook](https://api.slack.com/messaging/webhooks). Both of these settings are optional and the Job Board should still function without them set.

## Icons

This project uses the [Zondicons](https://www.zondicons.com/) icon set.

## Running tests

Run the PHPUnit tests:

```sh
vendor/bin/phpunit
```

## Logging into the database

```
$ make psql
```

This command will launch a `psql` sessions into the running database on the docker-compose service.

## Sponsors

<p>This project is supported by:</p>
<p>
  <a href="https://www.digitalocean.com/">
    <img src="https://opensource.nyc3.cdn.digitaloceanspaces.com/attribution/assets/SVG/DO_Logo_horizontal_blue.svg" width="201px">
  </a>
</p>
