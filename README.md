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

This API allows you manage a bookstore. You can create, read, update, delete and get information about a single book, author or category.

#### API Requests

#### GET - Read - All:
##### Book
```
http://localhost/php-rest-api/api/books
```
##### Example response get books:
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
##### Author
```
http://localhost/php-rest-api/api/authors
```
##### Category
```
http://localhost/php-rest-api/api/categories
```
#### GET - Read - Single:
##### Book
```
http://localhost/php-rest-api/api/book?id=1
```
##### Example response get single book:
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
##### Author
```
http://localhost/php-rest-api/api/author?id=1
```
##### Category
```
http://localhost/php-rest-api/api/category?id=1
```

#### POST - Create

##### Book
```
http://localhost/php-rest-api/api/book/create
```
##### JSON book
```
// description can be null
{
    "title": "Christmas Eve at Friday Harbor",
    "author_id": 11,
    "category_id": 1
}
```
##### Author
```
http://localhost/php-rest-api/api/author/create
```
##### JSON Author
```
{
    "author_name": "Julia Quinn"
}
```
##### Category
```
http://localhost/php-rest-api/api/category/create
```
##### JSON Category
```
{
    "name": "Comedy"
}
```
##### PATCH - Update
###### Book
```
http://localhost/php-rest-api/api/book?id=5

//Send Json with fields you need to update
{
    "title": "THe Fifth Wave"
}
```
###### Author
```
http://localhost/php-rest-api/api/author?id=2

//Send Json with field you need to update, in this case "author_name"
```
###### Category
```
http://localhost/php-rest-api/api/category?id=3

//Send Json with field you need to update, in this case "name"
```
#### DELETE
##### Book
```
http://localhost/php-rest-api/api/book?id=25
```
##### Response delete book
```
{
    "status": 200,
    "data": "The book was delete succesfully"
}
```
##### Author
```
http://localhost/php-rest-api/api/author?id=12
```
##### Category
```
http://localhost/php-rest-api/api/category?id=7
```
##### Error responses
```
// Bad request
{
    "status": 500,
    "message": "Bad request, you must send Id parameter."
}

// Invalid JSON
{
    "status": 500,
    "message": "Invalid json."
}
// Not found
{
    "status": 404,
    "message": "Book not found."
}
```









