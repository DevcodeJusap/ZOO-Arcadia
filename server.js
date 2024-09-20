const express = require('express');
const mysql = require('mysql');
const app = express();
const port = 3000;

const db = mysql.createConnection({
    host: 'mysql-zooarcadiaa.alwaysdata.net',
    user: '376865',
    password: 'Marley2809',
    database: 'zooarcadiaa_zoo'
});

db.connect((err) => {
    if (err) {
        throw err;
    }
    console.log('Connecté à la base de données MySQL');
});

app.get('/animal', (req, res) => {
    const sql = 'SELECT * FROM animals';
    db.query(sql, (err, result) => {
        if (err) {
            return res.status(500).send(err);
        }
        res.json(result);
    });
});

app.listen(port, () => {
    console.log(`Serveur démarré sur le port ${port}`);
});


const express = require('express');
const fs = require('fs');

app.use(express.json());

app.post('/valider-avis', (req, res) => {
    const avis = req.body;

    fs.readFile('index.html', 'utf8', (err, data) => {
        if (err) {
            return res.status(500).send('Erreur lors de la lecture du fichier index.html');
        }

        const avisContent = `
        <div class="item">
            <div class="avis-content">
                <p>"${avis.texte}"</p>
                <span>— ${avis.nom}, ${avis.age} ans</span>
            </div>
            <div class="rating">
                ${genererEtoiles(avis.note)}
            </div>
        </div>
        `;

        const updatedData = data.replace('</div><!-- Fin de la section carousel-avis -->', avisContent + '</div><!-- Fin de la section carousel-avis -->');

        fs.writeFile('index.html', updatedData, 'utf8', (err) => {
            if (err) {
                return res.status(500).send('Erreur lors de l\'écriture du fichier index.html');
            }
            res.send('Avis validé et publié avec succès !');
        });
    });
});

function genererEtoiles(note) {
    let etoiles = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= note) {
            etoiles += '<i class="fas fa-star"></i>';
        } else if (i === Math.ceil(note) && note % 1 !== 0) {
            etoiles += '<i class="fas fa-star-half-alt"></i>';
        } else {
            etoiles += '<i class="far fa-star"></i>';
        }
    }
    return etoiles;
}

app.listen(3000, () => {
    console.log('Serveur démarré sur le port 3000');
});