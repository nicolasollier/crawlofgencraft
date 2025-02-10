<?php

return [
    'weapons' => [
        'common' => [
            ['name' => 'Épée rouillée du vagabond', 'item_type' => 'weapon', 'damage_bonus' => 2, 'value' => 12, 'description' => 'Une épée ébréchée, ayant vu de nombreuses batailles oubliées.'],
            ['name' => 'Dague émoussée des bas-fonds', 'item_type' => 'weapon', 'damage_bonus' => 1, 'value' => 5, 'description' => 'Une dague usée, souvent utilisée par les voleurs des ruelles sombres.'],
            ['name' => 'Masse en bois noueux', 'item_type' => 'weapon', 'damage_bonus' => 1, 'value' => 4, 'description' => 'Un simple bâton renforcé, parfait pour briser quelques crânes.'],
            ['name' => 'Faucille du paysan déchu', 'item_type' => 'weapon', 'damage_bonus' => 1, 'value' => 6, 'description' => 'Une faucille rouillée qui a troqué les blés pour le sang.'],
            ['name' => 'Fléau brisé des oubliés', 'item_type' => 'weapon', 'damage_bonus' => 2, 'value' => 10, 'description' => 'Un fléau en mauvais état, vestige d\'un passé guerrier.'],
            ['name' => 'Arc de fortune', 'item_type' => 'weapon', 'damage_bonus' => 2, 'value' => 8, 'description' => 'Un arc rudimentaire, fait de bois tordu et de ficelle de lin.'],
        ],
        'uncommon' => [
            ['name' => 'Lame de chasseur de goules', 'item_type' => 'weapon', 'damage_bonus' => 4, 'value' => 55, 'description' => 'Une lame effilée, imprégnée du sang des créatures de la nuit.'],
            ['name' => 'Hache de guerre ensanglantée', 'item_type' => 'weapon', 'damage_bonus' => 5, 'value' => 80, 'description' => 'Une hache robuste dont le fil est encore poisseux de sang séché.'],
            ['name' => 'Arc en bois noir', 'item_type' => 'weapon', 'damage_bonus' => 3, 'value' => 50, 'description' => 'Un arc élégant sculpté dans un bois noirci par le temps.'],
            ['name' => 'Fléau de la rétribution', 'item_type' => 'weapon', 'damage_bonus' => 4, 'value' => 60, 'description' => 'Un fléau à pointes, parfait pour punir les impurs.'],
        ],
        'rare' => [
            ['name' => 'Lame des murmures funestes', 'item_type' => 'weapon', 'damage_bonus' => 7, 'value' => 220, 'description' => 'Une épée maudite, susurrant à l\'oreille de son porteur des promesses de puissance.'],
            ['name' => 'Arc d\'ébène maudit', 'item_type' => 'weapon', 'damage_bonus' => 7, 'value' => 230, 'description' => 'Un arc sinistre, dont les flèches semblent chercher leur cible d\'elles-mêmes.'],
            ['name' => 'Hallebarde du massacre', 'item_type' => 'weapon', 'damage_bonus' => 8, 'value' => 300, 'description' => 'Une hallebarde massive, capable de faucher plusieurs ennemis à la fois.'],
        ],
        'epic' => [
            ['name' => 'Épée du jugement écarlate', 'item_type' => 'weapon', 'damage_bonus' => 12, 'value' => 500, 'description' => 'Une épée légendaire, réclamant la justice avec chaque coup tranchant.'],
            ['name' => 'Marteau du titan endormi', 'item_type' => 'weapon', 'damage_bonus' => 15, 'value' => 600, 'description' => 'Un marteau colossal, imprégné de l\'essence des géants.'],
        ],
        'legendary' => [
            ['name' => 'Lame du Roi Déchu', 'item_type' => 'weapon', 'damage_bonus' => 18, 'value' => 700, 'description' => 'Une lame ancestrale, autrefois brandie par un roi dont le nom a été effacé de l\'histoire.'],
            ['name' => 'Bâton du néant absolu', 'item_type' => 'weapon', 'damage_bonus' => 20, 'value' => 800, 'description' => 'Un bâton imprégné d\'une énergie abyssale, dévorant la lumière autour de lui.'],
        ],
    ],

    'armors' => [
        'common' => [
            ['name' => 'Tunique de cuir usée', 'item_type' => 'armor', 'armor_bonus' => 1, 'value' => 18, 'description' => 'Une tunique en cuir tanné, idéale pour se protéger des faibles coups.'],
            ['name' => 'Bouclier fendu', 'item_type' => 'armor', 'armor_bonus' => 1, 'value' => 12, 'description' => 'Un bouclier ayant encaissé trop de coups pour rester fiable.'],
            ['name' => 'Casque cabossé', 'item_type' => 'armor', 'armor_bonus' => 1, 'value' => 10, 'description' => 'Un casque en métal ayant subi bien des batailles.'],
        ],
        'uncommon' => [
            ['name' => 'Cotte de mailles corrodée', 'item_type' => 'armor', 'armor_bonus' => 3, 'value' => 110, 'description' => 'Un maillage métallique usé, offrant une protection décente malgré le temps.'],
            ['name' => 'Gantelets du soldat inconnu', 'item_type' => 'armor', 'armor_bonus' => 2, 'value' => 70, 'description' => 'Des gants en cuir renforcés, marqués par le temps et les combats.'],
        ],
        'rare' => [
            ['name' => 'Armure des chevaliers noirs', 'item_type' => 'armor', 'armor_bonus' => 5, 'value' => 350, 'description' => 'Une armure imposante, chargée d\'un passé mystérieux et macabre.'],
            ['name' => 'Bouclier des âmes perdues', 'item_type' => 'armor', 'armor_bonus' => 6, 'value' => 400, 'description' => 'Un bouclier forgé à partir des esprits des défunts.'],
        ],
        'epic' => [
            ['name' => 'Carapace draconique', 'item_type' => 'armor', 'armor_bonus' => 8, 'value' => 500, 'description' => 'Un plastron forgé à partir des écailles d\'un dragon déchu.'],
            ['name' => 'Casque de la terreur', 'item_type' => 'armor', 'armor_bonus' => 9, 'value' => 600, 'description' => 'Un casque effrayant qui glace le sang de ceux qui le voient.'],
        ],
        'legendary' => [
            ['name' => 'Armure de l\'Éternel Tourment', 'item_type' => 'armor', 'armor_bonus' => 12, 'value' => 700, 'description' => 'Une armure mythique, écho des douleurs des âmes captives.'],
            ['name' => 'Bouclier du Gardien des Dieux', 'item_type' => 'armor', 'armor_bonus' => 15, 'value' => 800, 'description' => 'Un bouclier divin, capable de renvoyer la force des assauts ennemis.'],
        ],
    ],
];
