<?php

namespace App\Repositories;

class DeckTypeRepository
{
    /**
     * The list of deck types.
     *
     * @var array
     */
    public $decks = [
        [
            'identifier'        =>  'bombmence',
            'parent'            =>  null,
            'name'              =>  'Bombmence',
            'icon_primary'      =>  'salamence',
            'icon_secondary'    =>  'electrode',
        ],
        [
            'identifier'        =>  'tyranitar-ex',
            'parent'            =>  null,
            'name'              =>  'Shockwave',
            'icon_primary'      =>  'tyranitar',
            'icon_secondary'    =>  'beedrill',
        ],
        [
            'identifier'        =>  'growler',
            'parent'            =>  null,
            'name'              =>  'Growler',
            'icon_primary'      =>  'groudon',
            'icon_secondary'    =>  'stantler',
        ],
        [
            'identifier'        =>  'sunflora',
            'parent'            =>  null,
            'name'              =>  'Green Blast',
            'icon_primary'      =>  'sunflora',
            'icon_secondary'    =>  'parasect',
        ],
        [
            'identifier'        =>  'unown-control',
            'parent'            =>  null,
            'name'              =>  'Unown Control',
            'icon_primary'      =>  'unown',
            'icon_secondary'    =>  'pidgeot',
        ],
        [
            'identifier'        =>  'eeveelutions',
            'parent'            =>  null,
            'name'              =>  'Eeveelutions',
            'icon_primary'      =>  'eevee',
            'icon_secondary'    =>  null,
        ],
        [
            'identifier'        =>  'dustox-ex',
            'parent'            =>  null,
            'name'              =>  'Dustox ex',
            'icon_primary'      =>  'dustox',
            'icon_secondary'    =>  null,
        ],
        [
            'identifier'        =>  'wimpy-chicken',
            'parent'            =>  null,
            'name'              =>  'Wimpy Chicken',
            'icon_primary'      =>  'dodrio',
            'icon_secondary'    =>  'aerodactyl',
        ],
        [
            'identifier'        =>  'sleep-inducer',
            'parent'            =>  null,
            'name'              =>  'Sleep Inducer',
            'icon_primary'      =>  'hypno',
            'icon_secondary'    =>  'grumpig',
        ],
        [
            'identifier'        =>  'meganium-delta',
            'parent'            =>  null,
            'name'              =>  'Meganium δ',
            'icon_primary'      =>  'meganium',
            'icon_secondary'    =>  null,
        ],
        [
            'identifier'        =>  'acid-liability',
            'parent'            =>  null,
            'name'              =>  'Acid Liability',
            'icon_primary'      =>  'victreebel',
            'icon_secondary'    =>  'weezing',
        ],
        [
            'identifier'        =>  'holon-circle',
            'parent'            =>  null,
            'name'              =>  'Holon Circle Lock',
            'icon_primary'      =>  'celebi',
            'icon_secondary'    =>  'pidgeot',
        ],
        [
            'identifier'        =>  'groudon-ex',
            'parent'            =>  null,
            'name'              =>  'Groudon ex',
            'icon_primary'      =>  'groudon',
            'icon_secondary'    =>  null,
        ],
        [
            'identifier'        =>  'crobat-ex',
            'parent'            =>  null,
            'name'              =>  'Crobat ex',
            'icon_primary'      =>  'crobat',
            'icon_secondary'    =>  'cacturne',
        ],
        [
            'identifier'        =>  'gyarados-ex',
            'parent'            =>  null,
            'name'              =>  'Gyarados ex',
            'icon_primary'      =>  'gyarados',
            'icon_secondary'    =>  null,
        ],
        [
            'identifier'        =>  'turbo-blastoise',
            'parent'            =>  null,
            'name'              =>  'Turbo Blastoise',
            'icon_primary'      =>  'blastoise ',
            'icon_secondary'    =>  'aipom',
        ],
        [
            'identifier'        =>  'turbo-flygon',
            'parent'            =>  null,
            'name'              =>  'Turbo Flygon',
            'icon_primary'      =>  'flygon',
            'icon_secondary'    =>  'aipom',
        ],
        [
            'identifier'        =>  'turbo-vileplume',
            'parent'            =>  null,
            'name'              =>  'Turbo Vileplume',
            'icon_primary'      =>  'vileplume',
            'icon_secondary'    =>  'aipom',
        ],
        [
            'identifier'        =>  'kingdra-meganium',
            'parent'            =>  null,
            'name'              =>  'Kingdraganium',
            'icon_primary'      =>  'kingdra',
            'icon_secondary'    =>  'meganium',
        ],
        [
            'identifier'        =>  'cacturne-ex',
            'parent'            =>  null,
            'name'              =>  'Cacturne ex',
            'icon_primary'      =>  'cacturne',
            'icon_secondary'    =>  null,
        ],
        [
            'identifier'        =>  'marowak-crobat',
            'parent'            =>  null,
            'name'              =>  'Marowak Crobat',
            'icon_primary'      =>  'marowak',
            'icon_secondary'    =>  'crobat',
        ],
        [
            'identifier'        =>  'ninetales-togetic',
            'parent'            =>  null,
            'name'              =>  'Double Rainbow Moves',
            'icon_primary'      =>  'ninetales',
            'icon_secondary'    =>  'togetic',
        ],
        [
            'identifier'        =>  'dragtrode-sceptile',
            'parent'            =>  'dragtrode',
            'name'              =>  'Dragtile',
            'icon_primary'      =>  'dragonite',
            'icon_secondary'    =>  'sceptile',
        ],
        [
            'identifier'        =>  'legend-box',
            'parent'            =>  null,
            'name'              =>  'Legend Box',
            'icon_primary'      =>  'rayquaza',
            'icon_secondary'    =>  'latios',
        ],
        [
            'identifier'        =>  'sableye-absol',
            'parent'            =>  null,
            'name'              =>  'Absolute Limitation',
            'icon_primary'      =>  'sableye',
            'icon_secondary'    =>  'absol',
        ],
        [
            'identifier'        =>  'wet-rat',
            'parent'            =>  'ratlock',
            'name'              =>  'Wet Rat',
            'icon_primary'      =>  'raticate',
            'icon_secondary'    =>  'crawdaunt',
        ],
        [
            'identifier'        =>  'burn-away',
            'parent'            =>  null,
            'name'              =>  '毎日BurnAway',
            'icon_primary'      =>  'blaziken',
            'icon_secondary'    =>  'mewtwo',
        ],
        [
            'identifier'        =>  'skamory-absol',
            'parent'            =>  null,
            'name'              =>  'Metal Gravity',
            'icon_primary'      =>  'skamory',
            'icon_secondary'    =>  'absol',
        ],
        [
            'identifier'        =>  'dragtrode-charizard',
            'parent'            =>  null,
            'name'              =>  'Klacztrdoe',
            'icon_primary'      =>  'dragonite',
            'icon_secondary'    =>  'charizard',
        ],
    ];
}