# 🎓 Espace Étudiant & Administrateur — Laravel

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Jira](https://img.shields.io/badge/Jira-0052CC?style=for-the-badge&logo=jira&logoColor=white)

Application web de gestion des demandes administratives, réclamations et notifications pour les étudiants et administrateurs — **ENSA Tétouan 2025/2026**.

</div>

---

## 📋 Présentation

Cette application permet aux étudiants de soumettre des **demandes administratives** et des **réclamations**, et aux administrateurs de les traiter via un **dashboard complet**. Un système d'**emails automatiques** envoie les attestations et notifications.

---

## ✨ Fonctionnalités

### 👤 Espace Étudiant
- Authentification et gestion du profil
- Soumission de demandes administratives (formulaire)
- Dépôt de réclamations
- Suivi de l'état des demandes en temps réel
- Réception de notifications et attestations par email
- Historique des demandes et réclamations

### 🛡️ Espace Administrateur
- Dashboard avec statistiques globales
- Gestion et traitement des demandes étudiantes
- Gestion des réclamations (accepter / refuser / répondre)
- Gestion des comptes étudiants
- Envoi d'emails et d'attestations automatiques

### 📧 Système de Notification Email
- Envoi automatique lors du changement de statut d'une demande
- Génération et envoi d'attestations par email

---

## 🔧 Technologies

| Catégorie | Technologie |
|-----------|-------------|
| Framework | Laravel |
| Langage | PHP |
| Base de données | MySQL |
| Frontend | Bootstrap + Blade |
| Emails | Laravel Mail (SMTP) |
| Versioning | GitHub |
| Gestion de projet | Jira (Agile Scrum) |

---

## ✅ Prérequis

- [PHP 8.1+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/)
- [Node.js & npm](https://nodejs.org/) (pour les assets)
- [Git](https://git-scm.com/)

---

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/votre-utilisateur/espace-etudiant.git
cd espace-etudiant
```

### 2. Installer les dépendances

```bash
composer install
npm install && npm run build
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

Éditez `.env` avec vos paramètres :

```env
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre@email.com
MAIL_PASSWORD=votre_mot_de_passe
MAIL_FROM_ADDRESS=no-reply@ensa.ma


## 📄 Licence

Projet académique — ENSA Tétouan © 2025-2026
