# 🚂 Déploiement Railway - Guide Ultra-Rapide

**Pour les pressés - Résumé en 2 pages** ⏱️

---

## 🎯 TU AS BESOIN DE QUOI ?

1. **Credentials PostgreSQL Railway** (va les chercher maintenant):
   ```
   PGHOST     = _____________________
   PGPORT     = _____________________
   PGDATABASE = _____________________
   PGUSER     = _____________________
   PGPASSWORD = _____________________
   ```

2. **Credentials Pusher** (régénère sur dashboard.pusher.com):
   ```
   APP_ID  = _____________________
   APP_KEY = _____________________
   SECRET  = _____________________
   ```

---

## ⚡ DÉPLOIEMENT EN 5 ÉTAPES (15 min)

### 1️⃣ Push vers GitHub (2 min)

```bash
cd smartstock

# Vérifier que les fichiers Railway sont là
ls -la | grep -E "(Procfile|railway.toml|heroku-start.sh)"

# Rendre le script exécutable
chmod +x heroku-start.sh

# Commit & Push
git add .
git commit -m "🚀 Ready for Railway deployment"
git push origin main
```

### 2️⃣ Créer projet sur Railway (2 min)

1. https://railway.app/dashboard
2. **New Project** > **Deploy from GitHub repo**
3. Sélectionne ton repo `MonoProject`
4. Railway détecte Laravel automatiquement ✅

### 3️⃣ Configurer variables (5 min)

1. Clique sur ton service **SmartStock**
2. Onglet **"Variables"**
3. Clique **"RAW Editor"**
4. Copie-colle ça et **REMPLACE les valeurs**:

```env
APP_NAME=SmartStock Production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://SERA_GENERE_APRES.up.railway.app

# DATABASE (REMPLACE avec tes credentials PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=TON_PGHOST
DB_PORT=TON_PGPORT
DB_DATABASE=TON_PGDATABASE
DB_USERNAME=TON_PGUSER
DB_PASSWORD=TON_PGPASSWORD

# SESSION & CACHE
CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=60
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
LOG_LEVEL=info

# MAIL (Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=grecdada@gmail.com
MAIL_PASSWORD=uqwyfvscdhnelrxt
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=grecdada@gmail.com
MAIL_FROM_NAME=SmartStock

# PUSHER (REMPLACE avec tes credentials régénérées)
PUSHER_APP_ID=TON_APP_ID
PUSHER_APP_KEY=TON_APP_KEY
PUSHER_APP_SECRET=TON_APP_SECRET
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=eu
VITE_PUSHER_APP_KEY=${PUSHER_APP_KEY}
VITE_PUSHER_APP_CLUSTER=${PUSHER_APP_CLUSTER}
```

5. **Sauvegarder** → Railway redéploie automatiquement

### 4️⃣ Attendre le build (3-5 min)

1. Onglet **"Deployments"** → Voir les logs en temps réel
2. Attendre que ça affiche:
   ```
   ✅ Build completed
   🚀 SmartStock - Démarrage sur Railway
   📦 Exécution des migrations...
   ⚡ Optimisation de l'application...
   🌐 Démarrage du serveur web...
   ```

### 5️⃣ Générer domaine & tester (3 min)

1. Onglet **"Settings"** > Section **"Domains"**
2. Clique **"Generate Domain"**
3. Note l'URL: `https://smartstock-production-xxxx.up.railway.app`
4. **IMPORTANT**: Retourne dans **"Variables"** et met à jour:
   ```env
   APP_URL=https://smartstock-production-xxxx.up.railway.app
   ```
5. Sauvegarde (redéploie automatiquement)
6. Ouvre l'URL → Tu dois voir la page de login ✅

---

## 👤 CRÉER LE PREMIER ADMIN

**Via Railway CLI** (plus rapide):

```bash
# Installer Railway CLI (une seule fois)
npm install -g @railway/cli

# Se connecter à Railway
railway login

# Lier au projet
railway link

# Créer le Super-Admin
railway run php artisan tinker

# Dans Tinker, tape ça:
\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);
$user = \App\Models\User::create(['name' => 'Admin', 'username' => 'admin', 'email' => 'admin@smartstock.cm', 'password' => bcrypt('MotDePasseSecure123!'), 'is_active' => true]);
$user->assignRole('super-admin');
exit
```

**Credentials admin créé**:
- Email: `admin@smartstock.cm`
- Password: `MotDePasseSecure123!` (**CHANGE-LE APRÈS PREMIER LOGIN**)

---

## ✅ TESTS RAPIDES

Fais ces 5 tests dans l'ordre:

1. **Login**: `https://ton-app.up.railway.app/login`
   - Email: `admin@smartstock.cm`
   - Password: `MotDePasseSecure123!`
   - ✅ Doit fonctionner

2. **Dashboard**: Après login, tu vois le dashboard SuperAdmin
   - ✅ Pas d'erreur 500

3. **Créer Store**: Dashboard > Gestion Magasins > Créer
   - Nom: "Test Store"
   - Code: (auto-généré)
   - ✅ Doit enregistrer

4. **Créer Gérant**: Dashboard > Utilisateurs > Créer
   - Rôle: Gérant
   - Store: Test Store
   - ✅ Doit enregistrer

5. **Test Email 2FA** (si SMTP ok):
   - Logout
   - Re-login
   - ✅ Code 2FA reçu par email

**Si tout marche → SUCCÈS 🎉**

---

## 🔧 PROBLÈMES COURANTS (Solutions 30 sec)

### ❌ "No encryption key"
```bash
# Localement:
php artisan key:generate --show

# Copie la clé (commence par base64:)
# Ajoute dans Railway Variables:
APP_KEY=base64:LA_CLE_COPIEE
```

### ❌ "Connection refused" (Database)
```
Vérifie dans Variables Railway:
DB_HOST = Exactement ton PGHOST (sans espace)
DB_PASSWORD = Exactement ton PGPASSWORD (sans espace)

Ou simplifie avec:
DATABASE_URL=${{Postgres.DATABASE_URL}}
```

### ❌ Page blanche
```bash
# Via Railway CLI:
railway run php artisan config:clear
railway run php artisan cache:clear
railway run php artisan migrate --force
```

### ❌ Emails non envoyés
```
Vérifie:
MAIL_MAILER=smtp (PAS "log")
MAIL_PASSWORD=ton_app_password_gmail (16 caractères sans espace)

Si Gmail marche pas:
→ Utilise Brevo (gratuit 300/jour)
→ Voir SMTP_QUICK_START.md
```

---

## 🚀 OPTIMISATIONS (5 min chacune)

### Redis Cache (10-100x plus rapide)
```
1. Railway Dashboard > New > Database > Redis
2. Variables SmartStock:
   CACHE_STORE=redis
   REDIS_URL=${{Redis.REDIS_URL}}
3. Redéployer → Dashboard ultra-rapide
```

### Queue Worker (emails async)
```
1. Railway Dashboard > New > Service (même repo)
2. Custom Start Command:
   php artisan queue:work --tries=3 --timeout=30
3. Copier TOUTES les variables depuis app principale
4. Déployer → Emails envoyés en arrière-plan
```

---

## 📊 MONITORING

**Voir les logs en temps réel**:
```bash
# Via CLI
railway logs

# Via Dashboard
Deployments > Latest > View Logs
```

**Métriques importantes** (Railway Dashboard):
- CPU < 70% ✅
- Memory < 400MB ✅
- No crashes ✅

---

## 📚 GUIDES COMPLETS

**Besoin de plus de détails ?**

| Guide | Pour quoi | Temps |
|-------|-----------|-------|
| `RAILWAY_CHECKLIST.md` | Checklist étape par étape | 20 min |
| `RAILWAY_DEPLOY_SIMPLE.md` | Guide complet détaillé | 40 min |
| `DEPLOYMENT_STATUS.md` | État complet du projet | - |
| `.railway-env.example` | Template variables complètes | - |

---

## 🎉 TU AS RÉUSSI !

Si l'app est accessible et fonctionne:

```
╔═══════════════════════════════════════╗
║  SmartStock déployé sur Railway ✅    ║
║                                       ║
║  URL: https://ton-app.railway.app    ║
║  Admin: admin@smartstock.cm          ║
║  Status: PRODUCTION READY 🚀         ║
╚═══════════════════════════════════════╝
```

**Prochaines étapes**:
1. Change le mot de passe admin
2. Crée tes vrais magasins
3. Crée tes gérants et vendeurs
4. Forme les utilisateurs
5. (Optionnel) Active Redis + Queue Worker

**Questions ?** → Voir les guides complets ci-dessus

---

**Créé le**: 2025-12-07
**Version**: 2.1 - Ultra Simple ⚡
**Temps total**: 15-20 minutes
