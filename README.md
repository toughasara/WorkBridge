# WorkBridge

WorkBridge est une plateforme de recrutement qui met en relation les candidats et les recruteurs grâce à un système intelligent de matching. L'application optimise la gestion des candidatures, des entretiens et des tests de compétences.

## 🚀 Technologies

- **Backend** : Laravel 8+
- **Base de données** : PostgreSQL
- **Authentification** : Laravel Sanctum

## 📌 Fonctionnalités

### 1️⃣ Gestion des utilisateurs
- ✅ Inscription/connexion sécurisée (Email, Google, LinkedIn)
- ✅ Rôles : Candidat, Recruteur, Admin
- ✅ Profils utilisateurs (photo, description, expériences, compétences)
- ✅ Notifications en temps réel
- ✅ Gestion des préférences et disponibilité pour les entretiens

### 2️⃣ Système de matching
- ✅ Génération d'un score de correspondance (%) basé sur :
  - Expérience et compétences du candidat vs critères de l’offre
  - Niveau d’éducation, certifications et localisation
  - Correspondance linguistique et disponibilité
- ✅ Affichage des offres pertinentes pour les candidats
- ✅ Classement des candidatures pour les recruteurs selon la pertinence

### 3️⃣ Gestion des entretiens
- ✅ Gestion des calendriers des recruteurs
- ✅ Planification des entretiens selon les disponibilités
- ✅ Intégration avec Google Calendar / Outlook
- ✅ Suivi des entretiens passés et à venir
- ✅ Statut des entretiens : en attente, validé, refusé

### 4️⃣ Tests de compétences (Quiz)
- ✅ Création de tests par les recruteurs
- ✅ Affectation des tests aux candidats
- ✅ Correction automatique et affichage du score
- ✅ Stockage des résultats dans le profil du candidat

### 5️⃣ Suivi des candidatures
- ✅ Liste des candidatures envoyées pour chaque candidat
- ✅ Statut de la candidature : en cours, accepté, refusé, en attente de test
- ✅ Relance automatique après un certain délai sans réponse
- ✅ Messagerie intégrée pour la communication candidat-recruteur

### 6️⃣ Analyse des CV
- ✅ Upload et stockage sécurisé des CV
- ✅ Extraction automatique des données clés
- ✅ Génération d’un profil automatique basé sur le CV
- ✅ Recherche avancée par mots-clés et filtres

## 🛡️ Rôles et permissions

### 🎯 Candidat
- Postuler aux offres
- Passer des tests de compétences
- Suivre ses candidatures
- Participer aux entretiens
- Gérer son profil et CV

### 🎯 Recruteur
- Publier et gérer des offres d’emploi
- Sélectionner des candidats
- Organiser et suivre les entretiens
- Gérer les tests de compétences
- Contacter les candidats

### 🎯 Administrateur
- Gérer les utilisateurs
- Modérer les annonces et tests
- Suivre les statistiques des recrutements
- Assurer la sécurité et la maintenance

## ⚡ Optimisation des performances
- 📌 Utilisation d’indexes pour les recherches rapides dans PostgreSQL
- 📌 Lazy loading pour optimiser le chargement des offres et des profils
- 📌 Sécurisation des données utilisateurs (cryptage des mots de passe, protection des données sensibles)

## 🔗 Intégrations externes
- ✅ Google Calendar / Outlook pour la gestion des entretiens
- ✅ Stripe / PayPal pour un éventuel abonnement des recruteurs
- ✅ OCR pour l'extraction des données des CV

## 📜 Diagrammes
- **Diagramme de cas d’utilisation** : [Lien Google Drive](https://drive.google.com/file/d/1b-MOyDgtbXCW_Th4XWv6g1lNVuOSN6mo/view)
- **Diagramme de classe** : [Lien Lucidchart](https://lucid.app/lucidchart/9bb2a27a-1b7b-4ace-bd76-5fd4265c21fd/edit?viewport_loc=-3527%2C-2026%2C7677%2C3249%2C0_0&invitationId=inv_4572e89a-193e-4a9e-9fa6-08fe27d12849)

## 📢 Conclusion
WorkBridge vise à simplifier et optimiser le processus de recrutement en facilitant la mise en relation entre les candidats et les recruteurs grâce à un système de matching intelligent et des outils avancés de gestion des candidatures.
