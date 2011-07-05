 .. footer:: Victor Stinner - INL - RMLL 2008

Assurance Qualité avec Fusil le fuzzer

 .. image:: windows_bsod.png
    :align: center
    :alt: Windows 95 Blue Screen of Death (BSOD)
    :target: http://en.wikipedia.org/wiki/Image:Windows_9X_BSOD.png

Victor Stinner - INL

Assurance Qualité
=================

 * Processus et non une fin en soi
 * Objectif : augmenter la sécurité de l'application
 * Sécurité : disponibilité, confidentialité et consistence

Mauvais projet
==============

 .. image:: avant.jpg
    :target: http://www.villiard.com/Page-ordinateurs-2.html
    :alt: Bureau d'informaticien jonché d'ordures
    :align: center


Bon projet
==========

 .. image:: bebe_rigole.jpg
    :alt: Bébé qui rigole
    :target: http://www.flickr.com/photos/martin_mcdonald/379588276/
    :align: center

Cycle de développement
======================

 .. image:: cycle.png
    :alt: Cycle "Écriture - Exécution - Erreur", dessiné par Victor Stinner avec Dia
    :align: center

Style du code
=============

 * Code écrit une fois, relu dix fois
 * Fonction courte (100 lignes)
 * Fichier court (1000 lignes)
 * Limiter les symboles

Petits modules
==============

 * Simple à compiler
 * Simple à comprendre
 * Simple à corriger
 * Simple à faire évoluer

*What The Fuck Meter*
=====================

 .. image:: wtf_meter.png
    :target: http://www.osnews.com/comics
    :alt: The only valid measurement of code quality: WTFs/minute
    :align: center

Analyse statique
================

 * gcc -Wall -Wextra -Werror
 * SPlint, RATS, FlawFinder
 * pylint, pyflakes
 * Longs rapports, faux positifs

Analyse dynamique
=================

 .. image:: lolcat_valgrind.jpg
    :alt: DEBIAN CAT IZ USING VALGRIND
    :target: http://blog.rominet.net/2008/05/debianopenssl-debacle.html
    :align: right

 * Valgrind
 * pychecker
 * Faux positifs
 * Lenteur

Tests
=====

 * Tests unitaires : JUnit
 * Tests fonctionnels : py.test
 * Scripts post-commit
 * Buildbot

DTC
===

 .. image:: dtc.png
    :alt: Logo de la société DTC Diamond
    :target: http://www.palagems.com/gem_news_2005.htm
    :align: right

 * Documente Ton Code !
 * Où ça ? Dans Ton Code
 * Module Python doctest

Exemple de doctest
==================

::

    def bin2long(text, endian):
        """
        >>> bin2long("110", BIG_ENDIAN)
        6
        >>> bin2long("110", LITTLE_ENDIAN)
        3
        """

Couverture de code
==================

 .. image:: trace2html.png
    :alt: Capture d'écran trace2html par Olivier Grisel
    :target: http://www.afpy.org/Members/ogrisel/afpynews.2006-03-16.2652246222/image
    :align: right

 * Code non testé
 * Code mort
 * gprof, trace2html

Code de retour
==============

 * true, false
 * 0, 1, -1, NULL, ERR_OK
 * Pénible à gérer, on préfère les oublier

Exceptions
==========

 * Traverse plusieurs fonctions
 * Moins de code
 * Type et message
 * Ignorer ou transmettre

Fonctionnalité ?
=================

 .. image:: bug_feature.png
    :target: http://blog.zugschlus.de/archives/289-Bug-oder-Feature.html
    :align: center

Fuzzing
=======

 * Découvrir des bugs
 * Boîte noire
 * Faible coût
 * Efficace

Vecteurs d'entrée
=================

 * Ligne de commande
 * Variable d'environnement
 * Fichier, réseau
 * Quota

Générer des données
===================

 * Aléatoire
 * Mutation
 * Modèle

Surveillance
============

 * Code de retour
 * Temps
 * Mémoire et CPU
 * stdout et logs

Fusil
=====

 * Boîte à outils pour écrire son fuzzer
 * Nombreux projets
 * Gestion des sessions
 * Écrit en Python, licence GPL

Démo Fusil
==========

 * Plantage de mplayer

Ce n'est pas tout
=================

 * Failles humaines
 * Sécurité du maillon le plus faible
 * Importance de l'architecture

Questions
=========

 .. image:: lolcat_bug.jpg
    :align: center
    :target: http://www.flickr.com/photos/tigerlemurguy/2374407002/
    :alt: cant wurk 2day i haz a bug

