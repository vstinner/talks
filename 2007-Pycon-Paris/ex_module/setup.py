#!/usr/bin/python
# -*- coding: UTF-8 -*-

from distutils.core import setup
setup(
    name="mademo",
    version="1.0",
    url="http://www.example.com/",
    author="Victor Stinner",
    description="Module de démo",
    long_description="""Super module de démo pour les journées Python
Code minimaliste montrant les éléments essentiels d'un module""",
    packages=("mademo",),
    license="GNU GPL",
    classifiers=['Intended Audience :: Developers', 'Development Status :: 5 - Production/Stable'],
)

