# Nouveautés de Python 3.13

* https://drew.silcock.dev/blog/everything-you-need-to-know-about-python-3-13/
* Comparaison des performances : Python 3.12 vs Python 3.13:
  https://en.lewoniewski.info/2024/python-3-12-vs-python-3-13-performance-testing/

## Ergonomie

* Messages d'erreur

  * fichier random.py
  * fichier numpy.py
  * `max_split` keyword: suggest `maxsplit`

* REPL

  * couleur
  * multiligne
  * portable (Windows)

* random CLI

  * python -m random 6  # lancé de dé [1; 6]
  * python -m random --float 3.14  # nombre dans [0; 3.14]
  * python -m random Pierre Feuille Ciseaux  # 3 choix (chifoumi)

## Free Threading

* Expérimental
* Plus lent que Python classique sur 1 seul thread
* Scale avec le nombre de threads
* Implémentation incomplète

## Compilation à la volée

* JIT compiler expérimental
* Pour l'instant, pas de gain de perf
* Gros travail de fond pour améliorer les perfs

## Bases de données clé-valeur

* dbm gagne un backend SQLite
* XXX exemple de code ?

## Support des plateformes

* WASM - Tier 2 (2 core devs, bloque un release)
* Apple iOS et Android - Tier 3 (1 core dev, bloquer une release)

## Dette technique

* Suppression de 19 modules, PEP 594 (2019)
* cgi, crypt, nntplib, xdrlib, etc.
* Suppression de 2to3 car son parseur ne gère pas la syntaxe de Python 3.10
