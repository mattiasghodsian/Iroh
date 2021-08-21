<p align="center">
  <a href="https://github.com/mattiasghodsian/Iroh/">
    <img alt="Iroh" src="assets/img/iroh.png?raw=true" height="150">
  </a>
  <p  align="center">Iroh The WordPress Starter Theme For Developers</p>
</p>

<p align="center">
  <a href="LICENSE">
    <img alt="GPL-2.0 License" src="https://img.shields.io/badge/license-GPL--2.0-purple/?style=flat-square" />
  </a>
  <a href="https://github.com/mattiasghodsian/Iroh/">
    <img alt="Build Status" src="https://img.shields.io/github/stars/mattiasghodsian/iroh?style=flat-square" />
  </a>
  <a href="https://github.com/mattiasghodsian/Iroh/">
    <img alt="Contributors" src="https://img.shields.io/github/contributors/mattiasghodsian/iroh?style=flat-square">  
  </a>
  <a href="LICENSE">
    <img alt="Donate Ethereum" src="https://img.shields.io/static/v1?label=donate&message=ethereum&color=blue&style=flat-square" />
  </a>
</p>

<p align="center">
  <a href="https://github.com/mattiasghodsian/Iroh/wiki">
    Documentation
  </a>
  |
  <a href="CHANGELOG">
    Change Log 
  </a>
</p>

## Overview
Iroh is a WordPress starter theme which includes some of our favorite tools, helpers and custom solutions, Gets you up and running in no time. Created by developers for developers.

## Requirements

- [WordPress](https://wordpress.org/download/)
- [Composer](https://getcomposer.org/doc/00-intro.md)
- [NPM](https://www.npmjs.com/get-npm)


## Iroh includes 

- Custom Helper Classes
- [Symfony VarDumper](https://github.com/symfony/var-dumper)
- [Symfony Validator](https://github.com/symfony/validator)
- [Laravel Mix](https://www.npmjs.com/package/laravel-mix)
- [Inputmask](https://github.com/RobinHerbots/Inputmask)
- [SweetAlert2](https://github.com/sweetalert2/sweetalert2)
- [Bootstrap](https://getbootstrap.com/)
- [WP Bootstrap Navwalker](https://github.com/wp-bootstrap/wp-bootstrap-navwalker)

## Theme structure
```bash
.
├── acf-json
├── assets
│   ├── img
│   └── src
├── app
├── src
│   └── Helper
├── languages
├── node_modules
├── templates
│   ├── acf-blocks
│   └── global
└── vendor
```

## Get started
1. Navigate to themes folder in your WordPress installation and clone the repository
  ```sh
  $ git clone git@github.com:mattiasghodsian/Iroh.git
  ```
2. Install composer dependencies
  ```sh
  $ composer install
  ```
3. Install npm packages
  ```sh
  $ npm install
  ```
4. Get a cup of coffee and write your new theme in
  ```sh
  iroh/app/
  ```