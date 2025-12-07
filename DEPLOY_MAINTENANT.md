# 🚀 DÉPLOIE MAINTENANT - INSTRUCTIONS EXACTES

**Suis ces étapes DANS L'ORDRE. Temps total: 10 minutes.**

---

## ✅ ÉTAPE 1: PUSHER CREDENTIALS (2 min) - IMPORTANT !

**Tu DOIS régénérer les credentials Pusher pour la sécurité** (les anciennes sont dans Git)

1. Va sur https://dashboard.pusher.com
2. Connecte-toi
3. Sélectionne ton app Pusher (ou crée-en une nouvelle)
4. Va dans **App Keys**
5. **Note ces 3 valeurs**:

```
PUSHER_APP_ID     = ________________
PUSHER_APP_KEY    = ________________
PUSHER_APP_SECRET = ________________
```

---

## ✅ ÉTAPE 2: COMMIT & PUSH (30 secondes)

```bash
cd smartstock

# Vérifier fichiers Railway
ls -la | grep -E "(Procfile|railway.toml|heroku-start.sh)"

# Rendre script exécutable
chmod +x heroku-start.sh

# Commit
git add Procfile railway.toml nixpacks.toml heroku-start.sh RAILWAY_*.md .railway-env.example
git commit -m "🚀 Railway deployment ready"

# Push
git push origin main
```

---

## ✅ ÉTAPE 3: CRÉER PROJET RAILWAY (1 min)

1. Ouvre https://railway.app/dashboard
2. Clique **"New Project"**
3. Sélectionne **"Deploy from GitHub repo"**
4. Sélectionne ton repo **MonoProject**
5. Railway détecte Laravel automatiquement ✅

---

## ✅ ÉTAPE 4: CONFIGURER VARIABLES (3 min) - CRUCIAL !

1. Clique sur le service **SmartStock** (pas PostgreSQL)
2. Onglet **"Variables"**
3. Clique **"RAW Editor"** (en haut à droite)
4. **SUPPRIME tout** ce qui est dedans
5. **Ouvre le fichier `.env.railway`** (dans ton projet)
6. **COPIE TOUT** le contenu
7. **COLLE** dans Railway RAW Editor
8. **REMPLACE** les 3 lignes Pusher avec tes valeurs de l'ÉTAPE 1:
   ```env
   PUSHER_APP_ID=ta_vraie_app_id
   PUSHER_APP_KEY=ta_vraie_app_key
   PUSHER_APP_SECRET=ton_vrai_app_secret
   ```
9. Clique **"Save"** → Railway redéploie automatiquement

---

## ✅ ÉTAPE 5: ATTENDRE BUILD (3-5 min)

1. Onglet **"Deployments"**
2. Clique sur le dernier déploiement (tout en haut)
3. Clique **"View Logs"**
4. Attends de voir:
   ```
   ✅ Installing PHP dependencies
   ✅ Installing Node dependencies
   ✅ Building frontend assets
   ✅ Build completed

   🚀 SmartStock - Démarrage sur Railway
   📦 Exécution des migrations...
   ⚡ Optimisation de l'application...
   🌐 Démarrage du serveur web...
   Laravel development server started
   ```

**Si tu vois ça → BUILD RÉUSSI ✅**

---

## ✅ ÉTAPE 6: GÉNÉRER DOMAINE (1 min)

1. Onglet **"Settings"**
2. Section **"Domains"**
3. Clique **"Generate Domain"**
4. Railway génère: `https://smartstock-production-xxxx.up.railway.app`
5. **Si l'URL générée est différente de `https://smartstock-production.up.railway.app`**:
   - Retourne dans **Variables**
   - Change `APP_URL` avec la VRAIE URL générée
   - Change `ASSET_URL` avec la VRAIE URL générée
   - Clique **Save** (redéploie automatiquement)

---

## ✅ ÉTAPE 7: TESTER L'APP (1 min)

1. Ouvre l'URL Railway dans ton navigateur
2. Tu dois voir la page `/login` ✅
3. Pas d'erreur 500 ✅

**Si page login s'affiche → DÉPLOIEMENT RÉUSSI 🎉**

---

## ✅ ÉTAPE 8: CRÉER SUPER-ADMIN (2 min)

**Option 1: Via Railway CLI (recommandé)**

```bash
# Installer Railway CLI (une seule fois)
npm install -g @railway/cli

# Se connecter
railway login

# Lier au projet (choisir "smartstock-production")
railway link

# Ouvrir Tinker
railway run php artisan tinker
```

Dans Tinker, **copie-colle ligne par ligne**:

```php
\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);

$user = \App\Models\User::create(['name' => 'Admin Principal', 'username' => 'superadmin', 'email' => 'admin@smartstock.cm', 'password' => bcrypt('Admin2025!SmartStock'), 'is_active' => true]);

$user->assignRole('super-admin');

echo "Super-Admin créé: " . $user->email;

exit
```

**Credentials créés**:
- **Email**: `admin@smartstock.cm`
- **Password**: `Admin2025!SmartStock`
- ⚠️ **Change-le après premier login !**

**Option 2: Si Railway CLI ne marche pas**

Voir le guide `RAILWAY_DEPLOY_SIMPLE.md` section "Créer SuperAdmin via Seeder"

---

## ✅ ÉTAPE 9: PREMIER LOGIN (1 min)

1. Va sur `https://ton-url-railway.up.railway.app/login`
2. Email: `admin@smartstock.cm`
3. Password: `Admin2025!SmartStock`
4. Si 2FA activé → Vérifie ton email pour le code
5. Tu arrives sur le dashboard SuperAdmin ✅

**PREMIER TEST**: Change ton mot de passe immédiatement !
- Dashboard > Profil > Changer mot de passe

---

## ✅ TESTS RAPIDES (2 min)

Fais ces 5 tests:

1. **Dashboard SuperAdmin** → S'affiche correctement ✅
2. **Créer Store**:
   - Gestion Magasins > Nouveau
   - Nom: "Magasin Principal"
   - Ville: "Douala"
   - Créer ✅
3. **Créer Gérant**:
   - Utilisateurs > Nouveau
   - Rôle: Gérant
   - Magasin: Magasin Principal
   - Créer ✅
4. **Vérifier Email 2FA** → Email reçu ? ✅
5. **Performance** → Dashboard charge en < 2 secondes ? ✅

**Si tout marche → SUCCÈS TOTAL 🎉🎉🎉**

---

## 🔧 SI PROBLÈME (Solutions rapides)

### ❌ Erreur "No encryption key"

```bash
# Localement:
php artisan key:generate --show

# Copie la clé (commence par base64:)
# Ajoute dans Railway Variables:
APP_KEY=base64:LA_CLE_GENEREE

# Redéploie
```

### ❌ Erreur "SQLSTATE[08006]" (Database)

```
Vérifie dans Railway Variables:
DB_HOST=postgres.railway.internal (exactement)
DB_PASSWORD=rGziZWJbZUIVxpyGNCDALQGpBamUyGzb (sans espace)

Ou remplace DB_* par:
DATABASE_URL=${{Postgres.DATABASE_URL}}
```

### ❌ Page blanche / Erreur 500

```bash
railway run php artisan config:clear
railway run php artisan cache:clear
railway run php artisan migrate --force
```

### ❌ "Class Role not found"

Tu n'as pas créé les rôles. Exécute:

```bash
railway run php artisan tinker

# Dans Tinker:
\Spatie\Permission\Models\Role::create(['name' => 'super-admin']);
\Spatie\Permission\Models\Role::create(['name' => 'gerant']);
\Spatie\Permission\Models\Role::create(['name' => 'vendeur']);
exit
```

Puis retourne à l'ÉTAPE 8.

### ❌ Emails pas envoyés

Vérifie:
```env
MAIL_MAILER=smtp (PAS "log")
MAIL_PASSWORD=uqwyfvscdhnelrxt (sans espace)
```

Si Gmail bloque toujours → Utilise Brevo (voir `SMTP_QUICK_START.md`)

---

## 🚀 OPTIMISATIONS (Après déploiement réussi)

### Redis Cache (10x plus rapide) - 5 min

```
1. Railway Dashboard > New > Database > Add Redis
2. Variables SmartStock > Ajouter:
   CACHE_STORE=redis
   REDIS_URL=${{Redis.REDIS_URL}}
3. Save (redéploie auto)
4. Dashboard devient ULTRA rapide ⚡
```

### Queue Worker (emails async) - 5 min

```
1. Railway Dashboard > New > Service (même repo)
2. Settings > Custom Start Command:
   php artisan queue:work --tries=3 --timeout=30
3. Variables > Copier TOUTES les variables depuis SmartStock
4. Deploy
5. Emails envoyés en arrière-plan ⚡
```

---

## 📊 MONITORING

**Voir logs en temps réel**:

```bash
railway logs
```

Ou Dashboard > Deployments > Latest > View Logs

**Métriques** (Dashboard):
- CPU < 70% ✅
- Memory < 400MB ✅
- Pas de crash ✅

---

## 🎉 FÉLICITATIONS !

Si tu arrives ici avec tout qui marche:

```
╔════════════════════════════════════════════════╗
║                                                ║
║   🎉 SmartStock déployé avec SUCCÈS ! 🎉      ║
║                                                ║
║   URL: https://smartstock-production.up.      ║
║        railway.app                             ║
║                                                ║
║   Admin: admin@smartstock.cm                   ║
║   Password: Admin2025!SmartStock               ║
║                                                ║
║   ✅ Base de données: PostgreSQL Railway      ║
║   ✅ Emails: Gmail SMTP                       ║
║   ✅ Broadcasting: Pusher                     ║
║   ✅ Migrations: Exécutées                    ║
║   ✅ Performance: Optimale                    ║
║                                                ║
║   STATUT: PRODUCTION READY 🚀                 ║
║                                                ║
╚════════════════════════════════════════════════╝
```

**Prochaines étapes**:
1. ✅ Change le mot de passe admin
2. ✅ Crée tes vrais magasins
3. ✅ Crée tes gérants et vendeurs
4. ✅ Forme les utilisateurs
5. (Optionnel) Active Redis pour perf max
6. (Optionnel) Active Queue Worker pour emails async

---

## 📚 SUPPORT

**Questions ?**
- Guide complet: `RAILWAY_DEPLOY_SIMPLE.md`
- Checklist: `RAILWAY_CHECKLIST.md`
- Status projet: `DEPLOYMENT_STATUS.md`
- SMTP: `SMTP_QUICK_START.md`

**Railway Support**:
- Docs: https://docs.railway.app
- Discord: https://discord.gg/railway

---

**Créé le**: 2025-12-07
**Credentials pré-remplies**: ✅ OUI
**Temps total**: 10-15 minutes
**Difficulté**: ⭐☆☆☆☆ (Très facile)

**BON DÉPLOIEMENT ! 🚀**
