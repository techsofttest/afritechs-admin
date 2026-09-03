<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        PageContent::updateOrCreate(
            ['key' => 'about'],
            [
                'title' => 'À Propos de Nous - Afri-techs',
                'meta_title' => 'À Propos de Nous | Afri-techs SARLU',
                'meta_desc' => 'Découvrez l\'histoire, les valeurs, la mission et l\'équipe dirigeante d\'Afri-techs SARLU.',
                'content' => [
                    'hero' => [
                        'title' => "À Propos de Nous\nAbout Afri-techs",
                        'subtitle' => "Découvrez nos valeurs, notre équipe dirigeante\net nos engagements.",
                        'image' => '/banner/about-page.png',
                    ],
                    'profile' => [
                        'section_title' => "Profil de l'Entreprise",
                        'heading' => "Bienvenue chez Afri-techs",
                        'p1' => "Nous fournissons de nombreux services dans les secteurs automobile et agricole. Nos activités sont concentrées en République de Guinée et aux Émirats Arabes Unis. Nous nous engageons à vous offrir le meilleur de nos services, avec un accent particulier sur la fiabilité, le service client et l'originalité.",
                        'p2' => "Fondée en 2015 par M. Arun, Afri-techs a parcouru un long chemin depuis ses débuts en République de Guinée. Nous servons désormais des clients dans toute la République de Guinée. Nous espérons que vous apprécierez nos produits autant que nous aimons vous les proposer. Si vous avez des questions ou des commentaires, n'hésitez pas à nous contacter.",
                        'image' => '/about/v-r.png',
                    ],
                    'mission_vision' => [
                        'section_title' => 'Mission & Vision',
                        'mission_tag' => 'Notre Mission',
                        'mission_title' => 'Quality & Cost Effective Service',
                        'mission_desc' => 'Our mission is to provide Quality & Cost Effective End-to-End Service, thereby achieving our target of Customer Satisfaction to a greater extent.',
                        'vision_tag' => 'Notre Vision',
                        'vision_title' => 'Globally Recognized Brand',
                        'vision_desc' => 'To achieve year-on-year growth by being a globally recognized brand and the partner of choice for providing complete Agricultural and Automotive solutions.',
                    ],
                    'values' => [
                        'section_title' => 'Nos Valeurs Fondamentales',
                        'items' => [
                            [
                                'icon' => 'dependability',
                                'title' => 'Dependability',
                                'desc' => 'Un engagement constant de fiabilité envers nos partenaires agricoles et automobiles.',
                            ],
                            [
                                'icon' => 'satisfaction',
                                'title' => 'Customer Satisfaction',
                                'desc' => 'Placer le client au centre de notre processus logistique et technique.',
                            ],
                            [
                                'icon' => 'uniqueness',
                                'title' => 'Uniqueness',
                                'desc' => "Des offres sur-mesure et adaptées aux réalités géographiques de l'Afrique de l'Ouest.",
                            ],
                            [
                                'icon' => 'cost',
                                'title' => 'Cost Effectiveness',
                                'desc' => 'Optimiser les coûts pour garantir un rapport qualité-prix sans précédent.',
                            ],
                        ],
                    ],
                    'chairman' => [
                        'section_title' => "Chairman's Message",
                        'heading' => "Guider Afri-techs vers l'avenir",
                        'quote' => "Depuis la fondation d'Afri-techs en 2015, notre ambition a toujours été de construire un pont d'excellence industrielle entre la Guinée, les Émirats Arabes Unis et les marchés mondiaux. En apportant des solutions complètes de mécanisation agricole et d'automobile aux communautés locales, nous permettons aux entreprises de prospérer et de réaliser une croissance durable.",
                        'name' => 'Mr. Arun',
                        'role' => 'Fondateur & Président, Afri-techs',
                        'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80',
                    ],
                    'team' => [
                        'section_title' => 'Équipe Dirigeante',
                        'members' => [
                            [
                                'name' => 'Mr. Arun',
                                'role' => 'Fondateur & Président',
                                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80',
                            ],
                            [
                                'name' => 'Aissatou Diallo',
                                'role' => 'Directrice Opérationnelle - Guinée',
                                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80',
                            ],
                            [
                                'name' => 'Rajesh Kumar',
                                'role' => 'Responsable Logistique & UAE',
                                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80',
                            ],
                            [
                                'name' => 'Mariama Sylla',
                                'role' => 'Directrice Administrative & Financière',
                                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
                            ],
                        ],
                    ],
                    'governance' => [
                        'section_title' => "Gouvernance d'Entreprise",
                        'desc' => "Chez Afri-techs, nous croyons qu'une gouvernance solide est la clé pour bâtir la confiance avec nos partenaires, nos investisseurs et les communautés que nous servons.",
                    ],
                    'quality_security' => [
                        'quality_title' => 'Politique Qualité',
                        'quality_desc' => 'Nos produits et équipements respectent scrupuleusement les normes internationales de sécurité et de performance.',
                        'hse_title' => 'Sécurité & Environnement (HSE)',
                        'hse_desc' => 'Engagement absolu pour la sécurité de nos équipes et la préservation environnementale dans toutes nos zones d\'intervention.',
                    ],
                    'csr' => [
                        'title' => 'Responsabilité Sociale & Environnementale',
                        'desc' => 'Au-delà de nos activités commerciales, nous investissons activement dans l\'autonomisation des communautés rurales, le soutien à la jeunesse et le transfert de compétences technologiques en République de Guinée.',
                    ],
                ],
            ]
        );
    }
}
