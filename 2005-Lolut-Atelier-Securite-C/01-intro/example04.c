/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Exemple 4 : Vérifie les valeurs de retour.
 *
 * C'est un petit bug, pas vraiment une faille.
 */

#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int hello(void)
{
#define SIZE 10
    char name[SIZE], str_age[SIZE], *err;
    long age;
    
    // Ask age
    printf("Enter your age: ");
    err = fgets(str_age, SIZE, stdin);
    if (err == NULL) return -1;
    if (str_age[strlen(str_age)-1] != '\n') str_age[strlen(str_age)-1] = '\0';
    age = strtol(str_age, &err, 10);
    if ((err == str_age) || (err != NULL && *err != '\0')) return -1;

    // Ask name
    printf("Enter your name: ");
    err = fgets(name, SIZE, stdin);
    if (err == NULL) return -1;
    if (name[strlen(name)-1] != '\n') name[strlen(name)-1] = '\0';

    // Display result
    printf("Hello %s, you're %d years old!\n", name, age);
    return 0;
}

int main(void)
{
    if (hello() < 0) printf ("\nError ...\n");
    return 0;
}    
