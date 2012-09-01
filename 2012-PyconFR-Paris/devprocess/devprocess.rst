************************************
Processus de développement de Python 
************************************

.. c'est juste histoire de mettre qqch

Python : le langage
-------------------

 * Python Enhancement Proposals

CPython : l'implémentation
--------------------------

 * Ajout de fonctionnalités
 * Améliorations de performance
 * Corrections de bugs

Amélioration du langage : les PEPs
----------------------------------

CPython : ajout de fonctionnalités
----------------------------------

 * PEPs
 * ... ou pas PEPs
 * implémentation discutée sur le bug tracker
 * revue de code
 * commit sur la branche "default" (version 3.N+1)

CPython : améliorations
-----------------------

 * de performance, de consommation mémoire, etc.
 * même processus que les ajouts de fonctionnalités

CPython : correction de bugs
----------------------------

 * implémentation discutée sur le bug tracker
 * revue de code
 * commit sur les branches "2.X", "3.N" et "default" (version 3.N+1)

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
