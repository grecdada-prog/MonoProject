# 🎨 Déploiement Render.com - SmartStock (GRATUIT)

**Plateforme**: Render.com
**Prix**: 100% GRATUIT
**Temps**: 15 minutes
**Difficulté**: ⭐⭐☆☆☆ (Facile)

---

## ✅ AVANTAGES RENDER

- ✅ **Vraiment gratuit** (pas de carte requise)
- ✅ **PostgreSQL inclus** (gratuit 90 jours)
- ✅ **SSL automatique** (HTTPS)
- ✅ **Déploiement auto** depuis GitHub
- ⚠️ **Limitation**: Service s'endort après 15 min d'inactivité (redémarre en 30-60s)

---

## 📋 PRÉ-REQUIS

Avant de commencer:

- [x] Compte GitHub (avec le repo MonoProject)
- [x] Compte Render.com (créer sur https://render.com)
- [ ] Credentials Pusher (à régénérer - 2 min)

---

## 🚀 ÉTAPE 1: CRÉER COMPTE RENDER (3 min)

### 1.1 S'inscrire

1. Va sur https://render.com
2. Clique **"Get Started"**
3. Connecte-toi avec **GitHub** (recommandé)
4. Autorise Render à accéder à ton GitHub
5. ✅ Compte créé !

**Pas de carte de crédit requise** 🎉

---

## 🔗 ÉTAPE 2: CONNECTER GITHUB (2 min)

### 2.1 Lier le repository

1. Dashboard Render > **"New +"** (en haut à droite)
2. Sélectionne **"Blueprint"**
3. Clique **"Connect a repository"**
4. Cherche **"MonoProject"** (ou ton nom de repo)
5. Clique **"Connect"**

### 2.2 Render détecte render.yaml

Render va automatiquement détecter le fichier `render.yaml` et afficher:

```
✅ Found render.yaml
✅ Services to create:
    - Web Service: smartstock-web
    - PostgreSQL: smartstock-db
```

**Clique "Apply"** 🎯

---

## ⚙️ ÉTAPE 3: CONFIGURER VARIABLES MANUELLES (5 min)

### 3.1 Variables déjà configurées automatiquement

Render configure automatiquement (via `render.yaml`):
- ✅ APP_NAME, APP_ENV, APP_DEBUG
- ✅ APP_KEY (généré automatiquement)
- ✅ DB_* (toutes les variables database)
- ✅ CACHE_STORE, SESSION_*, QUEUE_*
- ✅ MAIL_HOST, MAIL_PORT, MAIL_USERNAME, etc.

### 3.2 Variables à ajouter MANUELLEMENT

**Tu dois ajouter 4 variables seulement** :

1. Dashboard Render > Clique sur **"smartstock-web"**
2. Onglet **"Environment"** (à gauche)
3. Scroll jusqu'à **"Environment Variables"**
4. Clique **"Add Environment Variable"** pour chacune:

```env
# 1. Gmail App Password
Key: MAIL_PASSWORD
Value: uqwyfvscdhnelrxt

# 2. Pusher App ID (régénère sur dashboard.pusher.com)
Key: PUSHER_APP_ID
Value: TON_APP_ID

# 3. Pusher App Key
Key: PUSHER_APP_KEY
Value: TON_APP_KEY

# 4. Pusher App Secret
Key: PUSHER_APP_SECRET
Value: TON_APP_SECRET

# 5. App URL (après premier déploiement)
Key: APP_URL
Value: https://smartstock-web.onrender.com
```

5. Clique **"Save Changes"** après chaque ajout

### 3.3 Régénérer Pusher Credentials (2 min)

**Important pour la sécurité** :

1. Va sur https://dashboard.pusher.com
2. Connecte-toi
3. Sélectionne ton app (ou crée une nouvelle)
4. **App Keys** > Note:
   ```
   app_id = _______________
   key    = _______________
   secret = _______________
   ```
5. Entre ces valeurs ci-dessus (PUSHER_APP_ID, etc.)

---

## 🏗️ ÉTAPE 4: PREMIER DÉPLOIEMENT (5 min)

### 4.1 Lancer le build

Render démarre automatiquement le build après "Apply".

**Suis les logs** :
1. Dashboard > **smartstock-web** > **"Logs"** (onglet)
2. Tu verras:
   ```
   ✅ Installing PHP dependencies (composer install)
   ✅ Installing Node dependencies (npm ci)
   ✅ Building frontend assets (npm run build)
   ✅ Caching config, routes, views
   ✅ Running migrations
   ✅ Starting server
   ```

**Durée**: 3-5 minutes

### 4.2 Build terminé

Quand tu vois:
```
✅ Live!
Your service is live at https://smartstock-web.onrender.com
```

**C'est prêt** ! 🎉

### 4.3 Mettre à jour APP_URL

**IMPORTANT** - Après le premier déploiement:

1. Note l'URL générée: `https://smartstock-web.onrender.com`
2. Retourne dans **Environment** > **Environment Variables**
3. Trouve **APP_URL**
4. Met à jour avec l'URL exacte générée
5. **Save Changes** → Render redéploie automatiquement (2 min)

---

## ✅ ÉTAPE 5: CRÉER SUPER-ADMIN (3 min)

### 5.1 Via Shell Render

1. Dashboard > **smartstock-web**
2. En haut à droite > **"Shell"** (icône terminal)
3. Un terminal s'ouvre dans ton container

### 5.2 Créer l'admin

Dans le Shell Render, tape:

```bash
php artisan tinker
```

Puis **copie-colle ligne par ligne**:

```php
\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);

$user = \App\Models\User::create(['name' => 'Admin Principal', 'username' => 'superadmin', 'email' => 'admin@smartstock.cm', 'password' => bcrypt('Admin2025!SmartStock'), 'is_active' => true]);

$user->assignRole('super-admin');

echo "Super-Admin créé: " . $user->email;

exit
```

**Credentials créés**:
- Email: `admin@smartstock.cm`
- Password: `Admin2025!SmartStock`
- ⚠️ Change-le après premier login !

---

## 🧪 ÉTAPE 6: TESTER L'APPLICATION (2 min)

### 6.1 Accéder à l'app

1. Ouvre l'URL: `https://smartstock-web.onrender.com/login`
2. Tu dois voir la page de login ✅

### 6.2 Premier login

1. Email: `admin@smartstock.cm`
2. Password: `Admin2025!SmartStock`
3. Code 2FA si activé (check email)
4. ✅ Tu arrives sur le dashboard SuperAdmin

### 6.3 Tests rapides

- [ ] **Dashboard** s'affiche correctement
- [ ] **Créer Store**: Gestion Magasins > Nouveau
- [ ] **Créer Gérant**: Utilisateurs > Nouveau
- [ ] **Vérifier email 2FA**: Email reçu ?
- [ ] **Performance**: Page load < 3 secondes (première fois après wake-up)

**Si tout marche → SUCCÈS** 🎉

---

## ⚙️ CONFIGURATION AVANCÉE (Optionnel)

### Activer Auto-Deploy

Par défaut, Render redéploie automatiquement à chaque push GitHub.

**Vérifier** :
1. Dashboard > smartstock-web > **"Settings"**
2. Section **"Build & Deploy"**
3. **Auto-Deploy**: Doit être **Yes** ✅

### Custom Domain (Optionnel)

**Si tu as un nom de domaine** :

1. Settings > **"Custom Domains"**
2. Clique **"Add Custom Domain"**
3. Entre ton domaine: `smartstock.tondomaine.com`
4. Ajoute les DNS records (Render te donne les instructions)
5. Render génère SSL automatiquement ✅

### Logs en Temps Réel

```bash
# Via Dashboard
smartstock-web > Logs (onglet)

# Filtrer par niveau
- All Logs
- Error Only
- Search (barre de recherche)
```

---

## 🆘 DÉPANNAGE

### ❌ Erreur: "No encryption key"

**Cause**: APP_KEY pas généré

**Solution**:
1. Environment > Trouve **APP_KEY**
2. Si vide, clique **"Generate"** (Render le fait automatiquement normalement)
3. Redéploie (Manual Deploy)

### ❌ Erreur: "SQLSTATE[08006]" (Database)

**Cause**: Database pas encore créée

**Solution**:
1. Vérifie que **smartstock-db** est **"Available"** (Dashboard)
2. Vérifie les variables DB_* sont bien remplies (auto)
3. Redéploie si nécessaire

### ❌ Page blanche / Erreur 500

**Cause**: Cache ou migration

**Solution**:
```bash
# Via Shell (Dashboard > Shell)
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
```

### ❌ Service "Sleeping"

**Normal** - Plan gratuit s'endort après 15 min.

**Au réveil** :
- Première requête: 30-60 secondes
- Requêtes suivantes: rapide

**Upgrade au plan payant (7$/mois)** pour éviter le sleep.

### ❌ Emails pas envoyés

**Vérifications** :
1. Environment > **MAIL_PASSWORD** = `uqwyfvscdhnelrxt` (sans espace)
2. Logs > Chercher "SMTP error"
3. Tester Gmail App Password actif

---

## 📊 LIMITES PLAN GRATUIT

| Resource | Limite Gratuite |
|----------|----------------|
| Web Service | 750 heures/mois (suffisant) |
| PostgreSQL | 90 jours (puis expire) |
| RAM | 512 MB |
| Bandwidth | 100 GB/mois |
| Build Minutes | 500 min/mois |
| Auto-sleep | Après 15 min d'inactivité |

**⚠️ PostgreSQL expire après 90 jours** - Sauvegarde tes données régulièrement !

**Upgrade disponible**: 7$/mois (pas de sleep + database permanente)

---

## 🔄 MISES À JOUR (Futurs déploiements)

### Auto-deploy activé

Chaque fois que tu push sur GitHub:
```bash
git add .
git commit -m "Update feature"
git push origin main
```

Render redéploie automatiquement ✅

### Forcer un redéploiement

Dashboard > smartstock-web > **"Manual Deploy"** > **"Deploy latest commit"**

---

## 📚 MONITORING

### Dashboard Render

**Métriques visibles** :
- CPU Usage
- Memory Usage
- Response Time
- Bandwidth
- Deploy History

### Logs

**Voir les logs**:
1. smartstock-web > **Logs**
2. Filtre par date/niveau
3. Recherche par mot-clé

### Alertes

**Configurer notifications** :
1. Settings > **"Notifications"**
2. Email ou Slack
3. Alertes: Deploy failed, High CPU, etc.

---

## 🎉 SUCCÈS - DÉPLOIEMENT RENDER COMPLET !

Si tout fonctionne:

```
╔═══════════════════════════════════════════════╗
║   SmartStock déployé sur Render.com ✅        ║
║                                               ║
║   URL: https://smartstock-web.onrender.com   ║
║                                               ║
║   Admin: admin@smartstock.cm                  ║
║   Password: Admin2025!SmartStock              ║
║                                               ║
║   Database: PostgreSQL (gratuit 90 jours)     ║
║   Plan: Free (avec auto-sleep)                ║
║   SSL: Automatique (HTTPS)                    ║
║                                               ║
║   STATUS: PRODUCTION READY 🚀                ║
╚═══════════════════════════════════════════════╝
```

**Prochaines étapes**:
1. ✅ Change le mot de passe admin
2. ✅ Crée tes vrais magasins
3. ✅ Crée tes gérants et vendeurs
4. ✅ Forme les utilisateurs
5. ⚠️ Sauvegarde la BD régulièrement (expire dans 90 jours)
6. (Optionnel) Upgrade plan pour éviter auto-sleep

---

## 🔗 RESSOURCES

**Render Docs**:
- Getting Started: https://render.com/docs
- Laravel Deploy: https://render.com/docs/deploy-laravel
- PostgreSQL: https://render.com/docs/databases

**Support Render**:
- Community: https://community.render.com
- Status: https://status.render.com

**Support SmartStock**:
- Voir: `DEPLOYMENT_STATUS.md`
- Troubleshooting: `FINAL_CORRECTIONS_2025-12-07.md`

---

**Dernière mise à jour**: 2025-12-07
**Version**: 2.1 - Render Ready ✅
**Temps total**: 15-20 minutes
**Prix**: GRATUIT 🎉

**BON DÉPLOIEMENT SUR RENDER ! 🚀**
