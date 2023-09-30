<?php
namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Product;
use App\Entity\Producer;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class SeedProducts extends Command
{

	private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

	protected function configure(): void
    {
        $this->setName('seed-products')
		->setDescription('This command adds products to db')
		->setHelp('Run this command to add products to db');
    }

	protected function seedProducts() : void
    {
        $products = array(
		array(
			'name' => 'Tłok 87-114900-30',
			'price' => 467,26,
			'quantity' => 1,
			'features' => ['Długość 60,8mm','Otwór o średnicy 79,5mm', 'Sworzeń o średnicy 24mm'],
			'sku' => 2,
			'images' => ['images/parts/part1.jpg'],
			'compareAtPrice' => 810,99,
			'category'=> 'części',
			'producer'=> 'agco',
			'visited' => 100,
			'sold' => 15,
			'addedDate' => new \DateTime('2023-09-02 12:00:00'),
			'promotion' => true,
			'longDescription' => "Z dumą prezentujemy nasz nowoczesny tłok, który spełni wszystkie Twoje oczekiwania i potrzeby. Nasz tłok to produkt najwyższej jakości, stworzony z myślą o profesjonalistach oraz pasjonatach mechaniki. Oferujemy niezawodność i trwałość, które pozwalają Ci zrealizować nawet najbardziej wymagające projekty.\n
			Wykonany z wysokiej jakości materiałów: Nasz tłok został precyzyjnie wykonany z najwyższej jakości stopów metalu, co gwarantuje jego niezawodność i trwałość.\n
			Doskonała wydajność: Nasz tłok został zaprojektowany z myślą o maksymalnej wydajności. Dzięki temu zyskujesz więcej mocy i osiągi, niezależnie od zastosowania.\n
			Precyzyjne wykonanie: Nasza firma stawia na dokładność i precyzję w produkcji. Każdy tłok jest starannie przetestowany i zaprojektowany tak, aby spełniał najwyższe standardy jakości.",
			'shortDescription' => 'Nasz tłok to gwarancja niezawodności i wydajności. Wykonany z najwyższej jakości materiałów, zapewni Ci maksymalną moc i trwałość. Dla profesjonalistów i pasjonatów mechaniki. Wybierz jakość i inwestuj w najlepszy tłok na rynku!'
		),
		array(
			'name' => 'Gaźnik DPR Classic Simson SR2 NKJ 123-4',
			'price' => 116,95,
			'quantity' => 5,
			'features' => ['Towar jest fabrycznie nowy','Symbol MF28916', 'Zastosowanie w pojazdach Simson'],
			'sku' => 3,
			'images' => ['images/parts/part2.jpg'],
			'compareAtPrice' => 225,99,
			'category'=> 'części',
			'producer'=> 'arbos',
			'visited' => 12,
			'sold' => 13,
			'addedDate' => new \DateTime('2023-09-11 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasz gaźnik to produkt, który przedefiniuje wydajność i niezawodność Twojego Simsona. Nasza konstrukcja łączy w sobie zaawansowaną technologię z materiałami najwyższej jakości, zapewniając doskonałe rezultaty w każdych warunkach. Dzięki naszemu gaźnikowi zyskasz pełną kontrolę nad pracą silnika, jednocześnie oszczędzając paliwo i zwiększając moc. Prosty montaż sprawia, że możesz cieszyć się jego zaletami już dziś. Wybierz nasz gaźnik i odkryj, jakie możliwości kryją się w Twoim Simsonie.',
			'shortDescription' => 'Nasz gaźnik to klucz do doskonałej kontroli nad silnikiem Simsona. Wydajność, niezawodność i łatwy montaż - to wszystko znajdziesz w naszym produkcie. Wybierz najlepszy gaźnik dla swojego Simsona już teraz!'
		),
		array(
			'name' => 'Chłodnica silnika NISSENS 68001A',
			'price' => 880,54,
			'quantity' => 12,
			'features' => ['Wysokość 608mm','Szerokość 359mm', 'Grubość 26mm'],
			'sku' => 4,
			'images' => ['images/parts/part3.jpg'],
			'compareAtPrice' => 1200,99,
			'category'=> 'części',
			'producer'=> 'case',
			'visited' => 55,
			'sold' => 27,
			'addedDate' => new \DateTime('2023-09-20 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasza chłodnica silnika to esencja niezawodności i efektywności, która zadba o optymalną temperaturę Twojego silnika. Wykonana z wysokiej jakości materiałów i starannie zaprojektowana, ta chłodnica to klucz do dłuższego i bardziej wydajnego życia Twojego pojazdu. Dzięki niej możesz zapomnieć o przegrzewaniu się silnika, a jednocześnie oszczędzać paliwo. Montaż jest prosty i intuicyjny, co sprawia, że możesz cieszyć się jej korzyściami praktycznie od razu. Odkryj, jak nasza chłodnica silnika może zrewolucjonizować pracę Twojego pojazdu i zainwestuj w niezawodność oraz komfort jazdy już teraz.',
			'shortDescription' => 'Nasza chłodnica silnika to gwarancja optymalnej temperatury silnika i niezawodności. Wydajność i prosty montaż - wybierz naszą chłodnicę i ciesz się spokojem podczas każdej jazdy!'
		),
		array(
			'name' => 'Amortyzator SACHS 310 842',
			'price' => 334,55,
			'quantity' => 4,
			'features' => ['Sposób mocowania amortyzatora: dolne oko/górny trzon','Długość 364mm', 'Gazowy'],
			'sku' => 5,
			'images' => ['images/parts/part4.jpg'],
			'compareAtPrice' => 899,66,
			'category'=> 'części',
			'producer'=> 'cat',
			'visited' => 315,
			'sold' => 88,
			'addedDate' => new \DateTime('2023-06-15 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasz amortyzator to klucz do lepszej kontroli i komfortu na drodze. Zaprojektowany z myślą o pasjonatach motoryzacji, nasz produkt redefiniuje jakość jazdy. Wykorzystujemy najnowsze technologie i najwyższej jakości materiały, aby zapewnić Ci niezawodność i trwałość. Nasz amortyzator dostosowuje się do zmieniających się warunków terenowych, zapewniając gładką i stabilną jazdę. Dzięki niemu masz pewność, że Twój pojazd zawsze będzie gotów do pokonywania każdej trasy. Wybierz nasz amortyzator i poczuj różnicę, jaką może przynieść w Twojej jeździe.',
			'shortDescription' => 'Nasz amortyzator to gwarancja lepszej kontroli i komfortu na drodze. Niezawodność i dostosowanie do warunków terenowych - to wszystko znajdziesz w naszym produkcie. Wybierz najlepszy amortyzator dla swojego pojazdu i ciesz się wyjątkowym komfortem jazdy!'
		),
		array(
			'name' => 'Massey Ferguson dysza wtryskiwacza',
			'price' => 130,00,
			'quantity' => 15,
			'features' => ['BDN12SPC6290','TYP CIĄGNIKA 35'],
			'sku' => 6,
			'images' => ['images/parts/part5.jpg'],
			'compareAtPrice' => 315,22,
			'category'=> 'części',
			'producer'=> 'claas',
			'visited' => 66,
			'sold' => 115,
			'addedDate' => new \DateTime('2023-06-17 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasza dysza wtryskiwacza to kluczowy element układu paliwowego, który wpływa na wydajność i oszczędność Twojego silnika. To precyzyjnie zaprojektowana część, wykonana z wysokiej jakości materiałów, aby zapewnić niezawodność i trwałość. Nasza dysza wtryskiwacza doskonale rozpyla paliwo, co przekłada się na efektywną pracę silnika i optymalne zużycie paliwa. Dzięki temu masz pewność, że Twój pojazd działa na najwyższym poziomie, a jednocześnie oszczędzasz na kosztach eksploatacji. Montaż jest prosty, co pozwoli Ci szybko cieszyć się korzyściami naszej dyszy wtryskiwacza. Wybierz jakość i niezawodność - wybierz nasz produkt i ulepsz pracę swojego silnika.',
			'shortDescription' => 'Nasza dysza wtryskiwacza to gwarancja efektywnej pracy silnika i oszczędności paliwa. Niezawodność i prosty montaż - to wszystko znajdziesz w naszym produkcie. Wybierz naszą dyszę wtryskiwacza i ciesz się lepszą wydajnością swojego pojazdu!'
		),
		array(
			'name' => 'Rozrusznik BOSCH 0 986 018 950',
			'price' => 884,37,
			'quantity' => 5,
			'features' => ['200-600A','50-300 obr/min'],
			'sku' => 7,
			'images' => ['images/parts/part6.jpg'],
			'compareAtPrice' => 1200,22,
			'category'=> 'części',
			'producer'=> 'john deere',
			'visited' => 32,
			'sold' => 250,
			'addedDate' => new \DateTime('2023-05-25 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasz rozrusznik to serce Twojego pojazdu, zapewniające mu życie i moc. To niezawodne urządzenie, które odgrywa kluczową rolę w procesie rozruchu silnika. Dzięki zaawansowanej technologii i starannie dobranej konstrukcji, nasz rozrusznik gwarantuje płynny i niezawodny start Twojego pojazdu za każdym razem. Bez względu na warunki pogodowe czy teren, nasz rozrusznik działa sprawnie i skutecznie. To pewność, że Twój pojazd jest gotowy do działania w każdej sytuacji. Odkryj, jak nasz rozrusznik może poprawić jakość i niezawodność Twojej jazdy.',
			'shortDescription' => 'Nasz rozrusznik to gwarancja płynnego i niezawodnego startu Twojego pojazdu. Bez względu na warunki - nasz produkt zapewni Ci pewność, że Twój pojazd zawsze ruszy bez problemu. Wybierz niezawodność i komfort startu - wybierz nasz rozrusznik!'
		),
		array(
			'name' => 'Łożysko SKF 6208-2RS1',
			'price' => 94,32,
			'quantity' => 5,
			'features' => ['Rodzaj łożyskowania	kulkowe zwykłe','Średnica wewnętrzna 40mm', 'Średnica zewnętrzna 80mm'],
			'sku' => 8,
			'images' => ['images/parts/part7.jpg'],
			'compareAtPrice' => 215,87,
			'category'=> 'części',
			'producer'=> 'krone',
			'visited' => 234,
			'sold' => 156,
			'addedDate' => new \DateTime('2023-11-11 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasze łożysko to niezawodność i precyzja w jednym. To niepozorne, ale kluczowe rozwiązanie, które wpływa na płynność ruchu w wielu dziedzinach przemysłu. Nasze łożysko zostało starannie zaprojektowane i wykonane z myślą o maksymalnej trwałości i efektywności. Dzięki precyzyjnemu wykonaniu i wykorzystaniu najwyższej jakości materiałów, nasze łożysko działa bezawaryjnie i niezawodnie przez długi okres czasu. Doskonale znosi obciążenia, co sprawia, że jest idealne do zastosowań w różnych gałęziach przemysłu. Wybierz nasze łożysko i zyskaj pewność, że Twoje maszyny i urządzenia będą pracować bez zakłóceń.',
			'shortDescription' => 'Nasze łożysko to pewność niezawodności i efektywności. Doskonałe wykonanie i trwałość - to wszystko znajdziesz w naszym produkcie. Wybierz najlepsze łożysko i zyskaj płynność ruchu, na którą zasługujesz!'
		),
		array(
			'name' => 'Łożysko SKF 6005-2Z /SKF/',
			'price' => 25,24,
			'quantity' => 50,
			'features' => ['Rodzaj łożyskowania	kulkowe zwykłe','Średnica wewnętrzna 20mm', 'Średnica zewnętrzna 50mm'],
			'sku' => 9,
			'images' => ['images/parts/part8.jpg'],
			'compareAtPrice' => 90,44,
			'category'=> 'części',
			'producer'=> 'massey ferguson',
			'visited' => 89,
			'sold' => 90,
			'addedDate' => new \DateTime('2023-03-14 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasze łożysko to niezawodność i precyzja w jednym. To niepozorne, ale kluczowe rozwiązanie, które wpływa na płynność ruchu w wielu dziedzinach przemysłu. Nasze łożysko zostało starannie zaprojektowane i wykonane z myślą o maksymalnej trwałości i efektywności. Dzięki precyzyjnemu wykonaniu i wykorzystaniu najwyższej jakości materiałów, nasze łożysko działa bezawaryjnie i niezawodnie przez długi okres czasu. Doskonale znosi obciążenia, co sprawia, że jest idealne do zastosowań w różnych gałęziach przemysłu. Wybierz nasze łożysko i zyskaj pewność, że Twoje maszyny i urządzenia będą pracować bez zakłóceń.',
			'shortDescription' => 'Nasze łożysko to pewność niezawodności i efektywności. Doskonałe wykonanie i trwałość - to wszystko znajdziesz w naszym produkcie. Wybierz najlepsze łożysko i zyskaj płynność ruchu, na którą zasługujesz!'
		),
		array(
			'name' => 'IMPERGOM 222091 przewód gumowy układu chłodzenia od rury łączącej chłodnicy silnika',
			'price' => 140,66,
			'quantity' => 31,
			'features' => ['Producent IMPERGOM','Indeks	IMP222091', 'Średnica wewnętrzna 32mm'],
			'sku' => 10,
			'images' => ['images/parts/part9.jpg'],
			'compareAtPrice' => 320,13,
			'category'=> 'części',
			'producer'=> 'agco',
			'visited' => 45,
			'sold' => 13,
			'addedDate' => new \DateTime('2023-04-26 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasz przewód gumowy układu chłodzenia to kluczowy element, który zapewni optymalną pracę Twojego pojazdu. Wykonany z najwyższej jakości materiałów, ten elastyczny przewód jest niezawodny w utrzymaniu odpowiedniej temperatury silnika. Nasz produkt doskonale przewodzi ciepło, jednocześnie odporniejąc na działanie czynników atmosferycznych i ekstremalnych warunków. Dzięki elastyczności i trwałości naszego przewodu gumowego, Twój układ chłodzenia będzie działać sprawnie i skutecznie.',
			'shortDescription' => 'Nasz przewód gumowy to pewność utrzymania odpowiedniej temperatury silnika. Elastyczność i trwałość - to wszystko znajdziesz w naszym produkcie. Wybierz niezawodność i komfort dla swojego pojazdu - wybierz nasz przewód gumowy układu chłodzenia!'
		),
		array(
			'name' => 'Olej Silnikowy Castrol Edge 5W-30',
			'price' => 241,99,
			'quantity' => 31,
			'features' => ['Olej syntetyczny','5W-30', 'Fluid TITANIUM'],
			'sku' => 11,
			'images' => ['images/parts/part10.jpg'],
			'compareAtPrice' => 499,23,
			'category'=> 'oleje',
			'producer'=> 'agco',
			'visited' => 13,
			'sold' => 45,
			'addedDate' => new \DateTime('2023-02-24 12:00:00'),
			'promotion' => true,
			'longDescription' => 'Nasz Olej Silnikowy Castrol Edge 5W-30 to wybór najwyższej jakości dla Twojego pojazdu. To produkt, który łączy w sobie innowacyjne technologie z niezawodnością, zapewniając doskonałą ochronę i wydajność Twojego silnika. Dzięki dokładnie dobranym składnikom i starannemu procesowi produkcji, nasz olej silnikowy zapewnia doskonałe smarowanie i ochronę podczas każdej jazdy. Niezależnie od warunków pogodowych i stylu jazdy, nasz produkt utrzymuje silnik w doskonałej formie, zapobiegając zużyciu i korozji. Wybierz Olej Silnikowy Castrol Edge 5W-30 i daj swojemu pojazdowi to, czego naprawdę potrzebuje.',
			'shortDescription' => 'Nasz Olej Silnikowy Castrol Edge 5W-30 to synonim ochrony i wydajności. Dla silnika, który zasługuje na najlepsze. Wybierz niezawodność i jakość Castrol Edge!'
		),
		array(
			'name' => 'Castrol Olej silnikowy MAGNATEC 10W-40 4L',
			'price' => 169,00,
			'quantity' => 5,
			'features' => ['Pojemność: 4L','Klasa lepkości: 10W-40'],
			'sku' => 12,
			'images' => ['images/parts/part11.jpg'],
			'compareAtPrice' => 180,00,
			'category'=> 'oleje',
			'producer'=> 'john deere',
			'visited' => 88,
			'sold' => 120,
			'addedDate' => new \DateTime('2023-11-19 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz Castrol Olej Silnikowy MAGNATEC 10W-40 4L to wybór dla troszczących się o swoje pojazdy. To produkt, który wyróżnia się nie tylko doskonałą jakością, ale także innowacyjnym podejściem do ochrony silnika. Nasz olej silnikowy MAGNATEC to efekt wieloletnich badań i rozwoju, który przekłada się na niezawodność i wydajność Twojego pojazdu. Dzięki specjalnym molekułom przylegającym do metalu, nasz olej zapewnia optymalne smarowanie i ochronę w czasie rozruchu silnika, kiedy to silnik jest najsłabszy. To znaczy, że Twój silnik jest chroniony przez cały czas, nawet podczas krótkich podróży. Nasz olej MAGNATEC utrzymuje silnik w doskonałej kondycji, co przekłada się na oszczędność, wydajność i długotrwałość.',
			'shortDescription' => 'Nasz Castrol Olej Silnikowy MAGNATEC 10W-40 4L to gwarancja ochrony i wydajności Twojego silnika. Innowacyjne rozwiązania i niezawodność Castrol w jednym produkcie. Wybierz MAGNATEC i ciesz się spokojem na drodze!'
		),
		array(
			'name' => '77 Lubricants Olej silnikowy 0W30CP 5L',
			'price' => 246.00,
			'quantity' => 5,
			'features' => ['Pojemność: 5L','0W-30', 'ACEA C2'],
			'sku' => 13,
			'images' => ['images/parts/part12.jpg'],
			'compareAtPrice' => 253,22,
			'category'=> 'oleje',
			'producer'=> 'krone',
			'visited' => 98,
			'sold' => 210,
			'addedDate' => new \DateTime('2023-10-05 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz 77 Lubricants Olej Silnikowy 0W30CP 5L to wyjątkowy produkt, który dostarcza najwyższej jakości smarowania i ochrony dla Twojego silnika. To olej stworzony z myślą o użytkownikach, którzy cenią sobie niezawodność i wydajność. Nasza formuła 0W30CP została opracowana, aby zapewnić doskonałe smarowanie w różnych warunkach, zarówno podczas zimnego rozruchu, jak i podczas intensywnej jazdy. Nasz olej jest wyjątkowo trwały i efektywny, a jego niski opór zapewnia oszczędność paliwa. Dlatego, jeśli szukasz produktu, który zadba o wydajność i długotrwałość Twojego silnika, nasz 77 Lubricants Olej Silnikowy 0W30CP 5L jest doskonałym wyborem.',
			'shortDescription' => 'Nasz 77 Lubricants Olej Silnikowy 0W30CP 5L to gwarancja doskonałego smarowania i ochrony dla Twojego silnika. Wydajność i niezawodność w jednym produkcie. Wybierz 0W30CP i zyskaj pewność, że Twój silnik działa na najwyższym poziomie!'
		),
		array(
			'name' => 'GM Olej silnikowy syntetyczny 5W-30',
			'price' => 140,00,
			'quantity' => 50,
			'features' => ['Pojemność: 5L','5W-30', 'Syntetyczny'],
			'sku' => 14,
			'images' => ['images/parts/part13.jpg'],
			'compareAtPrice' => 320,44,
			'category'=> 'oleje',
			'producer'=> 'massey ferguson',
			'visited' => 210,
			'sold' => 105,
			'addedDate' => new \DateTime('2023-05-08 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz GM Olej Silnikowy Syntetyczny 5W-30 to doskonały wybór dla wszystkich, którzy cenią sobie wydajność, trwałość i niezawodność swojego silnika. Ten olej silnikowy to efekt wieloletnich badań i rozwoju, który przekłada się na doskonałe osiągi i ochronę Twojego pojazdu. Nasza specjalna formuła 5W-30 jest zaprojektowana, aby zapewnić optymalne smarowanie w różnych warunkach, zarówno w niskich, jak i wysokich temperaturach. Dzięki technologii syntetycznej, nasz olej jest wyjątkowo trwały i skuteczny w redukcji zużycia paliwa. To gwarancja, że Twój silnik będzie działać na najwyższym poziomie, a Ty oszczędzisz na kosztach eksploatacji. Wybierz GM Olej Silnikowy Syntetyczny 5W-30 i zyskaj pewność, że Twój pojazd jest odpowiednio chroniony i gotowy do każdej trasy.',
			'shortDescription' => 'Nasz GM Olej Silnikowy Syntetyczny 5W-30 to gwarancja wydajności i ochrony Twojego silnika. Doskonałe smarowanie i trwałość w jednym produkcie. Wybierz GM i ciesz się pewnością podczas każdej jazdy!'
		),
		array(
			'name' => 'Wilgotnościomierz do ziarna zboża',
			'price' => 1355,00,
			'quantity' => 31,
			'features' => ['Dokładność pomiaru [+/-]: 0.5 %','Twarda skrzynka z paskiem', 'Zakres wilgotności: 8 - 35% with grain, 6 - 25% with oil plants %'],
			'sku' => 15,
			'images' => ['images/parts/part14.jpg'],
			'compareAtPrice' => 1399,00,
			'category'=> 'wilgotnościomierze',
			'producer'=> 'agco',
			'visited' => 54,
			'sold' => 130,
			'addedDate' => new \DateTime('2023-03-27 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz Wilgotnościomierz do Ziarna Zboża to nieoceniony sprzęt dla rolników, producentów zboża oraz profesjonalistów z branży spożywczej. Ten precyzyjny urządzenie umożliwia błyskawiczny pomiar wilgotności ziarna, co jest kluczowe dla prawidłowego przechowywania i przetwarzania plonów. Dzięki najnowszej technologii pomiarowej, nasz wilgotnościomierz gwarantuje dokładne wyniki, co pozwala na podejmowanie mądrych decyzji dotyczących gromadzenia i obróbki zboża. Ten przenośny, łatwy w obsłudze sprzęt stanie się niezastąpiony zarówno na polu, jak i w magazynie. Daj sobie przewagę i inwestuj w nasz Wilgotnościomierz do Ziarna Zboża, który pomoże Ci zarządzać plonami z jeszcze większą precyzją.',
			'shortDescription' => 'Nasz Wilgotnościomierz to niezawodne narzędzie do pomiaru wilgotności ziarna zbożowego. Precyzja i łatwość obsługi w jednym. Wybierz jakość i kontroluj stan swojego plonu dzięki naszemu wilgotnościomierzowi!'
		),
		array(
			'name' => 'Wilgotnościomierz do zboża ziarna Unimeter Super Digital',
			'price' => 1744,50,
			'quantity' => 5,
			'features' => ['łatwy do czytania monitor LCD','Regulacja monitora: skala 1-10', 'Zakres temperatur: 0-50 C'],
			'sku' => 16,
			'images' => ['images/parts/part15.jpg'],
			'compareAtPrice' => 1894,50,
			'category'=> 'wilgotnościomierze',
			'producer'=> 'john deere',
			'visited' => 222,
			'sold' => 111,
			'addedDate' => new \DateTime('2023-06-10 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz Wilgotnościomierz do Zboża Ziarna Unimeter Super Digital to narzędzie, które zrewolucjonizuje sposób, w jaki kontrolujesz i zarządzasz wilgotnością swojego zbóż. Ten zaawansowany, cyfrowy wilgotnościomierz został stworzony z myślą o rolnikach, hodowcach i profesjonalistach z branży spożywczej, którzy zależą od precyzyjnych pomiarów wilgotności ziarna. Dzięki technologii najwyższej jakości, nasz Unimeter Super Digital dostarcza szybkich, dokładnych i niezawodnych wyników. To narzędzie, które pozwala na błyskawiczne dostosowanie procesów magazynowania, suszenia i przechowywania zboża, co przekłada się na jakość i wydajność produkcji.',
			'shortDescription' => 'Nasz Wilgotnościomierz Unimeter Super Digital to gwarancja precyzyjnych pomiarów wilgotności ziarna. Szybkość i niezawodność w jednym urządzeniu. Wybierz jakość i kontroluj stan swojego zboża z łatwością!'
		),
		array(
			'name' => 'Miernik wilgotności zboża wilgotnosciomierz ziarna',
			'price' => 1550,94,
			'quantity' => 5,
			'features' => ['16 rodzajów zbóż','precyzja pomiaru +/- 0,5%', 'Rozmiar: 17,5 x 7,5 x 6,5 cm'],
			'sku' => 17,
			'images' => ['images/parts/part16.jpg'],
			'compareAtPrice' => 1600,94,
			'category'=> 'wilgotnościomierze',
			'producer'=> 'krone',
			'visited' => 111,
			'sold' => 222,
			'addedDate' => new \DateTime('2023-07-23 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz Miernik Wilgotności Zboża, czyli Wilgotnościomierz Ziarna, to niezbędne narzędzie dla profesjonalnych rolników, hodowców i wszystkich związanych z produkcją zboża. Ten zaawansowany miernik wilgotności umożliwia dokładny i szybki pomiar wilgotności ziarna, co stanowi kluczowy czynnik zarówno w procesie przechowywania, jak i obróbki plonów. Nasz produkt jest wyjątkowo łatwy w obsłudze, co sprawia, że nawet osoby bez doświadczenia w branży rolniczej mogą z niego korzystać z łatwością.',
			'shortDescription' => 'Nasz Miernik Wilgotności Zboża - Wilgotnościomierz Ziarna to narzędzie, które ułatwia kontrolę wilgotności Twojego zboża. Prosty w obsłudze i niezawodny w pomiarach. Wybierz jakość i zarządzaj plonami zbożowymi z pewnością, że są one w doskonałej kondycji!'
		),
		array(
			'name' => 'Wilgotnościomierz GMM',
			'price' => 2596.00,
			'quantity' => 50,
			'features' => ['Masa przyrządu: 1595 g','Wymiary: 25,0 x 16,0 x 12,0 cm', 'Objętość próbki: 210 ml'],
			'sku' => 18,
			'images' => ['images/parts/part17.jpg'],
			'compareAtPrice' => 2715,22,
			'category'=> 'wilgotnościomierze',
			'producer'=> 'massey ferguson',
			'visited' => 25,
			'sold' => 63,
			'addedDate' => new \DateTime('2023-01-01 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz Wilgotnościomierz GMM to wyjątkowe narzędzie dla profesjonalistów i pasjonatów z różnych dziedzin, którzy potrzebują precyzyjnych pomiarów wilgotności w swojej pracy lub hobby. To urządzenie, które łączy w sobie najnowocześniejszą technologię pomiarową z niezawodnością i trwałością. Nasz wilgotnościomierz GMM zapewnia dokładne i szybkie wyniki, niezależnie od rodzaju materiału czy warunków środowiskowych. Dzięki swojej wszechstronności, może być stosowany w rolnictwie, budownictwie, przemyśle spożywczym, oraz wielu innych dziedzinach. Intuicyjna obsługa i wytrzymała konstrukcja sprawiają, że nasz Wilgotnościomierz GMM to niezawodny partner w codziennej pracy.',
			'shortDescription' => 'Nasz Wilgotnościomierz GMM to gwarancja dokładnych pomiarów wilgotności. Prosty w obsłudze i niezawodny w działaniu. Wybierz nasz wilgotnościomierz i uzyskaj precyzyjne wyniki w każdej dziedzinie!'
		),
		array(
			'name' => 'Wilgotnościomierz do zboża DRAMIŃSKI TwistGrain pro',
			'price' => 1740,00,
			'quantity' => 50,
			'features' => ['Masa przyrządu: 1595 g','Futerał transportowy gratis', 'Objętość próbki: 210 ml'],
			'sku' => 19,
			'images' => ['images/parts/part18.jpg'],
			'compareAtPrice' => 1800,00,
			'category'=> 'wilgotnościomierze',
			'producer'=> 'claas',
			'visited' => 32,
			'sold' => 55,
			'addedDate' => new \DateTime('2023-05-06 12:00:00'),
			'promotion' => false,
			'longDescription' => "Dramiński TwistGrain pro jest niezbędnym narzędziem pracy w każdym nowoczesnym gospodarstwie rolnym. Dzięki niemu szybko i dokładnie sprawdzisz wilgotność ziarna bezpośrednio na polu lub w miejscu, gdzie przechowywane jest zboże. Innowacyjne rozwiązania, zaawansowana technologia, ogromna uniwersalność, złącze USB oraz możliwość podłączenia zewnętrznej sondy temperaturowej zmieniają zakup TG pro w bezcenną inwestycję.
			TG pro to inteligentny wilgotnościomierz, który łączy pokolenia. W menu urządzenia można samodzielnie wybrać tryb pracy z którego aktualnie chcemy korzystać (podstawowy lub zaawansowany).
    		W trybie podstawowym nastawiamy się na łatwość w użyciu oraz szybki i wygodny pomiar wilgotności i temperatury ziarna tak, by obsługa była przyjazna nawet dla początkujących użytkowników.",
			'shortDescription' => 'Nasz Wilgotnościomierz to gwarancja dokładnych pomiarów wilgotności. Prosty w obsłudze i niezawodny w działaniu. Wybierz nasz wilgotnościomierz i uzyskaj precyzyjne wyniki w każdej dziedzinie!'
		),
		array(
			'name' => 'Wilgotnościomierz do ziarna Dramiński',
			'price' => 1260,00,
			'quantity' => 50,
			'features' => ['Wyświetlacz graficzny','Wymiary: 25,0 x 16,0 x 12,0 cm', 'Objętość próbki: 210 ml'],
			'sku' => 20,
			'images' => ['images/parts/part19.jpg'],
			'compareAtPrice' => 1400,
			'category'=> 'wilgotnościomierze',
			'producer'=> 'john deere',
			'visited' => 44,
			'sold' => 23,
			'addedDate' => new \DateTime('2023-06-15 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Nasz Wilgotnościomierz GMM to wyjątkowe narzędzie dla profesjonalistów i pasjonatów z różnych dziedzin, którzy potrzebują precyzyjnych pomiarów wilgotności w swojej pracy lub hobby. To urządzenie, które łączy w sobie najnowocześniejszą technologię pomiarową z niezawodnością i trwałością. Nasz wilgotnościomierz GMM zapewnia dokładne i szybkie wyniki, niezależnie od rodzaju materiału czy warunków środowiskowych. Dzięki swojej wszechstronności, może być stosowany w rolnictwie, budownictwie, przemyśle spożywczym, oraz wielu innych dziedzinach. Intuicyjna obsługa i wytrzymała konstrukcja sprawiają, że nasz Wilgotnościomierz GMM to niezawodny partner w codziennej pracy.',
			'shortDescription' => 'Dramiński GMM mini to najpopularniejszy model naszej produkcji. Jest małym, poręcznym i nowoczesnym a przez to niezbędnym narzędziem pracy w każdym gospodarstwie rolnym. Dzięki niemu bardzo szybko i dokładnie sprawdzisz wilgotność ziarna bezpośrednio na polu lub w miejscu gdzie przechowywane jest zboże. Dzięki wbudowanemu złączu USB aktualizacja danych kalibracyjnych oraz oprogramowania jest szybka a co najważniejsze łatwa do wykonania. Teraz bez odsyłania miernika do serwisu będziesz mógł cieszyć się jego najbardziej aktualną wersją nawet po wielu latach.'
		),
		array(
			'name' => 'Orlen Oil Superol CC SAE30 5 L Olej silnikowy letni',
			'price' => 77,95,
			'quantity' => 50,
			'features' => ['Wyświetlacz graficzny','Wymiary: 25,0 x 16,0 x 12,0 cm', 'Objętość próbki: 210 ml'],
			'sku' => 21,
			'images' => ['images/parts/part20.jpg'],
			'compareAtPrice' => 85,66,
			'category'=> 'oleje',
			'producer'=> 'john deere',
			'visited' => 99,
			'sold' => 111,
			'addedDate' => new \DateTime('2023-06-15 12:00:00'),
			'promotion' => false,
			'longDescription' => 'Olej silnikowy letni Orlen Oil Superol CC SAE30 5 L to produkt stworzony z myślą o dbałości o wydajność i trwałość Twojego silnika podczas ciepłych letnich dni. Ten wysokiej jakości olej silnikowy jest wynikiem wieloletniego doświadczenia i innowacyjnych technologii, jakie oferuje marka Orlen Oil.
			Niezależnie od tego, czy jesteś profesjonalnym mechanikiem samochodowym, czy po prostu dbasz o swoje pojazdy, ten olej silnikowy jest idealny do wszystkich typów silników letnich. Jego unikalna formuła pozwala na skuteczną ochronę przed zużyciem i zapewnia optymalne smarowanie, co przekłada się na długą żywotność Twojego silnika.',
			'shortDescription' => 'Olej silnikowy letni Orlen Oil Superol CC SAE30 5 L to gwarancja optymalnej ochrony Twojego silnika w gorące dni. Długotrwała wydajność i niezawodność od marki Orlen Oil. Ciesz się długą żywotnością swojego pojazdu!'
		),
		array(
			'name' => 'John Deere olej silnikowy Plus 50 II 15W40 5l',
			'price' => 170,00,
			'quantity' => 50,
			'features' => ['Wyświetlacz graficzny','Wymiary: 25,0 x 16,0 x 12,0 cm', 'Objętość próbki: 210 ml'],
			'sku' => 22,
			'images' => ['images/parts/part21.jpg'],
			'compareAtPrice' => 205,00,
			'category'=> 'oleje',
			'producer'=> 'john deere',
			'visited' => 79,
			'sold' => 102,
			'addedDate' => new \DateTime('2023-06-22 12:00:00'),
			'promotion' => false,
			'longDescription' => 'John Deere olej silnikowy Plus 50 II 15W40 5l to produkt stworzony z myślą o wyjątkowych potrzebach Twojego silnika. Marka John Deere znana jest ze swojego zaangażowania w rolnictwo i budownictwo, a ten olej silnikowy jest kolejnym dowodem na ich wysoką jakość i niezawodność.
			Ten olej silnikowy został opracowany, aby sprostać wymaganiom najnowszych silników diesla, zarówno w rolnictwie, jak i przemyśle. Jego unikalna formuła zapewnia doskonałą ochronę przed zużyciem, co przekłada się na długą żywotność silnika.',
			'shortDescription' => 'Wysokiej jakości olej silnikowy John Deere Plus 50 II 15W40 to środek, który wydłuża czas pomiędzy kolejnymi wymianami, zapewnia zwiększoną trwałość silnika oraz ochronę mechanizmów. Olej ten został stworzony z myślą o pojazdach terenowych i jeździe w skrajnych temperaturach.'
		),
		);
		foreach($products as $newProduct){
			$product = new Product();
        	$product->setName($newProduct['name']);
        	$product->setPrice($newProduct['price']);
			$product->setQuantity($newProduct['quantity']);
        	$product->setFeatures($newProduct['features']);
			$product->setsku($newProduct['sku']);
			$product->setImages($newProduct['images']);
			$product->setCompareAtPrice($newProduct['compareAtPrice']);
			$product->setVisited($newProduct['visited']);
			$product->setSold($newProduct['sold']);
			$product->setAddedDate($newProduct['addedDate']);
			$product->setPromotion($newProduct['promotion']);
			$product->setLongDescription($newProduct['longDescription']);
			$product->setShortDescription($newProduct['shortDescription']);
			$producerId = $this->entityManager->getRepository(Producer::class)->findOneBy(['name'=>$newProduct['producer']]);
			$categoryId = $this->entityManager->getRepository(Category::class)->findOneBy(['name'=>$newProduct['category']]);
			$product->setProducer($producerId);
			$product->setCategory($categoryId);

        	$this->entityManager->persist($product);
		}

        $this->entityManager->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
		$this->seedProducts();
        return 1;
    }
}
?>