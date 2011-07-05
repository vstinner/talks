/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Exemple 2 : Premier jet avec fgets.
 *
 * Tout semble ok ? Bon c'est un bug, pas vraiment
 * une faille de sécurité.
 */

#include <stdio.h>
#include <string.h>

int main(void)
{
#define SIZE 20       
    char name[SIZE];
    printf("Enter your name: ");
    fgets(name, SIZE, stdin);
    if (name[strlen(name)-1] == '\n') name[strlen(name)-1] = '\0';
    printf("Hello %s!\n", name);
    return 0;
}
