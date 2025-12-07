# ✅ Checklist Déploiement Railway - SmartStock

**Utilise cette checklist pour un déploiement sans stress !**

---

## 📦 PRÉPARATION (Avant de déployer)

### Code
- [ ] Tous les fichiers Railway sont présents:
  - [ ] `Procfile`
  - [ ] `railway.toml`
  - [ ] `nixpacks.toml`
  - [ ] `heroku-start.sh` (chmod +x)
- [ ] `heroku-start.sh` est exécutable: `chmod +x heroku-start.sh`
- [ ] Git: Tous les changements sont commités
- [ ] Git: Push vers GitHub effectué

### Credentials (Note-les maintenant)
- [ ] **PostgreSQL** (depuis Railway Dashboard):
  - [ ] PGHOST = `________________`
  - [ ] PGPORT = `________________`
  - [ ] PGDATABASE = `________________`
  - [ ] PGUSER = `________________`
  - [ ] PGPASSWORD = `________________`

- [ ] **Pusher** (régénère sur dashboard.pusher.com):
  - [ ] PUSHER_APP_ID = `________________`
  - [ ] PUSHER_APP_KEY = `________________`
  - [ ] PUSHER_APP_SECRET = `________________`

- [ ] **SMTP** (Gmail ou Brevo):
  - [ ] MAIL_HOST = `________________`
  - [ ] MAIL_USERNAME = `________________`
  - [ ] MAIL_PASSWORD = `________________`

---

## 🚀 DÉPLOIEMENT

### Étape 1: Créer projet Railway
- [ ] Aller sur https://railway.app/dashboard
- [ ] Cliquer "New Project"
- [ ] Sélectionner "Deploy from GitHub repo"
- [ ] Autoriser Railway (si première fois)
- [ ] Choisir le repo `MonoProject`
- [ ] Railway détecte Laravel + Nixpacks ✅

### Étape 2: Configurer Variables
- [ ] Cliquer sur le service SmartStock
- [ ] Onglet "Variables"
- [ ] Cliquer "RAW Editor"
- [ ] Copier le template depuis `.railway-env.example`
- [ ] Remplacer TOUTES les valeurs `REMPLACE_PAR_TON_*`
- [ ] Sauvegarder

Variables CRITIQUES à configurer:
- [ ] `DB_HOST` = Ton PGHOST
- [ ] `DB_PORT` = Ton PGPORT
- [ ] `DB_DATABASE` = Ton PGDATABASE
- [ ] `DB_USERNAME` = Ton PGUSER
- [ ] `DB_PASSWORD` = Ton PGPASSWORD
- [ ] `PUSHER_APP_ID` = (régénéré)
- [ ] `PUSHER_APP_KEY` = (régénéré)
- [ ] `PUSHER_APP_SECRET` = (régénéré)
- [ ] `APP_ENV` = production
- [ ] `APP_DEBUG` = false

### Étape 3: Premier déploiement
- [ ] Railway détecte le push automatiquement
- [ ] Onglet "Deployments" - Suivre les logs
- [ ] Attendre le build (3-5 min)
- [ ] Vérifier logs de démarrage (heroku-start.sh)

### Étape 4: Générer domaine
- [ ] Onglet "Settings"
- [ ] Section "Domains"
- [ ] Cliquer "Generate Domain"
- [ ] Noter l'URL: `https://__________________.up.railway.app`
- [ ] Mettre à jour `APP_URL` dans Variables avec cette URL
- [ ] Redéployer (automatique après sauvegarde variables)

---

## ✅ VÉRIFICATIONS POST-DÉPLOIEMENT

### Tests de base
- [ ] Ouvrir l'URL Railway dans le navigateur
- [ ] Page `/login` s'affiche correctement
- [ ] Pas d'erreur 500 ou 404
- [ ] Assets CSS/JS chargés (vérifier dans DevTools)

### Créer Super-Admin
Choisir UNE méthode:

**Méthode 1: Via Tinker (Railway CLI)**
```bash
railway run php artisan tinker

# Dans Tinker:
\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);
$user = \App\Models\User::create([
    'name' => 'Admin',
    'username' => 'admin',
    'email' => 'admin@smartstock.cm',
    'password' => bcrypt('ChangeMe123!'),
    'is_active' => true
]);
$user->assignRole('super-admin');
```

- [ ] Super-Admin créé
- [ ] Email et mot de passe notés

**Méthode 2: Via migration locale puis push**
- [ ] Créer seeder localement (voir guide)
- [ ] Push vers GitHub
- [ ] Exécuter: `railway run php artisan db:seed --class=SuperAdminSeeder`

### Tests fonctionnels
- [ ] **Login**: Se connecter avec Super-Admin
- [ ] **Dashboard**: Affiche correctement
- [ ] **Store**: Créer un magasin
- [ ] **Gérant**: Créer un gérant
- [ ] **Vendeur**: Créer un vendeur (via gérant)
- [ ] **Produit**: Créer un produit
- [ ] **Vente**: Créer une vente
- [ ] **Facture PDF**: Générer et télécharger
- [ ] **Email 2FA**: Vérifier réception (si SMTP ok)
- [ ] **Historique**: Exporter en Excel
- [ ] **Isolation**: Gérant A ne voit pas données Gérant B

### Performance
- [ ] Page load < 2 secondes
- [ ] Dashboard Gérant < 500ms
- [ ] Ventes créées sans timeout
- [ ] Pas d'erreurs dans les logs Railway

---

## 🔧 OPTIMISATIONS (Recommandées)

### Redis Cache (10-100x plus rapide)
- [ ] Railway Dashboard > New > Database > Redis
- [ ] Variables SmartStock: `CACHE_STORE=redis`
- [ ] Variables SmartStock: `REDIS_URL=${{Redis.REDIS_URL}}`
- [ ] Redéployer
- [ ] Tester: Dashboard doit être ultra-rapide

### Queue Worker (emails async)
- [ ] Créer nouveau service depuis même repo
- [ ] Custom Start Command: `php artisan queue:work --tries=3 --timeout=30`
- [ ] Copier TOUTES les variables depuis app principale
- [ ] Déployer
- [ ] Tester: Email envoyé en arrière-plan

### Monitoring
- [ ] Configurer alertes Railway (Settings > Alerts)
- [ ] Alert CPU > 80%
- [ ] Alert Memory > 400MB
- [ ] Alert Crash rate > 5%

---

## 🆘 TROUBLESHOOTING

### ❌ Erreur "No encryption key"
- [ ] Générer: `php artisan key:generate --show`
- [ ] Copier clé (commence par `base64:`)
- [ ] Ajouter dans Variables: `APP_KEY=base64:...`
- [ ] Redéployer

### ❌ Erreur "Connection refused" (DB)
- [ ] Vérifier DB_HOST = PGHOST (exact)
- [ ] Vérifier DB_PASSWORD = PGPASSWORD (sans espaces)
- [ ] Ou utiliser: `DATABASE_URL=${{Postgres.DATABASE_URL}}`

### ❌ Page blanche / Erreur 500
- [ ] Logs Railway: Chercher erreur exacte
- [ ] `railway run php artisan config:clear`
- [ ] `railway run php artisan cache:clear`
- [ ] `railway run php artisan migrate --force`

### ❌ Assets non chargés (CSS/JS)
- [ ] Vérifier `APP_URL` dans Variables = URL Railway exacte
- [ ] `railway run php artisan config:cache`
- [ ] Vider cache navigateur (Ctrl+Shift+R)

### ❌ Emails non envoyés
- [ ] Vérifier `MAIL_MAILER=smtp` (pas "log")
- [ ] Tester Gmail App Password actif
- [ ] Logs Railway: Chercher erreur SMTP
- [ ] Alternative: Utiliser Brevo (voir SMTP_QUICK_START.md)

---

## 🎉 SUCCÈS - DÉPLOIEMENT COMPLET !

Si tout est ✅:
```
╔═══════════════════════════════════════════════╗
║   SmartStock déployé sur Railway avec succès  ║
║                                               ║
║   URL: https://ton-app.up.railway.app        ║
║   Status: Production Ready ✅                 ║
║   Performance: Optimale ⚡                    ║
║                                               ║
║   Prochaines étapes:                         ║
║   - Former les utilisateurs                  ║
║   - Configurer sauvegardes BD                ║
║   - Activer monitoring (optionnel)           ║
╚═══════════════════════════════════════════════╝
```

---

## 📞 SUPPORT

**Problème non résolu ?**
- 📖 Voir guide complet: `RAILWAY_DEPLOY_SIMPLE.md`
- 📊 Voir status: `DEPLOYMENT_STATUS.md`
- 🔧 Troubleshooting: `FINAL_CORRECTIONS_2025-12-07.md`

**Railway Support**:
- Docs: https://docs.railway.app
- Discord: https://discord.gg/railway

---

**Checklist créée le**: 2025-12-07
**Version**: 2.1 - Production Ready ✅
