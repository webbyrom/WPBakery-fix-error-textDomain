# WPBakery JIT Translation Error Fix

## 🧩 Description

Ce petit plugin (idéalement un Must-Use Plugin) corrige un avertissement (Notice) récurrent et potentiellement bloquant qui apparaît dans l'administration WordPress (ou les logs) suite à une mise à jour de WordPress 6.7+.

L'erreur est déclenchée par le plugin **WPBakery Page Builder** (`js_composer`) qui tente de charger son domaine de traduction (`textdomain`) trop tôt dans le cycle de vie de WordPress.

Ce correctif **cible et neutralise UNIQUEMENT** cet avertissement spécifique de WPBakery, permettant ainsi de :
* Supprimer les avertissements de type `_doing_it_wrong` liés à `_load_textdomain_just_in_time`.
* Éviter les erreurs en cascade comme "Headers already sent" qui peuvent bloquer l'administration.

---

## 🚀 Installation

Ce correctif est conçu pour être exécuté le plus tôt possible dans WordPress. Il est fortement recommandé de l'installer comme un **Must-Use Plugin (MU-Plugin)**.

### Méthode Recommandée (MU-Plugin)

1.  **Créer un fichier :** Enregistrez le code du plugin dans un nouveau fichier nommé, par exemple, `wpbakery-jit-fix.php`.
2.  **Placer le fichier :** Téléchargez ce fichier dans le répertoire `wp-content/mu-plugins/` de votre installation WordPress. Si le dossier `mu-plugins` n'existe pas, créez-le.

> **Avantage des MU-Plugins :** Ils se chargent avant tous les plugins standards, y compris WPBakery, garantissant que le correctif est actif au moment opportun. Ils ne peuvent pas être désactivés depuis l'administration.

### Méthode Alternative (Plugin Standard)

1.  Créez un dossier nommé `wpbakery-jit-fix` dans `wp-content/plugins/`.
2.  Placez le fichier `wpbakery-jit-fix.php` à l'intérieur de ce dossier.
3.  Activez le plugin via l'administration de WordPress.

---

## ⚙️ Fonctionnement

Le code utilise le filtre WordPress natif `doing_it_wrong_trigger_error` qui est appelé par WordPress juste avant de déclencher l'avertissement de `_doing_it_wrong()`.

```php
add_filter('doing_it_wrong_trigger_error', function (/* ... */) {
  // Vérifie que l'erreur est bien _load_textdomain_just_in_time ET qu'elle concerne 'js_composer'
  if (/* ... conditions ... */) {
    // On retourne `false` pour dire à WordPress de ne pas déclencher cette erreur.
    return false;
  }
  // ...
});
