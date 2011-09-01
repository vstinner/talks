++++++++++++++++++++++++++++++++++++++++++++++++
Python : langage homogène, explicite et efficace
++++++++++++++++++++++++++++++++++++++++++++++++

Mon parcours
============

* QBASIC
* Turbo Pascal et assembleur Intel x86
* Borland C++ Builder
* PHP
* Python

.. Javascript, Delphi

POO
===

* C : fgets(buffer, size, *file*)
* C : read(*file*, buffer, size)
* Python : f.readline(); f.read(size)

.. strcpy(a, b)?

POO: bonus
==========

* Keyword-only arguments

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

for x in y ("foreach")
======================

::

    for cle in dico: ...
    for valeur in dico.values(): ...
    for cle, valeur in dico.items(): ...

::

    for item in generateur(): ...

 * tuple, list, dict, set, bytes, str
 * fichier

Espace de nommage
=================

* C (glib) : g_printf(), g_rand_int_range(), ...
* PHP : iconv_get_encoding(), iconv_strlen(), ...
* Python : os.open(), os.read()
* Noms plus courts, mieux organisé

.. TODO: bibliothèque commune Python/PHP

Explicite
=========

* Perl : if ( $texte ~= /cle=(.*) / ) $valeur = $1;
* Perl : system($cmd); if ($?) ...
* Perl ::

    if (/^\@syn(code)?index (\w+) (\w+)/)
    {
        delete $clean_suffixes{"$2s"};
        $clean_suffixes{"$3s"} = 1;
    }

* Perl : open("fichier") || die("erreur: $_");
* PHP : $_POST, $_GET
* PHP : "Bonjour $prenom", Python : "Bonjour {}".format(prenom)

* Perl : sub func() { my ($a, $b) = @_; ... }
* Perl : sub func() { $_ = shift; ... }
* Perl : sub func($$$@) { my ($a, $b) = @_; ... }
* Python : def func(a, b): ...

* Perl : foreach (@array) { say $_; }
* Perl : foreach my $item (@array) { say $item; }
* Python : for item in array: print(item)


Pas d'ASCII Art
===============

* C : \*ptr, !a && b, test?a:b
* Bash : $1, $#, $@, $$
* Perl : $entier, @liste, %hash
* PHP : $dico = Array('cle' => 'valeur');
* Perl, PHP : Getopt::Long::Getoption, Classe::methode

.. Perl : local $| = 1;

Pas d'ASCII Art
===============

* import sys; sys.argv[1], len(sys.argv)
* import os; os.getpid()
* entier, liste, hash
* dico = {'cle': 'valeur'}
* getopt.getoption, Classe.methode

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

* Perl : f, "f 1", "f 1, 2";
* Python : f(), f(1), f(1, 2)

Homogène appel fonction
=======================

* PHP : func($a); func(&$a);
* PHP : function func(&$a) {... }; func($a);
* Python : func(1) # copie
* Python : liste=[1, 2, 3]; func(liste) # référence

Appel fonction: keyword
=======================

* PHP : ?
* Python : fichier = open("/etc/passwd", encoding="utf-8")

Callback
========

* Perl : xxx(&func) => ?
* PHP : xxx('func') => eval($name);
* Python : settrace(func) => func()

Effet de bord
=============

* C : if ((a=*ptr++)) { ... }
* Python : if a = b: ... # interdit !

None
====

* C : char* func() => NULL, int func() => -1
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

Slice
=====

::

    x=[1, 2, 3, 4, 5]
    assert x[:3] == [1, 2, 3]
    x[1:3] == [9]

 * tuple, list, bytes, str

