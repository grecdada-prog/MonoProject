# 🚀 Guide de Déploiement Railway - SmartStock

**Version**: 2.1
**Temps estimé**: 15-20 minutes
**Difficulté**: ⭐⭐☆☆☆ (Facile)

---

## 📋 PRÉ-REQUIS

Avant de commencer, assure-toi d'avoir:

- [x] Compte Railway créé (https://railway.app)
- [x] PostgreSQL service créé sur Railway
- [x] Les credentials PostgreSQL (PGDATABASE, PGHOST, PGPORT, PGUSER, PGPASSWORD)
- [x] Compte GitHub (pour connecter le repo)
- [x] Git configuré localement

---

## 🎯 ÉTAPE 1: PRÉPARER LE CODE (5 min)

### 1.1 Vérifier les fichiers Railway

Assure-toi que ces fichiers existent (✅ déjà créés):

```bash
cd smartstock
ls -la | grep -E "(Procfile|railway.toml|nixpacks.toml|heroku-start.sh)"
```

Tu dois voir:
- ✅ `Procfile` - Définit comment démarrer l'app
- ✅ `railway.toml` - Configuration Railway
- ✅ `nixpacks.toml` - Configuration build Nixpacks
- ✅ `heroku-start.sh` - Script de démarrage
- ✅ `.railway-env.example` - Template variables d'environnement

### 1.2 Rendre le script exécutable

```bash
chmod +x heroku-start.sh
```

### 1.3 Commit et push vers GitHub

```bash
# Ajouter tous les fichiers Railway
git add Procfile railway.toml nixpacks.toml heroku-start.sh .railway-env.example

# Commit
git commit -m "🚀 Configuration Railway pour déploiement production"

# Push vers GitHub
git push origin main
```

---

## 🔗 ÉTAPE 2: CONNECTER RAILWAY À GITHUB (3 min)

### 2.1 Créer un nouveau projet Railway

1. Va sur https://railway.app/dashboard
2. Clique sur **"New Project"**
3. Sélectionne **"Deploy from GitHub repo"**
4. Autorise Railway à accéder à ton GitHub (si première fois)
5. Sélectionne le repo **"MonoProject"** (ou le nom de ton repo)
6. Railway détecte automatiquement Laravel avec Nixpacks ✅

### 2.2 Vérifier la détection

Railway devrait afficher:
- ✅ **Builder**: Nixpacks
- ✅ **Framework détecté**: Laravel
- ✅ **Build Command**: Automatique (composer install + npm build)
- ✅ **Start Command**: `bash heroku-start.sh` (depuis Procfile)

---

## ⚙️ ÉTAPE 3: CONFIGURER LES VARIABLES D'ENVIRONNEMENT (10 min)

### 3.1 Récupérer les credentials PostgreSQL

Sur Railway Dashboard:
1. Clique sur ton service **PostgreSQL**
2. Va dans l'onglet **"Variables"**
3. Note ces valeurs (tu en auras besoin):

```
PGDATABASE = railway
PGHOST = xxxxxx.railway.app
PGPORT = 5432
PGUSER = postgres
PGPASSWORD = xxxxxxxxxxxxxxxxxx
```

### 3.2 Configurer les variables dans ton app

1. Clique sur ton service **SmartStock** (pas PostgreSQL)
2. Va dans l'onglet **"Variables"**
3. Clique sur **"RAW Editor"** (plus rapide)
4. Copie-colle le template ci-dessous et **REMPLACE les valeurs**:

```env
# ============ APP CONFIGURATION ============
APP_NAME=SmartStock Production
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://VOTRE_APP.up.railway.app
APP_LOCALE=fr

# ============ DATABASE (PostgreSQL Railway) ============
# OPTION 1: Variables séparées
DB_CONNECTION=pgsql
DB_HOST=REMPLACE_PAR_TON_PGHOST
DB_PORT=REMPLACE_PAR_TON_PGPORT
DB_DATABASE=REMPLACE_PAR_TON_PGDATABASE
DB_USERNAME=REMPLACE_PAR_TON_PGUSER
DB_PASSWORD=REMPLACE_PAR_TON_PGPASSWORD

# OPTION 2: Variable magique Railway (recommandé - simplifie)
# DATABASE_URL=${{Postgres.DATABASE_URL}}

# ============ SESSION & CACHE ============
CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=60
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true

# ============ LOGGING ============
LOG_CHANNEL=stack
LOG_LEVEL=info

# ============ MAIL (SMTP) ============
# Gmail (si tu as configuré App Password)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=grecdada@gmail.com
MAIL_PASSWORD=uqwyfvscdhnelrxt
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=grecdada@gmail.com
MAIL_FROM_NAME=SmartStock

# ============ PUSHER (Broadcasting) ============
# IMPORTANT: Régénère ces credentials sur dashboard.pusher.com
PUSHER_APP_ID=TON_APP_ID
PUSHER_APP_KEY=TON_APP_KEY
PUSHER_APP_SECRET=TON_APP_SECRET
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=eu

VITE_PUSHER_APP_KEY=${PUSHER_APP_KEY}
VITE_PUSHER_APP_CLUSTER=${PUSHER_APP_CLUSTER}
```

### 3.3 Variables automatiques Railway

Railway génère automatiquement certaines variables. **NE PAS les ajouter manuellement**:
- ✅ `PORT` - Railway l'assigne automatiquement
- ✅ `DATABASE_URL` - Si tu utilises `${{Postgres.DATABASE_URL}}`
- ⚠️ `APP_KEY` - Sera généré au premier déploiement (par heroku-start.sh)

---

## 🚢 ÉTAPE 4: DÉPLOYER (2 min)

### 4.1 Lancer le build

1. Railway détecte automatiquement le push GitHub
2. Le build démarre automatiquement
3. Suis les logs en temps réel dans l'onglet **"Deployments"**

### 4.2 Vérifier les logs de build

Tu devrais voir:

```bash
✅ Installing PHP dependencies (composer install)
✅ Installing Node dependencies (npm ci)
✅ Building frontend assets (npm run build)
✅ Build completed successfully
```

### 4.3 Vérifier les logs de démarrage

Une fois le build terminé, Railway exécute `bash heroku-start.sh`:

```bash
🚀 SmartStock - Démarrage sur Railway
======================================
📦 Exécution des migrations...
   Migration table created successfully.
   Migrating: 2024_01_01_000000_create_users_table
   Migrated: 2024_01_01_000000_create_users_table (150ms)
   ...
⚡ Optimisation de l'application...
   Configuration cached successfully.
   Routes cached successfully.
   ...
🌐 Démarrage du serveur web sur port 8080...
   Laravel development server started: http://0.0.0.0:8080
```

### 4.4 Accéder à ton application

1. Va dans l'onglet **"Settings"**
2. Trouve la section **"Domains"**
3. Clique sur **"Generate Domain"**
4. Railway génère une URL: `https://smartstock-production-xxxx.up.railway.app`
5. Clique sur l'URL pour ouvrir ton app 🎉

---

## ✅ ÉTAPE 5: VÉRIFICATIONS POST-DÉPLOIEMENT (5 min)

### 5.1 Tester l'accès

```bash
# Ouvre l'URL Railway dans ton navigateur
https://TON_APP.up.railway.app/login
```

Tu dois voir la page de login ✅

### 5.2 Créer le premier Super-Admin

**Option 1: Via Tinker (Railway CLI)**

Si tu as installé Railway CLI (`npm i -g @railway/cli`):

```bash
# Se connecter au container Railway
railway run php artisan tinker

# Dans Tinker:
>>> use App\Models\User;
>>> use Spatie\Permission\Models\Role;
>>> Role::firstOrCreate(['name' => 'super-admin']);
>>> $user = User::create([
    'name' => 'Admin',
    'username' => 'admin',
    'email' => 'admin@smartstock.cm',
    'password' => bcrypt('VotreMotDePasseSecurise123!'),
    'is_active' => true
]);
>>> $user->assignRole('super-admin');
>>> echo "Super-Admin créé: " . $user->email;
```

**Option 2: Via Seeder (recommandé)**

1. Crée un seeder localement:

```bash
# Localement
php artisan make:seeder SuperAdminSeeder
```

2. Édite `database/seeders/SuperAdminSeeder.php`:

```php
public function run()
{
    $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);

    $user = \App\Models\User::firstOrCreate(
        ['email' => 'admin@smartstock.cm'],
        [
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => bcrypt('ChangeMe123!'),
            'is_active' => true,
        ]
    );

    $user->assignRole('super-admin');
}
```

3. Commit et push:

```bash
git add database/seeders/SuperAdminSeeder.php
git commit -m "Add SuperAdmin seeder"
git push origin main
```

4. Exécute via Railway:

```bash
railway run php artisan db:seed --class=SuperAdminSeeder
```

### 5.3 Tester les fonctionnalités

- [ ] Login avec Super-Admin ✅
- [ ] Créer un Store
- [ ] Créer un Gérant
- [ ] Créer un Vendeur (via Gérant)
- [ ] Créer un Produit
- [ ] Créer une Vente
- [ ] Générer une Facture PDF
- [ ] Vérifier email 2FA (si SMTP configuré)

---

## 🔧 ÉTAPE 6: OPTIMISATIONS (Optionnel)

### 6.1 Ajouter Redis pour le cache (recommandé)

1. Sur Railway Dashboard, clique **"New"** > **"Database"** > **"Add Redis"**
2. Railway crée automatiquement la variable `${{Redis.REDIS_URL}}`
3. Ajoute dans les variables de ton app:

```env
CACHE_STORE=redis
REDIS_URL=${{Redis.REDIS_URL}}
```

4. Redéploie (Railway le fait automatiquement)

**Gain de performance**: 10-100x plus rapide que database cache ⚡

### 6.2 Activer le Queue Worker (pour emails async)

1. Va dans **Settings** > **Deploy**
2. Trouve **"Custom Start Command"**
3. Remplace par:

```bash
bash heroku-start.sh & php artisan queue:work --tries=3 --timeout=30
```

Ou crée un service séparé (meilleure approche):

1. Crée un nouveau service depuis le même repo
2. Configure avec ces variables (copie depuis l'app principale)
3. Custom Start Command:

```bash
php artisan queue:work database --tries=3 --timeout=30 --sleep=3
```

---

## 🆘 DÉPANNAGE (Troubleshooting)

### Erreur: "No application encryption key has been specified"

**Cause**: APP_KEY manquante

**Solution**:
1. Localement: `php artisan key:generate --show`
2. Copie la clé générée (commence par `base64:...`)
3. Ajoute dans Railway Variables: `APP_KEY=base64:...`
4. Redéploie

### Erreur: "SQLSTATE[08006] Connection failed"

**Cause**: Credentials PostgreSQL incorrectes

**Solution**:
1. Vérifie les variables DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
2. Ou utilise: `DATABASE_URL=${{Postgres.DATABASE_URL}}`

### Erreur: "npm run build failed"

**Cause**: Dépendances Node manquantes ou Vite config

**Solution**:
1. Vérifie que `package.json` existe
2. Vérifie que `vite.config.js` existe
3. Logs Railway: Cherche l'erreur exacte

### App accessible mais erreur 500

**Cause**: Migration échouée ou config cache

**Solution**:
```bash
# Via Railway CLI
railway run php artisan migrate --force
railway run php artisan config:clear
railway run php artisan cache:clear
```

### Emails non envoyés

**Cause**: SMTP pas configuré ou credentials Gmail invalides

**Solution**:
1. Vérifie MAIL_MAILER=smtp (pas "log")
2. Teste Gmail App Password est actif
3. Ou utilise Brevo (voir SMTP_QUICK_START.md)

---

## 📊 MONITORING

### Voir les logs en temps réel

```bash
# Via Dashboard
Railway > Ton App > Deployments > Clique sur le dernier > View Logs

# Via CLI
railway logs --follow
```

### Métriques importantes

Railway Dashboard affiche automatiquement:
- **CPU Usage**: Doit rester < 70%
- **Memory Usage**: Doit rester < 80% (limite: 512MB par défaut)
- **Bandwidth**: Trafic réseau
- **Build Time**: Temps de build (cible: < 5 min)

---

## 🎉 SUCCÈS !

Si tout fonctionne:
- ✅ App accessible via URL Railway
- ✅ Login fonctionne
- ✅ Base de données connectée
- ✅ Migrations exécutées
- ✅ Assets frontend chargés

**Score déploiement**: 10/10 ⭐

---

## 📚 RESSOURCES

- **Railway Docs**: https://docs.railway.app
- **Nixpacks Docs**: https://nixpacks.com
- **Laravel Deployment**: https://laravel.com/docs/deployment
- **Support SmartStock**: Voir `DEPLOYMENT_STATUS.md`

---

## 📝 CHECKLIST RAPIDE

Avant déploiement:
- [ ] Git push vers GitHub
- [ ] Credentials PostgreSQL notées
- [ ] Variables d'environnement configurées
- [ ] Pusher credentials régénérées (sécurité)
- [ ] SMTP configuré (Gmail ou Brevo)

Après déploiement:
- [ ] URL Railway accessible
- [ ] Super-Admin créé
- [ ] Login fonctionnel
- [ ] Vente test créée
- [ ] Facture PDF générée

---

**Dernière mise à jour**: 2025-12-07
**Version**: 2.1 - Railway Ready ✅
