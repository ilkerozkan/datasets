<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$dbError = null;
$pdo = null;

try {
    $pdo = getPDO();
} catch (PDOException $exception) {
    $dbError = 'Veritabanı bağlantısı kurulamadı: ' . $exception->getMessage();
}

$defaults = [
    'profile' => [
        'title_prefix' => 'Prof. Dr.',
        'full_name' => 'Ayşe Demir',
        'hero_tagline' => 'Bilgisayar Bilimleri Bölümü — Yapay Zeka ve Öğrenen Sistemler Araştırma Grubu',
        'biography_primary' => 'Prof. Dr. Ayşe Demir, Yapay Zeka ve Makine Öğrenmesi alanında uzmanlaşmış bir akademisyendir. Doktora derecesini 2012 yılında Orta Doğu Teknik Üniversitesi\'nden almış, 2016 yılında doçentlik, 2021 yılında profesörlük unvanını kazanmıştır. Araştırmaları, etik yapay zeka, sağlam makine öğrenmesi ve sağlıkta veri bilimi uygulamalarına odaklanmaktadır.',
        'biography_secondary' => 'Bilgisayar Bilimleri Bölümü\'nde lisans ve lisansüstü düzeyde dersler veren Prof. Demir, aynı zamanda Yapay Zeka Araştırma Laboratuvarı\'nın kurucusu ve yürütücüsüdür.',
        'profile_image_url' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80',
        'cv_url' => '#cv',
        'email' => 'ayse.demir@ornek.edu.tr',
        'office' => '',
        'address' => 'Bilgisayar Bilimleri Bölümü, Örnek Üniversitesi, 06800 Ankara',
        'office_hours' => 'Salı & Perşembe 14:00 - 16:00',
    ],
    'research_interests' => [
        ['title' => 'Sağlam Makine Öğrenmesi', 'description' => 'Derin öğrenme modellerinin saldırılara ve gürültülü veri setlerine karşı dayanıklılığını artırmaya yönelik yeni yöntemler geliştirilmesi.'],
        ['title' => 'Etik Yapay Zeka', 'description' => 'Yapay zekâ sistemlerinde şeffaflık, hesap verebilirlik ve adalet ilkelerini gözeten algoritmalar tasarlanması.'],
        ['title' => 'Sağlıkta Veri Bilimi', 'description' => 'Erken teşhis ve kişiselleştirilmiş tedavi önerileri için büyük veri analizi ve sinyal işleme tekniklerinin uygulanması.'],
        ['title' => 'İnsan-Makine Etkileşimi', 'description' => 'İnsan odaklı yapay zekâ sistemleri için sezgisel arayüzler ve açıklanabilirlik araçlarının geliştirilmesi.'],
    ],
    'publications' => [
        [
            'authors' => 'Demir, A., Kaya, M., & Yıldız, B.',
            'year' => '2023',
            'title' => 'Robust Federated Learning with Adaptive Noise Injection',
            'publication' => 'Journal of Machine Learning Research, 24(110), 1-35.',
            'details' => '',
            'link' => '',
        ],
        [
            'authors' => 'Demir, A., & Özkan, S.',
            'year' => '2022',
            'title' => 'Explainable AI Framework for Clinical Decision Support',
            'publication' => 'IEEE Transactions on Medical Imaging, 41(8), 2102-2115.',
            'details' => '',
            'link' => '',
        ],
        [
            'authors' => 'Demir, A.',
            'year' => '2021',
            'title' => 'Bias Mitigation in Deep Neural Networks via Adversarial Training',
            'publication' => 'Proceedings of the 38th International Conference on Machine Learning.',
            'details' => '',
            'link' => '',
        ],
        [
            'authors' => 'Demir, A., Aksoy, M., & Şahin, D.',
            'year' => '2020',
            'title' => 'Human-Centered Design Principles for AI Interfaces',
            'publication' => 'ACM Transactions on Computer-Human Interaction, 27(4), 20:1-20:28.',
            'details' => '',
            'link' => '',
        ],
    ],
    'courses' => [
        [
            'course_code' => 'BLG 401',
            'course_title' => 'Makine Öğrenmesi',
            'term' => 'Lisans',
            'description' => 'Temel makine öğrenmesi algoritmaları, değerlendirme yöntemleri ve uygulamalarına giriş.',
        ],
        [
            'course_code' => 'BLG 507',
            'course_title' => 'Derin Öğrenme',
            'term' => 'Lisansüstü',
            'description' => 'Derin sinir ağları, konvolüsyonel ve tekrarlayan mimariler, optimizasyon teknikleri ve düzenlileştirme stratejileri.',
        ],
        [
            'course_code' => 'BLG 520',
            'course_title' => 'Yapay Zekada Etik',
            'term' => 'Lisansüstü',
            'description' => 'Etik ilkeler, veri gizliliği, ayrımcılık, sorumluluk ve regülasyon konularını tartışan seminer.',
        ],
        [
            'course_code' => 'BLG 315',
            'course_title' => 'Veri Madenciliği',
            'term' => 'Lisans',
            'description' => 'Büyük veri setlerinden içgörü elde etmek için kullanılan istatistiksel ve makine öğrenmesi teknikleri.',
        ],
    ],
    'projects' => [
        [
            'title' => 'Sağlıkta Yapay Zekâ Platformu',
            'timeframe' => '2023-',
            'description' => 'TÜBİTAK 1001 projesi kapsamında, çok merkezli hastane verilerinden hastalık risk tahmin modelleri geliştirilmesi.',
            'link' => '',
        ],
        [
            'title' => 'AdversaryAware',
            'timeframe' => '2022-',
            'description' => 'Avrupa Birliği Horizon programı desteğiyle, siber güvenlik uygulamalarında dayanıklı makine öğrenmesi çözümleri geliştirilmesi.',
            'link' => '',
        ],
        [
            'title' => 'AI4Inclusion',
            'timeframe' => '2021-2024',
            'description' => 'Sosyal medya içeriklerinde önyargıların tespiti ve azaltılmasına yönelik açıklanabilir yapay zekâ araçlarının tasarımı.',
            'link' => '',
        ],
    ],
    'cv_entries' => [
        [
            'year_label' => '2021',
            'title' => 'Profesör',
            'description' => 'Bilgisayar Bilimleri Bölümü, Örnek Üniversitesi',
        ],
        [
            'year_label' => '2016',
            'title' => 'Doçent',
            'description' => 'Bilgisayar Mühendisliği Bölümü, Örnek Üniversitesi',
        ],
        [
            'year_label' => '2012',
            'title' => 'Doktora, Bilgisayar Mühendisliği',
            'description' => 'Orta Doğu Teknik Üniversitesi',
        ],
        [
            'year_label' => '2007',
            'title' => 'Yüksek Lisans, Bilgisayar Mühendisliği',
            'description' => 'Boğaziçi Üniversitesi',
        ],
    ],
];

$usingFallback = false;

if ($pdo) {
    $profileRow = $pdo->query('SELECT title_prefix, full_name, hero_tagline, biography_primary, biography_secondary, profile_image_url, email, office, address, office_hours, cv_url FROM profile ORDER BY updated_at DESC LIMIT 1')->fetch();
    if ($profileRow) {
        $profile = [
            'title_prefix' => $profileRow['title_prefix'] ?? '',
            'full_name' => $profileRow['full_name'] ?? '',
            'hero_tagline' => $profileRow['hero_tagline'] ?? '',
            'biography_primary' => $profileRow['biography_primary'] ?? '',
            'biography_secondary' => $profileRow['biography_secondary'] ?? '',
            'profile_image_url' => $profileRow['profile_image_url'] ?? '',
            'cv_url' => $profileRow['cv_url'] ?? '',
            'email' => $profileRow['email'] ?? '',
            'office' => $profileRow['office'] ?? '',
            'address' => $profileRow['address'] ?? '',
            'office_hours' => $profileRow['office_hours'] ?? '',
        ];
    } else {
        $profile = $defaults['profile'];
        $usingFallback = true;
    }

    $researchInterests = $pdo->query('SELECT title, description FROM research_interests ORDER BY sort_order, id')->fetchAll();
    if (!$researchInterests) {
        $researchInterests = $defaults['research_interests'];
        $usingFallback = true;
    }

    $publications = $pdo->query('SELECT authors, year, title, publication, details, link FROM publications ORDER BY sort_order, id')->fetchAll();
    if (!$publications) {
        $publications = $defaults['publications'];
        $usingFallback = true;
    }

    $courses = $pdo->query('SELECT course_code, course_title, term, description FROM courses ORDER BY sort_order, id')->fetchAll();
    if (!$courses) {
        $courses = $defaults['courses'];
        $usingFallback = true;
    }

    $projects = $pdo->query('SELECT title, timeframe, description, link FROM projects ORDER BY sort_order, id')->fetchAll();
    if (!$projects) {
        $projects = $defaults['projects'];
        $usingFallback = true;
    }

    $cvEntries = $pdo->query('SELECT year_label, title, description FROM cv_entries ORDER BY sort_order, id')->fetchAll();
    if (!$cvEntries) {
        $cvEntries = $defaults['cv_entries'];
        $usingFallback = true;
    }
} else {
    $profile = $defaults['profile'];
    $researchInterests = $defaults['research_interests'];
    $publications = $defaults['publications'];
    $courses = $defaults['courses'];
    $projects = $defaults['projects'];
    $cvEntries = $defaults['cv_entries'];
    $usingFallback = true;
}

$displayNameParts = array_filter([$profile['title_prefix'] ?? '', $profile['full_name'] ?? ''], static fn(string $part) => trim($part) !== '');
$displayName = trim(implode(' ', $displayNameParts));
if ($displayName === '') {
    $displayName = 'Akademik Profil';
}

$biographyParagraphs = array_values(array_filter([
    $profile['biography_primary'] ?? '',
    $profile['biography_secondary'] ?? '',
], static fn(string $text) => trim($text) !== ''));

$cvLink = $profile['cv_url'] !== '' ? $profile['cv_url'] : '#cv';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($displayName) ?> | Akademik Web Sayfası</title>
    <style>
        :root {
            --primary: #2f4b8f;
            --secondary: #f4f6fb;
            --accent: #d95c5c;
            --text: #1f2933;
            --muted: #5d6b7f;
            font-size: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: var(--text);
            background-color: var(--secondary);
        }

        header {
            background: linear-gradient(135deg, var(--primary), #20326d);
            color: white;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        header h1 {
            font-size: clamp(2rem, 4vw, 3.2rem);
            margin-bottom: 0.5rem;
            letter-spacing: 0.04em;
        }

        header p {
            font-size: clamp(1rem, 2.2vw, 1.4rem);
            color: rgba(255, 255, 255, 0.85);
        }

        nav {
            background-color: white;
            border-bottom: 1px solid rgba(47, 75, 143, 0.15);
            box-shadow: 0 3px 12px rgba(31, 41, 51, 0.08);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        nav ul {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            gap: 1.5rem;
        }

        nav a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        nav a:hover,
        nav a:focus {
            color: var(--accent);
        }

        main {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        section {
            background-color: white;
            margin-bottom: 2rem;
            padding: 2rem;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(31, 41, 51, 0.07);
        }

        section h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary);
            border-bottom: 2px solid rgba(47, 75, 143, 0.2);
            padding-bottom: 0.5rem;
        }

        .about {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            align-items: start;
        }

        .about figure {
            text-align: center;
        }

        .about img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid rgba(47, 75, 143, 0.2);
        }

        .about figcaption {
            margin-top: 0.75rem;
            font-weight: 600;
            color: var(--primary);
        }

        .about p {
            color: var(--muted);
        }

        .grid-two {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .card {
            border-left: 4px solid var(--primary);
            padding-left: 1rem;
        }

        .timeline {
            list-style: none;
            border-left: 3px solid rgba(47, 75, 143, 0.25);
            padding-left: 1.5rem;
            margin-left: 0.5rem;
        }

        .timeline li {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .timeline li::before {
            content: "";
            position: absolute;
            left: -1.9rem;
            top: 0.4rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--accent);
        }

        ul.publications {
            list-style: none;
            padding-left: 0;
        }

        ul.publications li {
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            background-color: rgba(47, 75, 143, 0.05);
            border-radius: 12px;
        }

        .cta {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.25rem;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 999px;
            transition: background-color 0.3s ease;
        }

        .cta:hover,
        .cta:focus {
            background-color: #1f3570;
        }

        .notice {
            background-color: rgba(47, 75, 143, 0.08);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            color: var(--muted);
        }

        .notice.error {
            background-color: rgba(217, 92, 92, 0.18);
            color: var(--accent);
        }

        footer {
            text-align: center;
            padding: 2rem 1.5rem;
            background-color: #192448;
            color: rgba(255, 255, 255, 0.7);
        }

        footer a {
            color: white;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($displayName) ?></h1>
        <?php if (!empty($profile['hero_tagline'])): ?>
            <p><?= htmlspecialchars($profile['hero_tagline']) ?></p>
        <?php endif; ?>
    </header>

    <nav aria-label="Ana menü">
        <ul>
            <li><a href="#hakkinda">Hakkında</a></li>
            <li><a href="#arastirma">Araştırma</a></li>
            <li><a href="#yayinlar">Yayınlar</a></li>
            <li><a href="#dersler">Dersler</a></li>
            <li><a href="#projeler">Projeler</a></li>
            <li><a href="#iletisim">İletişim</a></li>
        </ul>
    </nav>

    <main>
        <?php if ($usingFallback): ?>
            <div class="notice">Veritabanında kayıt bulunamadığı için örnek içerik gösterilmektedir. Yönetim panelinden verileri güncelleyin.</div>
        <?php endif; ?>
        <?php if ($dbError): ?>
            <div class="notice error"><?= htmlspecialchars($dbError) ?></div>
        <?php endif; ?>

        <section id="hakkinda">
            <h2>Hakkında</h2>
            <div class="about">
                <figure>
                    <?php if (!empty($profile['profile_image_url'])): ?>
                        <img src="<?= htmlspecialchars($profile['profile_image_url']) ?>" alt="<?= htmlspecialchars($displayName) ?>" />
                    <?php endif; ?>
                    <figcaption><?= htmlspecialchars($displayName) ?></figcaption>
                </figure>
                <div>
                    <?php if ($biographyParagraphs): ?>
                        <?php foreach ($biographyParagraphs as $paragraph): ?>
                            <p><?= nl2br(htmlspecialchars($paragraph)) ?></p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="notice">Bu alanı yönetim panelinden güncelleyebilirsiniz.</p>
                    <?php endif; ?>
                    <a class="cta" href="<?= htmlspecialchars($cvLink) ?>">Akademik Özgeçmiş</a>
                </div>
            </div>
        </section>

        <section id="arastirma">
            <h2>Araştırma İlgi Alanları</h2>
            <?php if ($researchInterests): ?>
                <div class="grid-two">
                    <?php foreach ($researchInterests as $interest): ?>
                        <article class="card">
                            <h3><?= htmlspecialchars($interest['title'] ?? '') ?></h3>
                            <?php if (!empty($interest['description'])): ?>
                                <p><?= htmlspecialchars($interest['description']) ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="notice">Henüz araştırma alanı eklenmedi.</p>
            <?php endif; ?>
        </section>

        <section id="yayinlar">
            <h2>Seçilmiş Yayınlar</h2>
            <?php if ($publications): ?>
                <ul class="publications">
                    <?php foreach ($publications as $pub): ?>
                        <li>
                            <?php if (!empty($pub['authors'])): ?>
                                <?= htmlspecialchars($pub['authors']) ?>
                            <?php endif; ?>
                            <?php if (!empty($pub['year'])): ?>
                                (<?= htmlspecialchars($pub['year']) ?>).
                            <?php endif; ?>
                            <?php if (!empty($pub['title'])): ?>
                                <em><?= htmlspecialchars($pub['title']) ?></em>.
                            <?php endif; ?>
                            <?php if (!empty($pub['publication'])): ?>
                                <?= htmlspecialchars($pub['publication']) ?>
                            <?php endif; ?>
                            <?php if (!empty($pub['details'])): ?>
                                <?= htmlspecialchars($pub['details']) ?>
                            <?php endif; ?>
                            <?php if (!empty($pub['link'])): ?>
                                <a href="<?= htmlspecialchars($pub['link']) ?>" target="_blank" rel="noopener">Bağlantı</a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="notice">Henüz yayın bilgisi eklenmedi.</p>
            <?php endif; ?>
        </section>

        <section id="dersler">
            <h2>Verilen Dersler</h2>
            <?php if ($courses): ?>
                <div class="grid-two">
                    <?php foreach ($courses as $course): ?>
                        <article class="card">
                            <h3>
                                <?php if (!empty($course['course_code'])): ?>
                                    <?= htmlspecialchars($course['course_code']) ?> -
                                <?php endif; ?>
                                <?= htmlspecialchars($course['course_title']) ?>
                            </h3>
                            <?php if (!empty($course['term'])): ?>
                                <p><strong><?= htmlspecialchars($course['term']) ?></strong></p>
                            <?php endif; ?>
                            <?php if (!empty($course['description'])): ?>
                                <p><?= htmlspecialchars($course['description']) ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="notice">Henüz ders bilgisi eklenmedi.</p>
            <?php endif; ?>
        </section>

        <section id="projeler">
            <h2>Devam Eden Projeler</h2>
            <?php if ($projects): ?>
                <ul class="timeline">
                    <?php foreach ($projects as $project): ?>
                        <li>
                            <h3><?= htmlspecialchars($project['title']) ?><?php if (!empty($project['timeframe'])): ?> (<?= htmlspecialchars($project['timeframe']) ?>)<?php endif; ?></h3>
                            <?php if (!empty($project['description'])): ?>
                                <p><?= htmlspecialchars($project['description']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($project['link'])): ?>
                                <p><a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" rel="noopener">Detaylar</a></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="notice">Henüz proje bilgisi eklenmedi.</p>
            <?php endif; ?>
        </section>

        <section id="cv">
            <h2>Akademik Özgeçmiş</h2>
            <?php if ($cvEntries): ?>
                <ul class="timeline">
                    <?php foreach ($cvEntries as $entry): ?>
                        <li>
                            <h3><?= htmlspecialchars($entry['year_label']) ?> &mdash; <?= htmlspecialchars($entry['title']) ?></h3>
                            <?php if (!empty($entry['description'])): ?>
                                <p><?= htmlspecialchars($entry['description']) ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="notice">Henüz özgeçmiş kaydı eklenmedi.</p>
            <?php endif; ?>
        </section>

        <section id="iletisim">
            <h2>İletişim</h2>
            <?php if (!empty($profile['email'])): ?>
                <p><strong>E-posta:</strong> <a href="mailto:<?= htmlspecialchars($profile['email']) ?>"><?= htmlspecialchars($profile['email']) ?></a></p>
            <?php endif; ?>
            <?php if (!empty($profile['address'])): ?>
                <p><strong>Adres:</strong> <?= htmlspecialchars($profile['address']) ?></p>
            <?php endif; ?>
            <?php if (!empty($profile['office'])): ?>
                <p><strong>Ofis:</strong> <?= htmlspecialchars($profile['office']) ?></p>
            <?php endif; ?>
            <?php if (!empty($profile['office_hours'])): ?>
                <p><strong>Ofis Saatleri:</strong> <?= htmlspecialchars($profile['office_hours']) ?></p>
            <?php endif; ?>
            <?php if (empty($profile['email']) && empty($profile['address']) && empty($profile['office']) && empty($profile['office_hours'])): ?>
                <p class="notice">İletişim bilgileri için yönetim panelini kullanın.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($displayName) ?> &middot; Tüm hakları saklıdır.</p>
        <p><a href="#hakkinda">Başa dön</a></p>
    </footer>
</body>
</html>
