++++++++++++++++++++++++++++++++++++++++++++++++
Python : langage homogène, explicite et efficace
++++++++++++++++++++++++++++++++++++++++++++++++

Avertissement
=============

* Compare Python à des langages que je connais : C, Perl, PHP, bash
* Compare le langage (syntaxe), pas bibliothèque standard
* Utilise d'autres langages comme illustration

Mon parcours
============

* QBASIC
* Turbo Pascal et assembleur Intel x86
* Turbo C, Borland C++ Builder, Delphi
* PHP (HTML, Javascript)
* bash, Python
* What else?

.. Delphi

POO
===

* C : fgets(buffer, size, *file*)
* C : read(*file*, buffer, size)
* Python : f.readline()
* Python : f.read(size)
* Python : " abc ".strip()
* Perl et PHP pas vraiment orientés objet

x in y
======

* PHP : in_array($a, $b), array_key_exists($a, $b)
* C : strstr(a, b)
* Python : a in b

x in y
======

* PHP : in_array(*$foin*, $aiguille), array_key_exists($aiguille, *$foin*)
* C : strstr(*foin*, aiguille)
* Python : aiguille in *foin*
* PHP : isset($array[$key])

for x in y ("foreach")
======================

 * C++ :

::

    std::vector<int> liste;
    ...
    for (std::vector<int>::const_iterator it=liste.begin(); it != liste.end(); ++it)
        std::cout << *it << std::endl;

Python : ::

    for number in liste:
        print(number)

Python : ::

    for cle in dico: ...
    for valeur in dico.values(): ...
    for cle, valeur in dico.items(): ...

::

    for item in generateur(): ...

 * tuple, list, dict, set, bytes, str
 * fichier (ligne par ligne)
 * type utilisateur (__iter__, __next__)
 * PHP : foreach sur chaîne ? sur fichier ?
 * C++0X : foreach(int x: liste) ...

Espace de nommage
=================

* C : #include <stdlib.h>
* C (glib) : g_printf(), g_rand_int_range(), ...
* PHP : iconv_get_encoding(), iconv_strlen(), ...
* Python : os.open(), os.read()
* from os import open, read
* Noms plus courts, mieux organisé

Explicite
=========

* Perl et Ruby (surtout Ruby on Rails) : convention
* Perl : if ( $texte ~= /cle=(.*) / ) $valeur = $1;
* Perl : system($cmd); if ($?) ...
* Perl : open("fichier") || die("erreur: $_");
* PHP : $_POST, $_GET
* Perl, PHP : "Bonjour $prenom"
* bash, PHP : 'raw \n'
* Python : "Bonjour {}".format(prenom)
* Python : r"raw \n"

* Perl : sub func() { my ($a, $b) = @_; ... }
* Python : def func(a, b): ...

* Perl : foreach (@array) { say $_; }
* Python : for item in array: print(item)
* Perl : foreach my $item (@array) { say $item; }

Fonctionnel
===========

 * (expr for item in liste)
 * yield

Bonnes pratiques
================

* Façon de faire la plus courante
* Façon conseillée par la documentation
* Style de bibliothèque standard
* PEP
* Livres
* Communauté
* Ex: tests (TDD)
* Ex: PEP 8 (style)

Pas d'ASCII Art
===============

* C : \*ptr, !a && b, test?a:b
* C, bash : a && b, a || b
* Bash : $1, $#, $@, $$, ! commande
* Perl : $entier, @liste, %hash
* PHP : $dico = Array('cle' => 'valeur');
* Perl, PHP : Getopt::Long::Getoption, Classe::methode

* Python : liste[index]
* Python : @decorateur
* Python : {'cle': 'valeur'}

* 'Bonjour ' + "monde"
* a, b, c = 1, 2, 3
* # commentaire
* object.attr
* func(args)
* def func(arg1, arg2: ...
* a=b; a > b; a <= b; a + b; a * b; a % b; a & b; a / b; a - b


.. Perl : local $| = 1;

Pas d'ASCII Art
===============

* import sys; sys.argv[1], len(sys.argv)
* import os; os.getpid()
* entier, liste, hash
* dico = {'cle': 'valeur'}
* getopt.getoption, Classe.methode
* Exception : @decorateur

Gestion d'erreur : code de retour vs exception
==============================================


Perl et PHP : ::

    f = open("document.txt") or die("oh là là");
    content = f.read()
    ...

PHP (C) : ::

    f = @open("document.txt");
    if (isset(f)) {
        content = f.read()
        ...
    } else {
        echo "impossible d'ouvrir document.txt\n");
    }

Python, C++ ::

    try:
        f = open("document.txt")
        content = f.read()
        ...
    except IOError, err:
        print("Impossible de lire le contenu de document.txt")

Homogène .
==========

* Perl : Module::Fonction, $objet->attribut
* C : objet.attribut, reference->attribut
* C++ : Classe::methode, objet->attribut
* Python : Module.Fonction, Classe.methode, objet.attribut

.. note:: a.b est la concaténation en Perl et PHP

Homogène in
===========

* 12 in liste
* 'cle' in dico
* item in set

Homogène in
===========

* Perl : f, "f 1", "f 1, 2", f(1);
* Python : f(), f(1), f(1, 2)

Homogène appel fonction
=======================

* PHP : func($a); func(&$a);
* PHP : function func(&$a) {... }; func($a);
* Python : func(1) # copie
* Python : liste=[1, 2, 3]; func(liste) # référence

Appel fonction: keyword
=======================

* PHP : myopen('/etc/password', Array('encoding' => 'utf-8'))
* Python : fichier = open("/etc/passwd", encoding="utf-8")
* Keyword-only arguments

Callback
========

* Perl : process(&func) => ?
* Perl : \&func ?
* PHP : process('func', $data) => $func($item);
* PHP : process('func', $data) => call_user_func($func, $item);
* C : process(func, data) => func(item)
* Python : process(func, data) => func(item)

None
====

* C : char* func() => NULL, int func() => -1 # un seul type de retour
* C : bool func(int \*result) => true / false
* PHP : if (isset($_GET['page'])) ...
* Perl : while (defined (my $error = <>)) ...
* Python : tableau=[1, 2, 3]; tableu[42] # IndexError !

with
====

::

    with tempfile.NamedTemporaryFile() as log:
        tmp.write("test")
        # remove the temporary file

::

    lock = threading.Lock()
    with lock:
        # critical section
        if not text:
            return
        print("text=")
        print(text)

.. note::

   with existe en Java et C# : synchronize / serialize

Slice
=====

::

    x=[1, 2, 3, 4, 5]
    assert x[:3] == [1, 2, 3]
    x[1:3] == [9]

 * tuple, list, bytes, str
 * pas en PHP

Lacunes
=======

* a="abc", => a est un tuple
* print "abc", => pas de retour à la ligne
* func((a,)) pas très lisible
* Pas d'enum => bibliothèques
* Pas de switch => voir PEP
* Pas de constante => module Python écrit en C
* (Pas de regex : pas de DSL)
* DeprecationWarning, ResourceWarning => python -Wd
* Adoption progression des nouveautés par la bibliothèque standard (with)
* Python lent et utilise beaucoup de mémoire => PyPy

Conclusion
==========

* Syntaxe explicite
* Langage homogène
* Python prend le meilleur de chaque langage

