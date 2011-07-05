Below are the typical steps taken to resolve an issue filed on issue tracker.
The section titles follow the Stage field of an issue except when in square
brackets. It is assumed you have already read Getting Set Up.

[New issue]
===========

When you file an issue, the issue should be explained as best as possible. The
more that can be said upfront the faster the issue can be dealt with as there
will be less of a chance someone needs more details later on.

With the new issue created, emails are sent out to the new-bugs-announce and
python-bugs-list mailing lists. The former receives a single email for all
created issues while the latter receives an email for any change made to an
issue. This way people who are interested in potentially working on issues are
quickly and easily notified when issues come in.

[triage]
========

Once a new issue has been created it needs to go through triage. This means
all fields in the issue tracker need to be set properly. While most of the
fields are self-explanatory, some need a little explanation:

Type
====

Behavior
    Something does not have the expected semantics.
Compile error
    When the issue relates to compilation specifically.
Crash
    Something is causing the interpreter to crash, e.g. a segfault, bus error,
    etc.
Feature request
    A request to add or change something in Python.
Performance
    A performance regression.
Resource usage
    A resource usage regression.
Security
    Somehow someone is able to gain escalated privileges when they shouldn't
    be able to.

Versions
========

This field represents what versions an issue is known to affect and should be
fixed on. This has the effect that what versions an open issue lists are the
ones that the issue explictly needs to be fixed on. As the issue is fixed on
various versions they can be removed from the versions list in order to make
it easily known what backporting is still required.

Priority
========

release blocker
    The next release of Python, whether it be an alpha or release candidate,
    will not happen unless this issue is closed.
deferred blocker
    While an issue of this priority will not hold up this release, it will
    hold up the next one.
critical
    A critical issue will most likely block a release, just not necessarily
    the next one.
high
    No release will be held up for an issue of this priority, but the issue
    should still be addressed when possible.
normal
    In no way critical but requiring some though.
low
    Simple issues, e.g. spelling errors in the documentation.

Nosy list
=========

If a specific developer should look at an issue, it is completely acceptable
to add them to the Nosy List without asking for permission. This is important
as not all developers subscribe to either of the bug announcement lists and
thus will not see all updates to an issue. By adding someone to the nosy list
they will receive an email to catch their attention.

Keywords
========

For Keywords, the easy keyword should be set if an issue can be handled by
someone with no deep knowledge of how Python works. Typically this is fixing
shallow bugs, clearing up some semantics, writing tests, etc. These issues can
be solved in a few hours, e.g. within the timespan of a single bug day.

Setting this field is important! Having easy issues allows people who wish to
help out have an easy time finding issues to work on that they will
(hopefully) not be frustrated by and thus have a gradual introduction to how
development for Python works.

[Unit] Test needed
==================

To help verify an issue is still a problem and have it easily reproduced, an
automated test is needed. It needs to be succinct and, if possible, execute
quickly. Every bug fix or semantic change needs some test, whether it is a new
test or a tweak of an existing one. But no new code should ever be checked in
without some test to exercise the new code! And having a bug available as a
patch against Python's test suite makes it easier to verify when a patch fixes
the issue.

As with all new code, the style guides of PEP 8 and PEP 7 should be followed.
For modules their tests live in Lib/test which corresponds to the test package
in Python. For packages a driver script can be put into Lib/test that runs
tests contained in a subpackage of the package being tested.

To run a test, you have two options. One is to execute the test directly
(./python Lib/test/test_grammar.py). The other option is to use the
regrtest.py test driver which you give the name of the module as contained in
the test package (./python Lib/test/regrtest.py test_grammar). If you run
regrtest.py without specifying a test then all tests are run. Run regrtest.py
with the -h flag to see all of the options it provides, but the most important
is the -u flag to turn on resource usage. To run Python's entire test suite,
run ./python Lib/test/regrtest.py -uall.

Test code can be written using doctest or unittest. Which one is used is left
up to personal preference or what a set of tests for a module is already
written in. For support code beyond what doctest and unittest provide, see
test.support (named test.test_support in Python 2.x). While not thoroughly
documented on purpose, there is several bits of code in there to help out with
testing.

Needs patch
===========

If the issue is a bug, then a patch is needed to fix it. The PEP 7 and PEP 8
style guides need to be followed. Tests should have already been written, if
needed, by the test needed stage. A unified diff is preferred and should be
automatic if you followed the Getting Set Up docs.

Any changes need to not only pass their own tests, but also the entire test
suite (./python Lib/test/regrtest.py -uall). This makes sure that no change,
no matter how small, does not break other code that may have been relying on
old behavior.

An issue can end up back at this stage if a pre-existing patch has problems.
Always read the comments on an issue to see what has led to the current state
of the issue. An issue can also seem to belong on this stage if there is a
patch but actually belong to test needed because a test is missing.

Once a patch is written, it is helpful to also add it to Rietveld. The code
review tool provides an upload.py script to help you upload the patch
directly. Simply paste in the link that Rietveld gives you in a message on the
issue and then reviews of your patch can utilize Rietveld.

[Docs needed]
=============

If any semantics are changed because of a patch or the issue is to make a
change to the docs then documentation changes are needed. Documenting Python
specifies how the markup works. How to compile Python's documentation is
outlined in the Getting Set Up documentation.

Patch review
============

If an issue reaches this stage then someone believes that the code is ready to
be reviewed for checking. All steps outlined in the other stages should have
been followed: there are tests if needed, all code follows the style
guidelines, the code is of high quality, and any needed docs changes have been
made. There should also be an entry for Misc/NEWS and Misc/ACKS as needed.

Anyone can comment on an issue that has reached this stage, not just
developers! If you think a change is needed or that the patch looks good then
please say so!

This stage is typically where an issue languishes on the issue tracker.
Because there are only so many developers and almost all of them volunteer
their free time to work on Python, there is simply not enough collective time
to usually get a patch review done promptly. This does not mean your patch
will never be reviewed or is not appreciated! It simply means people are busy
with other things which include "real life". Please be patient if your patch
takes a while to be reviewed.

If the OP of the patch didn't do so, feel free to use Rietveld for a patch
review. It can greatly simplify the review process for both you and the patch
creator.

Commit review
=============

Setting the stage to this value means that the issue cannot move any forward
without a review by a core developer. This can come up in two situations.

When the next release of Python is a release candidate or a final release,
issues need to reviewed by two core developers before being checked in, as
this stage represents. If a patch was written by a core developer than the
issue can skip over the patch review stage directly to this . But if a patch
was done be a non-core developer it must first pass through the patch review
stage and be reviewed by a core developer at that stage as well. This
guarantees all new code is reviewed by at least two core developers before
being committed, preventing any new bugs from slipping into an RC or final
release.

Another situation is that someone performing triage on an issue notices that a
patch has already been properly reviewed by a non-core developer and thus is
ready to be seriously looked at for being applied. By setting a stage to this
value should act as a flag to core developers that a patch is as ready as it's
going to be for a commit review.

Committed/rejected
==================

At this point the issue is closed. Either it was accepted/fixed or rejected for some reason.

