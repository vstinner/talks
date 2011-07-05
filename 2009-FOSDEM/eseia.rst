++++++++++++++++++++++++++++++
Pratique du fuzzing avec Fusil
++++++++++++++++++++++++++++++

Fuzzing (1)
===========

* Recherche de bugs
* Injection d'erreurs
* Surveiller les réactions du programme

Fuzzing (2)
===========

 * Rapide
 * Efficace
 * Libre libre ou fermé

Fusil
=====

 * Cible : programme Linux en ligne de commande
 * Vecteurs : ligne de commande, variable d'environnement, sockets (TCP, UNIX)
 * Données : aléatoires, erreurs, générées

Données aléatoires
==================

  * Aléatoire pure : nc host port < /dev/urandom
  * Crashe les logiciels sans QA, sécurité ou peu d'utilisateurs

Injection d'erreurs
===================

 * Inverses des bits, remplacer des octets, etc.
 * Crashe la plupart des lecteurs audio/vidéo
 * Technique la plus simple pour écrire un fuzzer

Générer des données
===================

 * Lire la spécification et écrire un générateur
 * Données aléatoires respectant les spécifications
 * Teste en profondeur
 * Besoin des spécifications

Sondes
======

 * Sortie standard (stdout et stderr)
 * Code de sortie du processus
 * Fichiers de logs
 * Ping réseaux
 * Débogueur (ptrace) intégré pour attraper des signaux

Fuzzers d'application
=====================

 * ClamAV antivirus
 * Firefox : contenu embarqué dans une page HTML
 * Gstreamer, mplayer, VCL (lecteur audio/vidéo)

Fuzzers de bibliothèque
=======================

 * gettext (traduction, i18n)
 * poppler : bibliothèque PDF utilisé par Evince et Kpdf

Démo
====

 * Crash mplayer

Gravité d'une erreur
====================

 * Déni de service
 * Erreur permanente ?
 * Difficulté d'exploitation

Bug ou vulnérabilité ?
======================

 * Contourner l'authentification
 * Déroutage du flot d'exécution

Réponse des éditeurs
====================

 * On s'en fiche !
 * Accepte les patchs
 * Interessé pour tester Fusil
 * Reflète la qualité du projet

Idées pour Fusil (1)
===================

 * Test new faults: failmalloc, /dev/full, time shift, send signals
 * Reuse existing fuzzers (zzuf) or be integrated to pentest suites
 * Code coverage (gcov, Valgrind, DynamoRio)
 * Check invalid memory usage (Valgrind)

Idées pour Fusil (2)
====================

 * Network fuzzers
 * Better support of graphical applications (Windows ?)
 * Wizzard to help fuzzer creation

Questions ?
===========

 * Fusil est distribué sous licence GPL
 * http://fusil.hachoir.org/

Source des images
=================

 * http://commons.wikimedia.org/wiki/File:Train_wreck_at_Montparnasse_1895.jpg
 * http://commons.wikimedia.org/wiki/File:Bundesarchiv_Bild_102-12503,_Autounfall.jpg
 * http://commons.wikimedia.org/wiki/File:Bundesarchiv_Bild_102-10248,_Mecklenburg,_Autounglück.jpg
 * http://commons.wikimedia.org/wiki/File:B-24_Kopfstand.jpg

