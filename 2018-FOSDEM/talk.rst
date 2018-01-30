Satursday: 11:00-11:50; 45 min?

Slides
======

Python 3: 10 years later
Looking back at Python evolutions of the last 10 years

Bad
---

* Initial plan failed badly: "port all Python code at once", 2to3
* First failed attempt to migrate to Python 3 "at once"

  * Run 2to3 at once: drop Python 2 support, forget the past
  * Unexpected fact #1: Python 2.7 is heavily used in production and companies
    have large code bases
  * Unexpected fact #2: Dropping Python 2 support is **no-go**, module authors
    don't want to loose more than 90% of their users
  * #3: Keeping Python 2 compatibility means that new shiny features of
    Python 3... cannot be used... Spend one week or one month to port,
    fix regressions, be the one responsible to any future regression
    for no immediate gain
  * One decided Python3 branch in the SCM repository, or even a fork:
    painful to keep up to date
  * Bad: 2to3: "drop Python2 support at once", don't work when you have
    dependencies.

* Growing populary of the Python programming language

  * Defacto language in the scientific world, replacing other closed
    source and more specialized but limited language
  * Favorite programming language used as the first language to learn
    programming



VERY BAD
--------

* Python 2.6: heavy used of six, unittest2, limit Python3 features
* Twisted, Mercurial and PyPy
* Python 2.8/Python 3 trolls/packaging haters

  * Twisted, Mercurial
  * https://www.python.org/dev/peps/pep-0404/
  * PEP 404 -- Python 2.8 Un-release Schedule
  * 2014: https://lwn.net/Articles/578532/ Debating a "transitional" Python 2.8

* Me: disappointed; it's not going to work; depression, deny, anger
* Feb. 2011: Python 3 Wall of Shame
  "an attempt at motivating package maintainers to port to python 3"
* Python 3 haters

  * <xxx> doesn't work as expected anymore
  * Unicode is hard
  * We love bytes
  * Locales are hard
* Python 3.2 required six.u("unicode")
* Cost of Migration, technical debt

  * Add Python3 support: no immediate gain
  * Regressions

* Python2 is better: right ; Python 3 is better: right

  * Python2: stable, works
  * Python3: better language, more features

Good
----

* More and more backports: subprocess32
* At Pycon US 2014, Guido van Rossum announced that the Python
  2.7 support was extended from 2015 to 2020 to give more time to
  companies to port their applications to Python 3.
* Python 2.7 adds "{}".format(...) and argparse
* Python 3.3. Changes to make the transition smoother:

  * PEP 414: u"syntax" reintroduced in Python 3.3
  * PEP 461: bytes % args, Python 3.5
  * More "Py3k" warnings added to Python 2.7.x
  * Linters like flake8 detect some issues
  * six, futures, modernize, 2to6, etc.
* Feb. 2011: Python 3 Wall of Shame => Dec. 2012: Python 3 Wall of Superpowers
  http://py3readiness.org/
  https://python3wos.appspot.com/
* Second successful attempt: add Python 3 support, still run on Python 2

  * Replace 2to3 with six
  * Different approach: incremental changes, each change is tested on
    CIs and then on production
  * Large code bases: original authors left, low code coverage. Need more tests
  * Port dependencies one by one: slow process, write a PR, get the PR merged,
    wait for a release, update dependency min version. Wait... what is the
    author doesn't answer (MySQL-python)? Fork? Fork under a different name?
  * MySQL-python => mysqlclient // PyMySQL: new pure Python client
  * python-ldap => ldap3 and pyldap
  * PIL => Pillow
  * (abandonned) mox => mock3
  * pydot3?
  * dnspython => dnspython3 -- merged back into dnspython?
* Python problem #1 now fixed: packaging
* Python 3 is better
* Python 3.3, six
* Python 3.6 at Facebook
* Evolutions of the Python language

  * Python 3.5

    * PEP 492: async/await "keywords" for asyncio.
      (Really keywords in Python 3.7.)
    * PEP 461: bytes % args and bytearray % args
    * PEP 465, a new matrix multiplication operator: a @ b.
    * PEP 448: Generalized unpacking:
      ``head, *tail = list``
      ``mylist = [1, 2, **other_list]``
      ``mydict = {"key": "value", **other_dict}``

  * Python 3.6

    * PEP 515: ``million = 1_000_000``
    * PEP 498: f-string:
      ``name = "World"; print(f"Hello {name}!")``
    * PEP 526, syntax for variable annotations.
    * PEP 525, asynchronous generators.
    * PEP 530: asynchronous comprehensions.

* Another trend: Port Python 3 code to Python 2. Write new Python 3 code, and
  then port it to Python 2. Can be very painful to travel in the past :-)


Very good
---------

* Bugs that won't be fixed in Python 2 anymore

  * Some bugs cannot be fixed without breaking the backward
    compatibility
  * Unicode Support
  * Python 2 I/O stack bugs: rely on libc stdio.h
  * Security: hash DoS, enabled by default in Python 3.3, Python 3.4 now
    uses SipHash
  * subprocess is not thread-safe in Python 2.
    Python 2 subprocess has many race conditions: fixed in Python 3
    with a C implementation which has less or no race condition.
    Handling signals while forking in complex.
  * threading.RLock is not "signal safe" in Python 2
  * Python 2 requires polling to wait for a lock or for I/O.
    Python 3 uses native threading API with timeout and has asyncio.
  * Python 3 uses a monotonic clock to not crash on system clock update
    (ex: DST change).
  * Python 3 has a better GIL.
  * Python 2 inherits file descriptors on fork+exec by default.
    Python 3 don't: PEP 446.
  * Functions can fail with OSError(EINTR) when interrupted by a signal,
    need to be very careful everywhere. SIGCHLD when a child process
    completes, SIGWINCH when using ncurses. Python 3.5 restarts the
    interrupted system call for you.

* Python 3 features, 3.7 features?
* Performance

  * Python 3.6 is now faster than Python 2.7
  * https://speed.python.org/
* Bury Python 2?

  * "Python 3 only"
  * https://pythonclock.org/
  * http://www.python3statement.org/
  * Fedora 23, Ubuntu 17.10: no python2 (/usr/bin/python) in the base
    system
  * 2017, April: IPython 6.0
  * 2017, December: Django 2

* Learn from our past mistakes. If done again, would it be different? Yes,
  obviously. Python 4 will be different than Python 3: no more "break the
  world" release, but a "regular deprecation period" release, as *any* other
  release. Break things, one by one :-)



RAW                             notes
=====================================

BIG TOPICS:



Timeline
    XXX draw a graphic
    2000-10: **Python 2.0**
    2008-10: **Python 2.6**
    2008-09: **Python 3.0**
    2009-06: Python 3.1
    2010-07: Python **2.7**
    2011-02: Python 3.2
    2011-03: **six** 1.0
    2011-04: **pip** 1.0
    2011-11: **PEP 404**, "Python 2.8 Un-release Schedule"
    2012-09: Python 3.3
    2013-02: Django 1.5 adds Python 3 support
    2014-03: Python 3.4
    2015-09: Python 3.5
    2016: More and more projects drops Python 2.6 support
    2016-10: "The Case Against Python 3 (For Now)"
        https://learnpythonthehardway.org/book/nopython3.html
    2016-12: Python 3.6
    2017-04: IPython 6.0 drops Python 3 support
    2017-12: Django 2.0 drops Python 3 support
    --
    2018-06: Python 3.7.0

    Python 2.0 -> 2.7: ~10 years
    Python 3.0 -> 3.7: ~10 years

Statistics Python 2 vs Python 3
    https://twitter.com/vlasovskikh/status/801720613312364544/photo/1
    https://blogs.msdn.microsoft.com/pythonengineering/2016/03/08/python-3-is-winning/
    https://gallery.cortanaintelligence.com/Notebook/Analyzing-PyPI-Data-to-Determine-Python-3-Support-2
