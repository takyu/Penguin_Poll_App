# Penguin Poll App

[This site](http://www.penguin-poll-app.com/) is where you can cast and vote in surveys about penguins.

## Environment

build [aws](https://aws.amazon.com/) [ec2](https://aws.amazon.com/ec2/) server and installed the following development environment on it and deployed.

## Getting Started

Requirement:

- [Node.js](https://nodejs.org/)

- [PHP](https://www.php.net/)

- [composer](https://getcomposer.org/)

- [Apache](https://httpd.apache.org/)

- [mysql](https://www.mysql.com/)

Install dependencies:

```
npm install
```

or

```
yarn
```

The following is described by the ***yarn*** command.

Install vendors(composer):

```
composer install
```

## build for production

Output dist/:

```
yarn prod
```

## build for development

Output dist/:

```
yarn dev
```