<?php

const SERVER="localhost";
const DB="prestamos";
const USER="root";
const PASS="";

//Para conectarse a la base de datos
const SGBD='mysql:host='.SERVER.';port=3307;dbname='.DB;

//Encriptación
const METHOD="AES-256-CBC";
const SECRET_KEY='$PRESTAMOS@2020';
CONST SECRET_IV='037970';