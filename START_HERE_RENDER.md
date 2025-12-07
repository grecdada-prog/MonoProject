# ▶️ DÉPLOYER SUR RENDER.COM - SmartStock (GRATUIT)

**Plateforme**: Render.com
**Prix**: 100% GRATUIT 🎉
**Temps**: 15 minutes
**Difficulté**: ⭐⭐☆☆☆

---

## 🎯 COMMENCE ICI

Tout est prêt pour déployer sur **Render.com** (gratuit).

**Fichiers créés**:
- ✅ `render.yaml` - Configuration complète Render
- ✅ `Dockerfile` - Image PHP 8.3 optimisée
- ✅ `RENDER_DEPLOY.md` - Guide détaillé étape par étape

---

## ⚡ DÉPLOIEMENT EXPRESS (15 min)

### Étape 1: Créer compte Render (2 min)

1. Va sur https://render.com
2. Clique **"Get Started"**
3. Connecte-toi avec **GitHub**
4. Autorise Render
5. ✅ Pas de carte requise !

### Étape 2: Connecter repository (2 min)

1. Dashboard Render > **"New +"**
2. Sélectionne **"Blueprint"**
3. Connecte **"MonoProject"** (ton repo)
4. Render détecte `render.yaml` automatiquement
5. Clique **"Apply"**

### Étape 3: Configurer 4 variables (3 min)

Render configure TOUT automatiquement sauf 4 variables.

**Dashboard** > **smartstock-web** > **Environment** > **Add Environment Variable**:

```env
1. MAIL_PASSWORD = uqwyfvscdhnelrxt

2. PUSHER_APP_ID = (régénère sur dashboard.pusher.com)

3. PUSHER_APP_KEY = (régénère sur dashboard.pusher.com)

4. PUSHER_APP_SECRET = (régénère sur dashboard.pusher.com)
```

Clique **Save Changes**

### Étape 4: Attendre build (5 min)

**Logs** (onglet) affichera:
```
✅ Installing dependencies
✅ Building assets
✅ Running migrations
✅ Live! https://smartstock-web.onrender.com
```

### Étape 5: Créer Super-Admin (2 min)

1. Dashboard > **smartstock-web** > **Shell** (terminal)
2. Tape:

```bash
php artisan tinker
```

3. Copie-colle:

```php
\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);
$user = \App\Models\User::create(['name' => 'Admin', 'username' => 'admin', 'email' => 'admin@smartstock.cm', 'password' => bcrypt('Admin2025!SmartStock'), 'is_active' => true]);
$user->assignRole('super-admin');
exit
```

### Étape 6: Tester (1 min)

1. Ouvre: `https://smartstock-web.onrender.com/login`
2. Email: `admin@smartstock.cm`
3. Password: `Admin2025!SmartStock`
4. ✅ **SUCCÈS** - Tu es sur le dashboard !

---

## 📚 GUIDE COMPLET

**Pour tous les détails**, ouvre:

```bash
code RENDER_DEPLOY.md
```

Ou lis directement le fichier `RENDER_DEPLOY.md`

---

## ⚠️ À SAVOIR (Plan Gratuit)

### Avantages ✅
- Vraiment gratuit (pas de carte)
- PostgreSQL inclus
- SSL automatique (HTTPS)
- Auto-deploy depuis GitHub

### Limitations ⚠️
- Service s'endort après 15 min d'inactivité
- PostgreSQL expire après 90 jours
- Première requête après sleep: 30-60s

**Upgrade disponible**: 7$/mois (pas de sleep + database permanente)

---

## 🆘 PROBLÈME ?

### Erreur build

Voir les logs: **smartstock-web** > **Logs** > Chercher l'erreur exacte

### Database error

Vérifie que **smartstock-db** est **"Available"** dans le Dashboard

### Emails pas envoyés

Environment > Vérifie **MAIL_PASSWORD** = `uqwyfvscdhnelrxt` (sans espace)

### Guide complet

Ouvre `RENDER_DEPLOY.md` - Section Dépannage

---

## 🎉 RÉSULTAT

Après 15 minutes:

```
╔═════════════════════════════════════════════╗
║  SmartStock déployé sur Render.com ✅       ║
║                                             ║
║  URL: https://smartstock-web.onrender.com  ║
║  Admin: admin@smartstock.cm                 ║
║  Status: PRODUCTION READY 🚀               ║
╚═════════════════════════════════════════════╝
```

**Prochaines étapes**:
1. Change le mot de passe admin
2. Crée tes magasins
3. Crée tes gérants/vendeurs
4. Forme les utilisateurs

---

## 📞 SUPPORT

**Guide détaillé**: `RENDER_DEPLOY.md`
**Render Docs**: https://render.com/docs
**Support**: https://community.render.com

---

**Créé le**: 2025-12-07
**Version**: 2.1 - Render Ready ✅
**Temps**: 15 minutes
**Prix**: GRATUIT 🎉

**BONNE CHANCE ! 🚀**
