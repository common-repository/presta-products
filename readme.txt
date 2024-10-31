=== Presta Products for WordPress ===
Contributors: Guillaume BOUAUD https://www.guillaume-bouaud.fr
Donate link: https://www.paypal.me/guillaumebouaud
Tags: produit, prestashop, wordpress, seo, obfuscation, lien
Requires at least: 4.7
Requires PHP: 5.6
Tested up to: 6.4.3
Stable tag: 1.1.27
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Affichage des produits Prestashop sur le site internet généré par WordPress.

== Description ==

<strong>Presta Products for WordPress</strong>

Affichage des produits Prestashop sur le site internet généré par WordPress.
Utilisez cette extension pour ajouter vos produits (venant de Prestashop) sur votre blog / site internet WordPress, avec de simples utilisations de shortcodes (documentation disponible dans le module).
Possibilité de modifier la présentation du bloc via un bloc "CSS personnalisé" intégré au module (attention, le code doit être valide au format CSS, si vous avez des questions, vous pouvez contacter <a href="https://www.guillaume-bouaud.fr/contact" target="_blank">le développeur du module</a>).

Les fonctionnalités du module "Presta Products for Wordpress" permettent de :
<ul>
<li>Afficher des produits Prestashop sur un WordPress simplement (utilisation de shortcodes)</li>
<li>Customiser l'affichage du produit (ordre des données, CSS personnalisé, etc...)</li>
<li>Choisir les données à afficher (nom, prix, description, image, etc...)</li>
</ul>

NB : plus de fonctionnalités sont disponibles avec une version payante (par le biais de l'achat d'une licence).

A venir : intégration avec un bloc gutenberg, intégration avec un bloc elementor...

== Installation ==

1. Utilisez le catalogue d'extensions de WordPress et rechercher "Presta Products for WordPress" ou téléversez le fichier ZIP du module en utilisant le bouton de la page d'ajout d'extensions de WordPress.
2. Activez le module depuis le catalogue ou le menu des extensions installées.
3. Vous êtes prêts ! Il n'y a plus qu'à paramétrer les options obligatoires (configuration) et les options souhaitées (fonctionnalités).
4. Bonus : pour profiter de toutes les fonctionnalités, vous pouvez acheter une licence sur <a href="https://www.guillaume-bouaud.fr/produit/licence-premium-presta-products-for-wordpress" target="_blank">le site du développeur</a>.

== Frequently Asked Questions ==

= Qui peut utiliser le module Presta Products for WordPress ? =

L'utilisation du module est ouverte à tous, pour afficher les produits Prestashop d'une boutique en ligne sur un blog WordPress.

= Pourquoi acheter la version payante ? =

Pour profiter de toutes les options d'affichage (prix barré, soldes, etc...) ou de template (produit, balisage, etc...), il est nécessaire de passer par l'achat d'une clé de licence.

== Credits ==

Guillaume BOUAUD (https://www.guillaume-bouaud.fr)

== Screenshots ==

1. Configuration du module
2. Fonctionnalités du module (1/2)
3. Fonctionnalités du module (2/2)
4. Exemples de shortcode
5. Affichage d'un listing avec 3 produits
6. Affichage d'un listing avec 1 produit
7. Système de cache pour augmenter radicalement les performances (PREMIUM)

== Changelog ==

= 1.1.27 = (12/07/2024)
* Nouveau: Gestion en cache de shortcode ajouté dans le fichier function du thème en cours, via add_filter/the_content (PREMIUM)

= 1.1.26 = (30/05/2024)
* Fixed: Correction d'une erreur fatale PHP 8.1

= 1.1.25 = (28/02/2024)
* Fixed: quelques correctifs mineurs apportés (sécurité d'appels API)

= 1.1.24 = (27/02/2024)
* Fixed: quelques correctifs mineurs apportés (PHP8)

= 1.1.23 = (26/02/2024)
* Fixed: plusieurs Warning avec PHP8 corrigés

= 1.1.22 = (12/02/2024)
* Fixed: Correctif de la récupération des produits en mode bestsellers

= 1.1.21 = (06/02/2024)
* Testée jusqu’à la version 6.4.3 de WordPress
* Fixed: Gestion de l'option bestsellers combiné à un autre parmi la liste suivante : product, products, category, categories

= 1.1.20 = (27/11/2023)
* Fixed: Gestion du lien du produit dans les différentes langues (avec WPML)

= 1.1.19 = (15/11/2023)
* Testée jusqu’à la version 6.4 de WordPress
* Fixed: Gestion du lien du produit dans les différentes langues
* Nouveau: Gestion de la langue avec le module WPML

= 1.1.18 = (31/07/2023)
* Testée jusqu’à la version 6.3 de WordPress
* Testée jusqu’à la version 8.0 de PHP
* Fixed: Correctif d'affichage du prix barré trop long (PREMIUM)
* Nouveau: Gestion de la langue souhaitée par l'utilisateur (code ISO)

= 1.1.17 = (27/02/2023)
* Fixed: Correctif à l'enregistrement du cache (PREMIUM)

= 1.1.16 = (20/02/2023)
* Fixed: Modfication de la taille des champs en base de données (problème de stockage en cache quand trop de données) (PREMIUM)

= 1.1.15 = (17/02/2023)
* Nouveau: Traduction espagnole (es_ES)
* Nouveau: Gestion du tri des produits (ID, prix, date de création, stock, aléatoire)
* Nouveau: Gestion des produits sans stock (affichage ou non quand le stock est <= 0) (PREMIUM)

= 1.1.14 = (24/01/2023)
* Testée jusqu’à la version 6.1.1 de WordPress
* Fixed: Gestion de la récupération des librairies uniquement sur la page admin du module
* Fixed: Problèmes mineurs de message d'avertissements
* Fixed: Erreur d'objet et de tableau dans le système de crontab (PREMIUM)
* Nouveau: Ajout d'un export CSV des données "Utilisé sur" (PREMIUM)
* Nouveau: Gestion de la duplication de shortcode sur la même page avec le cache (PREMIUM)

= 1.1.13 = (02/11/2022)
* Testée jusqu’à la version 6.1 de WordPress
* Fixed: Correctif du cron (erreur fonction dupliquée)
* Fixed: Correctifs de vérifications de variables
* Fixed: Correctifs d'appels des fichiers assets
* Fixed: Correctifs de conditions et d'éléments non existants
* Fixed: Message de mise en cache en cours plus visible et plus explicatif sur la marche à suivre (PREMIUM)
* Nouveau: Affichage d'un message d'avertissement sur la gestion du cache (PREMIUM)
* Nouveau: Gestion de la langue avec le module Polylang

= 1.1.12 = (24/10/2022)
* Fixed: Correctif de l'affichage des carrousels sur la version mobile
* Fixed: Correctifs mineurs sur les données par défaut du carrousel
* Nouveau: Ajout d'une option width sur le carrousel (précaution, bien gérer le nombre de produits affichés)

= 1.1.11 = (22/10/2022)
* Fixed: Correctifs d'attributs mal placés
* Nouveau: Ajout du mode carrousel de produits
* Nouveau: Ajout des options autoplay, number pour le carrousel de produits
* Nouveau: Gestion de différents affichages des flèches et points du carrousel (PREMIUM)

= 1.1.10 = (01/08/2022)
* Fixed: Correctif problème enregistrement des données en cache lors de shortcodes dupliqués (PREMIUM)
* Nouveau: Ajout des statuts "Brouillon", "En attente" en plus de "Publié" dans les statuts d'articles et de pages acceptés (PREMIUM)

= 1.1.9 = (28/05/2022)
* Testée jusqu’à la version 6.0 de WordPress
* Fixed: Correctif de la gestion avec le script crontab (PREMIUM)
* Fixed: Correctif de la connexion PREMIUM
* Fixed: Déplacement de l'enregistrement des formulaires du back office (problèmes de conflits entre modules)
* Fixed: Suivi de recommandations sur les "désinfections" des variables (sanitize)

= 1.1.8 = (24/05/2022)
* Fixed: Gestion du shortcode bestsellers (problème avec les limites)
* Fixed: Gestion du shortcode category (problème avec les limites)

= 1.1.7 = (18/05/2022)
* Fixed: Correctif sur l'url produit (récupération curl si les autres ne fonctionnent pas, exemple thirtybees)
* Nouveau: Ajout de 2 types d'images Prestashop compatible Thirtybees (home_default et cart_default)

= 1.1.6 = (25/04/2022)
* Nouveau: Possibilité d'ajouter un bouton "Voir le produit"

= 1.1.5 = (12/04/2022)
* Nouveau: Possibilité de choisir le format de l'image (small, medium, large)

= 1.1.4 = (07/03/2022)
* Nouveau: Gestion d'une version de cache des produits pour améliorer les performances (PREMIUM)
* Nouveau: Gestion de la valeur "Nulle Part" du champ Visibilité "Où le produit doit-il apparaître" de PrestaShop (PREMIUM)
* Nouveau: Ajout d'un tooltip d'aide sur la personnalisation de CSS
* Fixed: Ajout d'attributs sur les images pour l'optimisation
* Fixed: Amélioration de la connexion PREMIUM
* Fixed: Gestion de la compatibilité des options entre l'affichage Back Office et Front Office
* Fixed: Gestion des options améliorée

= 1.1.3 = (25/02/2022)
* Nouveau: Message d'alerte pour les boutiques prestashop en maintenance
* Nouveau: Possibilité d'avoir une seconde image au survol (PREMIUM)
* Fixed: Correctif de l'affichage des produits sur la version mobile
* Fixed: Gestion des fichiers assets
* Fixed: Ajout de messages d'aide sur le formulaire des fonctionnalités
* Fixed: Correctif lié à la réécriture de l'URL du produit
* Fixed: Correctif sur la gestion de plusieurs langues sur le prestashop (par défaut celle avec l'ID 1)

= 1.1.2 = (07/02/2022)
* Amélioration: Lien sur le nom du produit et non sur un espace vide (SEO)
* Nouveau: Ajout de la possibilité de choisir l'ouverture dans la même page (PREMIUM)
* Fixed: Correctif sur l'URL de la fiche produit (adaptation à tous les schémas URL de PrestaShop)
* Fixed: Problème de connexion version PREMIUM

= 1.1.1 = (05/02/2022)
* Fixed: Problème d'adaptabilité de la feuille de style aux différents WordPress

= 1.1.0 = (02/02/2022)
* Amélioration: Gestion graphique des sous menus
* Amélioration: Ajout d'aide sur la création d'une clé API (sous PrestaShop)
* Fixed: Modification de textes
* Fixed: Problème avec le champ URL du site internet PrestaShop
* Nouveau: Notification lors de la sauvegarde des formulaires

= 1.0.2 = (31/01/2022)
* Fixed: Gestion des appels de fonction (et prévention de conflits avec d'autres modules)

= 1.0.1 = (26/01/2022)
* Testée jusqu’à la version 5.9 de WordPress
* Fixed: Problème d'affichage des utilisations des shortcodes (PREMIUM)

= 1.0.0 = (12/01/2022)
* Nouveau: Connexion au prestashop
* Nouveau: Affichage du nom du produit
* Nouveau: Affichage de l'image du produit
* Nouveau: Affichage du prix du produit
* Nouveau: Affichage du prix barré du produit (PREMIUM)
* Nouveau: Affichage du récapitulatif du produit
* Nouveau: Affichage de la description du produit (PREMIUM)
* Nouveau: Affichage du bandeau promotion du produit (PREMIUM)
* Nouveau: Obfuscation du lien
* Nouveau: Balisage nom du produit (PREMIUM)
* Nouveau: Taille du texte récapitulatif (PREMIUM)
* Nouveau: Taille du texte description (PREMIUM)
* Nouveau: Cacher les produits hors ligne
* Nouveau: Cacher les produits non disponible à la vente (PREMIUM)
* Nouveau: CSS personnalisé
* Nouveau: 3 templates d'affichage produit (PREMIUM)
* Nouveau: Ajout de documentation de shortcode (+ exemples)
* Nouveau: Listing des pages et posts utilisant les shortcodes (PREMIUM)
* Nouveau: Traduction fr_FR
* Nouveau: Traduction en_US

= 0.0.1 = (01/01/2022)
* Lancement initial
