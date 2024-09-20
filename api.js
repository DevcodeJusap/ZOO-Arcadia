const express = require('express');
const cors = require('cors');
const mysql = require('mysql');
const app = express();
const port = 3000;

app.use(cors());

const db = mysql.createConnection({
    host: 'mysql-zooarcadiaa.alwaysdata.net',
    user: '376865',
    password: 'Marley280',
    database: 'zooarcadiaa_zoo'
});

db.connect((err) => {
    if (err) {
        console.error('Erreur de connexion à la base de données:', err);
        return;
    }
    console.log('Connecté à la base de données MySQL');
});

app.get('/animal', (req, res) => {
    const query = 'SELECT id, animal_name, species, age, weight, food, last_meal, food_quantity FROM animals';
    db.query(query, (err, results) => {
        if (err) {
            console.error('Erreur lors de la récupération des données:', err);
            res.status(500).json({ error: 'Erreur lors de la récupération des données' });
            return;
        }
        res.json(results);
    });
});

app.listen(port, () => {
    console.log(`Serveur API démarré sur le port ${port}`);
});




