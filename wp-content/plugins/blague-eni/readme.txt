=== Blagues - ENI ===
Contributors: Denis - Stagiaires ENI
Tags: Blagues, Demonstration, exemple
Requires at least: 4.9.8
Tested up to: 4.9.8
Stable tag: 4.9.8
License: GPLv2 or later

Permet de fournir une liste de blagues ou de citations.
L'idée est surtout de créer un plugin de démonstration pour s'entrainer à créer un plugin sous WordPress.

== Description ==
Permet de fournir une liste de blagues ou de citations.
L'idée est surtout de créer un plugin de démonstration pour s'entrainer à créer un plugin sous WordPress.

Moteur de recherche pour obtenir une blague ou une citation.
Cette liste est complétée et mise à jour réguliérement.
Vous cherchez une blague ? une citation ? un auteur en particulier?
Tapez un mot clef plutôt qu'une expression entière.

Major features in Blagues Citations ENI include:
* Saisir un mot clé dans le moteur de recherche
* Lancer une recherche
* Le plugin vous fournit une liste de blagues ou de citations en fonction du mot clé recherché s'il en possède un.

== Installation ==
Upload the Blague ENI plugin to your blog, Activate it.
1,2,3: You're done !
Ajouter le widget dans votre menu.

== Changelog ==
= 0.6 =
*Release Date - 16 January 2019*
Mise à jour des blagues.

= 0.2 =
*Release Date - 08 November 2018*
Ajouter un shortcode pour les pages et les articles qui affiche la liste des blagues.
Rajouter dans votre page le shortcode [eniBlagueList]

= 0.1 =
*Release Date - 07 November 2018*
Mise en place du plugin
Mise en place de la base de données.

= git =
Git global setup
git config --global user.name "Denis Sanchez"
git config --global user.email "dsanchez@campus-eni.fr"
Create a new repository
git clone https://gitlab.com/eni-ecole/eni-blague-ou-citation.git
cd eni-blague-ou-citation
git switch -c main
touch README.md
git add README.md
git commit -m "add README"
git push -u origin main
Push an existing folder
cd existing_folder
git init --initial-branch=main
git remote add origin https://gitlab.com/eni-ecole/eni-blague-ou-citation.git
git add .
git commit -m "Initial commit"
git push -u origin main
Push an existing Git repository
cd existing_repo
git remote rename origin old-origin
git remote add origin https://gitlab.com/eni-ecole/eni-blague-ou-citation.git
git push -u origin --all
git push -u origin --tags