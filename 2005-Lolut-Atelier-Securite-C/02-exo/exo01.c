/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Programme un poil plus complexe : utilise fopen, strcpy, etc.
 * 
 * À vous de jouer pour trouver la/les faille(s) ;-)
 */

#include <limits.h> // PATH_MAX
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <errno.h> // for errno
#include <sys/stat.h> // for mkdir

// Replace "\n" by "\0" at the end of a string
void trim(char *str)
{
    size_t len;
    if (str == NULL) return;
    len = strlen(str);
    if (len == 0) return;
    if (str[len-1] != '\n') return;
    str[len-1] = '\0';
}

// Read one line from stdin, and then call trim
// Returns 0 if fails, 1 else
int readLine(char *str, int size)
{
    char *err = fgets(str, size, stdin);
    if (err == NULL) return 0;
    trim(str);
    return 1;
}

// Read home directory, and copy it into filename
// Use HOME environment variable, or "/home/$USER"
// Returns 0 if fails, 1 else
int getHome(char *filename)
{
    char *home;
    home = getenv("HOME");
    if ((home == NULL) || (home[0] == '\0')) {
        home = getenv("USER");
        if (home == NULL) return 0;
        strcpy(filename, "/home/");
        strcat(filename, home);
    } else {
        strcpy(filename, home);
    }
    return 1;
}    
   
// Load filename from ~/.lolut/name
// Returns 0 if fails, 1 else
int loadName(char *name, int size)
{
    int nb;
    FILE *file;
    char filename[PATH_MAX];
    unsigned int lg;
   
    // Get file name 
    if (!getHome(filename)) return 0;
    strcat(filename, "/.lolut/name");

    // Open file
    file = fopen(filename, "r");
    if (file == NULL) return 0;
    
    // Read name
    fread((char *)&lg, sizeof(lg), 1, file);
    fread(name, lg, 1, file);
    name[lg] = '\0';
    fclose(file);
    return 1;
}

// Save filename into ~/.lolut/name
// Ignore all errors
void saveName(char *name)
{
    FILE *file;
    char filename[PATH_MAX];
    int ok;
    unsigned int lg;
    
    // Get directory name 
    if (!getHome(filename)) return;
    strcat(filename, "/.lolut");

    // Create directory
    ok = mkdir(filename, 0777);
    if (ok != 0)
    {
        if (errno != 17)
        {
            printf("Can not create directory %s (errno %i)!\n", filename, errno);
            return;
        }
    }
   
    // Open file
    strcat(filename, "/name");
    file = fopen(filename, "w");
    if (file == NULL)
    {
        printf("Can not create (or open) file %s!\n", filename);
        return;
    }
    
    // Write name 
    lg = strlen(name);
    fwrite((char *)&lg, sizeof(unsigned int), 1, file);
    fwrite(name, lg, 1, file);
    fclose(file);
}

// High level function to read user name
// Try to load it from the save, or ask him directly
// Returns 0 if fails, 1 else
int readName(char *name, int size)
{
    if (loadName(name, size)) return 1;
    printf ("Enter your name: ");
    if (!readLine(name, size)) return 0;
    saveName(name);
    return 1;
}

int main()
{
    char name[40];
    if (readName(name, sizeof(name)*sizeof(name[0]))) {
        printf ("Your name is %s.\n", name);
        return 0;
    } else { 
        printf("\nSorry, can't read your name :-(\n");
        return 1;
    }
}
