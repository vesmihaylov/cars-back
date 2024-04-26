<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Enum\FeatureType;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Uid\Uuid;

final class Version20240426125724 extends AbstractMigration
{
    const SECURITY_FEATURES = [
        '4x4',
        'ABS',
        'ESP',
        'Ксенонови фарове',
        'Халогенни фарове',
        'ASR/Тракшън контрол',
        'Парктроник',
        'Аларма',
        'Имобилайзер',
        'Центр. заключване',
        'Застраховка',
        'Брониран',
        'Старт-Стоп система',
        'Въздушни възглавници',
        'Сервизна книжка',
        'Сензор за дъжд',
        'GPS система за проследяване',
        'Адаптивни предни светлини',
        'Контрол на налягането на гумите',
        'Система за контрол на дистанцията',
        'Система за контрол на спускането',
        'Система за подпомагане на спирането'
    ];

    const COMFORT_FEATURES = [
        'Климатик',
        'Климатроник',
        'Кожен салон',
        'Ел.стъкла',
        'Ел.огледала',
        'Ел.седалки',
        'Подгряване на седалки',
        'Шибедах',
        'Стерео уредба',
        'DVD/TV',
        'Мултифункционален волан',
        'Безключово палене',
        'Панорамен покрив',
        'Печка',
        'Дълга база',
        'Хладилна жабка',
        'Система за контрол на скоростта',
        'Система за измиване на фаровете',
        'Подгряване на предното стъкло',
        'Отопление на волана',
        'Адаптивно въздушно окачване',
        'Bluetooth/Handsfree система',
        'USB, audio/video, IN/AUX изводи'
    ];

    const OTHER_FEATURES = [
        'Типтроник/Мултитроник',
        'Автопилот',
        'Серво управление',
        'Бордови компютър',
        'Навигационна система',
        'Теглич',
        'Алуминиеви джанти',
        'Тунинг',
        'Лебедка',
        'За хора с увреждания',
        'Бързи/бавни скорости',
        'Блокаж на диференциала'
    ];

    const CITIES = [
        'София',
        'Варна',
        'Пловдив',
        'Враца',
        'Бургас',
        'Дупница',
        'Стара Загора',
        'Монтана',
        'Хасково',
        'Русе',
        'Плевен',
        'Шумен',
        'Сливен',
        'Добрич',
        'Велико Търново',
        'Перник',
        'Пазарджик',
        'Габрово',
        'Благоевград',
        'Казанлък',
        'Силистра',
        'Разград',
        'Кюстендил',
        'Димитровград',
        'Търговище',
        'Кърджали',
        'Троян',
        'Видин',
        'Лясковец',
        'Петрич',
        'Гоце Делчев',
        'Ямбол',
        'Горна Оряховица',
        'Асеновград',
        'Провадия',
        'Елин Пелин',
        'Червен бряг',
        'Панагюрище',
        'Драгичево',
        'Айтос',
        'Карлово',
        'Смолян',
        'Свищов',
        'Карнобат',
        'Луковит',
        'Севлиево',
        'Първомайци',
        'Ловеч',
        'Велинград',
        'Нови пазар'
    ];

    const BRANDS = [
        'VW' => ['Amarok', 'Amarok DoubleCab', 'Arteon', 'Arteon SB', 'Atlas', 'Beetle', 'Bora', 'Buggy', 'Caddy', 'Caddy Kasten', 'Caddy Kombi', 'Caddy Life', 'Caddy Maxi Kasten', 'Caddy Maxi Kombi', 'Caddy Maxi Life', 'Caravelle', 'CC', 'Corrado', 'Country', 'Crafter', 'Eos', 'Fox', 'Golf', 'Golf Plus', 'Golf Sportsvan', 'Golf Variant', 'ID.3', 'ID.4', 'ID.5', 'Jetta', 'Karmann Ghia', 'LT', 'Lupo', 'Multivan', 'New Beetle', 'Passat', 'Passat Alltrack', 'Passat CC', 'Passat Variant', 'Phaeton', 'Polo', 'Santana', 'Scirocco', 'Sharan', 'T-Cross', 'T-Roc', 'T3', 'T4', 'T4 Caravelle', 'T5', 'T5 Caravelle', 'T5 Multivan', 'Taigo', 'Tiguan', 'Touareg', 'Touran', 'Transporter', 'up!', 'Vento'],
        'Mercedes-Benz' => ['0405', '110', '115', '123', '124', '126', '190', '200', '207', '210', '220', '230', '240', '250', '270', '280', '290', '300', '320', '350', '400', '420', '500', '508', '560', 'A 45 AMG', 'A', 'A 140', 'A 150', 'A 160', 'A 170', 'A 180', 'A 190', 'A 200', 'A 210', 'A 220', 'A 250', 'A 250 AMG', 'B', 'B 150', 'B 170', 'B 180', 'B 200', 'C 450', 'C', 'C 160', 'C 180', 'C 200', 'C 220', 'C 230', 'C 240', 'C 250', 'C 270', 'C 280', 'C 30 AMG', 'C 300', 'C 32 AMG', 'C 320', 'C 350', 'C 400', 'C 43 AMG', 'C 63 AMG', 'CE 220', 'Citan', 'CL 180', 'CL 220', 'CL 420', 'CL 500', 'CL 55 AMG', 'CL 600', 'CL 63 AMG', 'CL 65 AMG', 'CLA', 'CLA 220', 'CLA 45 AMG', 'CLC 180', 'CLC 200', 'CLC 220', 'CLC 230', 'CLK 200', 'CLK 220', 'CLK 230', 'CLK 240', 'CLK 270', 'CLK 280', 'CLK 320', 'CLK 350', 'CLK 430', 'CLK 500', 'CLK 55 AMG', 'CLS', 'CLS 250', 'CLS 280', 'CLS 320', 'CLS 350', 'CLS 400', 'CLS 450', 'CLS 500', 'CLS 53 AMG', 'CLS 55 AMG', 'CLS 63 AMG', 'E 200', 'E 220', 'E 230', 'E 240', 'E 250', 'E 260', 'E 270', 'E 280', 'E 290', 'E 300', 'E 320', 'E 350', 'E 36 AMG', 'E 400', 'E 420', 'E 43 AMG', 'E 430', 'E 450', 'E 50', 'E 500', 'E 53 AMG', 'E 55', 'E 63 AMG', 'EQA', 'EQB', 'EQC', 'EQE', 'EQS', 'EQV', 'G', 'G 240', 'G 270', 'G 280', 'G 300', 'G 320', 'G 350', 'G 400', 'G 500', 'G 55 AMG', 'G 550', 'G 63 AMG', 'GL', 'GL 320', 'GL 350', 'GL 420', 'GL 450', 'GL 500', 'GL 55 AMG', 'GL 550', 'GL 63 AMG', 'GLA', 'GLB', 'GLC', 'GLE', 'GLK', 'GLK 200', 'GLK 220', 'GLK 250', 'GLK 280', 'GLK 320', 'GLK 350', 'GLS', 'GT', 'GTR', 'GTS', 'ML 300', 'ML', 'ML 230', 'ML 250', 'ML 270', 'ML 280', 'ML 320', 'ML 350', 'ML 400', 'ML 420', 'ML 430', 'ML 450', 'ML 500', 'ML 55 AMG', 'ML 63 AMG', 'R', 'R 280', 'R 320', 'R 350', 'R 500', 'S', 'S 280', 'S 300', 'S 320', 'S 350', 'S 400', 'S 420', 'S 430', 'S 450', 'S 500', 'S 55', 'S 550', 'S 560', 'S 580', 'S 600', 'S 63 AMG', 'S 65 AMG', 'S 650', 'SL 280', 'SL 300', 'SL 320', 'SL 350', 'SL 420', 'SL 450', 'SL 500', 'SL 55 AMG', 'SL 560', 'SL 63 AMG', 'SLK', 'SLK 200', 'SLK 230', 'SLK 250', 'SLK 320', 'SLK 350', 'Sprinter', 'V 220', 'V 230', 'V 250', 'Vaneo', 'Viano', 'Vito', 'W123', 'W124', 'X 250'],
        'BMW' => ['114', '116', '118', '120', '123', '125', '128', '130', '135', '2 Gran Tourer', '216', '218', '220', '225i', '225xe', '228', '230i', '3 Gran Turismo', '315', '316', '318', '320', '323', '324', '325', '328', '330', '335', '340', '420', '428', '430', '435', '435i', '440i', '5 Gran Turismo', '518', '520', '523', '524', '525', '528', '530', '535', '540', '545', '550', '620d', '630', '635', '640', '645', '650', '725', '728', '730', '735', '740', '745', '750', '750IL', '760', '840', '850', 'Bertone', 'Gran Coupe', 'i3', 'i4', 'i7', 'i8', 'iX', 'iX3', 'M135i', 'M235i', 'M3', 'M4', 'M5', 'M6', 'M8', 'X5 M', 'X6 M', 'Z3 M', 'X1', 'X2', 'X3', 'X4', 'X5', 'X6', 'X7', 'Z1', 'Z3', 'Z4'],
        'Audi' => ['100', '200', '80', '90', 'A1', 'A1 Sportback', 'A2', 'A3', 'A3 Sportback', 'A4', 'A4 Allroad', 'A4 Avant', 'A5', 'A5 Sportback', 'A6', 'A6 Allroad', 'A6 Avant', 'A7', 'A7 Sportback', 'A8', 'Allroad', 'E-tron', 'E-tron Sportback', 'Q2', 'Q3', 'Q3 Sportback', 'Q4 e-tron', 'Q4 Sportback e-tron', 'Q5', 'Q5 Sportback', 'Q7', 'Q8', 'R8', 'RS3', 'RS3 Sportback', 'RS4', 'RS5', 'RS6', 'RS6 Avant', 'RS7', 'RS7 Sportback', 'RSQ3', 'RSQ8', 'S2', 'S3', 'S3 Sportback', 'S4', 'S4 Avant', 'S5', 'S5 Sportback', 'S6', 'S7', 'S7 Sportback', 'S8', 'SQ5', 'SQ7', 'SQ8', 'TT', 'TT Roadster', 'TTS'],
        'Opel' => ['Adam', 'Agila', 'Ampera', 'Ampera-e', 'Antara', 'Arena', 'Ascona', 'Astra', 'Calibra', 'Campo', 'Cascada', 'Combo', 'Corsa', 'Crossland X', 'Frontera', 'Grandland X', 'GT', 'Insignia', 'Kadett', 'Karl', 'Manta', 'Meriva', 'Mokka', 'Monterey', 'New Meriva', 'Omega', 'Rekord', 'Rocks-e', 'Senator', 'Signum', 'Sintra', 'Tigra', 'Vectra', 'Vivaro', 'Zafira', 'Zafira Tourer'],
        'Peugeot' => ['1007', '104', '106', '107', '108', '2008', '204', '205', '206', '206 CC', '206 Plus', '207', '207 CC', '207 SW', '208', '3008', '301', '305', '306', '307', '307 CC', '307 SW', '308', '308 CC', '308 SW', '309', '4007', '4008', '404', '405', '406', '407', '408', '5008', '504', '505', '508', '508 RXH', '508 SW', '604', '605', '607', '806', '807', 'Bipper', 'Boxer', 'Expert', 'iOn', 'Partner', 'Ranch', 'RCZ', 'Rifter', 'Traveller'],
        'Toyota' => ['4-Runner', 'Auris', 'Avensis', 'Avensis Verso', 'Aygo', 'C-HR', 'Camry', 'Carina', 'Celica', 'Corolla', 'Corolla Verso', 'Crown', 'FJ', 'GT86', 'Hiace', 'Highlander', 'Hilux', 'IQ', 'Land Cruiser', 'MR 2', 'Paseo', 'Picnic', 'Previa', 'Prius', 'Prius+', 'Proace', 'RAV 4', 'Scion', 'Sequoia', 'Sienna', 'Soarer', 'Starlet', 'Supra', 'Tacoma', 'Tercel', 'Tundra', 'Urban Cruiser', 'Venza', 'Verso', 'Verso-S', 'Yaris'],
        'Renault' => ['11', '19', '21', '25', '30', '4', '5', '9', 'Arkana', 'Avantime', 'Captur', 'Chamade', 'Clio', 'Espace', 'Express', 'Fluence', 'Grand Espace', 'Grand Modus', 'Grand Scenic', 'Kadjar', 'Kangoo', 'Koleos', 'Laguna', 'Latitude', 'Master', 'Megane', 'Modus', 'Rapid', 'Safrane', 'Scenic', 'Symbol', 'Talisman', 'Trafic', 'Twingo', 'Twizy', 'Vel Satis', 'Wind', 'Zoe'],
        'Ford' => ['B-Max', 'Bronco', 'C-Max', 'Connect', 'Cougar', 'Courier', 'Econoline', 'EcoSport', 'Edge', 'Escape', 'Escort', 'Expedition', 'Explorer', 'F 150', 'F 250', 'F 350', 'Fiesta', 'Focus', 'Focus C-Max', 'Fusion', 'Galaxy', 'Granada', 'Ka', 'Kuga', 'Maverick', 'Mondeo', 'Mustang', 'Orion', 'Probe', 'Puma', 'Ranger', 'S-Max', 'Scorpio', 'Sierra', 'Streetka', 'Taunus', 'Taurus', 'Thunderbird', 'Tourneo', 'Transit', 'Windstar'],
        'Citroen' => ['2 CV', 'AX', 'Berlingo', 'BerlingoFT', 'BX', 'C-Crosser', 'C-Elysee', 'C-Zero', 'C1', 'C15', 'C2', 'C3', 'C3 Aircross', 'C3 Picasso', 'C4', 'C4 Aircross', 'C4 Cactus', 'C4 NEW', 'C4 Picasso', 'C5', 'C5 Aircross', 'C5 NEW', 'C6', 'C8', 'CX', 'DS', 'DS 7 Crossback', 'DS3', 'DS4', 'DS5', 'DS7', 'Evasion', 'Grand C4 Picasso', 'Jumper', 'Jumper II', 'Jumpy', 'Jumpy II', 'Nemo', 'SAXO', 'Spacetourer', 'Visa', 'Xantia', 'XM', 'Xsara', 'Xsara Picasso', 'ZX'],
        'Nissan' => ['100 NX', '200 SX', '300 ZX', '350 Z', '370 Z', 'Almera', 'Almera Tino', 'Altima', 'Armada', 'Bluebird', 'Cherry', 'Cube', 'Frontier', 'GTR', 'Juke', 'King Cab', 'Kubistar', 'Leaf', 'Maxima', 'Micra', 'Murano', 'Navara', 'Note', 'NP300', 'NV 200', 'Pathfinder', 'Patrol', 'PickUP', 'Pixo', 'Prairie', 'Primastar', 'Primera', 'Pulsar', 'Qashqai', 'Qashqai+2', 'Quest', 'Rogue', 'Serena', 'Skyline', 'Sunny', 'Terrano', 'Tiida', 'Titan', 'Trade', 'Vanette', 'X-Terra', 'X-Trail'],
        'Honda' => ['Accord', 'Aerodeck', 'Civic', 'Concerto', 'CR-V', 'CR-Z', 'CRX', 'e', 'FR-V', 'HR-V', 'Insight', 'Integra', 'Jazz', 'Legend', 'Logo', 'Odyssey', 'Pilot', 'Prelude', 'Ridgeline', 'S2000', 'Shuttle', 'Stream'],
        'Fiat' => ['125', '126', '131', '500', '500L', '500X', '595C', 'Albea', 'Barchetta', 'Brava', 'Bravo', 'Campagnola', 'Cinquecento', 'Coupe', 'Croma', 'Dino', 'Doblo', 'Ducato', 'Fiorino', 'Freemont', 'Fullback', 'Grande Punto', 'Idea', 'Linea', 'Marea', 'Multipla', 'Palio', 'Panda', 'Punto', 'Qubo', 'Regata', 'Ritmo', 'Scudo', 'Sedici', 'Seicento', 'Stilo', 'Strada', 'Tempra', 'Tipo', 'Ulysse', 'Uno'],
        'Mazda' => ['121', '2', '3', '323', '5', '5 NEW', '6', '6 NEW', '626', '929', 'B series', 'BT-50', 'CX 3', 'CX 30', 'CX 5', 'CX 7', 'CX 9', 'Demio', 'MPV', 'MX-3', 'MX-5', 'MX-6', 'Premacy', 'RX-8', 'Tribute', 'Xedos'],
        'Skoda' => ['105', '120', '130', 'Citigo', 'Enyaq', 'Fabia', 'Favorit', 'Felicia', 'Forman', 'Kamiq', 'Karoq', 'Kodiaq', 'Octavia', 'Pick-up', 'Praktik', 'Rapid', 'Roomster', 'Scala', 'Superb', 'Yeti'],
        'Hyundai' => ['Accent', 'Atos', 'Bayon', 'Coupe', 'Elantra', 'Galloper', 'Genesis', 'Getz', 'Grand Santa Fe', 'Grandeur', 'H 100', 'H 200', 'H-1', 'H-1 Starex', 'i10', 'i20', 'i30', 'i30 CW', 'i40', 'Ioniq', 'ix20', 'ix35', 'ix55', 'Kona', 'Lantra', 'Matrix', 'Palisade', 'Pony', 'S-Coupe', 'Santa Fe', 'Santamo', 'Sonata', 'Terracan', 'Trajet', 'Tucson', 'Veloster', 'Veracruz', 'XG 30', 'XG 350'],
        'Seat' => ['Alhambra', 'Altea', 'Arona', 'Arosa', 'Ateca', 'Cordoba', 'Exeo', 'Ibiza', 'Inca', 'Leon', 'Leon ST', 'Marbella', 'Mii', 'Tarraco', 'Terra', 'Toledo', 'Vario'],
        'Mitsubishi' => ['ASX', 'Carisma', 'Challenger', 'Colt', 'Eclipse', 'Eclipse Cross', 'Galant', 'Grandis', 'i-MiEV', 'L200', 'L300', 'Lancer', 'Mirage', 'Montero', 'Outlander', 'Pajero', 'Pajero Pinin', 'Pajero Sport', 'Space Gear', 'Space Runner', 'Space Star', 'Space Wagon', 'Аttrage'],
        'Kia' => ['Avella Delta', 'Cadenza', 'Carens', 'Carnival', 'Ceed', 'Cerato', 'Clarus', 'Elan', 'Forte', 'Joice', 'K 5', 'K 7', 'K2900', 'Magentis', 'Mohave', 'Niro', 'Opirus', 'Optima', 'Picanto', 'Pride', 'pro_ceed', 'Retona', 'Rio', 'Sedona', 'Sephia', 'Shuma', 'Sorento', 'Soul', 'Spectra', 'Sportage', 'Stinger', 'Stonic', 'Venga', 'XCeed'],
        'Suzuki' => ['Alto', 'Baleno', 'Cappuccino', 'Celerio', 'Grand Vitara', 'Ignis', 'Jimny', 'Kizashi', 'Liana', 'Maruti', 'SJ Samurai', 'Splash', 'Swace', 'Swift', 'SX4', 'SX4 S-Cross', 'Vitara', 'Wagon R+', 'X-90', 'XL7'],
        'Volvo' => ['144', '240', '340', '440', '460', '480', '740', '850', '940', '960', 'Amazon', 'C30', 'C70', 'Polar', 'S40', 'S60', 'S70', 'S80', 'S90', 'V40', 'V50', 'V60', 'V70', 'V90', 'XC 40', 'XC 60', 'XC 70', 'XC 90'],
        'Subaru' => ['B9 Tribeca', 'Baja', 'BRZ', 'Forester', 'Impreza', 'Justy', 'Legacy', 'Levorg', 'Libero', 'OUTBACK', 'SVX', 'Trezia', 'Vivio', 'WRX', 'XT', 'XV'],
        'Dacia' => ['1310', 'Dokker', 'Duster', 'Lodgy', 'Logan', 'Pick Up', 'Sandero', 'Solenza', 'Spring'],
        'Alfa Romeo' => ['145', '146', '147', '155', '156', '156 Sportwagon', '159', '159 SW', '164', '166', '33', 'Alfetta', 'Arna', 'Brera', 'Crosswagon', 'Giulia', 'Giulietta', 'GT', 'GTV', 'MiTo', 'Spider', 'Stelvio', 'Tonale'],
        'Chevrolet' => ['2500', 'Alero', 'Aveo', 'Blazer', 'Camaro', 'Captiva', 'Cavalier', 'Chevelle', 'Cobalt', 'Corvette', 'Cruze', 'Epica', 'Equinox', 'Evanda', 'HHR', 'Impala', 'Kalos', 'Lacetti', 'Malibu', 'Matiz', 'Nubira', 'Orlando', 'Rezzo', 'Silverado', 'Spark', 'Suburban', 'Tacuma', 'Tahoe', 'Trailblazer', 'Trans Sport', 'Trax', 'Venture', 'Volt'],
        'Land Rover' => ['Defender', 'Discovery', 'Discovery 3', 'Discovery Sport', 'Freelander', 'Land Rover I', 'Land Rover II', 'Land Rover III', 'Range Rover', 'Range Rover Evoque', 'Range Rover Sport', 'Range Rover Vogue', 'Velar'],
        'Jeep' => ['Cherokee', 'Commander', 'Compass', 'Grand Cherokee', 'Liberty', 'Patriot', 'Renegade', 'Wrangler'],
        'Mini' => ['Clubman', 'Cooper', 'Cooper S', 'Countryman', 'John Cooper Works', 'ONE', 'Paceman'],
        'Chrysler' => ['300 M', '300C', 'Crossfire', 'Grand Voyager', 'Le Baron', 'Neon', 'Pacifica', 'PT Cruiser', 'Saratoga', 'Sebring', 'Stratus', 'Vision', 'Voyager'],
        'Lancia' => ['Beta', 'Dedra', 'Delta', 'Flavia', 'Kappa', 'Lybra', 'MUSA', 'Phedra', 'Thema', 'Thesis', 'Voyager', 'Y', 'Ypsilon', 'Zeta'],
        'Daihatsu' => ['Applause', 'Charade', 'Copen', 'Cuore', 'Feroza/Sportrak', 'Gran Move', 'Hijet', 'MATERIA', 'Move', 'Rocky/Fourtrak', 'Sirion', 'Terios', 'TREVIS', 'YRV'],
        'Ssangyong' => ['Actyon', 'Korando', 'Kyron', 'MUSSO', 'REXTON', 'Rodius', 'TIVOLI', 'XLV'],
        'Porsche' => ['911', '924', '944', '991', 'Boxster', 'Boxter S', 'Carrera', 'Carrera GT', 'Cayenne', 'Cayman', 'Macan', 'Panamera', 'Taycan'],
        'Jaguar' => ['Daimler', 'E Type', 'E-Pace', 'F Type', 'F-Pace', 'I-Pace', 'S Type', 'X Type', 'XE', 'XF', 'XJ', 'XJ12', 'XJ40', 'XJ6', 'XJ8', 'XJS', 'XK', 'XKR'],
        'Smart' => ['ForFour', 'ForTwo', 'Mc', 'Micro', 'Roadster'],
        'Lada' => ['1200', '1300', '1500', '1600', '2101', '21011', '21013', '2102', '2103', '2104', '2105', '2106', '21061', '2107', '2108', '21093', '21099', '2110', '21213', 'Kalina', 'Niva', 'Oka', 'Priora', 'Samara', 'Vesta'],
        'Lexus' => ['CT 200h', 'GS300', 'GS350', 'GS430', 'GS450', 'IS200', 'IS220', 'IS250', 'IS300', 'LS400', 'LS430', 'LS500', 'LS600', 'LX450', 'LX570', 'NX200', 'NX300', 'RX300', 'RX330', 'RX350', 'RX400', 'RX400h', 'RX450', 'SC430', 'UX'],
        'Rover' => ['115', '200', '214', '216', '25', '400', '414', '416', '420', '45', '600', '618', '620', '75', '820', '825', 'Streetwise', 'ZT'],
        'Saab' => ['9-3', '9-3x', '9-5', '9-7X', '900', '9000', '99'],
        'Daewoo' => ['Damas', 'Espero', 'Evanda', 'FSO', 'Kalos', 'Korando', 'Lacetti', 'Lanos', 'Leganza', 'Magnus', 'Matiz', 'Musso', 'Nexia', 'Nubira', 'Rezzo', 'Tacuma', 'Tico'],
        'Dodge' => ['Avenger', 'Caliber', 'Challenger', 'Charger', 'Dakota', 'Dart', 'Durango', 'Grand Caravan', 'Journey', 'Magnum', 'Nitro', 'RAM', 'Shadow', 'Stealth', 'Stratus'],
        'Infiniti' => ['EX', 'FX', 'G35', 'G37', 'M', 'Q30', 'Q45', 'Q50', 'Q60', 'Q70', 'QX30', 'QX50', 'QX56', 'QX60', 'QX70', 'QX80'],
        'Isuzu' => ['Campo', 'D-Max', 'PICK UP', 'Rodeo', 'Trooper'],
        'Tesla' => ['Model 3', 'Model S', 'Model X', 'Model Y'],
        'Great wall' => ['C20 R', 'C30', 'Haval H6', 'Hover Cuv', 'Hover H3', 'Hover H5', 'Hover H6', 'Safe', 'Steed', 'Steed 5', 'Voleex C10', 'Voleex C30'],
        'Range Rover' => ['Discovery 4', 'Evoque', 'Freelander 2', 'Range Rover', 'Sport'],
        'UAZ' => ['452', '469', '69', 'Patriot'],
        'Cadillac' => ['BLC', 'BLS', 'CTS', 'Deville', 'Eldorado', 'Escalade', 'Fleetwood', 'Seville', 'SRX', 'STS', 'XLR', 'XT5', 'XT6'],
        'Moskvich' => ['1360', '2140', '2141', '21412', '403', '407', '408', '412', 'Aleko', 'Иж'],
        'Tata' => ['Aria', 'Indica', 'Indigo', 'Safari', 'Telcoline', 'Xenon'],
        'Trabant' => ['600', '601', 'Combi'],
        'DR' => ['1', '2', '3', '5'],
        'DS' => ['DS 3', 'DS 4', 'DS 5', 'DS 7 Crossback'],
        'Maserati' => ['Ghibli', 'GranCabrio', 'Granturismo S', 'Grecale', 'Levante', 'Quattroporte', 'Quattroporte S', 'Quattroporte Sport GT S'],
        'Wartburg' => ['1.3', '311', '353'],
        'MG' => ['MGB', 'MGF', 'TF', 'ZR', 'ZS', 'ZT'],
        'Lincoln' => ['Aviator', 'Mark', 'MKZ', 'Navigator', 'Town Car'],
        'GAZ' => ['13 ЧАЙКА', '69'],
        'Volga' => ['24', 'M 21'],
        'Hummer' => ['H1', 'H2', 'H3'],
        'Acura' => ['MDX', 'RDX', 'RL', 'RSX', 'TL'],
        'Bentley' => ['Arnage', 'Bentayga', 'Continental', 'Flying Spur', 'Mulsanne', 'T1'],
        'Pontiac' => ['Bonneville', 'Fiero', 'Firebird', 'Grand-Am', 'Trans Sport'],
        'Mahindra' => ['Bolero', 'GOA', 'XUV'],
        'Zaz' => ['965', '966', '968', 'Tavria'],
        'Aston Martin' => ['DB11', 'DB9', 'DBS', 'DBX', 'V8 Vantage'],
        'ВАЗ' => ['21213'],
        'Haval' => ['Dargo', 'H2', 'H6', 'Jolion'],
        'Zastava' => ['750', 'Gt 55'],
        'Ferrari' => ['208', '308', '458', '488', 'F8', 'Portofino'],
        'Rolls Royce' => ['Cullinan', 'Ghost', 'Silver Cloud', 'Silver Spur', 'Silver Wraith'],
        'Lamborghini' => ['Aventador', 'Huracan', 'Urus'],
        'Iveco' => ['35c13', '35s13', 'Daily', 'Massif'],
        'Aro' => ['244', '461'],
        'Варшава' => ['223'],
        'Landwind' => ['Jx6476da'],
        'Buick' => ['Century', 'Enclave', 'Encore'],
        'Simca' => ['Vedette'],
        'GMC' => ['Safari', 'Terrain', 'Yukon'],
        'Yogomo' => ['MA'],
        'Datsun' => ['Bluebird'],
        'Tempo' => ['Traveller 2.4 D'],
        'Asia Motors' => ['Rocsta'],
        'LDV' => ['Maxus'],
        'София' => ['С'],
        'Maybach' => ['62'],
        'Microcar' => ['M.GO'],
        'STOEWER' => ['1939'],
        'Oldsmobile' => ['Cutlass'],
        'Barkas' => ['1000'],
        'Talbot' => ['1100'],
        'Austin' => ['Princess'],
        'McLaren' => ['600'],
        'Scion' => ['tC'],
        'Triumph' => ['Spitfire'],
        'Plymouth' => ['Prowler'],
        'Aixam' => ['400'],
        'Shuanghuan' => ['Ceo']
    ];

    public function getDescription(): string
    {
        return 'Add predefined data to main tables.';
    }

    public function up(Schema $schema): void
    {
        // Populate brands & models for each brand
        foreach (self::BRANDS as $name => $models) {
            $brandId = Uuid::v4();
            $this->addSql('INSERT INTO "brands" (id, name) VALUES (:id, :name)', [$brandId, $name]);
            foreach ($models as $model) {
                $this->addSql('INSERT INTO "brand_models" (id, brand_id, name) VALUES (:id, :brand_id, :name)', [Uuid::v4(), $brandId, $model]);
            }
        }

        // Security features
        foreach (self::SECURITY_FEATURES as $securityFeature) {
            $this->addSql('INSERT INTO "features" (id, name, type) VALUES (:id, :name, :type)', [Uuid::v4(), $securityFeature, FeatureType::SECURITY->name]);
        }

        // Comfort features
        foreach (self::COMFORT_FEATURES as $comfortFeature) {
            $this->addSql('INSERT INTO "features" (id, name, type) VALUES (:id, :name, :type)', [Uuid::v4(), $comfortFeature, FeatureType::COMFORT->name]);
        }

        // Other features
        foreach (self::OTHER_FEATURES as $otherFeature) {
            $this->addSql('INSERT INTO "features" (id, name, type) VALUES (:id, :name, :type)', [Uuid::v4(), $otherFeature, FeatureType::OTHER->name]);
        }

        foreach (self::CITIES as $city) {
            $this->addSql('INSERT INTO "cities" (id, name) VALUES (:id, :name)', [Uuid::v4(), $city]);
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE "features"');
        $this->addSql('TRUNCATE TABLE "cities"');
        $this->addSql('TRUNCATE TABLE "brand_models"');
        $this->addSql('TRUNCATE TABLE "brands"');
    }
}
