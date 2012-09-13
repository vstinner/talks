************************************
Processus de développement de Python
************************************

.. c'est juste histoire de mettre qqch

Sommaire
--------

 * Côté humain : python-ideas, python-dev, PEP
 * Côté humain : patch, bugs.python.org
 * Côté technique : C, buildbot
 * Comment contribuer

Communauté ouverte
------------------

 * Développement de Python (langage + stdlib) ~= développement CPython
 * Discussions publiques et ouvertes à tous
 * ... sauf sécurité et infrastructure

Liste python-ideas
------------------

 * Brainstorm
 * Mauvaises idées proposées par manque de connaissance
   du langage ou de la bibliothèque standard
 * Changement de syntaxe rarement acceptés
 * Les meilleurs idées donnent lieu à des PEP

Liste python-dev
----------------

 * Propositions et questions concrètes liées au développement
 * Commentaires sur les commits
 * Discussions sur les PEP en cours

bugs.python.org
---------------

 * Diagnostique d'un bug
 * Relecture des patchs
 * Choix parmis plusieurs solutions techniques

*******************

CPython : ajout de fonctionnalités
----------------------------------

 * Python Enhancement Proposals (PEP)
 * ... ou pas PEPs
 * implémentation discutée sur le bug tracker
 * revue de code
 * commit sur la branche "default" (version 3.N+1)

CPython : améliorations
-----------------------

 * performance, consommation mémoire, stabilité, etc.
 * même processus que les ajouts de fonctionnalités

CPython : correction de bugs
----------------------------

 * implémentation discutée sur le bug tracker
 * revue de code
 * commit sur les branches "2.X", "3.N" et "default" (version 3.N+1)

PEP 410 : nanosecondes
----------------------

 * Use decimal.Decimal type for timestamps
 * Précision d'une nanoseconde
 * Bug os.utime(os.stat().st_mtime)
 * 7 types différents proposés dans la PEP

PEP 410 : rejettée
------------------

 * Rejetée par Guido von Rossum
 * Précision théorique, inaccessible en pratique
 * Ajout d'une complexité injustifiée
 * os.stat() et os.utime() modifiés pour avoir le timestamp en nanosecondes (int)

PEP refusées
------------

 * Besoin trop spécifique
 * Manque de cas d'utilisation
 * Solution existante satisfaisante
 * Refus servant à conserver un Langage homogène, simple et cohérent
 * PEPs abandonnées, retirées
 * PEPs différées

PEP 3151
--------

 * Refonte de la hiérarchie d'exceptions d'entrées-sorties
 * IOError, OSError, EnvironmentError, socket.error etc.: fusionnées
 * Nouvelles exceptions plus fines basées sur errno : FileNotFoundError, BlockingIOError, etc.

PEP 3151 : acceptée
-------------------

 * Conception délicate (préserver la compatibilité)
 * Écriture longue : recension des usages, argumentaire
 * Discussion plus aisée que prévu : débats sur le nommage

PEP 418
-------

 * Ajout au module time de Python 3.3 :
 * time.get_clock_info(name)
 * time.monotonic()
 * time.perf_counter()
 * time.process_time()

PEP 418 : débat houleux
-----------------------

 * Débat des plusieurs semaines sur python-dev avec une dizaine d'intervenants
 * Débat sur le vocabulaire : "accuracy", "monotonic", "steady"
 * Débat sur monotonic() : fallback sur time.time() ou non ?
 * Difficile définition des fonctions (documentation)

PEP 418 : acceptée
------------------

 * Après de nombreuses révisions de la PEP,
 * PEP acceptée dans Python 3.3
 * PEP avec des nombreuses annnexes sur les OS, horloges matérielles et
   performances



*******************

CPython : l'implémentation
--------------------------

 * Ajout de fonctionnalités
 * Améliorations de performance
 * Corrections de bugs

Amélioration du langage : les PEPs
----------------------------------

 * Idées sur python-ideas or python-dev
 * L'auteur rédige une PEP
 * La PEP sert de base de travail pour la discussion
 * PEP rejetée ou acceptée

CPython : suite de tests
------------------------

 * richesse et complétude croissante
   (nb de lignes dans Lib/test - comptées avec sloccount de David A. Wheeler -
    et % total :
    - 2.0.1 : 11380 ( / 251551 -> 4,5 %)
    - 2.1.3 : 14853 ( / 378276 -> 3,9 %)
    - 2.2.3 : 27411 ( / 432258 -> 6,3 %)
    - 2.3.7 : 46576 ( / 523235 -> 8,9 %)
    - 2.4.6 : 61170 ( / 598266 -> 10 %)
    - 2.5.6 : 75547 ( / 696551 -> 11 %)
    - 2.6.8 : 100432 ( / 784688 -> 13 %)
    - 2.7.2 : 117621 ( / 861925 -> 14 %)
    - 3.1.5 : 106114 ( / 623468 -> 17 %)
    - 3.2.3 : 127976 ( / 684093 -> 19 %)
    - 3.3.0 : 166967 ( / 793919 -> 21 %)
    )
  * couverture du dossier Lib (3.3.0, mesuré par Brett Cannon) : 75 %

CPython : suite de tests
------------------------

 * tests unitaires
 * tests de stress (threads)
 * robustesse croissante mais imparfaite
    - bugs sporadiques
    - problèmes externes
    - problèmes inhérents à la fonction testée (ex: timeouts)
 * tests instables sur certains OS
    - threads et BSD

CPython : intégration continue
------------------------------

 * buildbots
 * compilent et testent en mode debug (sauf un)
 * tests sérialisés ou parallèles

CPython : buildbots stables
---------------------------

* bloquants pour une sortie de version
* systèmes :
   - FreeBSD 9.0
   - Gentoo
   - OpenIndiana
   - OS X Lion
   - RHEL 6
   - Ubuntu
   - Windows 7, XP
* architectures : x86, x86-64
* compilateurs : gcc, clang, MSVC

CPython : buildbots instables
-----------------------------

* indicatifs
* échouent souvent => pour les dévs courageux
* systèmes :
   - DragonFlyBSD 3.0.2
   - Fedora
   - FreeBSD 6.4, 7.2, 8.2, 9.1, 10.0
   - Gentoo
   - NetBSD 5.1.2
   - OpenBSD 5.1
   - OpenIndiana
   - OS X Mountain Lion, Snow Leopard, Tiger
   - Solaris 10
   - Ubuntu
   - Windows 8, Server 2003, 2008
* architectures : x86, x86-64, ARM, IA64, PA-RISC, SPARC

CPython : buildbots spéciaux
----------------------------

* un buildbot non-debug (optimisations)
* un buildbot bigmem : 24 GB et 6 heures par build

Prix de la portabilité
----------------------

 * Plusieurs implémentations d'une même fonction
 * Cas typique : version Windows et version POSIX
 * Soucis avec threads et signaux, notamment sous BSD
 * Fonctions récentes d'un noyau, ex: Linux >= 2.6.28
 * #ifdef et if dans le code

Contribuer à Python
-------------------

 * devguide
 * core-mentorship
 * Pas besoin du droit de commit (push)

