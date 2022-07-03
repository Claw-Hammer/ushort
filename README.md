
# URL Shortener

Requirements:

- PHP 7.4 or above
- composer
- node / npm



## Installation

clone the project from the Github repository, enter the project folder, open a terminal inside the project folder and run:

```bash
  composer install
  npm install
  npm run dev
```

You need to create your .env file; inside the project folder run the following command:

```bash
  cp .env.example .env
```

then setup your db schema and db credentials into the .env file and create the database using your favorite method (phpMyAdmin, MySQL Workbench, etc).

After that you need to create the database tables and populate them with data by running:

```bash
  php artisan migrate --seed
```

A default user is created with the  following credentials:

```bash
  User:  admin
  Email: admin@admin.com
  Pasword: password
```

## API End-Points


### /api/v1/url/shortener

This will generate a short url that points to the provided real url, you need to send a POST request with a json body as follows:

```bash
  {
    "url" : "your-real-url-here"
  }
```

if succeed, the request will respond with a json body as follows:

```bash
{
    "data": {
        "short_url": "generated-short-url-here"
    }
}
```



### /api/v1/url/top

This will generate a Json array with the top 100 most visited Urls, you need to send a GET request



### /api/v1/url/real

This will respond with the real Url that the provided short url points to, you need to send a GET request with a json body as follows:

```bash
  {
    "url" : "your-short-url-here"
  }
```

if succeed, the request will respond with a json body as follows:

```bash
  {
    "real_url" : "your-real-url-here"
  }
```



## Acknowledgements

In this project I show how to work with:

 - Creating an API
 - Fetching an API
 - Livewire components
 - Livewire modals

## Required and pending Improvements

 - To have separate and related tables since the same real URL could have several short URLs associated with it. This would also help in scalability of the application and in integration with other systems.
 - Create a token-based authentication for the API; this way, requests to the API could be limited in a free subscription model and have another paid subscription model with unlimited requests.
 - Create a pagination for the Top 100 URLs view.
