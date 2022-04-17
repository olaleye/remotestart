# Mercury Holidays - Take Home Test

# Documentation

## Getting started
### Prerequisities

Recent versions of Docker and Docker-Compose are required for this project to run.
Before you build the Docker image, within the project root run.

```
cp .env.example .env
```

#### Docker

Use docker compose for easier setup and installing all the containers at once.

_NOTE:_ In case port 80 is already used by another service like Nginx, Apache, or others, change it within the `docker-compose.yml` file.
Should be 'your_port:80'. If this is your first time of building the application, the build stage might take sometime.

To set up with Docker do the following steps:

Build the image using:

```
docker-compose up -d
```

Install the dependencies

```
docker-compose exec app composer install
```

You can access the application using http://localhost/

That is it!

To run all the test 

```
docker-compose exec app vendor/bin/phpunit --testdox
```

To run a single test, e.g SearcherTest
```
docker-compose exec app vendor/bin/phpunit --testdox --filter SearcherTest
```


# Task Description
Your task is to fill in the stubbed Property Searcher service to return correct results based on the input criteria.

The correct results are defined as such:

- All room options must be adjacent (and on the same floor) if the number of rooms is more than one.
- All room options should be returned within the minimum and maximum budget inclusive.
- Only rooms that are AVAILABLE should be returned.

## Examples

Given the following hotels:

| Name    | Available | Floor | Room No | Per Room Price |
|---------|-----------|-------|---------|----------------|
| Hotel A | False     | 1     | 1       | 25.80          |
| Hotel A | False     | 1     | 2       | 25.80          |
| Hotel A | True      | 1     | 3       | 25.80          |
| Hotel A | True      | 1     | 4       | 25.80          |
| Hotel A | False     | 1     | 5       | 25.80          |
| Hotel A | False     | 2     | 6       | 30.10          |
| Hotel A | True      | 2     | 7       | 35.00          |
| Hotel B | True      | 1     | 1       | 45.80          |
| Hotel B | False     | 1     | 2       | 45.80          |
| Hotel B | True      | 1     | 3       | 45.80          |
| Hotel B | True      | 1     | 4       | 45.80          |
| Hotel B | False     | 1     | 5       | 45.80          |
| Hotel B | False     | 2     | 6       | 49.00          |
| Hotel B | False     | 2     | 7       | 49.00          |

### Example 1
Given a criteria of:

- Minimum budget £20 per room.
- Maximum budget £30 per room.
- Number of rooms required is 2.

We'd expect to see the following results returned:

| Name    | Available | Floor | Room No | Per Room Price |
|---------|-----------|-------|---------|----------------|
| Hotel A | True      | 1     | 3       | 25.80          |
| Hotel A | True      | 1     | 4       | 25.80          |

### Example 2
Given a criteria of:

- Minimum budget £30 per room.
- Maximum budget £50 per room.
- Number of rooms required is 2.

We'd expect to see the following results returned:

| Name    | Available | Floor | Room No | Per Room Price |
|---------|-----------|-------|---------|----------------|
| Hotel B | True      | 1     | 3       | 45.80          |
| Hotel B | True      | 1     | 4       | 45.80          |

### Example 3
Given a criteria of:

- Minimum budget £25 per room.
- Maximum budget £40 per room.
- Number of rooms required is 1.

We'd expect to see the following results returned:

| Name    | Available | Floor | Room No | Per Room Price |
|---------|-----------|-------|---------|----------------|
| Hotel A | True      | 1     | 3       | 25.80          |
| Hotel A | True      | 1     | 4       | 25.80          |
| Hotel A | True      | 2     | 7       | 35.00          |

## Instructions
To get you started, we've already provided a stubbed **Searcher** class with a method **search()** that accepts a rooms required count, minimum and maximum budget. 

We have also provided an **add()** method that you will use to store properties in-memory such that they will be available in the call to **search()**.

As part of this assignment, we will need to see evidence that you have verified the
functionality of your solution.

We have already set up a composer.json file along with PHPUnit.