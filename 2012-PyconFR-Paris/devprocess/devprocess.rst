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

 * couverture croissante
 * robustesse croissante mais imparfaite
 * [stats]

CPython : intégration continue
------------------------------

 * buildbots
 * buildbots stables => bloquants pour une sortie de version
 * buildbots instables => indicatifs (pour les dévs courageux)

