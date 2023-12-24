# PHP REST API - POO - NO FRAMEWORK

This Project is a simple **PHP REST API** made it with no framework.<br>
The purpose of this project is learn how to create a PHP API without implement a framework and create your own functionalities using **Object Oriented Programming**.
<br>

### Install

To read environment variables in file .env I used [PHP dotenv](https://github.com/vlucas/phpdotenv). <br> 
Installation via [Composer](https://getcomposer.org/):

```
$ composer require vlucas/phpdotenv
```

### Project details

This API allows you manage a bookstore. You can create, update, delete and get information about a single book, author or category.

#### API Requests

#### List all books:
```
http://localhost/php-rest-api/api/books
```
Response:

```
{
    "status": 200,
    "data": [
        {
            "id": 22,
            "title": "Poster Girl",
            "description": null,
            "author_id": 6,
            "author_name": "Veronica Roth",
            "category_id": 2,
            "category_name": "Adventure"
        },
        {
            "id": 21,
            "title": "Chosen ones",
            "description": "Fifteen years ago, five ordinary teenagers were singled out by a prophecy to take down an impossibly powerful entity wreaking havoc across North America. He was known as the Dark One, and his weapon of choice catastrophic events known as Drains leveled cities and claimed thousands of lives. Chosen Ones, as the teens were known, gave everything they had to defeat him.",
            "author_id": 6,
            "author_name": "Veronica Roth",
            "category_id": 2,
            "category_name": "Adventure"
        },
        ...
        ...
  ]
}
```

##### Get single book:
```
http://localhost/php-rest-api/api/book?id=1
```
Response:

```
{
  "status": 200,
  "data": {
      "id": 1,
      "title": "Pride and Prejudice",
      "description": "Pride and Prejudice tells the story of Mr and Mrs Bennet's five unmarried daughters after the rich and eligible Mr Bingley and his status-conscious friend, Mr Darcy, have moved into their neighbourhood.",
      "author_id": 2,
      "author_name": "Jane Austen",
      "category_id": 1,
      "category_name": "Romantic novel"
  }
}  
```
Error response:

```
{
    "status": 500,
    "message": "Bad request, you must send Id parameter."
}
```









