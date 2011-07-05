#!/usr/bin/perl
open(FILE, $ARGV[0]);
foreach (<FILE>) { print $_; }
close(FILE);
