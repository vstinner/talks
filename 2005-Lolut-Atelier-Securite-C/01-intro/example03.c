/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Exemple 3 : On demande également l'âge.
 *
 * Que se passe-t-il si on entre une chaîne vide ?
 * La nécessité de vérifier les valeurs de retour des fonctions
 * (ici fgets et strtol).
 */

#include <stdio.h>
#include <string.h>
#include <stdlib.h>

void hello(void)
{
#define SIZE 10
    char name[SIZE], str_age[SIZE];
    long age;
    strncpy(name, "randomvalu", SIZE);
    age = 0x12345678;
    
    // Ask age
    printf("Enter your age: ");
    fgets(str_age, SIZE, stdin);
    if (str_age[strlen(str_age)-1] == '\n')
        name[strlen(str_age)-1] = '\0';
    age = strtol(str_age, NULL, 10);

    // Ask name
    printf("Enter your name: ");
    fgets(name, SIZE, stdin);
    if (name[strlen(name)-1] == '\n')
        name[strlen(name)-1] = '\0';

    // Display result
    printf("Hello %s, you're %d years old!\n", name, age);
}

int main(void)
{
    hello();
    return 0;
}    
