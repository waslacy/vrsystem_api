const axios = require("axios");
const bodyParser = require("body-parser");
const cors = require("cors");
const express = require("express");
const jwt = require("jsonwebtoken");
const mysql2 = require("mysql2")

const app = express()
const port = 8080
const chaveSecreta = "Tecle@123"

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json()); 

app.get('/authorize/token/:cliente', (req, res) => {
    let cliente = req.params.cliente
    let usuario = {
        id: 1,
        nome: 'tropical'
    }

    let token = jwt.sign(usuario, chaveSecreta, { expiresIn: '1h' });
})

app.post('/products', (req, res) => {
    //let token = req.body.token
    jwt.verify(token, chaveSecreta, (err, decoded) => {
        if (err) {
            res.send('Erro ao verificar o token:', 403);
        } else {
            let cliente = decoded.id
            console.log(req.body)
        }
    });
})

app.listen(port, () => {
    console.log('roooodando')
})
