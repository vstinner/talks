/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Recherchez la/les faille(s) ... 
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main(int argc, char **argv)
{
    char name[30], *err;
    int i;

    // Read name
    printf ("Enter your name: ");
    err = fgets(name, sizeof(name), stdin);
    if (err == NULL) exit(EXIT_FAILURE);
    i = strlen(name);
    if (i < 2) exit(EXIT_FAILURE);
    if (name[i-1] == '\n') name[i-1] = '\0';

    // Display name
    printf ("Hello ");
    for (i=0; i<3; i++) printf ("-");
    printf(name);
    for (i=0; i<3; i++) printf ("-");
    printf ("\n");
    
    exit(EXIT_SUCCESS);
}
