/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Exemple 1 : Aïe aïe aïe!
 */

#include <stdio.h>

int main(void)
{
    char name[10];
    printf("Enter your name: ");
    gets(name);
    printf("Hello %s!\n", name);
    return 0;
}    
