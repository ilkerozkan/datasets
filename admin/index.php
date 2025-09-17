<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config.php';

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

$pdo = null;
$dbError = null;

try {
    $pdo = getPDO();
} catch (PDOException $exception) {
    $dbError = 'Veritabanına bağlanırken hata oluştu: ' . $exception->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        set_flash('error', 'Veritabanı bağlantısı kurulamadığı için işlem gerçekleştirilemedi.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    $action = $_POST['action'] ?? '';

    try {
        switch ($action) {
            case 'update_profile':
                $titlePrefix = trim($_POST['title_prefix'] ?? '');
                $fullName = trim($_POST['full_name'] ?? '');
                $heroTagline = trim($_POST['hero_tagline'] ?? '');
                $bioPrimary = trim($_POST['biography_primary'] ?? '');
                $bioSecondary = trim($_POST['biography_secondary'] ?? '');
                $profileImage = trim($_POST['profile_image_url'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $office = trim($_POST['office'] ?? '');
                $address = trim($_POST['address'] ?? '');
                $officeHours = trim($_POST['office_hours'] ?? '');
                $cvUrl = trim($_POST['cv_url'] ?? '');

                if ($fullName === '') {
                    set_flash('error', 'Ad soyad alanı zorunludur.');
                    break;
                }

                $profileId = $pdo->query('SELECT id FROM profile LIMIT 1')->fetchColumn();

                if ($profileId) {
                    $stmt = $pdo->prepare('UPDATE profile SET title_prefix = :title_prefix, full_name = :full_name, hero_tagline = :hero_tagline, biography_primary = :bio_primary, biography_secondary = :bio_secondary, profile_image_url = :image, email = :email, office = :office, address = :address, office_hours = :office_hours, cv_url = :cv_url WHERE id = :id');
                    $stmt->execute([
                        ':title_prefix' => $titlePrefix !== '' ? $titlePrefix : null,
                        ':full_name' => $fullName,
                        ':hero_tagline' => $heroTagline !== '' ? $heroTagline : null,
                        ':bio_primary' => $bioPrimary !== '' ? $bioPrimary : null,
                        ':bio_secondary' => $bioSecondary !== '' ? $bioSecondary : null,
                        ':image' => $profileImage !== '' ? $profileImage : null,
                        ':email' => $email !== '' ? $email : null,
                        ':office' => $office !== '' ? $office : null,
                        ':address' => $address !== '' ? $address : null,
                        ':office_hours' => $officeHours !== '' ? $officeHours : null,
                        ':cv_url' => $cvUrl !== '' ? $cvUrl : null,
                        ':id' => $profileId,
                    ]);
                } else {
                    $stmt = $pdo->prepare('INSERT INTO profile (title_prefix, full_name, hero_tagline, biography_primary, biography_secondary, profile_image_url, email, office, address, office_hours, cv_url) VALUES (:title_prefix, :full_name, :hero_tagline, :bio_primary, :bio_secondary, :image, :email, :office, :address, :office_hours, :cv_url)');
                    $stmt->execute([
                        ':title_prefix' => $titlePrefix !== '' ? $titlePrefix : null,
                        ':full_name' => $fullName,
                        ':hero_tagline' => $heroTagline !== '' ? $heroTagline : null,
                        ':bio_primary' => $bioPrimary !== '' ? $bioPrimary : null,
                        ':bio_secondary' => $bioSecondary !== '' ? $bioSecondary : null,
                        ':image' => $profileImage !== '' ? $profileImage : null,
                        ':email' => $email !== '' ? $email : null,
                        ':office' => $office !== '' ? $office : null,
                        ':address' => $address !== '' ? $address : null,
                        ':office_hours' => $officeHours !== '' ? $officeHours : null,
                        ':cv_url' => $cvUrl !== '' ? $cvUrl : null,
                    ]);
                }

                set_flash('success', 'Profil bilgileri güncellendi.');
                break;

            case 'add_research':
                $title = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');

                if ($title === '') {
                    set_flash('error', 'Araştırma alanı için başlık gereklidir.');
                    break;
                }

                $nextOrder = (int)$pdo->query('SELECT COALESCE(MAX(sort_order), 0) + 1 FROM research_interests')->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO research_interests (title, description, sort_order) VALUES (:title, :description, :sort_order)');
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $description !== '' ? $description : null,
                    ':sort_order' => $nextOrder,
                ]);

                set_flash('success', 'Araştırma alanı eklendi.');
                break;

            case 'delete_research':
                $id = (int)($_POST['id'] ?? 0);
                if ($id <= 0) {
                    set_flash('error', 'Geçersiz kayıt numarası.');
                    break;
                }

                $stmt = $pdo->prepare('DELETE FROM research_interests WHERE id = :id');
                $stmt->execute([':id' => $id]);
                set_flash('success', 'Araştırma alanı silindi.');
                break;

            case 'add_publication':
                $authors = trim($_POST['authors'] ?? '');
                $year = trim($_POST['year'] ?? '');
                $title = trim($_POST['title'] ?? '');
                $publication = trim($_POST['publication'] ?? '');
                $details = trim($_POST['details'] ?? '');
                $link = trim($_POST['link'] ?? '');

                if ($title === '') {
                    set_flash('error', 'Yayın başlığı zorunludur.');
                    break;
                }

                $nextOrder = (int)$pdo->query('SELECT COALESCE(MAX(sort_order), 0) + 1 FROM publications')->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO publications (authors, year, title, publication, details, link, sort_order) VALUES (:authors, :year, :title, :publication, :details, :link, :sort_order)');
                $stmt->execute([
                    ':authors' => $authors !== '' ? $authors : null,
                    ':year' => $year !== '' ? $year : null,
                    ':title' => $title,
                    ':publication' => $publication !== '' ? $publication : null,
                    ':details' => $details !== '' ? $details : null,
                    ':link' => $link !== '' ? $link : null,
                    ':sort_order' => $nextOrder,
                ]);

                set_flash('success', 'Yayın kaydı eklendi.');
                break;

            case 'delete_publication':
                $id = (int)($_POST['id'] ?? 0);
                if ($id <= 0) {
                    set_flash('error', 'Geçersiz kayıt numarası.');
                    break;
                }

                $stmt = $pdo->prepare('DELETE FROM publications WHERE id = :id');
                $stmt->execute([':id' => $id]);
                set_flash('success', 'Yayın kaydı silindi.');
                break;

            case 'add_course':
                $code = trim($_POST['course_code'] ?? '');
                $courseTitle = trim($_POST['course_title'] ?? '');
                $term = trim($_POST['term'] ?? '');
                $description = trim($_POST['description'] ?? '');

                if ($courseTitle === '') {
                    set_flash('error', 'Ders başlığı zorunludur.');
                    break;
                }

                $nextOrder = (int)$pdo->query('SELECT COALESCE(MAX(sort_order), 0) + 1 FROM courses')->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO courses (course_code, course_title, term, description, sort_order) VALUES (:code, :title, :term, :description, :sort_order)');
                $stmt->execute([
                    ':code' => $code !== '' ? $code : null,
                    ':title' => $courseTitle,
                    ':term' => $term !== '' ? $term : null,
                    ':description' => $description !== '' ? $description : null,
                    ':sort_order' => $nextOrder,
                ]);

                set_flash('success', 'Ders eklendi.');
                break;

            case 'delete_course':
                $id = (int)($_POST['id'] ?? 0);
                if ($id <= 0) {
                    set_flash('error', 'Geçersiz kayıt numarası.');
                    break;
                }

                $stmt = $pdo->prepare('DELETE FROM courses WHERE id = :id');
                $stmt->execute([':id' => $id]);
                set_flash('success', 'Ders silindi.');
                break;

            case 'add_project':
                $title = trim($_POST['title'] ?? '');
                $timeframe = trim($_POST['timeframe'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $link = trim($_POST['link'] ?? '');

                if ($title === '') {
                    set_flash('error', 'Proje başlığı zorunludur.');
                    break;
                }

                $nextOrder = (int)$pdo->query('SELECT COALESCE(MAX(sort_order), 0) + 1 FROM projects')->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO projects (title, timeframe, description, link, sort_order) VALUES (:title, :timeframe, :description, :link, :sort_order)');
                $stmt->execute([
                    ':title' => $title,
                    ':timeframe' => $timeframe !== '' ? $timeframe : null,
                    ':description' => $description !== '' ? $description : null,
                    ':link' => $link !== '' ? $link : null,
                    ':sort_order' => $nextOrder,
                ]);

                set_flash('success', 'Proje eklendi.');
                break;

            case 'delete_project':
                $id = (int)($_POST['id'] ?? 0);
                if ($id <= 0) {
                    set_flash('error', 'Geçersiz kayıt numarası.');
                    break;
                }

                $stmt = $pdo->prepare('DELETE FROM projects WHERE id = :id');
                $stmt->execute([':id' => $id]);
                set_flash('success', 'Proje silindi.');
                break;

            case 'add_cv':
                $yearLabel = trim($_POST['year_label'] ?? '');
                $title = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');

                if ($yearLabel === '' || $title === '') {
                    set_flash('error', 'Özgeçmiş girişleri için yıl ve başlık zorunludur.');
                    break;
                }

                $nextOrder = (int)$pdo->query('SELECT COALESCE(MAX(sort_order), 0) + 1 FROM cv_entries')->fetchColumn();
                $stmt = $pdo->prepare('INSERT INTO cv_entries (year_label, title, description, sort_order) VALUES (:year_label, :title, :description, :sort_order)');
                $stmt->execute([
                    ':year_label' => $yearLabel,
                    ':title' => $title,
                    ':description' => $description !== '' ? $description : null,
                    ':sort_order' => $nextOrder,
                ]);

                set_flash('success', 'Özgeçmiş kaydı eklendi.');
                break;

            case 'delete_cv':
                $id = (int)($_POST['id'] ?? 0);
                if ($id <= 0) {
                    set_flash('error', 'Geçersiz kayıt numarası.');
                    break;
                }

                $stmt = $pdo->prepare('DELETE FROM cv_entries WHERE id = :id');
                $stmt->execute([':id' => $id]);
                set_flash('success', 'Özgeçmiş kaydı silindi.');
                break;

            default:
                set_flash('error', 'Bilinmeyen işlem türü.');
        }
    } catch (PDOException $exception) {
        set_flash('error', 'Veritabanı hatası: ' . $exception->getMessage());
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$flash = get_flash();

$profile = null;
$researchInterests = [];
$publications = [];
$courses = [];
$projects = [];
$cvEntries = [];

if ($pdo) {
    $profile = $pdo->query('SELECT * FROM profile ORDER BY updated_at DESC LIMIT 1')->fetch() ?: null;
    $researchInterests = $pdo->query('SELECT * FROM research_interests ORDER BY sort_order, id')->fetchAll();
    $publications = $pdo->query('SELECT * FROM publications ORDER BY sort_order, id')->fetchAll();
    $courses = $pdo->query('SELECT * FROM courses ORDER BY sort_order, id')->fetchAll();
    $projects = $pdo->query('SELECT * FROM projects ORDER BY sort_order, id')->fetchAll();
    $cvEntries = $pdo->query('SELECT * FROM cv_entries ORDER BY sort_order, id')->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Akademik Site Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary: #2f4b8f;
            --secondary: #f4f6fb;
            --danger: #d95c5c;
            --success: #2f8f5b;
            font-size: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            background-color: var(--secondary);
            color: #1f2933;
        }

        header {
            background: linear-gradient(135deg, var(--primary), #20326d);
            color: #fff;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
        }

        main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
            display: grid;
            gap: 1.5rem;
        }

        section {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(31, 41, 51, 0.08);
            padding: 1.5rem;
        }

        section h2 {
            margin-top: 0;
            color: var(--primary);
        }

        form {
            display: grid;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        label {
            font-weight: 600;
            font-size: 0.95rem;
        }

        input[type="text"],
        input[type="url"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 0.65rem 0.75rem;
            border-radius: 8px;
            border: 1px solid rgba(47, 75, 143, 0.25);
            font-size: 1rem;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            justify-self: flex-start;
            background-color: var(--primary);
            color: #fff;
            border: none;
            border-radius: 999px;
            padding: 0.65rem 1.4rem;
            font-size: 1rem;
            cursor: pointer;
        }

        button.danger {
            background-color: var(--danger);
        }

        .muted {
            color: #5d6b7f;
            font-size: 0.9rem;
        }

        ul.item-list {
            list-style: none;
            padding-left: 0;
            display: grid;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        ul.item-list li {
            background-color: rgba(47, 75, 143, 0.05);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            display: grid;
            gap: 0.5rem;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .alert {
            padding: 0.85rem 1.1rem;
            border-radius: 12px;
            font-weight: 600;
        }

        .alert.success {
            background-color: rgba(47, 143, 91, 0.15);
            color: var(--success);
        }

        .alert.error {
            background-color: rgba(217, 92, 92, 0.15);
            color: var(--danger);
        }

        .grid-two {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .info-box {
            background-color: rgba(47, 75, 143, 0.08);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }

        @media (max-width: 720px) {
            button {
                width: 100%;
                justify-self: stretch;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Akademik Web Sitesi Yönetimi</h1>
        <p>İçeriği güncellemek için aşağıdaki formları kullanın.</p>
    </header>
    <main>
        <?php if ($flash): ?>
            <div class="alert <?= htmlspecialchars($flash['type']) ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?php if ($dbError): ?>
            <div class="alert error">
                <?= htmlspecialchars($dbError) ?>
            </div>
        <?php endif; ?>

        <section>
            <h2>Profil Bilgileri</h2>
            <p class="muted">Ana sayfadaki üst bölüm ve "Hakkında" içeriği bu bilgileri kullanır.</p>
            <form method="post">
                <input type="hidden" name="action" value="update_profile">
                <div class="grid-two">
                    <div>
                        <label for="title_prefix">Akademik Ünvan</label>
                        <input type="text" id="title_prefix" name="title_prefix" value="<?= htmlspecialchars($profile['title_prefix'] ?? '') ?>" placeholder="Prof. Dr.">
                    </div>
                    <div>
                        <label for="full_name">Ad Soyad<span class="muted"> *</span></label>
                        <input type="text" id="full_name" name="full_name" required value="<?= htmlspecialchars($profile['full_name'] ?? '') ?>" placeholder="Ayşe Demir">
                    </div>
                </div>
                <label for="hero_tagline">Üst Başlık / Tanıtım Satırı</label>
                <input type="text" id="hero_tagline" name="hero_tagline" value="<?= htmlspecialchars($profile['hero_tagline'] ?? '') ?>" placeholder="Bilgisayar Bilimleri Bölümü — Yapay Zeka Araştırma Grubu">

                <label for="biography_primary">Biyografi (1. paragraf)</label>
                <textarea id="biography_primary" name="biography_primary" placeholder="Kısa tanıtım metni..."><?= htmlspecialchars($profile['biography_primary'] ?? '') ?></textarea>

                <label for="biography_secondary">Biyografi (2. paragraf)</label>
                <textarea id="biography_secondary" name="biography_secondary" placeholder="Detaylı bilgi..."><?= htmlspecialchars($profile['biography_secondary'] ?? '') ?></textarea>

                <div class="grid-two">
                    <div>
                        <label for="profile_image_url">Profil Görseli URL</label>
                        <input type="url" id="profile_image_url" name="profile_image_url" value="<?= htmlspecialchars($profile['profile_image_url'] ?? '') ?>" placeholder="https://...">
                    </div>
                    <div>
                        <label for="cv_url">CV / Özgeçmiş URL</label>
                        <input type="url" id="cv_url" name="cv_url" value="<?= htmlspecialchars($profile['cv_url'] ?? '') ?>" placeholder="https://...">
                    </div>
                </div>

                <div class="grid-two">
                    <div>
                        <label for="email">E-posta</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" placeholder="ad.soyad@ornek.edu.tr">
                    </div>
                    <div>
                        <label for="office">Ofis</label>
                        <input type="text" id="office" name="office" value="<?= htmlspecialchars($profile['office'] ?? '') ?>" placeholder="Bina A, Oda 305">
                    </div>
                </div>

                <label for="address">Adres</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($profile['address'] ?? '') ?>" placeholder="Üniversite adresi...">

                <label for="office_hours">Ofis Saatleri</label>
                <input type="text" id="office_hours" name="office_hours" value="<?= htmlspecialchars($profile['office_hours'] ?? '') ?>" placeholder="Salı &amp; Perşembe 14:00 - 16:00">

                <button type="submit">Kaydet</button>
            </form>
        </section>

        <section>
            <h2>Araştırma Alanları</h2>
            <form method="post">
                <input type="hidden" name="action" value="add_research">
                <label for="research_title">Başlık<span class="muted"> *</span></label>
                <input type="text" id="research_title" name="title" required placeholder="Yeni araştırma alanı">

                <label for="research_description">Açıklama</label>
                <textarea id="research_description" name="description" placeholder="Bu alanın kısa açıklaması..."></textarea>

                <button type="submit">Araştırma Alanı Ekle</button>
            </form>

            <ul class="item-list">
                <?php foreach ($researchInterests as $item): ?>
                    <li>
                        <div>
                            <strong><?= htmlspecialchars($item['title']) ?></strong>
                            <?php if (!empty($item['description'])): ?>
                                <p class="muted"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <form method="post" class="actions" onsubmit="return confirm('Bu alanı silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="action" value="delete_research">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button type="submit" class="danger">Sil</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                <?php if (!$researchInterests): ?>
                    <li class="muted">Henüz araştırma alanı eklenmedi.</li>
                <?php endif; ?>
            </ul>
        </section>

        <section>
            <h2>Yayınlar</h2>
            <form method="post">
                <input type="hidden" name="action" value="add_publication">
                <div class="grid-two">
                    <div>
                        <label for="pub_authors">Yazarlar</label>
                        <input type="text" id="pub_authors" name="authors" placeholder="A. Demir, M. Kaya">
                    </div>
                    <div>
                        <label for="pub_year">Yıl</label>
                        <input type="text" id="pub_year" name="year" placeholder="2024">
                    </div>
                </div>
                <label for="pub_title">Başlık<span class="muted"> *</span></label>
                <input type="text" id="pub_title" name="title" required placeholder="Çalışmanın başlığı">

                <label for="pub_publication">Dergi / Konferans</label>
                <input type="text" id="pub_publication" name="publication" placeholder="Journal of ...">

                <label for="pub_details">Ek Bilgi</label>
                <input type="text" id="pub_details" name="details" placeholder="Cilt 12(3), 1-20">

                <label for="pub_link">Bağlantı</label>
                <input type="url" id="pub_link" name="link" placeholder="https://...">

                <button type="submit">Yayın Ekle</button>
            </form>

            <ul class="item-list">
                <?php foreach ($publications as $item): ?>
                    <li>
                        <div>
                            <strong><?= htmlspecialchars($item['title']) ?></strong>
                            <p class="muted">
                                <?php if (!empty($item['authors'])): ?>
                                    <?= htmlspecialchars($item['authors']) ?>
                                <?php endif; ?>
                                <?php if (!empty($item['year'])): ?>
                                    (<?= htmlspecialchars($item['year']) ?>).
                                <?php endif; ?>
                                <?php if (!empty($item['publication'])): ?>
                                    <?= htmlspecialchars($item['publication']) ?>
                                <?php endif; ?>
                                <?php if (!empty($item['details'])): ?>
                                    — <?= htmlspecialchars($item['details']) ?>
                                <?php endif; ?>
                            </p>
                            <?php if (!empty($item['link'])): ?>
                                <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank" rel="noopener">Bağlantıyı aç</a>
                            <?php endif; ?>
                        </div>
                        <form method="post" class="actions" onsubmit="return confirm('Bu yayını silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="action" value="delete_publication">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button type="submit" class="danger">Sil</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                <?php if (!$publications): ?>
                    <li class="muted">Henüz yayın eklenmedi.</li>
                <?php endif; ?>
            </ul>
        </section>

        <section>
            <h2>Dersler</h2>
            <form method="post">
                <input type="hidden" name="action" value="add_course">
                <div class="grid-two">
                    <div>
                        <label for="course_code">Ders Kodu</label>
                        <input type="text" id="course_code" name="course_code" placeholder="BLG 401">
                    </div>
                    <div>
                        <label for="course_term">Dönem</label>
                        <input type="text" id="course_term" name="term" placeholder="Güz 2024">
                    </div>
                </div>
                <label for="course_title">Ders Başlığı<span class="muted"> *</span></label>
                <input type="text" id="course_title" name="course_title" required placeholder="Ders adı">

                <label for="course_description">Açıklama</label>
                <textarea id="course_description" name="description" placeholder="Ders içeriği hakkında kısa bilgi..."></textarea>

                <button type="submit">Ders Ekle</button>
            </form>

            <ul class="item-list">
                <?php foreach ($courses as $item): ?>
                    <li>
                        <div>
                            <strong>
                                <?php if (!empty($item['course_code'])): ?>
                                    <?= htmlspecialchars($item['course_code']) ?> -
                                <?php endif; ?>
                                <?= htmlspecialchars($item['course_title']) ?>
                            </strong>
                            <?php if (!empty($item['term'])): ?>
                                <div class="muted"><?= htmlspecialchars($item['term']) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($item['description'])): ?>
                                <p class="muted"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <form method="post" class="actions" onsubmit="return confirm('Dersi silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="action" value="delete_course">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button type="submit" class="danger">Sil</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                <?php if (!$courses): ?>
                    <li class="muted">Henüz ders eklenmedi.</li>
                <?php endif; ?>
            </ul>
        </section>

        <section>
            <h2>Projeler</h2>
            <form method="post">
                <input type="hidden" name="action" value="add_project">
                <label for="project_title">Proje Başlığı<span class="muted"> *</span></label>
                <input type="text" id="project_title" name="title" required placeholder="Proje adı">

                <label for="project_timeframe">Zaman Aralığı</label>
                <input type="text" id="project_timeframe" name="timeframe" placeholder="2023 - ...">

                <label for="project_description">Açıklama</label>
                <textarea id="project_description" name="description" placeholder="Proje kapsamı hakkında kısa bilgi..."></textarea>

                <label for="project_link">Bağlantı</label>
                <input type="url" id="project_link" name="link" placeholder="https://...">

                <button type="submit">Proje Ekle</button>
            </form>

            <ul class="item-list">
                <?php foreach ($projects as $item): ?>
                    <li>
                        <div>
                            <strong><?= htmlspecialchars($item['title']) ?></strong>
                            <?php if (!empty($item['timeframe'])): ?>
                                <div class="muted"><?= htmlspecialchars($item['timeframe']) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($item['description'])): ?>
                                <p class="muted"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['link'])): ?>
                                <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank" rel="noopener">Proje bağlantısı</a>
                            <?php endif; ?>
                        </div>
                        <form method="post" class="actions" onsubmit="return confirm('Projeyi silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="action" value="delete_project">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button type="submit" class="danger">Sil</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                <?php if (!$projects): ?>
                    <li class="muted">Henüz proje eklenmedi.</li>
                <?php endif; ?>
            </ul>
        </section>

        <section>
            <h2>Özgeçmiş</h2>
            <form method="post">
                <input type="hidden" name="action" value="add_cv">
                <div class="grid-two">
                    <div>
                        <label for="cv_year">Yıl / Dönem<span class="muted"> *</span></label>
                        <input type="text" id="cv_year" name="year_label" required placeholder="2024">
                    </div>
                    <div>
                        <label for="cv_title">Pozisyon / Ünvan<span class="muted"> *</span></label>
                        <input type="text" id="cv_title" name="title" required placeholder="Profesör">
                    </div>
                </div>

                <label for="cv_description">Açıklama</label>
                <textarea id="cv_description" name="description" placeholder="Kurum veya ek detaylar..."></textarea>

                <button type="submit">Özgeçmiş Girişi Ekle</button>
            </form>

            <ul class="item-list">
                <?php foreach ($cvEntries as $item): ?>
                    <li>
                        <div>
                            <strong><?= htmlspecialchars($item['year_label']) ?> — <?= htmlspecialchars($item['title']) ?></strong>
                            <?php if (!empty($item['description'])): ?>
                                <p class="muted"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <form method="post" class="actions" onsubmit="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="action" value="delete_cv">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button type="submit" class="danger">Sil</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                <?php if (!$cvEntries): ?>
                    <li class="muted">Henüz özgeçmiş kaydı eklenmedi.</li>
                <?php endif; ?>
            </ul>
        </section>

        <section class="info-box">
            <strong>Not:</strong> Bu panel basit bir doğrulama sunar ve kimlik doğrulama içermez. Üretim ortamında ek güvenlik katmanları (oturum açma, CSRF koruması, HTTPS) eklemeniz önerilir.
        </section>
    </main>
</body>
</html>
