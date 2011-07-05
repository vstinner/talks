There are various ways one can contribute to Python and they do not all
involve knowing the internals of Python. Nor do they necessarily require
writing code! All it takes to contribute is a willing to learn and some free
time.

This document assumes you have already read how to get set up and how the
issue workflow works.

Helping with the Documentation
==============================

There is almost always something to help out with in terms of Python's
documentation. If you have ever found something that was not completely clear
or wished there was an example to go along with some complex idea then you
have found something that could use improvement. Simply submit an issue with a
patch to fix the problem you had.

If you want to help with a known issue with the documentation then look at the
open documentation bugs. You can comment on documentation issues that have
patches or write a patch to fix an issue. See the documentation guide on how
Python's documentation is written.

Writing Unit Tests
==================

Python is far from having good coverage (roughly 90% and better) for all of
its code. It is always helpful to increase the coverage by writing more unit
tests to help raise the code coverage. An easy way to see what kind of
coverage exists for code is to look here.

Please realize, though, that your patch may not be reviewed immediately! Since
Python is run entirely by open source developers who volunteer their time they
only have so many hours a week to look at issues in the tracker. It might be
quite some time until someone manages to free up enough time to get to your
patch. But do know that your help is still appreciated no matter how long we
take to get to your work!

Fixing Bugs
===========

If you simply look at the open bugs on the issue tracker you will notice help
is always needed. By writing a solid patch for a bug you make it so that the
core developers do not have to spend what little time they have fixing a bug
but instead doing patch reviews which are almost always a better use of time.
Just make sure to follow what is outlined in the issue workflow for what is
required of a good patch.

And you do not need to know C or how Python's intepreter works to contribute!
Simply restrict your search in the issue tracker to only a specific component
that requires only a certain skill set. For instance, if you are looking for
an explicitly **easy** issue that should take no more than a day (about the
length of a bug day) to work on they are flagged in the issue tracker as such.
If you are comfortable with working in Python code you can look at issues
pertaining to **Lib** or other components that are inherently only Python
code. If you are comfortable with **extension modules** you can find issues
pertaining to those. And when you are ready to learn the internal details of
Python you can tackle issues related to the **interpreter core**. There are
other components you can narrow your search on as well if you so choose. Just
play around with the search feature of the issue tracker to find a list of
issues you might be interested at looking into.

Please realize that while your patch is greatly appreciated, it may be some
time before a core developer gets around to looking at your patch. It is
simply an issue of someone having the free time and expertise to look at your
work in order to review it and commit it.

Triaging Issues
===============

While Python is a very solid piece of software, bugs are found. Plus people
are always suggesting new features through patches, improving existing code,
etc. This leads to a lost of issues being created in the issue tracker. Help
is always appreciated to go through issues and perform triage by following
what is discussed in the issue workflow. This ranges from helping validate a
bug exists in Python's in-development version to reviewing patches.

If you have helped out in the issue tracker for a little while or have been a
good participant on python-dev you may ask for Developer privileges on the
tracker which allow you to change any and any metadata on an issue. Please
don't be shy about asking for the privilege! We are more liberal with giving
out this ability than with commit privileges so don't feel like you have to
have been contributing for a year to gain this ability. And with Developer
privileges you can work more autonomously and be an even greater help by
narrowing down what issues on the tracker deserve the most attention at any
one time.

Become a Core Developer
======================

To become a core developer and gain commit privileges for Python you typically
need to have been an active developer on Python through the issue tracker and
shown the ability to develop top-quality patches that require little or no
input or changes from a core developer. Typically people take about a year to
reach this level; some people get there faster, others longer. It can be
short-circuited, though, if a core developer is willing to shepherd you
through the process, but this is typically reserved for special situations
like GSoC/GHOP. Essentially if a core developer is willing to vouch for you
and initially take personal responsibility for your actions as a developer you
can gain commit privileges that way.

When you think you have been submitting patches regularly that have not
required much feedback from a core developer you can email python-dev
requesting commit privileges. If it is decided you are ready then you mail
your SSH 2 key (see the dev FAQ on how to do this) to python-dev and you will
receive your commit privileges.

