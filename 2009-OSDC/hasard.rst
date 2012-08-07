Proposé le 16 juillet 2009

--

Par Victor Stinner
Date : Pas encore planifié
Durée : 40 minutes
Tags : hasard prng random

--

Générer des nombres aléatoires à partir d'un ordinateur est un problème
difficile.

Il existe deux principales utilisations des générateurs de nombres aléatoires :
les simulations physiques (les jeu vidéos en étant un cas particulier) et la
sécurité. Pour les simulations, un bon générateur doit être rapide et avoir une
distribution uniforme. Pour la sécurité, même si l'attaquant est capable de
contrôler la source d'entropie et/ou obtenir l'état interne du générateur, il
ne doit pas être capable de prédire les précédents nombres ou prochains nombres
générés.

Je vais présenter quelques algorithmes courant en décrivant pourquoi ils sont
utilisés, leurs forces et faiblesses, puis quels sources d'entropie utiliser
pour les initialiser. Je parlerai ensuite de la bibliothèque Hasard.

Site du projet : http://bitbucket.org/haypo/hasard/wiki/Home
Plus d'informations (en français) : http://linuxfr.org/2009/07/10/25721.html

