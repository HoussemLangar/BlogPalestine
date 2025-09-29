# BlogPalestine

BlogPalestine est une application web multilingue (Français, Arabe, Anglais) développée en **PHP** et connectée à une base de données **MySQL**.  
Elle permet de créer un blog collaboratif autour de la cause palestinienne, avec inscription, connexion, débats et gestion admin.

---

## 🚀 Fonctionnalités

- 🌍 Interface multilingue : Français, Anglais, Arabe  
- 👤 Inscription et connexion des utilisateurs  
- 🔒 Authentification sécurisée (tokens)  
- 📝 Création et gestion de débats/articles  
- 🛠️ Dashboard administrateur  
- 💾 Base de données SQL incluse (`bd_blog.sql`)

---

## 📂 Structure du projet

```
BlogPalestine-main/
│── Accueil_ar.php         # Page d'accueil en arabe
│── Accueil_fr.php         # Page d'accueil en français
│── Accueil_en.php         # Page d'accueil en anglais
│── Login.php              # Connexion
│── Signup.php             # Inscription
│── Logout.php             # Déconnexion
│── dashboard_admin.php    # Tableau de bord admin
│── debat.php              # Page de débat
│── connect.php            # Connexion à MySQL
│── bd_blog.sql            # Script de création de la base
│── composer.json          # Dépendances PHP
│── PresentationDuProjet.pdf
```

---

## ⚙️ Installation & Configuration

### 1️⃣ Prérequis
- PHP >= 7.4  
- MySQL / MariaDB  
- Serveur Apache ou Nginx (ex : XAMPP, WAMP, Laragon)  
- Composer (pour gérer les dépendances)

### 2️⃣ Installation
```bash
git clone https://github.com/HoussemLangar/BlogPalestine.git
cd BlogPalestine
```

### 3️⃣ Base de données
- Importer `bd_blog.sql` dans MySQL :
```bash
mysql -u root -p blogpalestine < bd_blog.sql
```

- Modifier `connect.php` avec vos identifiants MySQL :
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogpalestine";
```

### 4️⃣ Lancer le projet
- Démarrer Apache et MySQL via XAMPP/WAMP  
- Accéder au projet dans le navigateur :  
👉 [http://localhost/BlogPalestine-main/Accueil_fr.php](http://localhost/BlogPalestine-main/Accueil_fr.php)

---

## 🛠️ Technologies Utilisées

- **Langage** : PHP
- **Base de données** : MySQL
- **Serveur** : Apache (XAMPP/WAMP/Laragon)
- **Gestion dépendances** : Composer
- **Frontend** : HTML, CSS, Bootstrap

---

## 📊 Badges

![PHP](https://img.shields.io/badge/PHP-7.4+-blue)  
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)  
![License](https://img.shields.io/badge/License-MIT-green)  
![Status](https://img.shields.io/badge/Status-Active-success)

---

## 📄 License

This project is licensed under the MIT License – feel free to modify and use it.  

---

## 👤 Author

Developed by **Houssem LANGAR**  
📧 Email: houssemlangar3@gmail.com  
