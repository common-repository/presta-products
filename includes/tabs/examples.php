<div class="mt-4 clr ppgbo-examples" <?php echo (($page != 'examples') ? 'style="display:none;"' : ''); ?>>
        
    <hr class="mt-4">
    <h3 class="mt-3"><?php echo __( 'Options disponibles', 'presta-products'); ?></h3>
    <hr>
        
    <div class="mt-3">
        <h5><?php echo __( 'Produit', 'presta-products'); ?></h5>
        <code>product="X"</code><br>
        <i><?php echo __( 'Uniquement des nombres.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Liste des produits', 'presta-products'); ?></h5>
        <code>products="X,Y,Z"</code><br>
        <i><?php echo __( 'Uniquement des nombres.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Catégorie', 'presta-products'); ?></h5>
        <code>category="X"</code><br>
        <i><?php echo __( 'Uniquement des nombres.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Liste des catégories', 'presta-products'); ?></h5>
        <code>categories="X,Y,Z"</code><br>
        <i><?php echo __( 'Uniquement des nombres.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Nombre de produits', 'presta-products'); ?></h5>
        <code>counter="X"</code><br>
        <i><?php echo __( 'Par défaut, le nombre de produits récupérés sera de 5.<br>Pris en compte uniquement avec les paramètres category, categories ou bestsellers.<br>Champ facultatif.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Obfuscation forcée', 'presta-products'); ?></h5>
        <code>obfuscation="X"</code><br>
        <i><?php echo __( '0 (enlever l\'obfuscation) ou 1 (forcer l\'obfuscation).<br>Si la valeur est différente, alors l\'obfuscation n\'est pas forcée.<br>Champ facultatif.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Meilleures ventes', 'presta-products'); ?></h5>
        <code>bestsellers="X"</code><br>
        <i><?php echo __( 'Uniquement des nombres.<br>Par défaut, le nombre de jours à remonter est de 10.<br>Champ facultatif.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Tri', 'presta-products'); ?></h5>
        <code>sort="ID,ASC"</code><br>
        <i><?php echo __( 'Choix disponibles : ID, PRICE, DATE, STOCK, RANDOM) + Ordre (ASC ou DESC, facultatif, par défaut ASC), séparés par une virgule.<br>Par défaut, ID.<br>Champ facultatif.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Carrousel de produits', 'presta-products'); ?></h5>
        <code>mode="carrousel"</code><br>
        <i><?php echo __( 'Créé un carrousel avec les produits indiqués avec products, ou category, ou categories.<br>Champ facultatif.', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Option autoplay du carrousel', 'presta-products'); ?></h5>
        <code>autoplay="X"</code><br>
        <i><?php echo __( 'Uniquement des nombres.<br>Lance automatiquement le carrousel et tourne automatiquement toutes les X ms.<br>Par défaut, 5000ms pour 5 secondes de délai entre chaque mouvement.<br>Minimum 2000ms (2 secondes) pour un rendu correct.<br>Champ facultatif, utilisé uniquement avec le mode "carrousel".', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Option nombre de produits affichés du carrousel', 'presta-products'); ?></h5>
        <code>number="X"</code><br>
        <i><?php echo __( 'Uniquement des nombres.<br>Par défaut, prend le paramètre counter ou à défaut la gestion se fait sur le nombre de produits récupérés.<br>Champ facultatif, utilisé uniquement avec le mode "carrousel".', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Option taille du carrousel', 'presta-products'); ?></h5>
        <code>width="X"</code><br>
        <i><?php echo __( 'Une taille en pixel ou en % (utiliser 600px ou 80%).<br>Par défaut, prend la taille complète de l\'élément parent.<br>Champ facultatif, utilisé uniquement avec le mode "carrousel".<br>ATTENTION, bien gérer avec le nombre de produits par ligne !', 'presta-products'); ?></i>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Langue du/des produit(s)', 'presta-products'); ?></h5>
        <code>language="X"</code><br>
        <i><?php echo __( 'Code ISO de la langue souhaitée (doit être dans prestashop).<br>Par défaut, prend la langue courante.<br>A ne pas renseigner pour la langue native du Prestashop.<br>Champ facultatif, exemples de code ISO : fr, en, es...', 'presta-products'); ?></i>
    </div>

    <hr class="mt-5">
    <h3 class="mt-3"><?php echo __( 'Exemples de shortcodes', 'presta-products'); ?></h3>
    <hr>
    
    <div class="mt-3">
        <h5><?php echo __( 'Ajout d\'un produit Prestashop', 'presta-products'); ?></h5>
        <p>
            <?php echo __( 'Dans l\'exemple ci-dessous, on veut ajouter le produit dont l\'ID est le #1 de Prestashop :', 'presta-products'); ?>
        </p>
        <code>[ppgbo product="1"]</code>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Ajout d\'un produit Prestashop forcé en obfusqué', 'presta-products'); ?></h5>
        <p>
            <?php echo __( 'Dans l\'exemple ci-dessous, on veut ajouter le produit dont l\'ID est le #1 de Prestashop avec un lien forcé en obfusqué :', 'presta-products'); ?>
        </p>
        <code>[ppgbo product="1" obfuscation="1"]</code>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Ajout d\'une liste de produits Prestashop', 'presta-products'); ?></h5>
        <p>
            <?php echo __( 'Dans l\'exemple ci-dessous, on veut ajouter les produits dont les ID sont les #1, #14 et #23 de Prestashop :', 'presta-products'); ?>
        </p>
        <code>[ppgbo products="1,14,23"]</code>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Ajout de tous les produits d\'une catégorie Prestashop', 'presta-products'); ?></h5>
        <p>
            <?php echo __( 'Dans l\'exemple ci-dessous, on veut ajouter les produits de la catégorie dont l\'ID est le #1 de Prestashop :', 'presta-products'); ?>
        </p>
        <code>[ppgbo category="1"]</code>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Ajout du TOP 6 des produits d\'une catégorie Prestashop', 'presta-products'); ?></h5>
        <p>
            <?php echo __( 'Dans l\'exemple ci-dessous, on veut ajouter le TOP 6 des produits de la catégorie dont l\'ID est le #1 de Prestashop :', 'presta-products'); ?>
        </p>
        <code>[ppgbo category="1" counter="6"]</code>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Ajout des 4 produits les plus vendus depuis 15 jours', 'presta-products'); ?></h5>
        <p>
            <?php echo __( 'Dans l\'exemple ci-dessous, on veut ajouter les 4 produits les plus vendus sur Prestashop durant les 15 derniers jours :', 'presta-products'); ?>
        </p>
        <code>[ppgbo bestsellers="15" counter="4"]</code>
    </div>
    <hr>
    <div class="mt-3">
        <h5><?php echo __( 'Affiche un carrousel de 5 produits (3 affichés), avec un autoplay de 4 secondes', 'presta-products'); ?></h5>
        <p>
            <?php echo __( 'Dans l\'exemple ci-dessous, on veut ajouter les 5 produits indiqués dans un carrousel qui affichera 3 produits, en tournant automatiquement :', 'presta-products'); ?>
        </p>
        <code>[ppgbo products="1,2,3,4,5" mode="carrousel" autoplay="true" number="3"]</code>
    </div>
</div>