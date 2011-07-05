/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Recherchez la/les faille(s) ... 
 */

#include <stdio.h>
#include <stdlib.h>

typedef struct
{
    int x,y;
} Point;

int randint(int min, int max)
{
    long long r = random();
    return min + (r * (max-min)) / RAND_MAX;
}

int main(int argc, char **argv)
{
    unsigned long i, n;
    char *err;
    long size;
    long avgx, avgy;
    Point *points;

    // Check argument list
    if (argc < 2)
    {
        fprintf(stderr, "Usage: %s number\n", argv[0]);
        return 1;
    }
    
    // Get number of points
    n = strtol(argv[1], &err, 10);
    if ((err == argv[1]) || (err != NULL && *err != '\0'))
    {
        fprintf(stderr, "Invalid number.\n");
        return 1;
    }

    // Create points
    printf("Create points.\n");
    points = malloc(n*sizeof(points[0]));
    for (i=0; i<n; i++)
    {
        points[i].x = randint(-1000,1000);
        points[i].y = randint(-1000,1000);
    }

    // Compute average
    printf("Compute average.\n");
    avgx = avgy = 0;
    for (i=0; i<n; i++)
    {
        avgx += points[i].x;
        avgy += points[i].y;
    }
    printf("Average: %.2f ; %.2f\n", (double)avgx / n, (double)avgy / n);

    // Free memory
    free (points);
    return 0;
}
