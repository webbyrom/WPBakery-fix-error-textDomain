<?php

/**
 * Plugin Name: WPBakery JIT Translation Error Fix
 * Plugin URI: https://web-byrom.com
 * Description: Corrige l’avertissement de chargement prématuré du textdomain "js_composer" déclenché par WPBakery sur WordPress 6.7+. N'affecte pas les autres erreurs WordPress.
 * Author: Romain Fourel / Web-Byrom
 * Version: 1.0.0
 * License: GPL2+
 */

/**
 * Ce MU-plugin doit être chargé AVANT WPBakery.
 * Les MU-plugins sont exécutés avant tous les plugins normaux, 
 * ce qui permet d’intercepter l’erreur au bon moment.
 *
 * WPBakery déclenche une traduction 'js_composer' pendant sa phase d'initialisation,
 * ce qui provoque un _doing_it_wrong() de WordPress 6.7+. 
 *
 * Ce filtre supprime UNIQUEMENT cette erreur précise.
 */

add_filter('doing_it_wrong_trigger_error', function ($trigger, $function_name, $message) {

  // Vérifie qu'il s'agit bien de l'erreur spécifique à WPBakery
  if (
    $function_name === '_load_textdomain_just_in_time'
    && strpos($message, '<code>js_composer</code>') !== false
  ) {
    // On désactive SEULEMENT l'erreur de WPBakery.
    return false;
  }

  // Pour toutes les autres erreurs WordPress → comportement normal.
  return $trigger;
}, 0, 3);
